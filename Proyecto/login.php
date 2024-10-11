<?php 
session_start();
//COMPRUEBA SI LA SESION ESTA SETIADA 
if(isset($_SESSION['usuario'])){
    header('Location: index.php');
}


//VERIFICA QUE LOS DATOS SE EVIAN POR EL METODO POST
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $pass = $_POST['pass'];
    $pass = hash('sha512', $pass);

    //CONEXION CON LA BASE DE DATOS
    require 'funciones.php';
    $conexion = conexion();


    //CONSULTA SQL
    $sql = "SELECT * FROM usuario_cliente WHERE Nombre_UC=:usuario AND Pass_UC=:pass" ;
    $statement = $conexion->prepare($sql);
    var_dump($statement);
    $statement->execute(array(':usuario'=>$usuario,':pass'=>$pass));
    var_dump($statement);
    $resultado = $statement->fetchAll();

    //VALIDACION DE USUARIO    
    if($resultado ){
        $_SESSION ['usuario'] = $usuario;
        header('Location: index.php');
    } 

}

require 'Views/login.view.php';

