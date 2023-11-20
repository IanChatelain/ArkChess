<?php

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email {
    public static function validationEmail($email) {
        // True enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 1;
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '1185228d01ade6';
            $mail->Password = '4cc18f574b102b';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            //Recipients
            $mail->setFrom('registration@arkchess.ca', 'ArkChess Registration');
            $mail->addAddress($email);

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Email Validation';
            $mail->Body    = 'Please click the following link to validate your email: <a href="http://localhost:8012/ArkChess/validate.php">Validate Email</a>';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }
}
?>
