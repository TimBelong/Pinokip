<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

try {
    if (isset($_POST['email'])) {
        $mail = new PHPMailer(true);

        // EDIT THE 2 LINES BELOW AS REQUIRED
        $email_to = $_POST['email'];
        $email_subject = "Your email subject line";

        $name = $_POST['name']; // required
        $email_from = "admin@timbelong.xyz"; // required
        $telephone = $_POST['phone']; // not required
        $message = $_POST['message']; // required

        $error_message = "";
        $email_message = "Form details below.<br/><br/>";

        function clean_string($string)
        {
            $bad = ["content-type", "bcc:", "to:", "cc:", "href"];

            return str_replace($bad, "", $string);
        }

        $email_message .= "Name: " . clean_string($name) . "<br/>";
        $email_message .= "Email: " . clean_string($email_from) . "<br/>";
        $email_message .= "Telephone: " . clean_string($telephone) . "<br/>";
        $email_message .= "Message: " . clean_string($message) . "<br/>";

        $headers = 'From: ' . $email_from . "\r\n" .
            'Reply-To: ' . $email_to . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.cz';;
        $mail->SMTPAuth = true;
        $mail->Username = 'admin@timbelong.xyz';
        $mail->Password = 'Cofn2Usp9UYA';
        $mail->SMTPSecure
            = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->SMTPAutoTLS = false;
        $mail->CharSet = PHPMailer::CHARSET_UTF8;

        //Recipients
        $mail->setFrom($email_from, 'Mailer form');
        $mail->addAddress('Berezin_kostya@mail.ua', 'Admin');
        $mail->addReplyTo($email_to, $name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Письмо формы обратной связи от: ' . $name;
        $mail->Body = $email_message;

        $aaaa = $mail->send();

        $_GET['email_success'] = 'Письмо отправлено, мы свяжемся с Вами в ближайшее время!';
        header("Location: /index.php?email_success=1" . '#comment-form');

    }
} catch (Exception $e) {
    $_GET['email_error'] = 'Ошибка отправки формы';
    header("Location: /index.php?email_error=1" . '#comment-form');
}

?>