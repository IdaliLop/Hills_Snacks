<?php
// models/User.php
class User {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    // Función para verificar si es un cliente
    public function getClientUser($username, $password) {
        $query = $this->db->prepare("SELECT * FROM usuario_cliente WHERE Nombre_UC = :username AND Pass_UC = :password");
        $query->bindParam(":username", $username);
        $query->bindParam(":password", $password);
        $query->execute();
        return $query->fetch(); // Devolver los datos del usuario cliente si existe
    }

    // Función para verificar si es un dueño
    public function getAdminUser($username, $password) {
        $query = $this->db->prepare("SELECT * FROM dueño WHERE Nombre_D = :username AND Pass_D = :password");
        $query->bindParam(":username", $username);
        $query->bindParam(":password", $password);
        $query->execute();
        return $query->fetch(); // Devolver los datos del usuario dueño si existe
    }
}
?>
