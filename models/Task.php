<?php 

namespace Model;

class Task extends ActiveRecord{

  protected static $table = 'tasks';
  protected static $columnsDB = ['id', 'name', 'state', 'proyectId'];

  public function __construct($args = [])
  {
    $this->id = $args['id'] ?? null;
    $this->name = $args['name'] ?? '';
    $this->state = $args['state'] ?? 0;
    $this->proyectId = $args['proyectId'] ?? '';
  }

}

?>