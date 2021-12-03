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
        if ($array[0]->getId() > 0 && $array[0]->getEstado() == 1) {
            $_SESSION["iniciarSesionAppCap"] = "ok";
            $_SESSION["id_app_cap"] = $array[0]->getId();
            return true;
        } else {
            return false;
        }
    }
}
