<?php

class ControladorUsuario
{

    private $array;

    function __construct($var)
    {
        if ($var == 1) {
            require_once("../modelo/conexion.php");
            require_once("../modelo/UsuarioModelo.php");
            require_once("../clases/persona.php");
        } else {
            require_once("../../modelo/conexion.php");
            require_once("../../modelo/UsuarioModelo.php");
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
                    if ($arr["perfil"] == 2) {
                        $persona->setIdempresa($arr["idempresa"]);
                        $persona->setIdsede($arr["idsede"]);
                    } else {
                        $persona->setIdempresa(0);
                        $persona->setIdsede(0);
                    }
                    $persona->setNombre($arr["nombre"]);
                    $persona->setApellido($arr["apellido"]);
                    $persona->setEmail($arr["email"]);
                    $persona->setUsuario($arr["usuario"]);
                    $persona->setPassword($arr["contrasena"]);
                    $persona->setRol($arr["roles"]);
                    $persona->setCodigo($arr["codigo"]);
                    if (isset($arr["estado"])) $est = 1;
                    else  $est = 0;
                    $persona->setEstado($est);
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

    function listar($buscar, $empieza, $por_pagina, $var)
    {
        $personaMo = new ModeloUsuario($var);
        return $personaMo->listar(trim($buscar), $empieza, $por_pagina);
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
                if ($arr["perfil"] == 2) {
                    $persona->setIdempresa($arr["idempresa"]);
                    $persona->setIdsede($arr["idsede"]);
                } else {
                    $persona->setIdempresa(0);
                    $persona->setIdsede(0);
                }
                $persona->setNombre($arr["nombre"]);
                $persona->setApellido($arr["apellido"]);
                $persona->setEmail($arr["email"]);
                $persona->setUsuario($arr["usuario"]);
                $persona->setPassword($arr["contrasena"]);
                $persona->setRol($arr["perfil"]);
                $persona->setCodigo($arr["codigo"]);
                if (isset($arr["estado"])) $est = 1;
                else  $est = 0;
                $persona->setEstado($est);
                return $personaMo->actualizar($persona);
            } else {
                return $dato;
            }
        } else {
            $array[0] = 0;
            return $array;
        }
    }

