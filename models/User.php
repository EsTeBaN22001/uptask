<?php 

namespace Model;

class User extends ActiveRecord{

  protected static $table = 'users';
  protected static $columnsDB = ['id', 'name', 'email', 'password', 'token', 'confirmed'];

  public function __construct($args = [])
  {
    $this->id = $args['id'] ?? null;
    $this->name = $args['name'] ?? '';
    $this->email = $args['email'] ?? '';
    $this->password = $args['password'] ?? '';
    $this->token = $args['token'] ?? '';
    $this->confirmed = $args['confirmed'] ?? '';
  }

}

?>