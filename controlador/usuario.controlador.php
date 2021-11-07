<?php

class ControladorUsuario
{

  private $array;

  function __construct($var)
  {
    if ($var == 1) {
      require_once("../modelo/conexion.php");
      require_once("../modelo/usuario.modelo.php");
      require_once("../clases/persona.php");
    } else {
      require_once("../../modelo/conexion.php");
      require_once("../../modelo/usuario.modelo.php");
      require_once("../../clases/persona.php");
    }

    $this->array = array();
  }

  function crear($arr)
  {
    if ($arr != null) {
      $dato = validar($arr);
      if ($dato[0] == 1) {
        $personaMo = new ModeloUsuario(1);
        $array = $personaMo->validarUsuario($arr['usuario']);
        if ($array[0] == 1) {
          $persona = new Persona();
          $persona->setNombre($arr["nombre"]);
          $persona->setApellido($arr["apellido"]);
          $persona->setEmail($arr["correo"]);
          $persona->setUsuario($arr["usuario"]);
          $persona->setPassword($arr["contrasena"]);
          $persona->setRol($arr["roles"]);
          $persona->setCodigo($arr["codigo"]);
          return $personaMo->registrar($persona);
        } else {
          return $array;
        }
      } else {
        return $dato;
      }
    } else {
      $array[0] = 0;
      return $array;
    }
  }

  function listar($buscar, $empieza, $por_pagina)
  {
    $personaMo = new ModeloUsuario(1);

    if (empty(trim($buscar))) {
      return $personaMo->listar($empieza, $por_pagina);
    } else {
      return $personaMo->buscar(trim($buscar), $empieza, $por_pagina);
    }
  }

  function buscarUsuarios($id, $tipo)
  {
    $personaMo = new ModeloUsuario($tipo);
    if (!empty(trim($id))) {
      return $personaMo->buscarUsuario(trim($id));
    }
  }


  function editar($arr)
  {
    if ($arr != null) {
      $dato = validar($arr);
      if ($dato[0] == 1) {
        $personaMo = new ModeloUsuario(2);
        $persona = new Persona();
        $persona->setId($arr['id']);
        $persona->setNombre($arr["nombre"]);
        $persona->setApellido($arr["apellido"]);
        $persona->setEmail($arr["email"]);
        $persona->setUsuario($arr["usuario"]);
        $persona->setPassword($arr["contrasena"]);
        $persona->setRol($arr["perfil"]);
        $persona->setCodigo($arr["codigo"]);
        return $personaMo->actualizar($persona);
      } else {
        return $dato;
      }
    } else {
      $array[0] = 0;
      return $array;
    }
  }

  function eliminar($id)
  {
    if (empty(trim($id))) {
      $array[] = 2;
      $array[]  = "Usuario no encontrado";
      return $array;
    } else {
      $personaMo = new ModeloUsuario(2);
      return $personaMo->eliminar(trim($id));
    }
  }
}

function validar($arr)
{
  $array = array();
  if (trim($arr["nombre"]) == "") {
    $array[] = 2;
    $array[]  = "Ingrese un nombre valido";
  } else if (trim($arr["usuario"]) == "") {
    $array[] = 2;
    $array[]  = "Ingrese un nombre de usuario valido";
  } else if (trim($arr["usuario"]) == "") {
    $array[] = 2;
    $array[]  = "Ingrese un nombre de usuario valido";
  } else {
    $array[] = 1;
  }
  return $array;
}
