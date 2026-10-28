<?php
// Controllers/CuentaController.php
// Permite a la persona con sesión iniciada (cliente o administrador) cambiar sus propios datos.
//   POST funcion=actualizar&nombre&apellido&correo&telefono[&domicilio (clientes)][&contrasena (opcional)]
// Responde JSON: { ok: true } o { ok: false, error: "..." }

require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/database.php';
iniciarSesion();

ob_start();
header('Content-Type: application/json; charset=utf-8');

function responder($datos, $codigo = 200) {
    http_response_code($codigo);
    ob_clean();
    echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || ($_POST['funcion'] ?? '') !== 'actualizar') {
    responder(['ok' => false, 'error' => 'Solicitud no válida.'], 400);
}
$rol = $_SESSION['user_role'] ?? '';
$id  = (int) ($_SESSION['user_id'] ?? 0);
if ($id <= 0 || !in_array($rol, ['admin', 'cliente'], true)) {
    responder(['ok' => false, 'error' => 'Debes iniciar sesión.'], 403);
}

$nombre   = trim($_POST['nombre'] ?? '');
$apellido = trim($_POST['apellido'] ?? '');
$correo   = trim($_POST['correo'] ?? '');
$telefono = preg_replace('/\D/', '', $_POST['telefono'] ?? '');
$domicilio = trim($_POST['domicilio'] ?? '');
$clave    = $_POST['contrasena'] ?? '';

if ($nombre === '' || $apellido === '' || mb_strlen($nombre) > 80 || mb_strlen($apellido) > 80) {
    responder(['ok' => false, 'error' => 'Escribe tu nombre y apellido.'], 422);
}
if (!filter_var($correo, FILTER_VALIDATE_EMAIL) || strlen($correo) > 120) {
    responder(['ok' => false, 'error' => 'Escribe un correo válido.'], 422);
}
if (!preg_match('/^[0-9]{10}$/', $telefono)) {
    responder(['ok' => false, 'error' => 'El teléfono debe tener 10 dígitos.'], 422);
}
if ($rol === 'cliente' && ($domicilio === '' || mb_strlen($domicilio) > 200)) {
    responder(['ok' => false, 'error' => 'Escribe tu domicilio.'], 422);
}
if ($clave !== '' && strlen($clave) < 6) {
    responder(['ok' => false, 'error' => 'La contraseña nueva debe tener al menos 6 caracteres.'], 422);
}

$db = (new Database())->getConnection();
if (!$db) {
    responder(['ok' => false, 'error' => 'No se pudo conectar con la base de datos.'], 500);
}
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    $tabla = ($rol === 'admin') ? 'dueño' : 'usuario_cliente';
    if (correoRegistrado($db, $correo, $tabla, $id)) {
        responder(['ok' => false, 'error' => 'Ese correo ya lo usa otra cuenta.'], 409);
    }

    if ($rol === 'admin') {
        $sql = "UPDATE `dueño` SET Nombre_D = ?, Apellido_D = ?, Correo_D = ?, Telefono_D = ?";
        $params = [$nombre, $apellido, $correo, $telefono];
        if ($clave !== '') { $sql .= ", Pass_D = ?"; $params[] = password_hash($clave, PASSWORD_DEFAULT); }
    } else {
        $sql = "UPDATE usuario_cliente SET Nombre_UC = ?, Apellido_UC = ?, Correo_UC = ?, Telefono_UC = ?, Domicilio_UC = ?";
        $params = [$nombre, $apellido, $correo, $telefono, $domicilio];
        if ($clave !== '') { $sql .= ", Pass_UC = ?"; $params[] = password_hash($clave, PASSWORD_DEFAULT); }
    }
    $sql .= " WHERE id = ?";
    $params[] = $id;
    $db->prepare($sql)->execute($params);
} catch (Exception $ex) {
    responder(['ok' => false, 'error' => 'No se pudieron guardar los cambios.'], 500);
}

$_SESSION['nombre'] = $nombre;
responder(['ok' => true]);
