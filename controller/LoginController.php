<?php
require_once '../Models/Login.php'; // Cargar el modelo Login
require_once '../config/database.php'; // Cargar la conexión a la base de datos

class LoginController {
    private $loginModel;

    public function __construct() {
        $database = new Database(); 
        $this->loginModel = new Login($database->getConnection());
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['username'];
            $password = $_POST['password'];

            // Intentar validar como cliente
            $cliente = $this->loginModel->validarLoginCliente($nombre, $password);
            if ($cliente) {
                // Si es un cliente válido
                echo json_encode(['success' => true, 'redirectUrl' => '../index.php']);
                exit();
            }

            // Intentar validar como administrador
            $admin = $this->loginModel->validarLoginAdmin($nombre, $password);
            if ($admin) {
                // Si es un administrador válido
                echo json_encode(['success' => true, 'redirectUrl' => '../views/indexAdmin.php']);
                exit();
            }

            // Intentar validar como Trabajador
            $trabajador = $this->loginModel->validarLoginEmpleado($nombre, $password);
            if ($tabajador) {
                // Si es un administrador válido
                echo json_encode(['success' => true, 'redirectUrl' => '../views/indexAdmin.php']);
                exit();
            }

            // Si no se encontró el usuario o la contraseña es incorrecta
            echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrectos.']);
            exit();
        }
    }
}

// Crear una instancia del controlador y ejecutar la lógica de login
$loginController = new LoginController();
$loginController->login();
?>