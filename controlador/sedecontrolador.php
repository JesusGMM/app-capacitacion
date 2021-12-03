<?php
class SedeControlador
{
    private $array;
    public function __construct($var)
    {
        if ($var == 1) {
            require_once("../clases/sede.php");
            require_once("../modelo/SedeModelo.php");
        } else {
            require_once("../../clases/sede.php");
            require_once("../../modelo/SedeModelo.php");
        }

        $this->array = array();
    }


    function crear($arr)
    {
        if ($arr != null) {
            $dato = $this->validar($arr);
            if ($dato[0] == 1) {
                $sedemodel = new SedeModelo(1);
                $array = $sedemodel->validarSede($arr['nit']);
                if ($array[0] == 1) {
                    $sede = new Sede();
                    $sede->setIdempresa($arr["idempresa"]);
                    $sede->setNombre($arr["nombre"]);
                    $sede->setNit($arr["nit"]);
                    $sede->setCorreo($arr["email"]);
                    $sede->setCiudad($arr["ciudad"]);
                    $sede->setDirrecion($arr["dirrecion"]);
                    if (isset($arr["estado"])) $est = 1;
                    else  $est = 0;
                    $sede->setEstado($est);
                    $sede->setTelefono($arr["telefono"]);
                    $sede->setLogo("imagen_" . $arr["nit"] . ".png");
                    $array = $sedemodel->registrar($sede);
                    if ($array[0] == 1) {
                        if (!empty(trim($_FILES["imagen"]["name"]))) {
                            $name = $sede->getLogo();
                            $location = '../componentes/logos/sede/' . $name;
                            move_uploaded_file($_FILES["imagen"]["tmp_name"], $location);
                        }
                    }
                }
                return $array;
            } else {
                return $dato;
            }
        } else {
            $array[0] = 0;
            return $array;
        }
    }

    function editar($arr)
    {
        if ($arr != null) {
            $dato = $this->validar($arr);
            if ($dato[0] == 1) {
                $sedemodel = new SedeModelo(2);
                $sede = new Sede();
                $array = $sedemodel->validarSede($arr['nit']);
                if (($array[0] == 3 && $array[3] == $arr['id'] && $array[2] == "sede") || $array[0] == 1) {
                    $sede->setId($arr["id"]);
                    $sede->setNombre($arr["nombre"]);
                    $sede->setNit($arr["nit"]);
                    $sede->setCorreo($arr["email"]);
                    $sede->setCiudad($arr["ciudad"]);
                    $sede->setDirrecion($arr["dirrecion"]);
                    if (isset($arr["estado"])) $est = 1;
                    else  $est = 0;
                    $sede->setEstado($est);
                    $sede->setTelefono($arr["telefono"]);

                    if ((!empty(trim($_FILES["imagen"]["name"])))) {
                        $test = explode('.', $_FILES["imagen"]["name"]);
                        $name = $test[0] . $arr["nit"] . '.PNG';
                    } else if ($array[0] == 3) {
                        $name = $arr['foto'];
                    } else {
                        $name = "imagen_" . $arr["nit"] . ".PNG";
                    }
                    $sede->setLogo($name);
                    $array = $sedemodel->actualizar($sede);

                    if ($array[0] == 1) {
                        try {
                            if (!empty(trim($_FILES["imagen"]["name"]))) {
                                $location = '../../componentes/logos/sede/' . $sede->getLogo();
                                move_uploaded_file($_FILES["imagen"]["tmp_name"], $location);
                            } else {
                                rename("../../componentes/logos/sede/{$arr['foto']}", "../../componentes/logos/sede/{$sede->getLogo()}");
                            }
                        } catch (Exception $e) {
                            echo $e->getLine();
                            die("Error al subir la imagen:" . $e->getMessage());
                        }
                    }
                } else {
                    $array[0] = 3;
                    $array[1] = "El nit ya esta en uso";
                }
                return $array;
            } else {
                return $dato;
            }
        } else {
            $array[0] = 0;
            return $array;
        }
    }

    function eliminarSede($id, $var)
    {
        $sedemodel = new SedeModelo($var);
        return $sedemodel->eliminar($id);
    }

    function listarSedes($idempresa, $estado, $var)
    {
        $sedemodel = new SedeModelo($var);
        return $sedemodel->listarSedes($idempresa, $estado);
    }


    function asignar_capacitaciones($idsede, $idcapacitacion, $var)
    {
        $sedemodel = new SedeModelo($var);
        return $sedemodel->asignarCapacitaciones($idsede, $idcapacitacion);
    }

    function desasignarCapacitaciones($idsede, $idcapacitacion, $var)
    {
        $sedemodel = new SedeModelo($var);
        return $sedemodel->desasignarCapacitaciones($idsede, $idcapacitacion);
    }

    function actualizarEstado($idsede, $estado, $var){
        $sedemodel = new SedeModelo($var);
        return $sedemodel->actualizarEstado($idsede, $estado);
    }

    function listar($buscar, $empieza, $por_pagina, $var)
    {
        $sedemodel = new SedeModelo($var);
        return $sedemodel->listar(trim($buscar), $empieza, $por_pagina);
    }

    function contarSede($buscar, $var)
    {
        $sedemodel = new SedeModelo($var);
        return $sedemodel->cantidadSedes($buscar);
    }
    
    function buscarSede($id, $tipo)
    {
        $sedemodel = new SedeModelo($tipo);
        if (!empty(trim($id))) {
            return $sedemodel->buscarSede(trim($id));
        }
    }

    function asignar($arr, $var)
    {
        $sedemodel = new SedeModelo($var);
        foreach ($arr['asignar'] as $codigo) {
            $array = $sedemodel->asignarCapacitaciones($arr['id_sede'], $codigo);
        }
        return $array;
    }

    function quitarCapacitacion($arr, $var)
    {
        $sedemodel = new SedeModelo($var);
        return $sedemodel->desAsignarCapacitaciones($arr['sede'], $arr['codigo']);
    }
    function validarCurso($id, $codigo, $var)
    {
        $sedemodel = new SedeModelo($var);
        return $sedemodel->validarCapacitaciones($id, $codigo);
    }

    function validar($arr)
    {
        $array = array();
        if (trim($arr["nit"]) == "") {
            $array[] = 2;
            $array[] = "Ingrese un nit valido";
        } else if (trim($arr["nombre"]) == "") {
            $array[] = 2;
            $array[] = "Ingrese un nombre valido";
        } else if (trim($arr["email"]) == "") {
            $array[] = 2;
            $array[] = "Ingrese un correo electronico valido";
        } else {
            $array[] = 1;
        }
        return $array;
    }
}
