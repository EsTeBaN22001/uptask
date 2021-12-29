<?php 

namespace Controllers;

use MVC\Router;

class DashboardController{

  public static function index(Router $router){
    
    $router->render('dashboard/index', [
      'title' => 'Proyectos'
    ]);

  }

  public static function createProyect(Router $router){
    
    $router->render('dashboard/create-proyect', [
      'title' => 'Crear proyecto'
    ]);

  }

  public static function profile(Router $router){
    
    $router->render('dashboard/profile', [
      'title' => 'Perfil'
    ]);

  }

}

?>