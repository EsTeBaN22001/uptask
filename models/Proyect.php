<?php 

namespace Model;

use Model\ActiveRecord;

class Proyect extends ActiveRecord{
  
  protected static $table = 'proyects';
  protected static $columnsDB = ['id', 'proyect', 'url', 'userId'];

  public function __construct($args = [])
  {
    $this->id = $args['id'] ?? null;
    $this->proyect = $args['proyect'] ?? '';
    $this->url = $args['url'] ?? '';
    $this->userId = $args['userId'] ?? '';
  }

  public function validateProyect(){

    if(!$this->proyect){
      self::$alerts['error'][] = 'El nombre del proyecto es obligatorio';
    }

    return self::$alerts;

  }

}

?>