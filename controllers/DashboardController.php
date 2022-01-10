<?php 

namespace Controllers;

use Model\Proyect;
use MVC\Router;

class DashboardController{

  public static function index(Router $router){
    
    // Obtener los proyectos del usuario con su id
    $proyects = Proyect::belongsTo('userId', $_SESSION['id']);
    
    $router->render('dashboard/index', [
      'title' => 'Proyectos',
      'proyects' => $proyects
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

  public static function proyect(Router $router){

    // Revisar que la persona que visita el proyecto es quien lo creó
    // Obtener url/token/id del proyecto
    $url = $_GET['url'];

    // Si no hay un token redireccionar al usuario
    if(!$url) header('Location: /dashboard');

    // Buscar el proyecto por su url/id
    $proyect = Proyect::where('url', $url);

    if($proyect->userId !== $_SESSION['id']) header('Location: /dashboard');
    
    $router->render('dashboard/proyect', [
      'title' => $proyect->proyect
    ]);

  }

  public static function profile(Router $router){
    
    $router->render('dashboard/profile', [
      'title' => 'Perfil'
    ]);

  }

}

?>