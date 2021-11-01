<?php
class Persona
{
    private $id;
    private $name, $apellido;
    private $email;
    private $password;
    private $role;

    public function __construct()
    {     
    }
    public function setId($id){
        $this->id = $id;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setRole($role)
    {
        $this->role = $role;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function getName(){
        return ucwords($this->name);
    }
    public function getApellido(){
        return ucwords($this->apellido);
    }
    public function getEmail(){
        return $this->email;
    }
    public function getPasword(){
        return hash('whirlpool', $this->password);
    }
    public function getRol(){
        return $this->role;
    }
    public function getId(){
        return $this->id;
    }
}
