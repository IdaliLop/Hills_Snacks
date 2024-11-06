<?php
class Due {
    private $db;

    public function __construct($baseDeDatos) {
        $this->db = $baseDeDatos;
    }

    // Función para registrar un nuevo dueño
    public function registrarD($nombre, $apellido, $telefono, $correo, $password) {
        $passHash = hash('sha256', $password);

        $query = $this->db->prepare("INSERT INTO dueño (Nombre_D, Apellido_D, Pass_D, Telefono_D, Correo_D) VALUES (:nombre, :apellido, :pass, :telefono, :correo)");

        $query->bindParam(":nombre", $nombre);
        $query->bindParam(":apellido", $apellido);
        $query->bindParam(":telefono", $telefono);
        $query->bindParam(":correo", $correo);
        $query->bindParam(":pass", $passHash);

        // Ejecutar la consulta y devolver el resultado
        if ($query->execute()) {
            return $this->db->lastInsertId(); // Devolver el ID del dueño registrado
        }
        return false; // Devolver false si la inserción falla
    }

    // Función para registrar un nuevo negocio
    public function registrarNegocio($nombreNegocio, $direccion, $tipoNegocio, $telefonoNegocio, $idDueño) {
        $query = $this->db->prepare("INSERT INTO negocio (Nombre_N, Direccion_N, Tipo_de_negocio, Telefono_N, IdNegocio_N) VALUES (:nombreNegocio, :direccion, :tipoNegocio, :telefonoNegocio, :idDueño)");

        $query->bindParam(":nombreNegocio", $nombreNegocio);
        $query->bindParam(":direccion", $direccion);
        $query->bindParam(":tipoNegocio", $tipoNegocio);
        $query->bindParam(":telefonoNegocio", $telefonoNegocio);
        $query->bindParam(":idDueño", $idDueño);
        
        // Ejecutar la consulta y manejar el error
        if (!$query->execute()) {
            die("Error al registrar el negocio: " . implode(", ", $query->errorInfo()));
        }
        
        return true; // Devolver verdadero si la inserción fue exitosa
    }
}
?>
