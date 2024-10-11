<?php
session_start();

// VERIFICA LA SESION ESTA INICIADA
if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

//VERIFICA QUE LOS DATOS SE ENVIARION POR METODO POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = htmlspecialchars($_POST['usuario'], ENT_QUOTES, 'UTF-8');
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $direc = $_POST['direc'];
    $correo = $_POST['correo'];
    $pass = $_POST['pass'];

    // CONEXION CON LA BASE DE DATOS
    require 'funciones.php';
    $conexion = conexion();  

    //VERIFICA SI EL USUARIO EXISTE
    $statement = $conexion->prepare('SELECT * FROM usuario_cliente WHERE Nombre_UC = :usuario LIMIT 1');
    $statement->execute(array(':usuario' => $usuario));
    $resultado = $statement->fetch();

    // MENSAJE DE ERROR 
    if ($resultado != false) {
        echo '<p style="color:red;">El usuario ya existe</p>';
        return; 
    }

    //ENCRIPTACION DE LA CONTRASEÑA
    $pass = hash('sha512', $pass); 
   

    //GUARDA LOS DATOS 
    $statement = $conexion->prepare('INSERT INTO usuario_cliente (Idusuario_UC, Nombre_UC, Apellido_UC, Pass_UC, Telefono_UC, Domicilio_UC, Correo_UC) VALUES (null, :usuario, :apellido, :pass, :telefono, :direc, :correo)');
    $statement->execute(array(
        ':usuario' => $usuario,
        ':apellido' => $apellido,
        ':pass' => $pass,
        ':telefono' => $telefono,
        ':direc' => $direc,
        ':correo' => $correo
    ));

    // REGRESA AL LOGIN
    header('Location: login.php');
    exit();
}

//CARGA LA VISTA DEL FORMULARIO
require_once 'Views/RegistrateU.view.php'
?>
