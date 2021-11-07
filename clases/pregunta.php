<?php 
class Pregunta{
    private $id;
    private $id_capacitacion;
    private $pregunta;
    private $respuesta1;
    private $respuesta2;
    private $respuesta3;
    private $respuesta4;
    private $respuesta_corecta;
    public function __construct() {
        
    }
    public function getId() {
        return $this->id;
    }

    public function getId_capacitacion() {
        return $this->id_capacitacion;
    }

    public function getPregunta() {
        return $this->pregunta;
    }

    public function getRespuesta1() {
        return $this->respuesta1;
    }

    public function getRespuesta2() {
        return $this->respuesta2;
    }

    public function getRespuesta3() {
        return $this->respuesta3;
    }

    public function getRespuesta4() {
        return $this->respuesta4;
    }

    public function getRespuesta_corecta() {
        return $this->respuesta_corecta;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setId_capacitacion($id_capacitacion): void {
        $this->id_capacitacion = $id_capacitacion;
    }

    public function setPregunta($pregunta): void {
        $this->pregunta = $pregunta;
    }

    public function setRespuesta1($respuesta1): void {
        $this->respuesta1 = $respuesta1;
    }

    public function setRespuesta2($respuesta2): void {
        $this->respuesta2 = $respuesta2;
    }

    public function setRespuesta3($respuesta3): void {
        $this->respuesta3 = $respuesta3;
    }

    public function setRespuesta4($respuesta4): void {
        $this->respuesta4 = $respuesta4;
    }

    public function setRespuesta_corecta($respuesta_corecta): void {
        $this->respuesta_corecta = $respuesta_corecta;
    }

}