<?php

class SedeModelo
{
    private $db;
    private $aray;

    public function __construct($var)
    {
        require_once("conexion.php");
        if ($var == 1) {
            require_once("../clases/sede.php");
        } else {
            require_once("../../clases/sede.php");
        }
        date_default_timezone_set('America/Bogota');
        $this->db = conectar::conexion();
        $this->aray = array();
    }

    // VALIDAR SI LA SEDE CON EL NIT EXISTE
    function validarSede($nit)
    {
        try {
            $sql = "SELECT id FROM sede WHERE nit=:nitid";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":nitid", $nit, PDO::PARAM_STR);
            $consulta->execute();
            if ($consulta->rowCount() > 0) {
                $aray[0] = 3;
                $aray[1] = "El Nit de la sede ya existe";
            } else {
                $sql = "SELECT id FROM empresa WHERE nit=:nitid";
                $consulta = $this->db->prepare($sql);
                $consulta->bindParam(":nitid", $nit, PDO::PARAM_STR);
                $consulta->execute();
                if ($consulta->rowCount() > 0) {
                    $aray[0] = 3;
                    $aray[1] = "El Nit ya existe";
                } else
                    $aray[0] = 1;
            }
        } catch (Exception $e) {
            $aray[0] = 2;
            $aray[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $aray;
            die("Error :" . $e->getMessage());
        }
        return $aray;
    }

    // REGISTRAR UNA SEDE
    function registrar(Sede $sede)
    {
        $codigo = $sede->getNit();
        $nombre = $sede->getNombre();
        $email = $sede->getCorreo();
        $ciudad = $sede->getCiudad();
        $direcion = $sede->getDirrecion();
        $telefono = $sede->getTelefono();
        $imagen = $sede->getLogo();
        $estado = $sede->getEstado();

        try {
            $sql = "INSERT INTO sede (nit, nombre, correo, ciudad, dirrecion, telefono, estado, logo) VALUES (:nit,:nombre,:email,:ciudad,:dirrecion,:telefono,:estado,:foto)";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":nit", $codigo, PDO::PARAM_STR);
            $consulta->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $consulta->bindParam(":email", $email, PDO::PARAM_STR);
            $consulta->bindParam(":ciudad", $ciudad, PDO::PARAM_STR);
            $consulta->bindParam(":telefono", $telefono, PDO::PARAM_INT);
            $consulta->bindParam(":estado", $estado, PDO::PARAM_INT);
            $consulta->bindParam(":dirrecion", $direcion, PDO::PARAM_STR);
            $consulta->bindParam(":foto", $imagen, PDO::PARAM_STR);
            $consulta->execute();

            if ($consulta->rowCount() > 0) {
                $aray[0] = 1;
                $aray[1] = "Sede registrada";
            } else {
                $aray[0] = 3;
                $aray[1] = "Sede no registrado inténtelo nuevamente";
            }
            $consulta->closeCursor();
        } catch (Exception $e) {
            $aray[0] = 2;
            $aray[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte ";
            return $aray;
            // echo $e->getLine();
            // die("Error :" . $e->getMessage());
        }
        return $aray;
    }
}
