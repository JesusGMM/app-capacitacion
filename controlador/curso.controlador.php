<?php

class ControladorCurso
{
  private $array;

  function __construct($var)
  {
    if ($var == 1){
      require_once("../clases/curso.php");
      require_once("../modelo/CursoModelo.php");
    }else{
      require_once("../../clases/curso.php");
      require_once("../../modelo/CursoModelo.php");
    }

    $this->array = array();
  }
  function crear($arr)
  {
    if ($arr != null) {

      $array = $this->validarDatoCurso($arr);
      if ($array[0] == 1) {
        $cursoMo = new ModeloCurso(1);
        $array = $cursoMo->validarCurso($arr['codigo']);
        if ($array[0] == 1) {
          $curso = new curso();
          $curso->setNombre($arr["titulo"]);
          $curso->setDescripcion($arr["descripcion"]);
          $curso->setTiempo($arr["tiempo"]);
          $curso->setCan_pregutas($arr["cantidad"]);
          $curso->setUrl($arr["url"]);
          $curso->setEstado($arr["estado"]);
          $curso->setCodigo($arr["codigo"]);
          $curso->setImagen("imagen_" . $arr["codigo"] . ".png");
          $array =  $cursoMo->crear($curso);
          if ($array[0] == 1) {
            if (!empty(trim($_FILES["imagen"]["name"]))) {
              $name = $curso->getImagen();
              $location = '../componentes/imagenes/' . $name;
              move_uploaded_file($_FILES["imagen"]["tmp_name"], $location);
            }
          }
        }
      }
    } else {
      $array[0] = 0;
    }
    return $array;
  }

  function actualizarEstado($arr, $estado)
  {
    if ((is_numeric($estado))) {
      $cursoMo = new ModeloCurso(2);
      $array = $cursoMo->validarCurso($arr["codigo"]);
      if ($array[0] == 3) {
        $curso = new curso();
        $curso->setCodigo($arr["codigo"]);
        $curso->setEstado($estado);
        $array =  $cursoMo->actualizarEstado($curso);
      }
    } else {
      $array[] = 2;
      $array[]  = "Capacitacion no valida";
    }
    return $array;
  }

  function actualizarCantidadPregunta($arr, $var)
  {
    if (!empty(trim($arr["codigo"]))) {
      $cursoMo = new ModeloCurso($var);
      $array = $cursoMo->validarCurso($arr["codigo"]);
      if ($array[0] == 3) {
        $numero = ($array[2] - 1);
        $curso = new curso();
        $curso->setCodigo($arr["codigo"]);
        $curso->setCan_pregutas($numero);
        $array =  $cursoMo->actualizarNumeroPreguntas($curso);
        $array[2] = $numero; 
      }
    } else {
      $array[] = 2;
      $array[]  = "Capacitacion no valida";
    }
    return $array;
  }


  function eliminar($arr)
  {
    if (!empty(trim($arr["codigo"]))) {
      $cursoMo = new ModeloCurso(2);
      $array = $cursoMo->validarCurso($arr["codigo"]);
      if ($array[0] == 3) {
        $array =  $cursoMo->eliminarCapacitacion($arr["codigo"],$array[3]);
      }
    } else {
      $array[] = 2;
      $array[]  = "Capacitacion no valida";
    }
    return $array;
  }
  function publicar($id)
  {
  }
  function desPublicar($id)
  {
  }

  function buscarCapacitacion($id)
  {
    if (intval($id)) {
      $cursoMo = new ModeloCurso(1);
      $array = $cursoMo->buscarCurso($id);
    } else {
      $array[] = 2;
      $array[]  = "Ingrese una capacitación valida";
    }
    return $array;
  }

  function listarCapacitacion($buscar, $empieza, $por_pagina)
  {
    $cursoMo = new ModeloCurso(1);
    return  $cursoMo->listar(trim($buscar), $empieza, $por_pagina);
  }

  function validarDatoCurso($arr)
  {
    if (trim($arr["titulo"]) == "") {
      $array[] = 2;
      $array[]  = "Ingrese un titulo";
    } else if (trim($arr["codigo"]) == "") {
      $array[] = 2;
      $array[]  = "Ingrese un codigo";
    } else if (trim($arr["url"]) == "") {
      $array[] = 2;
      $array[]  = "Ingrese una url para el video";
    } else if (trim($arr["tiempo"]) == "") {
      $array[] = 2;
      $array[]  = "Ingrese un tiempo en minutos";
    } else if (trim($arr["cantidad"]) == "" || intval($arr["cantidad"]) < 1) {
      $array[] = 2;
      $array[]  = "Ingrese un numero de preguntas mayor a 0";
    } else {
      $array[] = 1;
    }

    return $array;
  }
}