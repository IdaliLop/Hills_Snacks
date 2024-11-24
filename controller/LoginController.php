<?php
require_once '../Models/Login.php';
require_once '../config/database.php';

session_start();

class LoginController {
    private $loginModel;

    public function __construct() {
        $database = new Database();
        $this->loginModel = new Login($database->getConnection());
    }

    public function login() {
        // Inicia la sesión si aún no ha sido iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            // Log para depuración
            error_log("Intentando login con el nombre: $nombre");

            // Validar cliente
            $cliente = $this->loginModel->validarLoginCliente($nombre, $password);
            if ($cliente) {
                $_SESSION['usuario_id'] = $cliente['id_cliente'];
                $_SESSION['nombre'] = $cliente['nombre'];
                $_SESSION['rol'] = 'cliente';

                echo json_encode(['success' => true, 'redirectUrl' => '../../index.php']);
                exit();
            }

            // Validar administrador
            $admin = $this->loginModel->validarLoginAdmin($nombre, $password);
            if ($admin) {
                $_SESSION['usuario_id'] = $admin['id_admin'];
                $_SESSION['nombre'] = $admin['nombre'];
                $_SESSION['rol'] = 'admin';

                echo json_encode(['success' => true, 'redirectUrl' => '../views/admin/indexAdmin.php']);
                exit();
            }

            // Validar trabajador
            $trabajador = $this->loginModel->validarLoginEmpleado($nombre, $password);
            if ($trabajador) {
                $_SESSION['usuario_id'] = $trabajador['id_empleado'];
                $_SESSION['nombre'] = $trabajador['nombre'];
                $_SESSION['rol'] = 'trabajador';

                echo json_encode(['success' => true, 'redirectUrl' => '../views/indexTrabajador.php']);
                exit();
            }

            // Credenciales incorrectas
            echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrectos.']);
            exit();
        }
    }
}

// Ejecutar controlador
$loginController = new LoginController();
$loginController->login();
