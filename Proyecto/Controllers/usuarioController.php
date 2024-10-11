<?php
include_once "../Models/usuario.php";
$usuario = new Usuario();

if(isset($_POST['funcion'])){
    $funcion = $_POST['funcion'];

    if($funcion == 'login'){
        $user = $_POST['user'];
        $pass =$_POST['pass'];
        $usuario->loguearse($user, $pass);
        if($usuario->objetos !=null){
            //reflejamos los datos
            foreach($usuario->objetos as $objeto){
                $_SESSION['id'] = $objeto->id;
                $_SESSION['user'] =$objeto->usuario;
            }
            echo 'logeado';
        } else {
            echo 'Usuario o contraseña incorrectos';
        }
    } elseif ($funcion == 'listar_usuario'){
        echo "Listar usuarios";
    } elseif ($funcion == 'register'){
        $user = $_POST ['user'];
        $telefono = $_POST['telefono'];
        $pass = $_POST['pass'];
        $nombres = $_POST['nombres'];
        $direc = $_POST['direc'];
        $apellidos = $_POST['apellidos'];
        $email = $_POST['email'];
        $usuario->registrarse($user, $telefono, $pass, $nombres, $direc, $apellidos, $email);
        if($usuario->objetos != null){
            echo 'Registrado';
        } else {
            echo 'No_Registrado';
        }
    } elseif($funcion == 'verificar_sesion'){
        if(!empty($_SESSION['id'])){
            $json[] = array('id' => $_SESSION['id'], 'user' => $_SESSION['user']);
            $jsonstring = json_encode($json[0]);
            echo $jsonstring;
        } else {
            echo '';
        }
    } elseif ($funcion == 'obtener_datos') {
        // Función para obtener los datos del usuario basado en el ID guardado en la sesión
        if (!empty($_SESSION['id'])) {
            $idUsuario = $_SESSION['id'];
            $usuario->obtener_datos($idUsuario);
            if ($usuario->objetos != null) {
                // Convertir los datos a formato JSON
                $json = array();
                foreach ($usuario->objetos as $objeto) {
                    $json[] = array(
                        'id' => $objeto->id,
                        'user' => $objeto->usuario,
                        'nombres' => $objeto->nombres,
                        'apellidos' => $objeto->apellidos,
                        'email' => $objeto->email,
                        'telefono' => $objeto->telefono, 
                        'direc' => $objeto->direc);
                    }
                    echo json_encode($json);
            } else {
                echo 'No se encontraron los datos del usuario';
            }
        } else{
            echo 'No hay sesion activa';
        }
    }
} else {
    echo "No se ha definido la funcion";
}


?>