<?php
// Ubicación: controller/reg_duenoController.php
require_once '../config/MailService.php';
require_once '../Models/Dueño.php'; // El modelo del dueño de negocio
require_once '../config/database.php';

class UsuarioController {
    private $duenoNegocio;

    public function __construct($db) {
        $this->duenoNegocio = new DuenoNegocio($db); // Usamos el modelo de dueño de negocio
    }

    // Método para registrar al dueño de negocio y enviar el correo de validación
    public function registrarDuenoNegocio($nombre, $apellido, $telefono, $email, $password) {
        // Generar un token de validación
        $token = bin2hex(random_bytes(16));

        // Guardar los datos del dueño de negocio
        $this->duenoNegocio->nombre = $nombre;
        $this->duenoNegocio->apellido = $apellido;
        $this->duenoNegocio->telefono = $telefono;
        $this->duenoNegocio->email = $email;
        $this->duenoNegocio->password = $password;
        $this->duenoNegocio->token_validacion = $token; // Asignamos el token al dueño de negocio

        // Guardar en la base de datos (con estado de "no validado")
        if ($this->duenoNegocio->registrar()) {
            // Si el dueño de negocio se registró exitosamente, enviar correo de validación
            $this->enviarCorreoDeValidacion($email, $nombre, $token);
        } else {
            echo "Error al registrar al dueño del negocio.";
        }
    }

    // Enviar el correo con el link de validación
    public function enviarCorreoDeValidacion($email, $nombre, $token) {
        $subject = "Verificación de cuenta";
        $body = "<h1>Hola, $nombre</h1>
                 <p>Gracias por registrarte en Hills Snacks. Haz clic en el enlace para verificar tu cuenta como dueño de un negocio:</p>
                 <a href='http://localhost/snacks/views/auth/validar_D.php?token=$token'>Validar Cuenta</a>";
        $altBody = "Hola, $nombre. Por favor, verifica tu cuenta usando este enlace: http://localhost/snacks/views/auth/validar_D.php?token=$token";

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

    // Recibir los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $email = $_POST['correo'];
    $password = $_POST['pass'];

    // Registrar al dueño de negocio
    $usuarioController->registrarDuenoNegocio($nombre, $apellido, $telefono, $email, $password);
}
?>
