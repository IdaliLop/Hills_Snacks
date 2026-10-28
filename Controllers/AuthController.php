<?php
class AuthController {
    private $userModel;

    public function __construct($dbConnection) {
        $this->userModel = new UserModel($dbConnection);
    }

    // Se ejecuta desde index.php?action=login (formulario de Views/login.php)
    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: Views/login.php');
            exit;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Consultar ambas tablas
        $admin = $this->userModel->getAdminByEmailAndPassword($email, $password);
        $cliente = $this->userModel->getClienteByEmailAndPassword($email, $password);

        if ($admin) {
            $this->guardarSesion($admin['id'], 'admin', $admin['Nombre_D']);
            header('Location: Views/admin/indexAdmin.php');
            exit;
        } elseif ($cliente) {
            $this->guardarSesion($cliente['id'], 'cliente', $cliente['Nombre_UC']);
            header('Location: index.php');
            exit;
        }

        // Datos incorrectos: volver al formulario con un mensaje
        header('Location: Views/login.php?error=1');
        exit;
    }

    private function guardarSesion($id, $rol, $nombre) {
        session_regenerate_id(true);
        $_SESSION['id'] = $id;          // lo usa Views/perfil.php
        $_SESSION['user_id'] = $id;
        $_SESSION['user_role'] = $rol;  // 'admin' o 'cliente'
        $_SESSION['nombre'] = $nombre;
    }
}
