<?php
header('Content-Type: application/json');
include_once("../Models/Usuario.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Asegúrate de que la sesión se inicie al principio
}

$usuario = new UsuarioCliente();

if (isset($_POST['funcion'])) {
    $funcion = $_POST['funcion'];

    switch ($funcion) {
        case 'login':
    $correo = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    if ($correo && $pass) {
        $usuario->loguearse($correo, $pass);
        $numObjetos = count($usuario->objetos);

        if ($numObjetos > 0) {
            // Obtener el primer objeto directamente
            $objeto = $usuario->objetos[0];

            // Asignar la información a la sesión
            $_SESSION['id'] = $objeto->idusuario_uc;
            $_SESSION['nombre'] = $objeto->nombre_uc;
            $_SESSION['apellido'] = $objeto->apellido_uc;
            $_SESSION['correo'] = $objeto->correo_uc;
            $_SESSION['validado'] = $objeto->validado;
            $_SESSION['rol'] = 'cliente';

            // Verifica que la sesión se haya establecido correctamente
            if (isset($_SESSION['id'], $_SESSION['rol'])) {
                redirigirPorRol($_SESSION['rol']);
            } else {
                // Aquí estamos mandando directamente los datos del objeto en formato JSON
                echo json_encode($objeto, JSON_PRETTY_PRINT); 
            }
        } else {
            echo json_encode(['error' => 'Correo o contraseña incorrectos']);
        }
    } else {
        echo json_encode(['error' => 'Correo y contraseña son requeridos']);
    }
    break;



        case 'verificar_sesion':
            if (!empty($_SESSION['id'])) {
                echo json_encode([
                    'id' => $_SESSION['id'],
                    'nombre' => $_SESSION['nombre'],
                    'apellido' => $_SESSION['apellido'],
                    'correo' => $_SESSION['correo'],
                    'validado' => $_SESSION['validado'],
                    'rol' => $_SESSION['rol']
                ]);
            } else {
                echo json_encode(['error' => 'No hay sesión activa']);
            }
            break;

        default:
            echo json_encode(['error' => 'Función no válida']);
            break;
    }
} else {
    echo json_encode(['error' => 'No se ha definido la función']);
}

function redirigirPorRol($rol) {
    switch ($rol) {
        case 'cliente':
            echo json_encode(['success' => true, 'redirectUrl' => '../index.php']);
            exit();
        case 'admin':
            echo json_encode(['success' => true, 'redirectUrl' => '../Views/admin/indexAdmin.php']);
            exit();
        case 'trabajador':
            echo json_encode(['success' => true, 'redirectUrl' => '../views/indexTrabajador.php']);
            exit();
        default:
            header("Location: ../Views/login.php");
            exit();
    }
}
?>
