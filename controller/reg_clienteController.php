<?php
require '../vendor/autoload.php';
include_once '../config/database.php';
include_once '../Models/User.php';
include_once '../api/gmail_api.php'; // Incluir la API de Gmail

$database = new Database();
$db = $database->getConnection();

$userModel = new User($db);
$gmailAPI = new GmailAPI();

// Iniciar sesión
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['verification_code'])) {
        $codigo_introducido = $_POST['verification_code'];

        // Verifica si el código introducido coincide con el almacenado en la sesión
        if ($codigo_introducido == $_SESSION['verification_code']) {
            echo "<script>alert('Verificación exitosa'); window.location.href='login.html';</script>";
        } else {
            echo "<script>alert('Código incorrecto. Inténtalo de nuevo'); window.location.href='../views/Msj_Verif.html';</script>";
        }

    } else {
        // Flujo del registro de cliente
        $userModel->nombre = $_POST['nombre'];
        $userModel->apellido = $_POST['Apellido'];
        $userModel->telefono = $_POST['telefono'];
        $userModel->direccion = $_POST['direccion'];
        $userModel->email = $_POST['email'];
        $userModel->password = $_POST['password'];

        // Intentar registrar al cliente
        if ($userModel->registrar()) {
            // Genera un código de verificación
            $verification_code = rand(100000, 999999); // Genera un código de 6 dígitos

            // Envía el correo de verificación con Gmail API
            $subject = "Código de Verificación";
            $body = "<p>Tu código de verificación es: <strong>$verification_code</strong></p>";

            if ($gmailAPI->sendVerificationEmail($userModel->email, $subject, $body)) {
                // Almacena el código de verificación en la sesión
                $_SESSION['verification_code'] = $verification_code;
                $_SESSION['email'] = $userModel->email;

                // Redirige a la página de verificación de código
                header("Location: ../views/Msj_Verif.html");
                exit();
            } else {
                echo "<script>alert('Error al enviar el correo. Inténtalo de nuevo');</script>";
            }
        } else {
            echo "<script>alert('Error al registrar. Inténtalo de nuevo');</script>";
        }
    }
}
?>
