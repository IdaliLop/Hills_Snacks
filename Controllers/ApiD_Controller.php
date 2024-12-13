<?php
// Ubicación: Controllers/reg_duenoController.php
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
        $subject = "Valida tu cuenta";
    
        // Cuerpo del correo con diseño (estilos en línea)
        $body = "
        <html>
        <body style='font-family: Arial, sans-serif; background-color: #f5f5f5; color: #222; margin: 0; padding: 0;'>
            <div style='max-width: 600px; margin: 0 auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);'>
                <div style='background-color: #154360; color: #fff; padding: 20px; text-align: center; border-radius: 8px 8px 0 0;'>
                    <h1 style='margin: 0; font-size: 24px;'>¡Hola, $nombre!</h1>
                </div>
                <div style='padding: 20px; text-align: center;'>
                    <p style='font-size: 16px; margin-bottom: 20px;'>Gracias por registrarte en Hills Snacks. Haz clic en el enlace de abajo para verificar tu cuenta como dueño de un negocio:</p>
                    <a href='http://localhost/proyect/Views/auth/validar_D.php?token=$token' style='background-color: #f9bb12; color: #fff; padding: 15px 30px; text-decoration: none; font-size: 18px; border-radius: 5px; display: inline-block;'>Validar Cuenta</a>
                </div>
                <div style='text-align: center; margin-top: 20px; font-size: 14px; color: #707070;'>
                    <p>Si no te registraste en Hills Snacks, ignora este correo.</p>
                </div>
            </div>
        </body>
        </html>";
    
        // Texto alternativo
        $altBody = "Hola, $nombre. Por favor, verifica tu cuenta usando este enlace: http://localhost/proyect/Views/auth/validar_D.php?token=$token";
    
        // Enviar el correo
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
