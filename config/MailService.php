<?php
// Ubicación: configurar/MailService.php

require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService {
    public static function sendMail($to, $subject, $body, $altBody = '') {
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Cambia a smtp.gmail.com
            $mail->SMTPAuth = true;
            $mail->Username = 'hillsnacks6@gmail.com'; // Cambia a tu correo SMTP
            $mail->Password = 'yvqf xpkw ltlt wtxu'; // Cambia a tu contraseña SMTP
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Remitente y destinatario
            $mail->setFrom('hillsnacks6@gmail.com', 'Hills snacks');
            $mail->addAddress($to);

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AltBody = $altBody;

            // Enviar correo
            $mail->send();
            return true;
        } catch (Exception $e) {
            return "Error al enviar correo: {$mail->ErrorInfo}";
        }
    }
}
?>