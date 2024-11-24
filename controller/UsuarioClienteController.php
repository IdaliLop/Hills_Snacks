<?php
header('Content-Type: application/json');
include_once("../Models/Usuario.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Asegúrate de que la sesión se inicie al principio
}

// Crear una instancia del modelo UsuarioCliente
$usuario = new UsuarioCliente();

// Verificar que la variable 'funcion' esté definida en la solicitud
if (isset($_POST['funcion'])) {
    $funcion = $_POST['funcion'];

    switch ($funcion) {
        case 'login':
            $correo = $_POST['username'] ?? '';
            $pass = $_POST['password'] ?? '';

            if ($correo && $pass) {
                $usuario->loguearse($correo, $pass);
                if ($usuario->objetos != null) {
                    // Reflejamos los datos en la sesión
                    foreach ($usuario->objetos as $objeto) {
                        $_SESSION['id'] = $objeto->Idusuario_UC;
                        $_SESSION['nombre'] = $objeto->Nombre_UC;
                        $_SESSION['apellido'] = $objeto->Apellido_UC;
                        $_SESSION['correo'] = $objeto->Correo_UC;
                        $_SESSION['validado'] = $objeto->validado;
                        $_SESSION['rol'] = 'cliente'; // Asigna el rol según la validación
                    }
                    // Redirigir según el rol
                    redirigirPorRol($_SESSION['rol']);
                } else {
                    echo json_encode(['error' => 'Correo o contraseña incorrectos']);
                }
            } else {
                echo json_encode(['error' => 'Correo y contraseña son requeridos']);
            }
            break;

        case 'register':
            $nombre = $_POST['nombre'] ?? '';
            $apellido = $_POST['apellido'] ?? '';
            $pass = $_POST['password'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $domicilio = $_POST['domicilio'] ?? '';
            $correo = $_POST['correo'] ?? '';
            $token = bin2hex(random_bytes(16)); // Generar un token único para validación

            if ($nombre && $apellido && $pass && $telefono && $domicilio && $correo) {
                $usuario->registrarse($nombre, $apellido, $pass, $telefono, $domicilio, $correo, $token);
                if ($usuario->objetos != null) {
                    echo json_encode(['success' => 'Registrado']);
                } else {
                    echo json_encode(['error' => 'No se pudo registrar']);
                }
            } else {
                echo json_encode(['error' => 'Todos los campos son requeridos']);
            }
            break;

        case 'verificar_sesion':
            if (!empty($_SESSION['id'])) {
                $json = [
                    'id' => $_SESSION['id'],
                    'nombre' => $_SESSION['nombre'],
                    'apellido' => $_SESSION['apellido'],
                    'correo' => $_SESSION['correo'],
                    'validado' => $_SESSION['validado'],
                    'rol' => $_SESSION['rol']
                ];
                echo json_encode($json);
            } else {
                echo json_encode(['error' => 'No hay sesión activa']);
            }
            break;

        case 'obtener_datos':
            if (!empty($_SESSION['id'])) {
                $idUsuario = $_SESSION['id'];
                $usuario->obtenerDatos($idUsuario);
                if ($usuario->objetos != null) {
                    $json = [];
                    foreach ($usuario->objetos as $objeto) {
                        $json[] = [
                            'id' => $objeto->Idusuario_UC,
                            'nombre' => $objeto->Nombre_UC,
                            'apellido' => $objeto->Apellido_UC,
                            'correo' => $objeto->Correo_UC,
                            'telefono' => $objeto->Telefono_UC,
                            'domicilio' => $objeto->Domicilio_UC,
                            'validado' => $objeto->validado,
                            'fecha_registro' => $objeto->fecha_registro
                        ];
                    }
                    echo json_encode($json);
                } else {
                    echo json_encode(['error' => 'No se encontraron datos del usuario']);
                }
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

// Función para redirigir según el rol del usuario
function redirigirPorRol($rol) {
    switch ($rol) {
        case 'cliente':
            // Redirigir a la página del cliente
            echo json_encode(['success' => true, 'redirectUrl' => '../index.php']);
            exit();
        case 'admin':
            // Redirigir a la página del administrador
            echo json_encode(['success' => true, 'redirectUrl' => '../Views/admin/indexAdmin.php']); 
            exit();
        case 'trabajador':
            // Redirigir a la página del trabajador
            echo json_encode(['success' => true, 'redirectUrl' => '../views/indexTrabajador.php']);
            exit();
        default:
            // Si no hay rol o no está definido, redirigir a una página de error o inicio
            header("Location: ../Views/login.php");
            exit();
    }
}
?>
