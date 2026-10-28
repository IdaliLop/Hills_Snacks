<?php
// Controllers/ProductoAdminController.php
// Acciones del panel de administración sobre los productos (solo administradores):
//   funcion=crear            -> agrega un producto nuevo con su imagen (formulario del inventario)
//   funcion=disponibilidad   -> cambia un producto entre Activo e Inactivo
// Siempre responde JSON: { success: true } o { success: false, error: "..." }

require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/database.php';
iniciarSesion();

ob_start(); // si database.php imprime un error de conexión, no se mezcla con el JSON
header('Content-Type: application/json; charset=utf-8');

function responder($datos, $codigo = 200) {
    http_response_code($codigo);
    ob_clean();
    echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responder(['success' => false, 'error' => 'Método no permitido.'], 405);
}
if (!esAdmin()) {
    responder(['success' => false, 'error' => 'Debes iniciar sesión como administrador.'], 403);
}

$db = (new Database())->getConnection();
if (!$db) {
    responder(['success' => false, 'error' => 'No se pudo conectar con la base de datos.'], 500);
}
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    switch ($_POST['funcion'] ?? '') {
        case 'crear':
            crearProducto($db);
            break;
        case 'disponibilidad':
            cambiarDisponibilidad($db);
            break;
        default:
            responder(['success' => false, 'error' => 'Función no válida.'], 400);
    }
} catch (Exception $ex) {
    responder(['success' => false, 'error' => 'Error al guardar en la base de datos.'], 500);
}

function crearProducto($db) {
    $nombre = trim($_POST['productName'] ?? '');
    $precio = $_POST['productPrice'] ?? '';
    $disponibilidad = $_POST['productDis'] ?? 'Activo';
    $idNegocio = (int) ($_POST['negocio'] ?? 0);

    if ($nombre === '' || strlen($nombre) > 100) {
        responder(['success' => false, 'error' => 'Escribe el nombre del producto (máximo 100 caracteres).'], 422);
    }
    if (!is_numeric($precio) || $precio <= 0 || $precio > 99999) {
        responder(['success' => false, 'error' => 'El precio debe ser un número mayor a 0.'], 422);
    }
    if (!in_array($disponibilidad, ['Activo', 'Inactivo'], true)) {
        responder(['success' => false, 'error' => 'La disponibilidad debe ser Activo o Inactivo.'], 422);
    }
    $stmt = $db->prepare("SELECT COUNT(*) FROM negocio WHERE IdNegocio_N = ?");
    $stmt->execute([$idNegocio]);
    if ((int) $stmt->fetchColumn() === 0) {
        responder(['success' => false, 'error' => 'Elige el negocio al que pertenece el producto.'], 422);
    }

    // ---- Imagen: solo imágenes reales, de máximo 3 MB ----
    if (!isset($_FILES['productImage']) || $_FILES['productImage']['error'] !== UPLOAD_ERR_OK) {
        responder(['success' => false, 'error' => 'Selecciona una imagen para el producto.'], 422);
    }
    $archivo = $_FILES['productImage'];
    if ($archivo['size'] > 3 * 1024 * 1024) {
        responder(['success' => false, 'error' => 'La imagen no debe pasar de 3 MB.'], 422);
    }
    $info = @getimagesize($archivo['tmp_name']);
    $extensiones = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];
    if (!$info || !isset($extensiones[$info['mime']])) {
        responder(['success' => false, 'error' => 'El archivo debe ser una imagen JPG, PNG, GIF o WEBP.'], 422);
    }

    $carpeta = __DIR__ . '/../Util/img/';
    if (!is_dir($carpeta) && !mkdir($carpeta, 0755, true)) {
        responder(['success' => false, 'error' => 'No se pudo crear la carpeta de imágenes.'], 500);
    }
    $nombreArchivo = 'prod_' . time() . '_' . bin2hex(random_bytes(3)) . '.' . $extensiones[$info['mime']];
    if (!move_uploaded_file($archivo['tmp_name'], $carpeta . $nombreArchivo)) {
        responder(['success' => false, 'error' => 'No se pudo guardar la imagen (revisa los permisos de Util/img).'], 500);
    }

    $stmt = $db->prepare("INSERT INTO producto (IdNegocio_N, Nombre_P, Precio_P, Disponibilidad_P, Imagen_P) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$idNegocio, $nombre, $precio, $disponibilidad, 'Util/img/' . $nombreArchivo]);

    responder(['success' => true, 'id' => (int) $db->lastInsertId()]);
}

function cambiarDisponibilidad($db) {
    $id = (int) ($_POST['id'] ?? 0);
    $disponibilidad = $_POST['disponibilidad'] ?? '';
    if ($id <= 0 || !in_array($disponibilidad, ['Activo', 'Inactivo'], true)) {
        responder(['success' => false, 'error' => 'Datos no válidos.'], 422);
    }
    $stmt = $db->prepare("UPDATE producto SET Disponibilidad_P = ? WHERE IdProducto_P = ?");
    $stmt->execute([$disponibilidad, $id]);
    responder(['success' => true]);
}
