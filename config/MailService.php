<?php
// config/MailService.php
// Envío de correos con PHPMailer (necesita "composer install" y config/mail.local.php).
// Si algo falta, NO truena: sendMail() devuelve un texto con el motivo y el sitio sigue funcionando.

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService {
    /** Datos de correo desde config/mail.local.php o variables de entorno SMTP_USER / SMTP_PASS. */
    private static function config() {
        $archivo = __DIR__ . '/mail.local.php';
        if (is_file($archivo)) {
            $c = include $archivo;
            if (is_array($c) && !empty($c['usuario']) && !empty($c['password'])) {
                return $c;
            }
        }
        $u = getenv('SMTP_USER');
        $p = getenv('SMTP_PASS');
        return ($u && $p) ? ['usuario' => $u, 'password' => $p, 'remitente' => 'Hills Snacks'] : null;
    }

    /** true si el correo puede intentarse (PHPMailer instalado y datos configurados). */
    public static function disponible() {
        return is_file(__DIR__ . '/../vendor/autoload.php') && self::config() !== null;
    }

    public static function sendMail($to, $subject, $body, $altBody = '') {
        if (!self::disponible()) {
            return 'El envío de correo no está configurado.';
        }
        require_once __DIR__ . '/../vendor/autoload.php';
        $c = self::config();
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $c['usuario'];
            $mail->Password = $c['password'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->Timeout = 8; // no dejar la página colgada si no hay internet
            $mail->CharSet = 'UTF-8';
            $mail->setFrom($c['usuario'], $c['remitente'] ?? 'Hills Snacks');
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AltBody = $altBody;
            $mail->send();
            return true;
        } catch (Exception $e) {
            return 'No se pudo enviar el correo: ' . $mail->ErrorInfo;
        } catch (\Throwable $e) {
            return 'No se pudo enviar el correo.';
        }
    }
}
