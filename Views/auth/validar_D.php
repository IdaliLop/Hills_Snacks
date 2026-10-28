<?php
// Enlace del correo de verificación de DUEÑOS de negocio
require_once __DIR__ . '/../../config/helpers.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../Models/Dueño.php';

$token = $_GET['token'] ?? '';
if ($token === '') {
    irA('../login.php?error=token');
}
$db = (new Database())->getConnection();
$dueno = new DuenoNegocio($db);
irA($dueno->validarUsuario($token) ? '../RegistroNeg.html?validacion=exitosa' : '../login.php?error=token');
