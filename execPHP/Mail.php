<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/infinite_knowledge/library/vendor/autoload.php');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    class Mail{
        private $mail = null;
        
        function __construct($correo,$password)
        {   
            $this->mail = new PHPMailer();
            $this->mail->isSMTP();
            $this->mail->SMTPAuth = true;
            $this->mail->SMTPSecure = 'tls';
            $this->mail->Host = "smtp.gmail.com";
            $this->mail->Port = 587;

            $this->mail->Username = $correo;
            $this->mail->Password = $password;
        }

        public function enviarCorreo($titulo,$correo,$nombre,$subject,$bodyHTML){
            $this->mail->setFrom($this->mail->Username,$titulo);
            $this->mail->addAddress($correo,$nombre);
            $this->mail->Subject = $subject;
            $this->mail->Body = $bodyHTML;
            $this->mail->isHTML(true);
            $this->mail->CharSet = "UTF-8";
            return $this->mail->send();
        }
    }
?>  