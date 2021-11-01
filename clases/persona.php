<?php

class Persona {

    private $id;
    private $nombre, $apellido;
    private $email;
    private $usuario;
    private $password;
    private $codigo;
    private $rol;
    private $capacitaciones;
    private $cap_realizadas;

    public function __construct() {
        
    }

    public function setId($id) {
        $this->id = $id;
    }
    public function getCapacitaiones() {
        return $this->capacitaciones;
    }

    public function getCap_realizadas() {
        return $this->cap_realizadas;
    }

    public function setCapacitaiones($capacitaciones) {
        $this->capacitaciones = $capacitaciones;
    }

    public function setCap_realizadas($cap_realizadas) {
        $this->cap_realizadas = $cap_realizadas;
    }

        public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function getNombre() {
        return ucwords(trim($this->nombre));
    }

    public function getApellido() {
        return ucwords(trim($this->apellido));
    }

    public function getEmail() {
        return trim($this->email);
    }

    public function getPasword() {
        return hash('whirlpool', $this->password);
    }

    public function getRol() {
        return $this->rol;
    }

    public function getId() {
        return $this->id;
    }

    public function getUsuario() {
        return trim($this->usuario);
    }

    public function getCodigo() {
        return trim($this->codigo);
    }

}
