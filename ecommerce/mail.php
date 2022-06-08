<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../mail/src/Exception.php';
require '../mail/src/PHPMailer.php';
require '../mail/src/SMTP.php';
$mail = new PHPMailer(true);
    
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;  
    $mail->isSMTP();                         
    $mail->Host       = 'smtp.gmail.com';     
    $mail->SMTPAuth   = true;                                
    $mail->Username   = 'montoshrai8@gmail.com';     
    $mail->Password   = 'montosh@123gmail';              
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     
    $mail->Port       = 587;                                 

    $mail->setFrom('montoshrai8@gmail.com', 'Sneekers');
    
?>