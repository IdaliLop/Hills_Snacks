<?php
class Login {
    private $conn;
    private $table_name_cliente = "usuario_cliente";
    private $table_name_admin = "dueño"; 
    private $table_name_tabajador = "trabajador"; 

    public $nombre;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para validar login de cliente
    public function validarLoginCliente($nombre, $password) {
        // Consulta SQL para obtener datos del administrador
        $query = "SELECT * FROM " . $this->table_name_cliente . " WHERE Nombre_UC = :nombre"; // Suponiendo que la tabla admin tiene un campo "Nombre_UA"
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($cliente && hash('sha256', $password) === $cliente['Pass_UC']) {
            return $cliente; // El cliente se validó
        }
        return false; // Si no se encuentra o la contraseña es incorrecta
    }

    // Método para validar login de administrador
    public function validarLoginAdmin($nombre, $password) {
        // Consulta SQL para obtener datos del administrador
        $query = "SELECT * FROM " . $this->table_name_admin . " WHERE Nombre_D = :nombre"; // Suponiendo que la tabla admin tiene un campo "Nombre_UA"
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($admin && hash('sha256', $password) === $admin['Pass_D']) {
            return $admin; // El administrador se validó
        }
        return false; // Si no se encuentra o la contraseña es incorrecta
    }

    //metodo para validar a los trabajadores 
    public function validarLoginEmpleado($nombre, $password) {
        // Consulta SQL para obtener datos del administrador
        $query = "SELECT * FROM " . $this->table_name_tabajador . " WHERE Nombre_T = :nombre"; // Suponiendo que la tabla admin tiene un campo "Nombre_UA"
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        
        $tabajador = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($trabajador && hash('sha256', $password) === $trabajador['Pass_T']) {
            return $trabajador; // El trabajador se validó
        }
        return false; // Si no se encuentra o la contraseña es incorrecta
    }
}
?>