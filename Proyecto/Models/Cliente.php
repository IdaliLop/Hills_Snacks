<?php
class Cliente {
    private $conn;
    private $table_name = "usuario_cliente";

    public $nombre;
    public $apellido;
    public $telefono;
    public $direccion;
    public $email;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para registrar un nuevo cliente
    public function registrar() {
        // Consulta SQL para insertar un nuevo cliente
        $query = "INSERT INTO " . $this->table_name . " (Nombre_UC, Apellido_UC, Pass_UC, Telefono_UC, Domicilio_UC, Correo_UC) 
        VALUES (:nombre, :apellido, :password, :telefono, :direccion, :email)";



        $stmt = $this->conn->prepare($query);


        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        // Encriptar la contraseña con SHA-256
        $this->password = hash('sha256', $this->password);

        // Vincular los parámetros
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellido', $this->apellido);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':direccion', $this->direccion);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);

        // Ejecutar la consulta
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>