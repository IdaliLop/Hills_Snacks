<?php
require_once 'vendor/autoload.php'; // Para cargar el SDK de Twilio
use Twilio\Rest\Client;

include_once '../config/database.php';
include_once '../Models/Cliente.php';


$database = new Database();
$db = $database->getConnection();


$cliente = new Cliente($db);

// Verificar si se ha enviado la solicitud POST con los datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Asignar los datos del formulario a las propiedades del modelo Cliente
    $cliente->nombre = $_POST['nombre'];
    $cliente->apellido = $_POST['Apellido'];
    $cliente->telefono = $_POST['telefono'];
    $cliente->direccion = $_POST['direccion'];
    $cliente->email = $_POST['email'];
    $cliente->password = $_POST['password'];

    // Intentar registrar al cliente
    if ($cliente->registrar()) {
        echo "<script>alert('Registro exitoso'); window.location.href='snacks/views/login.html';</script>";
    } else {
        echo "<script>alert('Error al registrar. Inténtalo de nuevo');</script>";
    }
}
?>