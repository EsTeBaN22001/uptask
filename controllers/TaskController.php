<?php 

namespace Controllers;

use Model\Proyect;
use Model\Task;

class TaskController{

  public static function index(){
    $proyectId = $_GET['url'];
    
    if(!$proyectId) header('Location: /dashboard');

    $proyect = Proyect::where('url', $proyectId);
    
    if(!$proyect || $proyect->userId !== $_SESSION['id']) header('Location: /404');

    $tasks = Task::belongsTo('proyectId', $proyect->id);
    
    echo json_encode(['tasks' => $tasks]);
  }

  public static function create(){

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

      $proyectId = $_POST['proyectId'];

      $proyect = Proyect::where('url', $proyectId);

      if(!$proyect || $proyect->userId !== $_SESSION['id']){
        $response = [
          'type' => 'error',
          'message' => 'Hubo un error al agregar la tarea! :('
        ];
        return;
      }

      // Todo correcto, instanciar y crear la tarea

      $task = new Task($_POST);
      $task->proyectId = $proyect->id;
      $result = $task->save();

      if($result){
        $response = [
          'type' => 'success',
          'message' => 'Se agregó la tarea con éxito',
          'id' => $result['id'],
          'proyectId' => $proyect->id
        ];
      }

      echo json_encode($response);
     
    }

  }

  public static function update(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

      // Validar que el proyecto exista
      $proyect = Proyect::where('url', $_POST['proyectId']);
      
      if(!$proyect || $proyect->userId !== $_SESSION['id']){

        $response = [
          'error' => 'error',
          'message' => 'Hubo un error al actualizar la tarea'
        ];

        return;

      }

      $task = new Task($_POST);
      $task->proyectId = $proyect->id;
      
      $result = $task->save();

      if($result){

        $response = [
          'type' => 'success',
          'id' => $task->id,
          'proyectId' => $proyect->id,
          'message' => 'Actualizado correctamente'
        ];

      }

      echo json_encode($response);
    }
  }

  public static function delete(){

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

      // Validar que el proyecto exista
      $proyect = Proyect::where('url', $_POST['proyectId']);

      if(!$proyect || $proyect->userId !== $_SESSION['id']){

        $response = [
          'error' => 'error',
          'message' => 'Hubo un error al actualizar la tarea',
        ];

        return;

      }

      $task = new Task($_POST);
      $result = $task->delete();

      $result = [
        'result' => $result,
        'message' => 'Eliminado correctamente',
        'type' => 'success'
      ];
      
      echo json_encode($result);
    }

  }

}

?>