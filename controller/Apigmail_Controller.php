<?php
// Ubicación: controller/reg_clienteController.php
require_once '../config/MailService.php';
require_once '../Models/Cliente.php';
require_once '../config/database.php';

class UsuarioController {
    private $cliente;

    public function __construct($db) {
        $this->cliente = new Cliente($db);
    }

    // Método para registrar al cliente y enviar el correo de validación
    public function registrarCliente($nombre, $apellido, $telefono, $direccion, $email, $password) {
        // Generar un token de validación
        $token = bin2hex(random_bytes(16));

        // Guardar los datos del cliente
        $this->cliente->nombre = $nombre;
        $this->cliente->apellido = $apellido;
        $this->cliente->telefono = $telefono;
        $this->cliente->direccion = $direccion;
        $this->cliente->email = $email;
        $this->cliente->password = $password;
        $this->cliente->token_validacion = $token; // Asignamos el token al cliente

        // Guardar en la base de datos (con estado de "no validado")
        if ($this->cliente->registrar()) {
            // Si el cliente se registró exitosamente, enviar correo de validación
            $this->enviarCorreoDeValidacion($email, $nombre, $token);
        } else {
            echo "Error al registrar el cliente.";
        }
    }

    // Enviar el correo con el link de validación
    public function enviarCorreoDeValidacion($email, $nombre, $token) {
        $subject = "Verificacion de cuenta";
        $body = "<h1>Hola, $nombre</h1>
                 <p>Gracias por registrarte en Hills Snacks. Haz clic en el enlace para verificar tu cuenta:</p>
                 <a href='localhost/snacks/views/auth/validar_usuario.php?token=$token'>Validar Cuenta</a>";
        $altBody = "Hola, $nombre. Por favor, verifica tu cuenta usando este enlace: localhost/snacks/views/auth/validar_usuario.php?token=$token";

        $resultado = MailService::sendMail($email, $subject, $body, $altBody);

        if ($resultado === true) {
            echo "Correo de validación enviado a $email.";
        } else {
            echo "Error al enviar el correo de validación: $resultado";
        }
    }
}

// Manejo de la solicitud de registro desde la vista
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database(); // Inicia la conexión a la base de datos
    $usuarioController = new UsuarioController($db->getConnection());

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $usuarioController->registrarCliente($nombre, $apellido, $telefono, $direccion, $email, $password);
}
?>