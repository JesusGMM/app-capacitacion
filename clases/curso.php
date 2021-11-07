<?php

class Curso {
private $id;
private $nombre;
private $codigo;
private $descripcion;
private $tiempo;
private $can_pregutas;
private $url;
private $imagen;
private $estado;
public function __construct() {
    
}
public function getImagen() {
    return $this->imagen;
}

public function setImagen($imagen): void {
    $this->imagen = $imagen;
}

public function getId() {
    return $this->id;
}

public function getNombre() {
    return $this->nombre;
}

public function getCodigo() {
    return $this->codigo;
}

public function getDescripcion() {
    return $this->descripcion;
}

public function getTiempo() {
    return $this->tiempo;
}

public function getCan_pregutas() {
    return $this->can_pregutas;
}

public function getUrl() {
    return $this->url;
}

public function setId($id): void {
    $this->id = $id;
}

public function setNombre($nombre): void {
    $this->nombre = $nombre;
}

public function setCodigo($codigo): void {
    $this->codigo = $codigo;
}

public function setDescripcion($descripcion): void {
    $this->descripcion = $descripcion;
}

public function setTiempo($tiempo): void {
    $this->tiempo = $tiempo;
}

public function setCan_pregutas($can_pregutas): void {
    $this->can_pregutas = $can_pregutas;
}

public function setUrl($url): void {
    $this->url = $url;
}
public function getEstado() {
    return $this->estado;
}

public function setEstado($estado): void {
    $this->estado = $estado;
}

}