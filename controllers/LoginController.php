<?php 

namespace Controllers;

use Classes\Email;
use Model\User;
use MVC\Router;

class LoginController{

  public static function login(Router $router){
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

    }

    $router->render('auth/login', [
      'title' => 'Iniciar sesión'
    ]);

  }

  public static function logout(){
    
    echo "Desde logout";

  }

  public static function createAccount(Router $router){

    // Nueva instancia de usuario
    $user = new User();
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

      // Sincronizar los datos del post con la instancia de usuario
      $user->syncUp($_POST);

      // Validar los campos
      $alerts = $user->validateNewAccount();

      if(empty($alerts)){

        // Verificar si un usuario existe
        $userExists = User::where('email', $user->email);
        
        if($userExists){
          $alerts = User::setAlert('error', 'El usuario ya existe');
        }else{
          
          // Hashear la contraseña
          $user->hashPassword();

          // Eliminar password2
          unset($user->password2);
          
          // Crear un token único
          $user->createToken();
          
          // Crear usuario
          $result = $user->save();

          // Enviar email
          $email = new Email($user->email, $user->name, $user->token);
          $email->sendConfirmation();

          if($result){
            header('Location: /message');
          }

        }

      }

    }

    $alerts = $user->getAlerts();

    $router->render('auth/createAccount', [
      'title' => 'Crear cuenta',
      'user' => $user,
      'alerts' => $alerts
    ]);

  }

  public static function forgotPassword(Router $router){

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

    }

    $router->render('auth/forgotPassword', [
      'title' => 'Recuperar contraseña'
    ]);

  }

  public static function resetPassword(Router $router){

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

    }

    $router->render('auth/reset-password', [
      'title' => 'Reestablecer contraseña'
    ]);

  }

  public static function message(Router $router){

    $router->render('auth/message', [
      'title' => 'Mensaje de confirmación'
    ]);

  }

  public static function confirmAccount(Router $router){

    $token = $_GET['token'];
    
    if(!$token){
      header('Location: /');
    }

    // Encontrar al usuario con el token
    $user = User::where('token', $token);
    
    if(empty($user)){
      User::setAlert('error', 'Token no válido');
    }else{

      $user->confirmed = 1;
      $user->token = null;
      unset($user->password2);
      
      $result = $user->save();

      if($result){
        User::setAlert('success', 'Cuenta confirmada correctamente');
      }

    }

    $alerts = User::getAlerts();
    
    $router->render('auth/confirmAccount', [
      'title' => 'Confirmar cuenta',
      'alerts' => $alerts
    ]);

  }


}

?>