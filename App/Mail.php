<?php

namespace App;

use PHPMailer;

/**
 * Mail
 * 
 * PHP version 5.5
 */
class Mail
{
    /**
     * Send a message
     * 
     * @param string $to Recipient
     * @param string $subject Subject
     * @param string $text Text-only content of the message
     * @param string $html HTML content of the message
     * 
     * @return mixed
     */
    public static function send($to, $subject, $text, $html, $cc = NULL) {
        $mail = new PHPMailer();

        $mail->isMail();                                      // Set mailer to use SMTP
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = Config::EMAIL_USER;                 // SMTP username
        $mail->Password = Config::EMAIL_PASS;                 // SMTP password
        $mail->Port = 465;                                    // TCP port to connect to
        $mail->isHTML(true);                                  // Set email to HTML
        $mail->SMTPDebug = 0;

        $mail->setFrom(Config::EMAIL_USER, Config::EMAIL_NAME);        
        $mail->addAddress($to);               // Name is optional
        
        if (isset($cc)) {
            foreach ($cc as $address) {
                $mail->addAddress($address);
            }
        }

        $mail->Subject = $subject;
        $mail->Body    = $html;
        $mail->AltBody = $text;

        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }
}