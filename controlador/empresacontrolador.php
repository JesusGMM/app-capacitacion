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

                    if (!empty(trim($_FILES["imagen"]["name"]))) {
                        $test = explode('.', $_FILES["imagen"]["name"]);
                        $name = $test[0] . $arr["codigo"] . '.PNG';
                    } else if ($array[0] == 3) {
                        $name = $arr['foto'];
                    } else {
                        $name = "imagen_" . $arr["codigo"] . ".PNG";
                    }

                    $empresa->setLogo($name);
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

    function editar($arr)
    {
        if ($arr != null) {
            $dato = $this->validar($arr);
            if ($dato[0] == 1) {
                $empresamodel = new EmpresaModelo(2);
                $empresa = new Empresa();
                $array = $empresamodel->validarEmpresa($arr['nit']);
                if (($array[0] == 3 && $array[3] == $arr['id'] && $array[2] == "empresa") || $array[0] == 1) {
                    $empresa->setId($arr["id"]);
                    $empresa->setNombre($arr["nombre"]);
                    $empresa->setNit($arr["nit"]);
                    $empresa->setCorreo($arr["email"]);
                    $empresa->setCiudad($arr["ciudad"]);
                    $empresa->setDirrecion($arr["dirrecion"]);
                    if (isset($arr["estado"])) $est = 1;
                    else  $est = 0;
                    $empresa->setEstado($est);
                    $empresa->setTelefono($arr["telefono"]);

                    if ((!empty(trim($_FILES["imagen"]["name"])))) {
                        $test = explode('.', $_FILES["imagen"]["name"]);
                        $name = $test[0] . $arr["nit"] . '.PNG';
                    } else if ($array[0] == 3) {
                        $name = $arr['foto'];
                    } else {
                        $name = "imagen_" . $arr["nit"] . ".PNG";
                    }
                    $empresa->setLogo($name);
                    $array = $empresamodel->actualizar($empresa);

                    if ($array[0] == 1) {
                        try {
                            if (!empty(trim($_FILES["imagen"]["name"]))) {
                                $location = '../../componentes/logos/empresa/' . $empresa->getLogo();
                                move_uploaded_file($_FILES["imagen"]["tmp_name"], $location);
                            } else {
                                rename("../../componentes/logos/empresa/{$arr['foto']}", "../../componentes/logos/empresa/{$empresa->getLogo()}");
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

    function eliminar($id)
    {
        if (empty(trim($id))) {
            $array[0] = 2;
            $array[1] = "Empresa no encontrado";
            return $array;
        } else {
            $empresamodel = new EmpresaModelo(2);
            return $empresamodel->eliminar(trim($id));
        }
    }


    function listar($buscar, $empieza, $por_pagina, $var)
    {
        $empresamodel = new EmpresaModelo($var);
        return $empresamodel->listar(trim($buscar), $empieza, $por_pagina);
    }

    function contarEmpresa($buscar, $var)
    {
        $empresamodel = new EmpresaModelo($var);
        return $empresamodel->cantidadEmpresas($buscar);
    }


    function buscarEmpresa($id, $tipo)
    {
        $empresamodel = new EmpresaModelo($tipo);
        if (!empty(trim($id))) {
            return $empresamodel->buscarEmpresa(trim($id));
        }
    }

    function listarEmpresaTodas($estado,$var)
    {
        $empresamodel = new EmpresaModelo($var);
        return $empresamodel->listarTodas($estado);
    }

    function validarCurso($id, $codigo, $var)
    {
        $empresamodel = new EmpresaModelo($var);
        return $empresamodel->validarCapacitaciones($id, $codigo);
    }

    function quitarCapacitacion($arr, $var)
    {
        $empresamodel = new EmpresaModelo($var);
        return $empresamodel->desAsignarCapacitaciones($arr['empresa'], $arr['codigo']);
    }

    function asignar($arr, $var)
    {
        $empresamodel = new EmpresaModelo($var);
        foreach ($arr['asignar'] as $codigo) {
            $array = $empresamodel->asignarCapacitaciones($arr['id_empresa'], $codigo);
        }
        return $array;
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
