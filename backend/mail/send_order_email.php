<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/PHPMailer/PHPMailer/src/Exception.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/PHPMailer/PHPMailer/src/PHPMailer.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/PHPMailer/PHPMailer/src/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function sendOrderEmail($order_number, $customer_email) {
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;

        $mail->Host = "smtp.remotehost.es";
        $mail->Port = 587;
        $mail->Username = "no-reply@remotehost.es";
        $mail->Password = "Justfortesting26#";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        $mail->setFrom('no-reply@remotehost.es', 'RemoteHost');
        $mail->addAddress($customer_email);

        $mail->isHTML(true);
        $mail->Subject = "Your Order #$order_number";
        $mail->Body    = "<b>Thank you for your order!</b><br>Your order number is <b>$order_number</b>.";
        $mail->AltBody = "Thank you for your order! Your order number is $order_number.";

        $mail->send();

    } catch (Exception $e) {
        error_log("Mailer Error: " . $e->getMessage());
    }
}