<?php
class User {
    private $db;

    public $nombre;
    public $apellido;
    public $telefono;
    public $direccion;
    public $email;
    public $password;

    public function __construct($database) {
        $this->db = $database;
    }

    public function registrar() {
        // Asegúrate de tener una consulta SQL para insertar el usuario en la base de datos
        $passwordHash = hash('sha256', $this->password); 
        $query = "INSERT INTO usuario_cliente (Nombre_UC, Apellido_UC, Telefono_UC, Direccion_UC, Email_UC, Pass_UC) 
                  VALUES (:nombre, :apellido, :telefono, :direccion, :email, :password)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellido', $this->apellido);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':direccion', $this->direccion);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $passwordHash);

        return $stmt->execute();
    }
}
?>
