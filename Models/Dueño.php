<?php
class DuenoNegocio {
    private $conn;
    private $table_name = "dueño"; // Asegúrate de que esta tabla existe en la base de datos

    public $nombre;
    public $apellido;
    public $telefono;
    public $email;
    public $password;
    public $token_validacion; // Campo para el token de validación

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para registrar un nuevo dueño de negocio
    public function registrar() {
        // Consulta SQL para insertar un nuevo dueño con token y estado de validación
        $query = "INSERT INTO " . $this->table_name . " (Nombre_D, Apellido_D, Pass_D, Telefono_D, Correo_D, token_validacion, validado) 
                  VALUES (:nombre, :apellido, :password, :telefono, :email, :token_validacion, 0)"; // validado = 0 (no validado)

        $stmt = $this->conn->prepare($query);

        // Limpiar los datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->token_validacion = htmlspecialchars(strip_tags($this->token_validacion));

        // Encriptar la contraseña con SHA-256
        $this->password = hash('sha256', $this->password);

        // Vincular los parámetros
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellido', $this->apellido);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':token_validacion', $this->token_validacion);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para validar el dueño de negocio por el token
    public function validarUsuario($token) {
        $query = "UPDATE " . $this->table_name . " SET validado = 1 WHERE token_validacion = :token AND validado = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':token', $token);
        
        if ($stmt->execute() && $stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }
}
?>
