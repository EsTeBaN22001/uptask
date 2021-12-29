<?php 

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

  protected $email;
  protected $name;
  protected $token;

  public function __construct($email, $name, $token)
  {
    $this->email = $email ?? '';
    $this->name = $name ?? '';
    $this->token = $token ?? '';
  }

  public function sendConfirmation(){

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Port = 2525;
    $mail->Username = '9092877c2d9ec1';
    $mail->Password = '84321ee8f7580a';

    $mail->setFrom('accounts@uptask.com');
    $mail->addAddress('accounts@uptask.com', 'uptask.com');
    $mail->Subject = 'Confirma tu cuenta';

    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';

    $content = '<html>';
    $content .= '<p><strong>Hola ' . $this->name . '</strong>. Has creado tu cuenta en UpTask, solo debes confirmarla en el siguiente enlace</p>';
    $content .= '<a href="http://localhost:3000/confirm-account?token=' . $this->token .  '">Confirmar cuenta</a>';
    $content .= '<p>Si tu no creaste esta cuenta puedes ignorar el mensaje</p>';
    $content .= '</html>';

    $mail->Body = $content;

    $mail->send();

  }

  public function sendInstructions(){

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Port = 2525;
    $mail->Username = '9092877c2d9ec1';
    $mail->Password = '84321ee8f7580a';

    $mail->setFrom('accounts@uptask.com');
    $mail->addAddress('accounts@uptask.com', 'uptask.com');
    $mail->Subject = 'Reestablece tu contraseña';

    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';

    $content = '<html>';
    $content .= '<p><strong>Hola ' . $this->name . '</strong>. Parece que has olvidado tu contraseña, sigue el siguiente enlace para recuperarla.</p>';
    $content .= '<a href="http://localhost:3000/reset-password?token=' . $this->token .  '">Reestablecer contraseña</a>';
    $content .= '<p>Si tu no creaste esta cuenta puedes ignorar el mensaje</p>';
    $content .= '</html>';

    $mail->Body = $content;

    $mail->send();
    
  }

}

?>