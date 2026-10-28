<?php
// Enlace del correo de verificación de CLIENTES
require_once __DIR__ . '/../../config/helpers.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../Models/Cliente.php';

$token = $_GET['token'] ?? '';
if ($token === '') {
    irA('../login.php?error=token');
}
$db = (new Database())->getConnection();
$cliente = new Cliente($db);
irA($cliente->validarUsuario($token) ? '../login.php?validacion=exitosa' : '../login.php?error=token');
