<?php 

namespace Controllers;

use Model\Proyect;
use MVC\Router;

class DashboardController{

  public static function index(Router $router){
    
    $router->render('dashboard/index', [
      'title' => 'Proyectos'
    ]);

  }

  public static function createProyect(Router $router){
    
    $alerts = [];

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      
      $proyect = new Proyect($_POST);
      
      // Validación del proyecto
      $alerts = $proyect->validateProyect();

      if(empty($alerts)){

        // Generar una URL única para el proyecto
        $proyect->url = md5(uniqid());
        
        // Obtener el id del usuario que creó el proyecto
        $proyect->userId = $_SESSION['id'];
        
        $result = $proyect->save();

        if($result){
          header('Location: /proyect?url=' . $proyect->url);
        }

      }

    }
    
    $router->render('dashboard/create-proyect', [
      'title' => 'Crear proyecto',
      'alerts' => $alerts
    ]);

  }

  public static function profile(Router $router){
    
    $router->render('dashboard/profile', [
      'title' => 'Perfil'
    ]);

  }

}

?>