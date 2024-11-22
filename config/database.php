<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'hills_snacks';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

class SomeClass {
    private $db;

    public function __construct() {
        // Instanciar la clase Database
        $database = new Database();
        // Obtener la conexión
        $this->db = $database->getConnection();
    }
}
?>
