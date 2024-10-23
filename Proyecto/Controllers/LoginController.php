<?php
require_once '../Models/User.php';
require_once '../config/database.php';

class LoginController {
    private $userModel;

    public function __construct() {
        $database = new Database(); 
        $this->userModel = new User($database->getConnection());
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Verificar si es cliente
            $clientUser = $this->userModel->getClientUser($username, $password);
            if ($clientUser) {
                // Si es cliente, devolver un JSON con la URL de redirección
                echo json_encode(['success' => true, 'redirectUrl' => '../index.php']);
                exit();
            }

            // Verificar si es dueño
            $adminUser = $this->userModel->getAdminUser($username, $password);
            if ($adminUser) {
                // Si es dueño, devolver un JSON con la URL de redirección
                echo json_encode(['success' => true, 'redirectUrl' => '../views/indexAdmin.php']);
                exit();
            }

            // Si no se encontró el usuario, devolver un mensaje de error
            echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrectos.']);
            exit();

    }
}
}

// Crear una instancia del controlador y ejecutar la lógica de login
$loginController = new LoginController();
$loginController->login();
?>
