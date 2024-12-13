<?php
class UserModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getAdminByEmailAndPassword($email, $password) {
        $query = $this->db->prepare("SELECT * FROM dueño WHERE Correo_D = :email");
        $query->bindParam(':email', $email);
        $query->execute();
        $admin = $query->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['Pass_D'])) {
            return $admin;
        }
        return null;
    }

    public function getClienteByEmailAndPassword($email, $password) {
        $query = $this->db->prepare("SELECT * FROM usuario_cliente WHERE Correo_UC = :email");
        $query->bindParam(':email', $email);
        $query->execute();
        $cliente = $query->fetch(PDO::FETCH_ASSOC);

        if ($cliente && password_verify($password, $cliente['Pass_UC'])) {
            return $cliente;
        }
        return null;
    }
}
