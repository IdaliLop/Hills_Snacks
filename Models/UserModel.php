<?php
class UserModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    // Acepta contraseñas con password_hash y las cuentas antiguas guardadas con SHA-256
    private function passwordValida($plana, $guardada) {
        if (password_verify($plana, $guardada)) {
            return true;
        }
        $limpia = htmlspecialchars(strip_tags($plana)); // así se limpiaba antes de hacer el hash
        return hash_equals($guardada, hash('sha256', $limpia));
    }

    public function getAdminByEmailAndPassword($email, $password) {
        $query = $this->db->prepare("SELECT * FROM dueño WHERE Correo_D = :email");
        $query->bindParam(':email', $email);
        $query->execute();
        $admin = $query->fetch(PDO::FETCH_ASSOC);

        if ($admin && $this->passwordValida($password, $admin['Pass_D'])) {
            return $admin;
        }
        return null;
    }

    public function getClienteByEmailAndPassword($email, $password) {
        $query = $this->db->prepare("SELECT * FROM usuario_cliente WHERE Correo_UC = :email");
        $query->bindParam(':email', $email);
        $query->execute();
        $cliente = $query->fetch(PDO::FETCH_ASSOC);

        if ($cliente && $this->passwordValida($password, $cliente['Pass_UC'])) {
            return $cliente;
        }
        return null;
    }
}
