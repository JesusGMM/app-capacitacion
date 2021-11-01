<?php

class ControllerLogin
{
    function __construct()
    {
        require_once("clases/persona.php");
        require_once("modelo/ModeloLogin.php");
    }

    static public function ctrIngresoUsuario($usuario, $pasword)
    {
        $login = new ModeloLogin();
        $array = $login->iniciarsesionusu($usuario, hash('whirlpool', $pasword));
        if ($array[0]->getId() > 0) {
            $_SESSION["iniciarSesion"] = "ok";
            $_SESSION["id_app_cap"] = $array[0]->getId();
            $_SESSION["nombre_app_cap"] = $array[0]->getNombre();
            $_SESSION["apellido_app_cap"] = $array[0]->getApellido();
            $_SESSION["rol_app_cap"] = $array[0]->getRol();
            return true;
        } else {
            return false;
        }
    }
}
