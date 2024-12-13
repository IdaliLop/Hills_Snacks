<?php
include 'config/database.php';

class NegocioModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para registrar un nuevo negocio
    public function registrarNegocio($nombreNegocio, $direccion, $telefonoNegocio, $tipoNegocio, $tipoEnvio, $imagenNegocio) {
        $query = "INSERT INTO negocio (Nombre_N, Direccion_N, Telefono_N, Tipo_N, Tipo_Envio, Imagen_N) 
                  VALUES (:nombreNegocio, :direccion, :telefonoNegocio, :tipoNegocio, :tipoEnvio, :imagenNegocio)";
        
        $stmt = $this->conn->prepare($query);

        // Bind de los parámetros
        $stmt->bindParam(':nombreNegocio', $nombreNegocio);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefonoNegocio', $telefonoNegocio);
        $stmt->bindParam(':tipoNegocio', $tipoNegocio);
        $stmt->bindParam(':tipoEnvio', $tipoEnvio);
        $stmt->bindParam(':imagenNegocio', $imagenNegocio);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
