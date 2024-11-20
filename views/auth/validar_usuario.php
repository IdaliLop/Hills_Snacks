<?php
require_once __DIR__ . '/../../config/database.php';

require_once __DIR__ . '/../../Models/Cliente.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $db = new Database();
    $cliente = new Cliente($db->getConnection());

    if ($cliente->validarUsuario($token)) {
        // Redirigir al login después de validar
        header("Location: http://localhost/snacks/views/login.html?validacion=exitosa");

    } else {
        echo "Token de validación inválido.";
    }
} else {
    echo "Token no proporcionado.";
}
?>
