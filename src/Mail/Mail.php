<?php

namespace Scuba\Web\Mail;

use PHPMailer\PHPMailer\PHPMailer;
require_once 'MailConstants.php';
class Mail
{
    private PHPMailer $mail;
    public function __construct()
    {
        $this->mail = new PHPMailer();
        $this->mail->isSMTP();
        $this->mail->SMTPAuth = true;
        $this->mail->Username = USERNAME;
        $this->mail->Password = PASSWORD;
        $this->mail->Host = 'smtp.mailtrap.io';
        $this->mail->Port = 2525;
    }

    public function sendMail($toEmail, $toName, $crypted)
    {
        try {
            $this->mail->setFrom('contact@scuba.com.br', 'Lok');
            $this->mail->addAddress($toEmail, $toName);

            $this->mail->Subject = 'Confirme sua senha';
            $this->mail->Body = "Confirme o email <a href='http://localhost:4242/?page=mail-validation&from=$crypted&email=$toEmail'>AQUI</a>";
            $this->mail->AltBody = 'Este é o cortpo da mensagem para clientes de e-mail que não reconhecem HTML';
            $this->mail->send();
            echo 'Email enviado!';
        } catch (\Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }
}