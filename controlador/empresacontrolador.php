<?php

class EmpresaControlador
{
    private $array;
    public function __construct($var)
    {
        if ($var == 1) {
            require_once("../clases/empresa.php");
            require_once("../modelo/EmpresaModelo.php");
        } else {
            require_once("../../clases/empresa.php");
            require_once("../../modelo/EmpresaModelo.php");
        }

        $this->array = array();
    }

    function crear($arr)
    {
        if ($arr != null) {
            $dato = $this->validar($arr);
            if ($dato[0] == 1) {
                $empresaModel = new EmpresaModelo(1);
                $array = $empresaModel->validarEmpresa($arr['nit']);
                if ($array[0] == 1) {
                    $empresa = new Empresa();
                    $empresa->setNombre($arr["nombre"]);
                    $empresa->setNit($arr["nit"]);
                    $empresa->setCorreo($arr["email"]);
                    $empresa->setCiudad($arr["ciudad"]);
                    $empresa->setDirrecion($arr["dirrecion"]);
                    if (isset($arr["estado"])) $est = 1;
                    else  $est = 0;
                    $empresa->setEstado($est);
                    $empresa->setTelefono($arr["telefono"]);
                    $empresa->setLogo("imagen_" . $arr["nit"] . ".png");
                    $array = $empresaModel->registrar($empresa);
                    if ($array[0] == 1) {
                        if (!empty(trim($_FILES["imagen"]["name"]))) {
                            $name = $empresa->getLogo();
                            $location = '../componentes/logos/empresa/' . $name;
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

    function listar($buscar, $empieza, $por_pagina, $var) {
        $empresamodel = new EmpresaModelo($var);
        return $empresamodel->listar(trim($buscar), $empieza, $por_pagina);
    }

    function contarEmpresa($buscar, $var) {
        $empresamodel = new EmpresaModelo($var);
        return $empresamodel->cantidadEmpresas($buscar);
    }


    function buscarEmpresa($id, $tipo) {
        $empresamodel = new EmpresaModelo($tipo);
        if (!empty(trim($id))) {
            return $empresamodel->buscarEmpresa(trim($id));
        }
    }

    function validarCurso($id, $codigo, $var) {
        $empresamodel = new EmpresaModelo($var);
        return $empresamodel->validarCapacitaciones($id, $codigo);
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
