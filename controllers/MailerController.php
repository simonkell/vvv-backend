<?php

namespace controllers;

use models\ConfirmationKey;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class MailerController extends Controller
{
    public function sendMail(ConfirmationKey $confirmKey, $mailTarget) {
        require dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config.php';

        require dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'packages'. DIRECTORY_SEPARATOR . 'phpmailer'. DIRECTORY_SEPARATOR .'Exception.php';
        require dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'packages'. DIRECTORY_SEPARATOR . 'phpmailer'. DIRECTORY_SEPARATOR . 'PHPMailer.php';
        require dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'packages'. DIRECTORY_SEPARATOR . 'phpmailer'. DIRECTORY_SEPARATOR . 'SMTP.php';

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'bernstein.metanet.ch';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'noreply@volunteervsvirus.de';          // SMTP username
            $mail->Password   = $mailPw;                                // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->CharSet    = 'utf-8';

            //Recipients
            $mail->setFrom('noreply@volunteervsvirus.de', 'Volunteer Vs Virus');
            $mail->addAddress($mailTarget);     // Add a recipient
            $mail->addReplyTo('info@volunteervsvirus.com', 'Volunteer Vs Virus');

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Volunteer Vs Virus Registrierung bestätigen';

            $confirmUrl = 'api.volunteervsvirus.de/userConfirmation.php?key=' . $confirmKey->key; // Used in registration.php
            // TEMPLATE
            require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'mail-templates'. DIRECTORY_SEPARATOR . 'registration.php';
            $mail->Body = $mailTemplateRegistration;

            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        return false;
    }
}