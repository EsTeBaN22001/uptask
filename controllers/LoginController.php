<?php 

namespace Controllers;

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

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

    }

    $router->render('auth/createAccount', [
      'title' => 'Crear cuenta'
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

    $router->render('auth/confirmAccount', [
      'title' => 'Confirmar cuenta'
    ]);

  }


}

?>