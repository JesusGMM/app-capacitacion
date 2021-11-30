<?php 
class SedeControlador{
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