    function editarPerfil($arr)
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
                $persona->setCodigo($arr["codigo"]);
                return $personaMo->actualizarPerfil($persona);
            } else {
                return $dato;
            }
        } else {
            $array[0] = 0;
            return $array;
        }
    }

    function editarClave($arr)
    {
        if ($arr != null) {
            $personaMo = new ModeloUsuario(2);
            $array = $personaMo->validarClave($arr['id'], hash('whirlpool', $arr['clave']));
            if ($array[0] == 1) {
                return $personaMo->actualizarPassword($arr['id'], hash('whirlpool', $arr['clave-nueva1']));
            }
        } else {
            $array[0] = 2;
            $array[1] = "Datos Invalidos";
        }
        return $array;
    }

    function eliminar($id)
    {
        if (empty(trim($id))) {
            $array[] = 2;
            $array[] = "Usuario no encontrado";
            return $array;
        } else {
            $personaMo = new ModeloUsuario(2);
            return $personaMo->eliminar(trim($id));
        }
    }

    function validarCurso($id, $codigo, $var)
    {
        $personaMo = new ModeloUsuario($var);
        return $personaMo->validarCapacitaciones($id, $codigo);
    }

    function asignar($arr, $var)
    {
        $personaMo = new ModeloUsuario($var);
        foreach ($arr['asignar'] as $codigo) {
            $array = $personaMo->asignarCapacitaciones($arr['id_usuario'], $codigo);
        }
        return $array;
    }

    function asignarCapacitaciones($idusuario, $codigo, $var)
    {
        $personaMo = new ModeloUsuario($var);
        return $personaMo->asignarCapacitaciones($idusuario, $codigo);
    }

    function quitarCapacitacion($arr, $var)
    {
        $personaMo = new ModeloUsuario($var);
        return $personaMo->desAsignarCapacitaciones($arr['usuario'], $arr['codigo']);
    }

    function iniciarExamen($id, $codigo)
    {
        $curso = new ControladorCurso(1);
        $capacitacion = $curso->buscarCapacitacion($codigo);
        if (is_object($capacitacion[0])) {
            $personaMo = new ModeloUsuario(1);
            return $personaMo->iniciarCapacitaciones($id, $codigo, $capacitacion[0]->getTiempo(), 0);
        } else {
            return $capacitacion;
        }
    }

    function reiniciarExamen($id, $codigo)
    {
        $curso = new ControladorCurso(1);
        $capacitacion = $curso->buscarCapacitacion($codigo);
        if (is_object($capacitacion[0])) {
            $personaMo = new ModeloUsuario(1);
            return $personaMo->reiniciarCapacitaciones($id, $codigo);
        } else {
            return $capacitacion;
        }
    }

    function guardarRespuesta($arr, $var)
    {
        $personaMo = new ModeloUsuario($var);
        $validar = false;
        foreach ($arr as $clave => $pregun) {
            if (is_numeric($clave)) {
                $validar = true;
                $array = $personaMo->guardarRespuesta($arr['id_usuario'], $arr['id_capacitacion'], $clave, $pregun, $arr['fase']);
            }
        }
        if ($validar == false) {
            $array[0] = 2;
            $array[1] = "No has respondido ninguna pregunta";
        }
        return $array;
    }

    function actualizarRespuesta($arr, $var)
    {
        $personaMo = new ModeloUsuario($var);
        $array = $personaMo->limpiarRespuesta($arr['id_usuario'], $arr['id_capacitacion'], $arr['fase']);
        if ($array[0] == 1 || $array[0] == 3) {
            foreach ($arr as $clave => $pregun) {
                if (is_numeric($clave)) {
                    $respuesta = $personaMo->actualizarRespuesta($arr['id_usuario'], $arr['id_capacitacion'], $clave, $pregun, $arr['fase']);
                    if ($respuesta[0] == 1) {
                        $array = $respuesta;
                    }
                }
            }
        }
        return $array;
    }

    function resultados($id, $codigo, $cantidad, $var)
    {
        $personaMo = new ModeloUsuario($var);
        return $personaMo->resultadosExamen($id, $codigo, $cantidad, $var);
    }

    function listarRespuesta($id, $codigo, $var)
    {
        $personaMo = new ModeloUsuario(1);
        return $personaMo->listarRespuesta($id, $codigo, $var);
    }

    function contarUsuario($buscar, $var)
    {
        $personaMo = new ModeloUsuario($var);
        return $personaMo->cantidadUsuarios($buscar);
    }

    function listarUsuarioSede($idsede, $estado, $var)
    {
        $personaMo = new ModeloUsuario($var);
        return $personaMo->listarUsuarioSede($idsede, $estado);
    }

    function listarUsuarioEmpresa($idempresa, $estado, $var)
    {
        $personaMo = new ModeloUsuario($var);
        return $personaMo->listarUsuarioEmpresa($idempresa, $estado);
    }

    function listarUsuarioEmpresaSede($idempresa, $sede, $estado, $var)
    {
        $personaMo = new ModeloUsuario($var);
        return $personaMo->listarUsuarioEmpresaSede($idempresa, $sede, $estado);
    }

    function actualizarEstado($id, $estado, $var)
    {
        $personaMo = new ModeloUsuario($var);
        return $personaMo->actualizarEstado($id, $estado);
    }
}

function validar($arr)
{
    $array = array();
    if (trim($arr["nombre"]) == "") {
        $array[] = 2;
        $array[] = "Ingrese un nombre valido";
    } else if (trim($arr["usuario"]) == "") {
        $array[] = 2;
        $array[] = "Ingrese un nombre de usuario valido";
    } else if (trim($arr["email"]) == "") {
        $array[] = 2;
        $array[] = "Ingrese un correo valido";
    } else {
        $array[] = 1;
    }
    return $array;
}
