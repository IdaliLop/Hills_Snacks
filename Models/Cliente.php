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
    public $token_validacion; // Nuevo campo para el token de validación

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para registrar un nuevo cliente
    public function registrar() {
        // Consulta SQL para insertar un nuevo cliente con token y estado de validación
        $query = "INSERT INTO " . $this->table_name . " (Nombre_UC, Apellido_UC, Pass_UC, Telefono_UC, Domicilio_UC, Correo_UC, token_validacion, validado) 
                  VALUES (:nombre, :apellido, :password, :telefono, :direccion, :email, :token_validacion, 0)"; // validado = 0 (no validado)

        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->token_validacion = htmlspecialchars(strip_tags($this->token_validacion));

        // Encriptar la contraseña con SHA-256
        $this->password = hash('sha256', $this->password);

        // Vincular los parámetros
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellido', $this->apellido);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':direccion', $this->direccion);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':token_validacion', $this->token_validacion);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para validar el cliente por el token
    public function validarUsuario($token) {
        $query = "UPDATE " . $this->table_name . " SET validado = 1 WHERE token_validacion = :token AND validado = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':token', $token);
        
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                return true; // El usuario fue validado
            } else {
                echo "El token no es válido o la cuenta ya estaba validada.";
                return false;
            }
        }
        
    }
}
?>
