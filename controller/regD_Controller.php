<?php
require_once '../Models/Dueño.php'; 
require_once '../config/database.php'; 

$database = new Database();
$db = $database->getConnection();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario del dueño
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
    $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : null;
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;
    $correo = isset($_POST['correo']) ? $_POST['correo'] : null;
    $password = isset($_POST['pass']) ? $_POST['pass'] : null;

    // Recoger los datos del negocio
    $nombreNegocio = isset($_POST['nombreNegocio']) ? $_POST['nombreNegocio'] : null;
    $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : null;
    $telefonoNegocio = isset($_POST['telefonoNegocio']) ? $_POST['telefonoNegocio'] : null;
    $tipoNegocio = isset($_POST['tipoNegocio']) ? $_POST['tipoNegocio'] : null;

    // Crea una instancia del modelo
    $due = new Due($db); 

    // Primero, registramos el dueño
    $idDueño = $due->registrarD($nombre, $apellido, $telefono, $correo, $password);

    if ($idDueño) {
        // Luego, registramos el negocio usando el ID del dueño
        if ($due->registrarNegocio($nombreNegocio, $direccion, $tipoNegocio, $telefonoNegocio, $idDueño)) {
            header("Location: ../snacks/views/RegistroNeg.html?status=success");
            exit();
        } else {
            // Captura el error de la consulta
            die("Error al registrar el negocio: " . implode(", ", $due->db->errorInfo()));
        }
    } else {
        // Captura el error de la consulta del dueño
        die("Error al registrar el dueño: " . implode(", ", $due->db->errorInfo()));
    }
}

?>
