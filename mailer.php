<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require ROOT.'/vendor/autoload.php';

function send_mail(array $sender, array $receiver, array $message) {
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    $mail->CharSet = "UTF-8";
    $mail->Encoding = 'base64';
    try {
        //Server settings
        $mail->SMTPDebug = 0;                      //2 or SMTP::DEBUG_SERVER to Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = DB_HOST;                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $sender['email'];                     //SMTP username
        $mail->Password   = $sender['password'];                               //SMTP password
        $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        if(isset($sender['displayname'])) {
            $mail->setFrom($sender['email'], $sender['displayname']);
        } else {
            $mail->setFrom($sender['email']);
        }
        
        if(isset($receiver['displayname'])) {
            $mail->addAddress($receiver['email'], $receiver['displayname']);
        } else {
            $mail->addAddress($receiver['email']);
        }
        
        //$mail->addAddress('chyjohn777@gmail.com', 'Joe User');     //Add a recipient
        /*$mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');*/
        
        if(isset($receiver['bcc'])) {
            foreach($receiver['bcc'] as $val) {
                $mail->addBCC($val);
            }
        }
    
        //Attachments
        /*$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    
        //Content */
        $mail->isHTML(true);                                 //Set email format to HTML
        $mail->Subject = $message['subject'];
        $mail->Body    = $message['body'];
        $mail->AltBody = $message['alt'];
    
        $mail->send();
        return true;
        //echo 'Message has been sent';
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}", 3, ENV['MAILER_ERR_URL']);
        return false;
    }
}