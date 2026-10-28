<?php
// Controllers/PedidoController.php
// Recibe los pedidos del carrito y permite al administrador cambiar su estado.
//
//   POST (JSON) { funcion: "crear", nombre, telefono, direccion, metodo, referencia, items: [{id, cantidad}] }
//   POST        funcion=estado&id=<IdPedido>&estado=<Pendiente|Completado|Cancelado>   (solo admin)
//
// Los precios SIEMPRE se leen de la base de datos: el total que calcula el navegador no se usa.

require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/database.php';
iniciarSesion();
date_default_timezone_set('America/Mexico_City');

ob_start(); // si database.php imprime un error de conexión, no se mezcla con el JSON
header('Content-Type: application/json; charset=utf-8');

function responder($datos, $codigo = 200) {
    http_response_code($codigo);
    ob_clean();
    echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responder(['ok' => false, 'error' => 'Método no permitido.'], 405);
}

// Acepta JSON (carrito) o formulario normal (panel admin)
$datos = json_decode(file_get_contents('php://input'), true);
if (!is_array($datos)) {
    $datos = $_POST;
}
$funcion = $datos['funcion'] ?? '';

$db = (new Database())->getConnection();
if (!$db) {
    responder(['ok' => false, 'error' => 'No se pudo conectar con la base de datos.'], 500);
}
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    switch ($funcion) {
        case 'crear':
            crearPedido($db, $datos);
            break;
        case 'estado':
            cambiarEstado($db, $datos);
            break;
        default:
            responder(['ok' => false, 'error' => 'Función no válida.'], 400);
    }
} catch (Exception $ex) {
    if ($db->inTransaction()) {
        $db->rollBack();
    }
    responder(['ok' => false, 'error' => 'Ocurrió un error al procesar el pedido. Intenta de nuevo.'], 500);
}

function crearPedido($db, $datos) {
    $nombre    = trim($datos['nombre'] ?? '');
    $telefono  = preg_replace('/[\s\-()]/', '', (string) ($datos['telefono'] ?? ''));
    $direccion = trim($datos['direccion'] ?? '');
    $metodo    = $datos['metodo'] ?? 'Efectivo';
    $referencia = substr(trim((string) ($datos['referencia'] ?? '')), 0, 80);
    $items     = $datos['items'] ?? [];

    // ---- Validación de los datos de entrega ----
    if ($nombre === '' || strlen($nombre) > 120) {
        responder(['ok' => false, 'error' => 'Escribe tu nombre.'], 422);
    }
    if (!preg_match('/^\+?[0-9]{7,15}$/', $telefono)) {
        responder(['ok' => false, 'error' => 'Escribe un teléfono válido (solo números).'], 422);
    }
    if ($direccion === '' || strlen($direccion) > 200) {
        responder(['ok' => false, 'error' => 'Escribe la dirección de entrega.'], 422);
    }
    if (!in_array($metodo, ['Efectivo', 'PayPal'], true)) {
        responder(['ok' => false, 'error' => 'Método de pago no válido.'], 422);
    }

    // ---- Productos: se juntan repetidos y se validan cantidades ----
    if (!is_array($items) || count($items) === 0) {
        responder(['ok' => false, 'error' => 'Tu carrito está vacío.'], 422);
    }
    $cantidades = [];
    foreach ($items as $item) {
        $id = (int) ($item['id'] ?? 0);
        $cantidad = (int) ($item['cantidad'] ?? 0);
        if ($id <= 0 || $cantidad < 1 || $cantidad > 99) {
            responder(['ok' => false, 'error' => 'Hay un producto con datos no válidos.'], 422);
        }
        $cantidades[$id] = ($cantidades[$id] ?? 0) + $cantidad;
    }

    // ---- Precios y disponibilidad reales desde la BD ----
    $ids = array_keys($cantidades);
    $marcas = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $db->prepare("SELECT IdProducto_P, IdNegocio_N, Nombre_P, Precio_P, Disponibilidad_P
                          FROM producto WHERE IdProducto_P IN ($marcas)");
    $stmt->execute($ids);
    $productos = [];
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $fila) {
        $productos[(int) $fila['IdProducto_P']] = $fila;
    }

    $idNegocio = null;
    $total = 0.0;
    foreach ($cantidades as $id => $cantidad) {
        if (!isset($productos[$id]) || $productos[$id]['Disponibilidad_P'] !== 'Activo') {
            responder(['ok' => false, 'error' => 'Algún producto de tu carrito ya no está disponible. Vacía el carrito y vuelve a elegirlo.'], 409);
        }
        if ($idNegocio === null) {
            $idNegocio = (int) $productos[$id]['IdNegocio_N'];
        } elseif ($idNegocio !== (int) $productos[$id]['IdNegocio_N']) {
            responder(['ok' => false, 'error' => 'Un pedido solo puede ser de un negocio.'], 422);
        }
        $total += (float) $productos[$id]['Precio_P'] * $cantidad;
    }

    // ---- Se guarda el pedido y su detalle en una sola transacción ----
    $idCliente = (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'cliente') ? (int) $_SESSION['user_id'] : null;

    $db->beginTransaction();
    $stmt = $db->prepare("INSERT INTO pedido
        (IdNegocio_N, id_cliente, Nombre_Cliente, Telefono_Cliente, Direccion_Entrega, Total, Metodo_Pago, Referencia_Pago, Estado, Fecha_Creacion)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pendiente', ?)");
    $stmt->execute([$idNegocio, $idCliente, $nombre, $telefono, $direccion, $total, $metodo, $referencia ?: null, date('Y-m-d H:i:s')]);
    $idPedido = (int) $db->lastInsertId();

    $stmt = $db->prepare("INSERT INTO pedido_detalle (IdPedido, IdProducto_P, Nombre_P, Precio_P, Cantidad) VALUES (?, ?, ?, ?, ?)");
    foreach ($cantidades as $id => $cantidad) {
        $stmt->execute([$idPedido, $id, $productos[$id]['Nombre_P'], $productos[$id]['Precio_P'], $cantidad]);
    }
    $db->commit();

    responder(['ok' => true, 'id' => $idPedido, 'total' => round($total, 2)]);
}

function cambiarEstado($db, $datos) {
    if (!esAdmin()) {
        responder(['ok' => false, 'error' => 'Solo el administrador puede cambiar el estado.'], 403);
    }
    $id = (int) ($datos['id'] ?? 0);
    $estado = $datos['estado'] ?? '';
    if ($id <= 0 || !in_array($estado, ['Pendiente', 'Completado', 'Cancelado'], true)) {
        responder(['ok' => false, 'error' => 'Datos no válidos.'], 422);
    }
    $entrega = ($estado === 'Completado') ? date('Y-m-d H:i:s') : null;
    $stmt = $db->prepare("UPDATE pedido SET Estado = ?, Fecha_Entrega = ? WHERE IdPedido = ?");
    $stmt->execute([$estado, $entrega, $id]);
    responder(['ok' => true]);
}
