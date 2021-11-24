<?php

class ControladorPregunta
{
    private $array;

    function __construct($var)
    {
        if ($var == 1) {
            require_once("../clases/pregunta.php");
            require_once("../modelo/preguntaModelo.php");
        } else {
            require_once("../../clases/pregunta.php");
            require_once("../../modelo/preguntaModelo.php");
        }

        $this->array = array();
    }

    function crearPregunta($id, $numero)
    {
        $preguntaModel = new ModeloPregunta(3);
        return $preguntaModel->crearPreguntas($id, $numero);
    }



    function actualizarPregunta($arr, $var)
    {
        if ($arr != null) {
            if (is_numeric($arr["id_pregunta"])) {
                $preguntaModel = new ModeloPregunta($var);
                $pregunta = new Pregunta();
                $pregunta->setId($arr["id_pregunta"]);
                $pregunta->setPregunta($arr["nombre_pregunta"]);
                $pregunta->setRespuesta1($arr["respuesta1"]);
                $pregunta->setRespuesta2($arr["respuesta2"]);
                $pregunta->setRespuesta3($arr["respuesta3"]);
                $pregunta->setRespuesta4($arr["respuesta4"]);
                $pregunta->setRespuesta_corecta($arr["respuesta_correcta"]);
                $array = $preguntaModel->actualizar($pregunta);
            } else {
                $array[] = 2;
                $array[]  = "Ingrese una pregunta valida";
            }
        } else {
            $array[] = 0;
            $array[]  = "Ingrese una pregunta valida";
        }
        return $array;
    }

    function buscarPregunta($id_capa, $ini, $fin)
    {
        if (is_numeric($id_capa)) {
            $preguntaModel = new ModeloPregunta(1);
            $array = $preguntaModel->buscar($id_capa, $ini, $fin);
        } else {
            $array[] = 2;
            $array[]  = "Ingrese una pregunta valida";
        }
        return $array;
    }


    function eliminarPregunta($arr, $var)
    {
        if (is_numeric($arr["id_pregunta"])) {
            $preguntaModel = new ModeloPregunta($var);
            $array = $preguntaModel->eliminar($arr["id_pregunta"]);
        } else {
            $array[] = 2;
            $array[]  = "La pregunta no es valida para eliminar";
        }
        return $array;
    }

    function eliminarTodasPregunta($id)
    {
        $preguntaModel = new ModeloPregunta(2);
        return $preguntaModel->eliminarTodas($id);
    }

    function validarRespuestasCompletas($id,$var){
      if (is_numeric($id)) {
            $preguntaModel = new ModeloPregunta($var);
            return $preguntaModel->preguntasCompletas($id,"");
        } else {
            $array[0] = 2;
            $array[1]  = "Las preguntas de este curso no son validas";
        }
        return $array;
    }
}
