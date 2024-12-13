<?php
class AuthController {
    private $userModel;

    public function __construct($dbConnection) {
        $this->userModel = new UserModel($dbConnection);
    }

    public function login() {
        session_start();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            // Consultar ambas tablas
            $admin = $this->userModel->getAdminByEmailAndPassword($email, $password);
            $cliente = $this->userModel->getClienteByEmailAndPassword($email, $password);
    
            if ($admin) {
                $_SESSION['user_id'] = $admin['id'];
                $_SESSION['user_role'] = 'admin';
                header('Location: Views/admin/indexAdmin.php');
                exit;
            } elseif ($cliente) {
                $_SESSION['user_id'] = $cliente['id'];
                $_SESSION['user_role'] = 'cliente';
                header('Location: ../index.php');
                exit;
            } else {
                // Cargar el formulario con un mensaje de error
                $error = "Correo o contraseña incorrectos.";
                require 'Views/login.php'; // Nota: Asegúrate de que esté renombrado a .php
            }
        }
    }
    
}
