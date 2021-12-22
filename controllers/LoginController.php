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

  public static function forgotPassword(){
    
    echo "Desde forgotPassword";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

    }

  }

  public static function resetPassword(){
    
    echo "Desde resetPassword";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

    }

  }

  public static function message(){
    
    echo "Desde message";

  }

  public static function confirmAccount(){
    
    echo "Desde confirmAccount";

  }


}

?>