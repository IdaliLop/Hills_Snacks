<?php
include 'database.php';

class Negocio {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function obtenerNegocios() {
        $stmt = $this->db->prepare("SELECT * FROM negocio");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerNegociosPorCategoria($categoria) {
        $stmt = $this->db->prepare("SELECT * FROM negocio WHERE Tipo_de_negocio = :categoria");
        $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}



?>
