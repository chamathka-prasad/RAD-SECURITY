<?php
require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;

class MailSender
{
    public static function sendMail($email, $subject, $body)
    {
        if (!empty($email) && !empty($subject) && !empty($body)) {



            $mail = new PHPMailer;
            $mail->IsSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'chamathkaprasad123@gmail.com';
            $mail->Password = 'jlmd llzz vzwj sica';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('chamathkaprasad123@gmail.com', 'Robotic Assistance Devices');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->AddEmbeddedImage('../assetss/images/logo.webp', 'logo_cid');
            $bodyContent = $body;
            $mail->Body    = $bodyContent;

            if (!$mail->send()) {
            } else {
            }
        }
    }
}
