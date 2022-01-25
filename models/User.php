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
    $this->password2 = $args['password2'] ?? '';
    $this->actualPassword = $args['actualPassword'] ?? '';
    $this->newPassword = $args['newPassword'] ?? '';
    $this->token = $args['token'] ?? '';
    $this->confirmed = $args['confirmed'] ?? 0;
  }

  public function validateNewAccount(){

    if(!$this->name){
      self::$alerts['error'][] = 'El nombre es obligatorio';
    }

    if(!$this->email){
      self::$alerts['error'][] = 'El correo es obligatorio';
    }

    if(!$this->password){
      self::$alerts['error'][] = 'La contraseña es obligatoria';
    }

    if(strlen($this->password) < 6){
      self::$alerts['error'][] = 'La contraseña debe tener al menos 6 caracteres';
    }

    if($this->password !== $this->password2){
      self::$alerts['error'][] = 'Las contraseñas no coinciden';
    }

    return self::$alerts;
  }

  public function validateEmail(){

    if(!$this->email){
      self::$alerts['error'][] = 'El correo es obligatorio';
    }

    if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
      self::$alerts['error'][] = 'Correo no válido';
    }

    return self::$alerts;

  }

  public function validatePassword(){

    if(!$this->password){
      self::$alerts['error'][] = 'La contraseña es obligatoria';
    }

    if(strlen($this->password) < 6){
      self::$alerts['error'][] = 'La contraseña debe tener al menos 6 caracteres';
    }

    return self::$alerts;

  }

  public function validateLogin(){

    if(!$this->email){
      self::$alerts['error'][] = 'El correo es obligatorio';
    }

    if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
      self::$alerts['error'][] = 'Correo no válido';
    }

    if(!$this->password){
      self::$alerts['error'][] = 'La contraseña es obligatoria';
    }

    if(strlen($this->password) < 6){
      self::$alerts['error'][] = 'La contraseña debe tener al menos 6 caracteres';
    }

    return self::$alerts;

  }

  public function validateProfile(){

    if(!$this->name){
      self::$alerts['error'][] = 'El nombre es obligatorio';
    }

    if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
      self::$alerts['error'][] = 'Correo no válido';
    }

    return self::$alerts;

  }

  public function newPassword(){

    if(!$this->actualPassword){
      self::$alerts['error'][] = 'La contraseña actual no puede ir vacía';
    }

    if(!$this->newPassword){
      self::$alerts['error'][] = 'La nueva contraseña no puede ir vacía';
    }

    if(strlen($this->newPassword) < 6){
      self::$alerts['error'][] = 'La contraseña debe tener al menos 6 caracteres';
    }

    return self::$alerts;

  }

  public function verifyPassword(){
    return password_verify($this->actualPassword, $this->password);
  }

  public function hashPassword(){
    $this->password = password_hash($this->password, PASSWORD_BCRYPT);
  }

  public function createToken(){
    $this->token = md5(uniqid());
  }

  public function startSession(){
    session_unset();

    $_SESSION['id'] = $this->id;
    $_SESSION['name'] = $this->name;
    $_SESSION['email'] = $this->email;
    $_SESSION['login'] = true;

  }

}

?>