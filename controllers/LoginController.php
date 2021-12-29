<?php 

namespace Controllers;

use Classes\Email;
use Model\User;
use MVC\Router;

class LoginController{

  public static function login(Router $router){
  
    $alerts = [];

    $user = new User();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

      // Sincronizar los datos del post con una instancia de usuario
      $user->syncUp($_POST);

      // Validar campos
      $alerts = $user->validateLogin();

      if(empty($alerts)){

        $auth = User::where('email', $user->email);

        if(!$auth || !$auth->confirmed){
          User::setAlert('error', 'El usuario no existe o no está confirmado');
        }else{

          // Verificar la contraseña
          if(password_verify($user->password, $auth->password)){
            
            $auth->startSession();

            // Redireccionar al usuario
            header('Location: /dashboard');

          }else{
            User::setAlert('error', 'La contraseña es incorrecta');
          }

        }

      }

    }

    $alerts = User::getAlerts();

    $router->render('auth/login', [
      'title' => 'Iniciar sesión',
      'alerts' => $alerts,
      'user' => $user
    ]);

  }

  public static function logout(){
    session_unset();
    header('Location: /');
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

    $alerts = [];
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

      // Nueva instancia de un usuario
      $user = new User($_POST);

      // Validar el email
      $alerts = $user->validateEmail();

      if(empty($alerts)){

        $user = User::where('email', $user->email);

        if($user && $user->confirmed == 1){
          
          $user->createToken();
          unset($user->password2);

          // Crear una instancia del email y enviar las instrucciones
          $email = new Email($user->email, $user->name, $user->token);
          $email->sendInstructions();

          // Guardar los cambios del usuario
          $result = $user->save();

          if($result){
            User::setAlert('success', 'Hemos enviado las instrucciones a tu correo');
          }

        }else{
          User::setAlert('error', 'El usuario no existe o no está confirmado');
        }

      }

    }

    $alerts = User::getAlerts();

    $router->render('auth/forgotPassword', [
      'title' => 'Recuperar contraseña',
      'alerts' => $alerts
    ]);

  }

  public static function resetPassword(Router $router){
    
    $token = s($_GET['token']);

    // Mostrar el input de contraseña o no
    $showInputPassword = true;

    if(!$token) header('Location: /');

    // Identificar al usuario con el token
    $user = User::where('token', $token);
    
    if(empty($user)){
      User::setAlert('error', 'Token no válido');
      $showInputPassword = false;
    }else{

    }
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

      // Sincronizar los datos del usuario con el post
      $user->syncUp($_POST);
      
      // Validar la contraseña
      $alerts = $user->validatePassword();

      if(empty($alerts)){

        $user->hashPassword();
        unset($user->password2);
        $user->token = null;

        $result = $user->save();

        if($result){
          header('Location: /');
        }

      }

    }

    // Obtener las alertas
    $alerts = User::getAlerts();
    
    $router->render('auth/reset-password', [
      'title' => 'Reestablecer contraseña',
      'alerts' => $alerts,
      'showInputPassword' => $showInputPassword
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