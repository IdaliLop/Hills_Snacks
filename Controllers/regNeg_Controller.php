<?php
// Controllers/regNeg_Controller.php
// Registro de un NEGOCIO (formulario Views/RegistroNeg.html): guarda sus datos y su imagen.

require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../Models/AgNegocio.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    irA('../Views/RegistroNeg.html');
}

function volverConError($mensaje) {
    irA('../Views/RegistroNeg.html?error=' . urlencode($mensaje));
}

$nombre    = trim($_POST['nombreNegocio'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');
$telefono  = preg_replace('/\D/', '', $_POST['telefonoNegocio'] ?? '');
$tipo      = $_POST['tipoNegocio'] ?? '';
$envio     = $_POST['tipoEnvio'] ?? '';

$tiposValidos  = ['Hamburguesas', 'Alitas', 'Chilaquiles', 'Pizza', 'Pollo', 'Cenaduria', 'Tacos', 'Postres'];
$enviosValidos = ['Domicilio', 'Sin', 'Ambos'];

if ($nombre === '' || mb_strlen($nombre) > 100) {
    volverConError('Escribe el nombre del negocio (máximo 100 caracteres).');
}
if ($direccion === '' || mb_strlen($direccion) > 200) {
    volverConError('Escribe la dirección del negocio.');
}
if (!preg_match('/^[0-9]{10}$/', $telefono)) {
    volverConError('El teléfono debe tener 10 dígitos.');
}
if (!in_array($tipo, $tiposValidos, true)) {
    volverConError('Elige el tipo de negocio.');
}
if (!in_array($envio, $enviosValidos, true)) {
    volverConError('Elige el tipo de envío.');
}

// ---- Imagen: solo imágenes reales de máximo 3 MB, con nombre generado por el sistema ----
if (!isset($_FILES['imagenNegocio']) || $_FILES['imagenNegocio']['error'] !== UPLOAD_ERR_OK) {
    volverConError('Selecciona una imagen del negocio (máximo 3 MB).');
}
$archivo = $_FILES['imagenNegocio'];
if ($archivo['size'] > 3 * 1024 * 1024) {
    volverConError('La imagen no debe pasar de 3 MB.');
}
$info = @getimagesize($archivo['tmp_name']);
$extensiones = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];
if (!$info || !isset($extensiones[$info['mime']])) {
    volverConError('El archivo debe ser una imagen JPG, PNG, GIF o WEBP.');
}
$carpeta = __DIR__ . '/../Util/img/';
if (!is_dir($carpeta) && !mkdir($carpeta, 0755, true)) {
    volverConError('No se pudo crear la carpeta de imágenes.');
}
$nombreArchivo = 'neg_' . time() . '_' . bin2hex(random_bytes(3)) . '.' . $extensiones[$info['mime']];
if (!move_uploaded_file($archivo['tmp_name'], $carpeta . $nombreArchivo)) {
    volverConError('No se pudo guardar la imagen (revisa los permisos de Util/img).');
}

try {
    $db = (new Database())->getConnection();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $guardado = (new NegocioModel($db))->registrarNegocio($nombre, $direccion, $telefono, $tipo, $envio, 'Util/img/' . $nombreArchivo);
} catch (Exception $e) {
    $guardado = false;
}
if (!$guardado) {
    @unlink($carpeta . $nombreArchivo);
    volverConError('No se pudo registrar el negocio. Intenta de nuevo.');
}

irA('../Views/login.php?negocio=ok');
