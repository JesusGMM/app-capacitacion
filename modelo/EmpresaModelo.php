<?php

class EmpresaModelo
{
    private $db;
    private $aray;

    public function __construct($var)
    {
        require_once("conexion.php");
        if ($var == 1)
            require_once("../clases/empresa.php");
        else
            require_once("../../clases/empresa.php");

        date_default_timezone_set('America/Bogota');
        $this->db = conectar::conexion();
        $this->aray = array();
    }

    // VALIDAR SI LA EMPRESA CON EL NIT EXISTE
    function validarEmpresa($nit)
    {
        try {
            $sql = "SELECT id FROM empresa WHERE nit=:nitid";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":nitid", $nit, PDO::PARAM_STR);
            $consulta->execute();
            if ($consulta->rowCount() > 0) {
                $aray[0] = 3;
                $aray[1] = "El Nit de la empresa ya existe";
            } else {
                $sql = "SELECT id FROM sede WHERE nit=:nitid";
                $consulta = $this->db->prepare($sql);
                $consulta->bindParam(":nitid", $nit, PDO::PARAM_STR);
                $consulta->execute();
                if ($consulta->rowCount() > 0) {
                    $aray[0] = 3;
                    $aray[1] = "El Nit ya existe";
                } else {
                    $aray[0] = 1;
                }
            }
        } catch (Exception $e) {
            $aray[0] = 2;
            $aray[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $aray;
            die("Error :" . $e->getMessage());
        }
        return $aray;
    }

    // REGISTRAR UN empresa$empresa
    function registrar(Empresa $empresa)
    {
        $codigo = $empresa->getNit();
        $nombre = $empresa->getNombre();
        $email = $empresa->getCorreo();
        $ciudad = $empresa->getCiudad();
        $direcion = $empresa->getDirrecion();
        $telefono = $empresa->getTelefono();
        $imagen = $empresa->getLogo();
        $estado = $empresa->getEstado();

        try {
            $sql = "INSERT INTO empresa (nit, nombre, correo, ciudad, dirrecion, telefono, estado, logo) VALUES (:nit,:nombre,:email,:ciudad,:dirrecion,:telefono,:estado,:foto)";
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
                $aray[1] = "Empresa registrada";
            } else {
                $aray[0] = 3;
                $aray[1] = "Empresa no registrado inténtelo nuevamente";
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

    // LISTAR LOS USUARIOS 
    function listar($busqueda, $empieza, $finaliza)
    {
        try {
            if (empty($busqueda)) {
                $sql = "SELECT * FROM empresa ORDER BY id DESC limit :inicia, :fin ";
                $consulta = $this->db->prepare($sql);
            } else {
                $sql = "SELECT * FROM empresa WHERE nit LIKE :nombre OR nombre LIKE :nombre OR ciudad LIKE :nombre ORDER BY id DESC limit :inicia, :fin ";
                $consulta = $this->db->prepare($sql);
                $busqueda = '%' . $busqueda . '%';
                $consulta->bindParam(":nombre", $busqueda, PDO::PARAM_STR);
            }

            $consulta->bindParam(":inicia", $empieza, PDO::PARAM_INT);
            $consulta->bindParam(":fin", $finaliza, PDO::PARAM_INT);
            $consulta->execute();
            if ($consulta->rowCount() > 0) {
                while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $aray[] = $this->crearObjeto($fila);
                }
            } else {
                $aray[] = 2;
                $aray[] = "No hay empresas";
            }
            $consulta->closeCursor();
            return $aray;
        } catch (Exception $e) {
            $aray[0] = 3;
            $aray[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte ";
            return $aray;
            // echo $e->getLine();
            // die("Error :" . $e->getMessage());
        }
    }

    function cantidadEmpresas($busqueda)
    {
        try {
            if (empty($busqueda)) {
                $sql = "SELECT COUNT(id) FROM `empresa`";
                $consulta = $this->db->prepare($sql);
            } else {
                $sql = "SELECT  COUNT(id) FROM empresa WHERE nombre LIKE :nombre OR nit LIKE :nombre OR ciudad LIKE :nombre";
                $consulta = $this->db->prepare($sql);
                $busqueda = '%' . $busqueda . '%';
                $consulta->bindParam(":nombre", $busqueda, PDO::PARAM_STR);
            }

            $consulta->execute();
            if ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                return $fila['COUNT(id)'];
            } else {
                return 0;
            }
            $consulta->closeCursor();
        } catch (Exception $e) {
            return "Ha ocurrido un error si el error persiste comuníquese con soporte ";
            //. $e->getLine();
            // die("Error :" . $e->getMessage());
        }
    }

    // BUSCAR UNA EMPRESA
    function buscarEmpresa($id)
    {
        try {
            $sql = "SELECT * FROM empresa WHERE id= :id_empresa";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":id_empresa", $id, PDO::PARAM_INT);
            $consulta->execute();

            if ($consulta->rowCount() > 0) {
                while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $aray[] = $this->crearObjeto($fila);
                } 
                $consulta->closeCursor();
                return $aray;           
            } else {
                return 0;
            }
            $consulta->closeCursor();
        } catch (Exception $e) {
            $aray[0] = 2;
            $aray[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $aray;
            die("Error :" . $e->getMessage());
        }
    }

    // VALIDAR LAS CAPACITACIONES ASIGNADAS
    function validarCapacitaciones($id, $codigo) {
        try {
            $sql = "SELECT * FROM `capacitaciones_empresa` WHERE id_empresa= :empresa AND id_capacitacion= :capacitacion";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":empresa", $id, PDO::PARAM_INT);
            $consulta->bindParam(":capacitacion", $codigo, PDO::PARAM_INT);
            $consulta->execute();

            if ($consulta->rowCount() > 0) {
                $aray[0] = 1;
                $aray[1] = "Este curso ya esta asignado";
                if ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $aray[2] = $fila['cantidad_sede'];
                    $aray[3] = $fila['cantidad_usuario'];
                }
            } else {
                $aray[0] = 3;
                $aray[1] = "Este curso no esta asignado"; //. $e->getLine();
            }
            $consulta->closeCursor();
        } catch (Exception $e) {
            $aray[0] = 2;
            $aray[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $aray;
            die("Error :" . $e->getMessage());
        }
        return $aray;
    }
 

    function crearObjeto($fila)
    {
        $empresa = new Empresa();
        $empresa->setId($fila['id']);
        $empresa->setNit($fila['nit']);
        $empresa->setNombre($fila['nombre']);
        $empresa->setCorreo($fila['correo']);
        $empresa->setCiudad($fila['ciudad']);
        $empresa->setDirrecion($fila['dirrecion']);
        $empresa->setTelefono($fila['telefono']);
        $empresa->setEstado($fila['estado']);
        $empresa->setLogo($fila['logo']);
        return $empresa;
    }
}
