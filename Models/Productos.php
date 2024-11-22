<?php
require_once 'config/database.php'; // Asegúrate de tener la conexión Database incluida

class Producto {
    private $db;

    public function __construct() {
        // Instanciar la clase Database
        $database = new Database();
        // Obtener la conexión
        $this->db = $database->getConnection();
    }

    public function obtenerProductosPorNegocio($idNegocio) {
        $stmt = $this->db->prepare("SELECT * FROM producto WHERE IdNegocio_N = :negocio_id");
        $stmt->bindParam(':negocio_id', $idNegocio, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
