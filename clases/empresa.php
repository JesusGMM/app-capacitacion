<?php

class  Empresa{
    private $id;
    private $nit;
    private $nombre;
    private $correo;
    private $ciudad;
    private $dirrecion;
    private $telefono;
    private $estado;
    private $logo;
    private $capacitaciones;
    private $sedes;
    private $usuario;


    public function __construct() {
        
    }

    
    public function getId() {
        return $this->id;
    }

    public function getNit() {
        return $this->nit;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function getCiudad() {
        return $this->ciudad;
    }

    public function getDirrecion() {
        return $this->dirrecion;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getLogo() {
        return $this->logo;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setNit($nit): void {
        $this->nit = $nit;
    }

    public function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    public function setCorreo($correo): void {
        $this->correo = $correo;
    }

    public function setCiudad($ciudad): void {
        $this->ciudad = $ciudad;
    }

    public function setDirrecion($dirrecion): void {
        $this->dirrecion = $dirrecion;
    }

    public function setTelefono($telefono): void {
        $this->telefono = $telefono;
    }

    public function setEstado($estado): void {
        $this->estado = $estado;
    }

    public function setLogo($logo): void {
        $this->logo = $logo;
    }
    public function getCapacitaciones() {
        return $this->capacitaciones;
    }

    public function getSedes() {
        return $this->sedes;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function setCapacitaciones($capacitaciones): void {
        $this->capacitaciones = $capacitaciones;
    }

    public function setSedes($sedes): void {
        $this->sedes = $sedes;
    }

    public function setUsuario($usuario): void {
        $this->usuario = $usuario;
    }

}