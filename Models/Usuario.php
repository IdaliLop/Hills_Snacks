<?php
include_once 'Conexion.php';

class UsuarioCliente {
    var $objetos;
    public $acceso;

    public function __construct() {
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }

    // Función para hashear la contraseña
    private function hashPassword($pass) {
        return hash('sha256', $pass);
    }

    // Método para iniciar sesión
    public function loguearse($correo, $pass) {
        // Hashear la contraseña ingresada
        $hashedPassword = $this->hashPassword($pass);

        // Consultar la base de datos con la contraseña hasheada
        $sql = "SELECT * FROM usuario_cliente WHERE Correo_UC = :correo AND Pass_UC = :pass";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':correo' => $correo, ':pass' => $hashedPassword));
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }

    // Método para registrar un nuevo usuario
    public function registrarse($nombre, $apellido, $pass, $telefono, $domicilio, $correo, $token) {
        // Hashear la contraseña
        $hashedPassword = $this->hashPassword($pass);

        // Registrar el usuario con la contraseña hasheada
        $sql = "INSERT INTO usuario_cliente (Nombre_UC, Apellido_UC, Pass_UC, Telefono_UC, Domicilio_UC, Correo_UC, validado, token_validacion) 
                VALUES (:nombre, :apellido, :pass, :telefono, :domicilio, :correo, 0, :token)";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(
            ":nombre" => $nombre,
            ":apellido" => $apellido,
            ":pass" => $hashedPassword,
            ":telefono" => $telefono,
            ":domicilio" => $domicilio,
            ":correo" => $correo,
            ":token" => $token
        ));
        return $this->acceso->lastInsertId(); // Devuelve el ID del usuario registrado
    }

    // Método para validar el usuario con el token
    public function validarUsuario($token) {
        $sql = "UPDATE usuario_cliente SET validado = 1, fecha_valid = CURRENT_TIMESTAMP WHERE token_validacion = :token";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':token' => $token));
        return $query->rowCount(); // Devuelve el número de filas actualizadas
    }

    // Método para obtener los datos de un usuario por ID
    public function obtenerDatos($idUsuario) {
        $sql = "SELECT * FROM usuario_cliente WHERE Idusuario_UC = :id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $idUsuario));
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }

    // Método para verificar si el correo ya existe
    public function verificarCorreo($correo) {
        $sql = "SELECT * FROM usuario_cliente WHERE Correo_UC = :correo";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':correo' => $correo));
        $this->objetos = $query->fetchAll();
        return !empty($this->objetos); // Devuelve true si el correo ya existe
    }
}
?>
