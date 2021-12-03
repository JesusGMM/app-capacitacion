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
    private $idsede;
    private $idempresa;
    private $estado;

    public function __construct() {
        
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getPassword() {
        return hash('whirlpool', $this->password);
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getRol() {
        return $this->rol;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getCapacitaciones() {
        return $this->capacitaciones;
    }

    public function getCap_realizadas() {
        return $this->cap_realizadas;
    }

    public function getIdsede() {
        return $this->idsede;
    }

    public function getIdempresa() {
        return $this->idempresa;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido): void {
        $this->apellido = $apellido;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }

    public function setUsuario($usuario): void {
        $this->usuario = $usuario;
    }

    public function setPassword($password): void {
        $this->password = $password;
    }

    public function setCodigo($codigo): void {
        $this->codigo = $codigo;
    }

    public function setRol($rol): void {
        $this->rol = $rol;
    }

    public function setCapacitaciones($capacitaciones): void {
        $this->capacitaciones = $capacitaciones;
    }

    public function setCap_realizadas($cap_realizadas): void {
        $this->cap_realizadas = $cap_realizadas;
    }

    public function setIdsede($idsede): void {
        $this->idsede = $idsede;
    }

    public function setIdempresa($idempresa): void {
        $this->idempresa = $idempresa;
    }

    public function setEstado($estado): void {
        $this->estado = $estado;
    }

}
