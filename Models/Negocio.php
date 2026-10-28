<?php
require_once __DIR__ . '/../config/database.php';

class Negocio {
    private $db;

    public function __construct() {
        // Crear una instancia de la clase Database
        $database = new Database();
        // Llamar al método getConnection() para obtener la conexión
        $this->db = $database->getConnection();
    }

    public function obtenerNegocios() {
        $stmt = $this->db->prepare("SELECT * FROM negocio");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerNegocioPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM negocio WHERE IdNegocio_N = :id LIMIT 1");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerNegociosPorCategoria($categoria) {
        $stmt = $this->db->prepare("SELECT * FROM negocio WHERE Tipo_N = :categoria");
        $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>