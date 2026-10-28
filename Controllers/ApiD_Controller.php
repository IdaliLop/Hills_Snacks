<?php
// Controllers/ApiD_Controller.php
// Registro de DUEÑOS de negocio (formulario Views/RegistroD.html).
// Igual que el de clientes: si el correo no se puede mandar, la cuenta se activa sola
// y se continúa con el registro del negocio.

require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/MailService.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../Models/Dueño.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    irA('../Views/RegistroD.html');
}

function volverConError($mensaje) {
    irA('../Views/RegistroD.html?error=' . urlencode($mensaje));
}

$nombre   = trim($_POST['nombre'] ?? '');
$apellido = trim($_POST['apellido'] ?? '');
$telefono = preg_replace('/\D/', '', $_POST['telefono'] ?? '');
$email    = trim($_POST['correo'] ?? '');
$password = $_POST['pass'] ?? '';

if ($nombre === '' || $apellido === '') {
    volverConError('Completa todos los campos.');
}
if (mb_strlen($nombre) > 80 || mb_strlen($apellido) > 80) {
    volverConError('Alguno de los textos es demasiado largo.');
}
if (!preg_match('/^[0-9]{10}$/', $telefono)) {
    volverConError('El teléfono debe tener 10 dígitos.');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 120) {
    volverConError('Escribe un correo válido.');
}
if (strlen($password) < 6) {
    volverConError('La contraseña debe tener al menos 6 caracteres.');
}

$db = (new Database())->getConnection();
if (!$db) {
    volverConError('No se pudo conectar con la base de datos.');
}
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    if (correoRegistrado($db, $email)) {
        volverConError('Ese correo ya está registrado. Inicia sesión.');
    }

    $token = bin2hex(random_bytes(16));
    $dueno = new DuenoNegocio($db);
    $dueno->nombre = $nombre;
    $dueno->apellido = $apellido;
    $dueno->telefono = $telefono;
    $dueno->email = $email;
    $dueno->password = $password;
    $dueno->token_validacion = $token;
    if (!$dueno->registrar()) {
        volverConError('No se pudo crear la cuenta. Intenta de nuevo.');
    }
} catch (Exception $e) {
    volverConError('No se pudo crear la cuenta. Intenta de nuevo.');
}

$enlace = urlBase() . '/Views/auth/validar_D.php?token=' . $token;
$cuerpo = "
<div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;padding:20px;background:#fff;border-radius:8px'>
  <div style='background:#154360;color:#fff;padding:20px;text-align:center;border-radius:8px 8px 0 0'>
    <h1 style='margin:0;font-size:24px'>¡Hola, " . e($nombre) . "!</h1>
  </div>
  <div style='padding:20px;text-align:center'>
    <p>Gracias por registrarte en Hills Snacks. Haz clic en el botón para verificar tu cuenta de dueño de negocio:</p>
    <a href='$enlace' style='background:#f9bb12;color:#fff;padding:15px 30px;text-decoration:none;font-size:18px;border-radius:5px;display:inline-block'>Validar cuenta</a>
  </div>
  <p style='text-align:center;font-size:14px;color:#707070'>Si no te registraste en Hills Snacks, ignora este correo.</p>
</div>";

if (MailService::sendMail($email, 'Valida tu cuenta de Hills Snacks', $cuerpo, "Verifica tu cuenta aquí: $enlace") === true) {
    irA('../Views/login.php?registro=correo');
}

validarCuentaPorToken($db, 'dueño', $token);
irA('../Views/RegistroNeg.html?validacion=exitosa');
