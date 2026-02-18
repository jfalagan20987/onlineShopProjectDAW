<?php

  require_once($_SERVER['DOCUMENT_ROOT'].'/PHPMailer/PHPMailer/src/Exception.php');
  require_once($_SERVER['DOCUMENT_ROOT'].'/PHPMailer/PHPMailer/src/PHPMailer.php');
  require_once($_SERVER['DOCUMENT_ROOT'].'/PHPMailer/PHPMailer/src/SMTP.php');

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  // Just in case
  try{
    $mail = new PHPMailer(true);

    // Code here
    $mail->isSMTP();
    $mail->SMTPAuth = true;

    // Data
    $mail->Host = "smtp.remotehost.es";
    $mail->Port = 587;
    $mail->Username = "no-reply@remotehost.es";
    $mail->Password = "Justfortesting26#";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    // Remitente
    $mail->setFrom('no-reply@remotehost.es', 'RemoteHost');

    // Destinatario
    $mail->addAddress('jfalagan20987@iesjoanramis.org', 'Josep');


    // Mail content
    $mail->isHTML(true);
    
    // Subject
    $mail->Subject = 'Testing PHPMailer';

    // HTML content
    $mail->Body = '<b>Testing HTML content</b>';
    $mail->AltBody = 'Please, don\'t crash.';

    // Attach files
    $mail->addAttachment($_SERVER['DOCUMENT_ROOT'] ."/student012/shop/assets/logos/logo_shift_and_go.png", "logo_shift_and_go.png");


    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    // Send
    $mail->send();


  } catch (Exception $e){
    echo "Mailer Error: ".$e->getMessage();
  }

?>