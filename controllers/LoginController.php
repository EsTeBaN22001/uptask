<?php 

namespace Controllers;

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

        if(!$auth){
          User::setAlert('error', 'El usuario no existe');
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
          $alerts = User::setAlert('error', 'El correo ya está en uso');
        }else{

          // Generar una URL única para el proyecto
          $user->uniqId = md5(uniqid());
          
          // Hashear la contraseña
          $user->hashPassword();

          // Hashear la palabra clave
          $user->hashKeyword();

          // Eliminar password2
          unset($user->password2);
          
          // Crear usuario
          $result = $user->save();

          if($result){
            header('Location: /dashboard');
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

        $auth = User::where('email', $user->email);

        if($auth){

          // Verificar que la keyword sea correcta
          $verifyKeyword = User::belongsTo('keyword', $auth->keyword)[0];

          if(password_verify($user->keyword, $verifyKeyword->keyword)){
            header('Location: /reset-password?idUser=' . $verifyKeyword->uniqId);
          }else{
              User::setAlert('error', 'La palabra clave no coincide');
          }
          // Guardar los cambios del usuario
          // $result = $user->save();

          // if($result){
          //   User::setAlert('success', 'Hemos enviado las instrucciones a tu correo');
          // }

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
    
    // Mostrar el input de la contraseña
    $showInputPassword = true;
    
    $uniqId = s($_GET['idUser']);

    if(!$uniqId) header('Location: /');

    // Identificar al usuario con el token
    $user = User::where('uniqId', $uniqId);
    
    if(empty($user)){
      User::setAlert('error', 'Usuario no válido');
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

}

?>