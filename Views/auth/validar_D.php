
<?php
require_once __DIR__ . '/../../config/database.php';

require_once __DIR__ . '/../../Models/Dueño.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $db = new Database();
    $duenoNegocio = new DuenoNegocio($db->getConnection());

    if ($duenoNegocio->validarUsuario($token)) {
        // Redirigir al login después de validar
        header("Location: http://localhost/proyect/Views/RegistroNeg.html?validacion=exitosa");

    } else {
        echo "Error al validar la cuenta. El token no es válido o ya ha sido utilizado.";
    }
} else {
    echo "Token no encontrado en la URL.";
}
?>
