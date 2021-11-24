<?php

class ControladorCurso
{
  private $array;

  function __construct($var)
  {
    if ($var == 1) {
      require_once("../clases/curso.php");
      require_once("../modelo/CursoModelo.php");
    } else {
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

  function actualizarCapacitacion($arr)
  {
    if ($arr != null) {
      $array = $this->validarDatoCurso($arr);
      if ($array[0] == 1) {
        $cursoMo = new ModeloCurso(1);
        $array = $cursoMo->validarCurso($arr['codigo']);
        if (($array[0] == 3 && $array[3] == $arr['id_cap']) || $array[0] == 1) {
          $aray = $cursoMo->buscarCurso($arr['id_cap']);
          require_once "../controlador/pregunta.controlador.php";
          $controlPre =  new ControladorPregunta(1);
          if ($aray[0]->getCan_pregutas() < $arr["cantidad"]) {
            $numero = $arr["cantidad"] - $aray[0]->getCan_pregutas();
            $aray = $controlPre->crearPregunta($arr['id_cap'], $numero);
          } else if ($aray[0]->getCan_pregutas() > $arr["cantidad"]) {
            $numero =  $aray[0]->getCan_pregutas() - $arr["cantidad"];
            for ($i = 0; $i < $numero; $i++) {
              $aray = $controlPre->buscarPregunta($arr['id_cap'], $arr["cantidad"], 1);
              $id_pregunta = ["id_pregunta" => $aray[0]->getId()];
              $aray = $controlPre->eliminarPregunta($id_pregunta, 3);
            }
          }
          $curso = new curso();
          $curso->setId($arr["id_cap"]);
          $curso->setNombre($arr["titulo"]);
          $curso->setDescripcion($arr["descripcion"]);
          $curso->setTiempo($arr["tiempo"]);
          $curso->setCan_pregutas($arr["cantidad"]);
          $curso->setUrl($arr["url"]);
          $curso->setEstado($arr["estado"]);
          $curso->setCodigo($arr["codigo"]);
          if (!empty(trim($_FILES["imagen"]["name"]))) {
            $test = explode('.', $_FILES["imagen"]["name"]);
            $name = $test[0] . $arr["codigo"] . '.PNG';
          } else if ($array[0] == 3) {
            $name = $arr['foto'];
          } else {
            $name = "imagen_" . $arr["codigo"] . ".PNG";
          }
          $curso->setImagen($name);
          $array =  $cursoMo->actualizar($curso);

          if ($array[0] == 1) {
            if (!empty(trim($_FILES["imagen"]["name"]))) {
              $location = '../componentes/imagenes/' . $curso->getImagen();
              move_uploaded_file($_FILES["imagen"]["tmp_name"], $location);
            } else {
              rename("../componentes/imagenes/{$arr['foto']}", "../componentes/imagenes/{$curso->getImagen()}");
            }
          }
        } else {
          $array[0] = 3;
          $array[1] = "El codigo ya esta en uso";
        }
      }
    } else {
      $array[] = 0;
    }
    return $array;
  }

  function actualizarEstado($arr, $estado)
  {
    if ((is_numeric($estado))) {
      $cursoMo = new ModeloCurso(2);
      $array = $cursoMo->validarCurso($arr["codigo"]);
      if ($array[0] == 3) {
        require_once "../../controlador/pregunta.controlador.php";
        $controlPre =  new ControladorPregunta(2);
        $array =  $controlPre->validarRespuestasCompletas($array[3], 2);
        if ($array[0] == 1) {
          $curso = new curso();
          $curso->setCodigo($arr["codigo"]);
          $curso->setEstado($estado);
          $array =  $cursoMo->actualizarEstado($curso);
        }
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
        $array =  $cursoMo->eliminarCapacitacion($arr["codigo"], $array[3]);
      }
    } else {
      $array[] = 2;
      $array[]  = "Capacitacion no valida";
    }
    return $array;
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

  function listarCapacitacion($buscar, $empieza, $por_pagina, $var)
  {
    $cursoMo = new ModeloCurso($var);
    return  $cursoMo->listar(trim($buscar), $empieza, $por_pagina);
  }


  function listarCapacitacionEstudiante($buscar, $empieza, $por_pagina, $id)
  {
    $cursoMo = new ModeloCurso(1);
    if (empty($buscar))
      return $cursoMo->listarCursosInscritos(1, $buscar, $empieza, $por_pagina, $id);
    else
      return $cursoMo->listarCursosInscritos(2, $buscar, $empieza, $por_pagina, $id);
  }

  function cantidadInscritos($buscar)
  {
    $cursoMo = new ModeloCurso(1);
    return  $cursoMo->listarInscritos($buscar);
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
