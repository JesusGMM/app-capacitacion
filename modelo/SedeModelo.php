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
                if ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $aray[0] = 3;
                    $aray[1] = "El Nit ya existe";
                    $aray[2] = "sede";
                    $aray[3] = $fila['id'];
                }
            } else {
                $sql = "SELECT id FROM empresa WHERE nit=:nitid";
                $consulta = $this->db->prepare($sql);
                $consulta->bindParam(":nitid", $nit, PDO::PARAM_STR);
                $consulta->execute();
                if ($consulta->rowCount() > 0) {
                    if ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                        $aray[0] = 3;
                        $aray[1] = "El Nit ya existe";
                        $aray[2] = "empresa";
                        $aray[3] = $fila['id'];
                    }
                } else
                    $aray[0] = 1;
            }
        } catch (Exception $e) {
            $aray[0] = 2;
            $aray[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte ";
            // echo $e->getLine();
            // die("Error :" . $e->getMessage());
        }
        return $aray;
    }

    // REGISTRAR UNA SEDE
    function registrar(Sede $sede)
    {
        $idempresa = $sede->getIdempresa();
        $codigo = $sede->getNit();
        $nombre = $sede->getNombre();
        $email = $sede->getCorreo();
        $ciudad = $sede->getCiudad();
        $direcion = $sede->getDirrecion();
        $telefono = $sede->getTelefono();
        $imagen = $sede->getLogo();
        $estado = $sede->getEstado();

        try {
            $sql = "INSERT INTO sede (id_empresa, nit, nombre, correo, ciudad, dirrecion, telefono, estado, logo) VALUES (:empresa,:nit,:nombre,:email,:ciudad,:dirrecion,:telefono,:estado,:foto)";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":empresa", $idempresa, PDO::PARAM_INT);
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
            // echo $e->getLine();
            // die("Error :" . $e->getMessage());
        }
        return $aray;
    }

    // ACTUALIZAR UN EMPRESA
    function actualizar(Sede $sede)
    {
        $id = $sede->getId();
        $idempresa = $sede->getIdempresa();
        $nit = $sede->getNit();
        $nombre = $sede->getNombre();
        $email = $sede->getCorreo();
        $ciudad = $sede->getCiudad();
        $direcion = $sede->getDirrecion();
        $telefono = $sede->getTelefono();
        $imagen = $sede->getLogo();
        $estado = $sede->getEstado();

        try {
            $sql = "UPDATE sede SET id_empresa=:idempresa, nit=:nit, nombre=:nombre, correo=:email, ciudad=:ciudad, dirrecion=:dirrecion, telefono=:telefono, estado=:estado, logo=:foto WHERE id=:idsede";
            $actualizar = $this->db->prepare($sql);
            $actualizar->bindParam(":idsede", $id, PDO::PARAM_INT);
            $actualizar->bindParam(":idempresa", $idempresa, PDO::PARAM_INT);
            $actualizar->bindParam(":nit", $nit, PDO::PARAM_STR);
            $actualizar->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $actualizar->bindParam(":email", $email, PDO::PARAM_STR);
            $actualizar->bindParam(":ciudad", $ciudad, PDO::PARAM_STR);
            $actualizar->bindParam(":telefono", $telefono, PDO::PARAM_INT);
            $actualizar->bindParam(":estado", $estado, PDO::PARAM_INT);
            $actualizar->bindParam(":dirrecion", $direcion, PDO::PARAM_STR);
            $actualizar->bindParam(":foto", $imagen, PDO::PARAM_STR);
            $actualizar->execute();

            if ($actualizar->rowCount() > 0) {
                require_once '../../controlador/usuario.controlador.php';
                $usu = new ControladorUsuario(2);
                $usuarios = $usu->listarUsuarioSede($id, "", 2);
                if (is_object($usuarios[0])) {
                    foreach ($usuarios as $idusu) {
                        $usu->actualizarEstado($idusu->getId(), $estado, 2);
                    }
                }
                $aray[0] = 1;
                $aray[1] = "Sede actualizada";
            } else {
                $aray[0] = 3;
                $aray[1] = "Sede no actualizada inténtelo nuevamente";
            }
            $actualizar->closeCursor();
        } catch (Exception $e) {
            $aray[0] = 2;
            $aray[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte ";
            //echo $e->getLine();
            //die("Error :" . $e->getMessage());
        }
        return $aray;
    }


    function actualizarEstado($id, $estado)
    {
        try {
            $sql = "UPDATE sede SET estado=:estado WHERE id=:idsede";
            $actualizar = $this->db->prepare($sql);
            $actualizar->bindParam(":idsede", $id, PDO::PARAM_INT);
            $actualizar->bindParam(":estado", $estado, PDO::PARAM_INT);
            $actualizar->execute();

            if ($actualizar->rowCount() > 0) {
                require_once '../../controlador/usuario.controlador.php';
                $usu = new ControladorUsuario(2);
                $usuarios = $usu->listarUsuarioSede($id, "", 2);
                if (is_object($usuarios[0])) {
                    foreach ($usuarios as $idusu) {
                        $usu->actualizarEstado($idusu->getId(), $estado, 2);
                    }
                }
                $aray[0] = 1;
                $aray[1] = "Sede actualizada";
            } else {
                $aray[0] = 3;
                $aray[1] = "Sede no actualizada inténtelo nuevamente";
            }
            $actualizar->closeCursor();
        } catch (Exception $e) {
            $aray[0] = 2;
            $aray[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte ";
            //echo $e->getLine();
            //die("Error :" . $e->getMessage());
        }
        return $aray;
    }

    function eliminar($idsede)
    {
        try {
            $sql_eliminar = "DELETE FROM sede WHERE id=:id";
            $eliminar = $this->db->prepare($sql_eliminar);
            $eliminar->bindParam(":id", $idsede, PDO::PARAM_INT);
            $eliminar->execute();
            if ($eliminar->rowCount() > 0) {
                require_once '../../controlador/usuario.controlador.php';
                $usu = new ControladorUsuario(2);
                $usuarios = $usu->listarUsuarioSede($idsede, "", 2);
                if (is_object($usuarios[0])) {
                    foreach ($usuarios as $idusu) {
                        $usu->eliminar($idusu->getId());
                    }
                }
                $aray[] = 1;
                $aray[] = "Sede eliminada";
            } else {
                $aray[] = 2;
                $aray[] = "Sede no eliminada inténtelo nuevamente";
            }
        } catch (Exception $e) {
            $aray[0] = 2;
            $aray[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte ";
            // echo $e->getLine();
            // die("Error :" . $e->getMessage());
        }
        return $aray;
    }

    // LISTAR LAS SEDES 
    function listar($busqueda, $empieza, $finaliza)
    {
        try {
            if (empty($busqueda)) {
                $sql = "SELECT * FROM sede ORDER BY id DESC limit :inicia, :fin ";
                $consulta = $this->db->prepare($sql);
            } else {
                $sql = "SELECT * FROM sede WHERE nit LIKE :nombre OR nombre LIKE :nombre OR ciudad LIKE :nombre ORDER BY id DESC limit :inicia, :fin ";
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
                $aray[] = "No hay sedes";
            }
            $consulta->closeCursor();
        } catch (Exception $e) {
            $aray[0] = 3;
            $aray[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte ";
            // echo $e->getLine();
            // die("Error :" . $e->getMessage());
        }
        return $aray;
    }

    function listarSedes($idempresa, $estado)
    {
        try {
            if (empty(trim($estado))) {
                $sql = "SELECT * FROM sede WHERE id_empresa=:empresa";
                $consulta = $this->db->prepare($sql);
            } else {
                $sql = "SELECT * FROM sede WHERE id_empresa=:empresa AND estado=:estado";
                $consulta = $this->db->prepare($sql);
                $consulta->bindParam(":estado", $estado, PDO::PARAM_INT);
            }

            $consulta->bindParam(":empresa", $idempresa, PDO::PARAM_INT);
            $consulta->execute();
            if ($consulta->rowCount() > 0) {
                while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $aray[] = $this->crearObjeto($fila);
                }
            } else {
                $aray[0] = 2;
                $aray[1] = "No hay empresas";
            }
            $consulta->closeCursor();
        } catch (Exception $e) {
            $aray[0] = 3;
            $aray[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte ";
            // echo $e->getLine();
            // die("Error :" . $e->getMessage());
        }
        return $aray;
    }


    // BUSCAR UNA SEDE
    function buscarSede($id)
    {
        try {
            $sql = "SELECT * FROM sede WHERE id= :id_sede";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":id_sede", $id, PDO::PARAM_INT);
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
            $aray[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte ";
            // echo $e->getLine();
            // die("Error :" . $e->getMessage());
            return $aray;
        }
    }

    function cantidadSedes($busqueda)
    {
        try {
            if (empty($busqueda)) {
                $sql = "SELECT COUNT(id) FROM `sede`";
                $consulta = $this->db->prepare($sql);
            } else {
                $sql = "SELECT  COUNT(id) FROM sede WHERE nombre LIKE :nombre OR nit LIKE :nombre OR ciudad LIKE :nombre";
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
            // echo $e->getLine();
            // die("Error :" . $e->getMessage());
        }
    }

    // ASIGNAR CAPACITACIONES SEDES
    function asignarCapacitaciones($id_sede, $capacitaciones)
    {
        try {
            $fecha = date('Y-m-d H:i:s');
            $sql = "INSERT INTO `capacitaciones_sede`(`id_sede`, `id_capacitacion`) VALUES (:sede, :codigo)";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":sede", $id_sede, PDO::PARAM_INT);
            $consulta->bindParam(":codigo", $capacitaciones, PDO::PARAM_INT);
            $consulta->execute();
            if ($consulta->rowCount() > 0) {
                require_once '../../controlador/usuario.controlador.php';
                $usu = new ControladorUsuario(2);
                $usuarios = $usu->listarUsuarioSede($id_sede, 1, 2);
                if (is_object($usuarios[0])) {
                    foreach ($usuarios as $idusu) {
                        $usu->asignarCapacitaciones($idusu->getId(), $capacitaciones, 2);
                    }
                }
                $aray[0] = 1;
                $aray[1] = "Capacitaciones asignadas";
            } else {
                $aray[0] = 3;
                $aray[1] = "Capacitaciones no asignadas inténtelo nuevamente";
            }
            $consulta->closeCursor();
        } catch (Exception $e) {
            $aray[0] = 2;
            $aray[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte ";
            // echo $e->getLine();
            // die("Error :" . $e->getMessage());
        }
        return $aray;
    }

    // QUITAR LAS CAPACITACIONES A LA SEDE
    function desAsignarCapacitaciones($id_sede, $capacitaciones)
    {
        try {
            $sql_eliminar = "DELETE FROM `capacitaciones_sede` WHERE `id_sede`=:idsede AND `id_capacitacion`=:idCap";
            $eliminar = $this->db->prepare($sql_eliminar);
            $eliminar->bindParam(":idsede", $id_sede, PDO::PARAM_INT);
            $eliminar->bindParam(":idCap", $capacitaciones, PDO::PARAM_INT);
            $eliminar->execute();
            if ($eliminar->rowCount() > 0) {
                require_once '../../controlador/usuario.controlador.php';
                $usu = new ControladorUsuario(2);
                $usuarios = $usu->listarUsuarioSede($id_sede, "", 2);
                if (is_object($usuarios[0])) {
                    foreach ($usuarios as $idusu) {
                        $foo = array('usuario' => $idusu->getId(), 'codigo' => $capacitaciones);
                        $usu->quitarCapacitacion($foo, $capacitaciones, 2);
                    }
                }
                $aray[0] = 1;
                $aray[1] = "Capacitacion eliminada";
            } else {
                $aray[0] = 2;
                $aray[1] = "La capacitacion no se pudo eliminar inténtelo nuevamente";
            }
            $eliminar->closeCursor();
        } catch (Exception $e) {
            $aray[0] = 2;
            $aray[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte ";
            // echo $e->getLine();
            // die("Error :" . $e->getMessage());
        }
        return $aray;
    }

    // VALIDAR LAS CAPACITACIONES ASIGNADAS
    function validarCapacitaciones($id, $codigo)
    {
        try {
            $sql = "SELECT * FROM `capacitaciones_sede` WHERE id_sede= :sede AND id_capacitacion= :capacitacion";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":sede", $id, PDO::PARAM_INT);
            $consulta->bindParam(":capacitacion", $codigo, PDO::PARAM_INT);
            $consulta->execute();

            if ($consulta->rowCount() > 0) {
                $aray[0] = 1;
                $aray[1] = "Este curso ya esta asignado";
            } else {
                $aray[0] = 3;
                $aray[1] = "Este curso no esta asignado"; //. $e->getLine();
            }
            $consulta->closeCursor();
        } catch (Exception $e) {
            $aray[0] = 2;
            $aray[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte ";
            // echo $e->getLine();
            // die("Error :" . $e->getMessage());
        }
        return $aray;
    }


    // OBTENER LA CANTIDAD DE CAPACITACIONES
    function obtenerCapacitaciones($id)
    {
        try {
            $sql = "SELECT COUNT(id) FROM `capacitaciones_sede` WHERE id_sede= :id";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":id", $id, PDO::PARAM_INT);
            $consulta->execute();
            if ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                return $fila['COUNT(id)'];
            } else {
                return 0;
            }
            $consulta->closeCursor();
        } catch (Exception $e) {
            $aray[0] = 2;
            $aray[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte ";
            // echo $e->getLine();
            // die("Error :" . $e->getMessage());
            return $aray;
        }
    }

    // OBTENER LA CANTIDAD DE USUARIOS ACTIVOS
    function obtenerUsuariosActivos($id)
    {
        try {
            $estado = 1;
            $sql = "SELECT COUNT(id) FROM `usuarios` WHERE id_sede=:id AND estado=:estado";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":id", $id, PDO::PARAM_INT);
            $consulta->bindParam(":estado", $estado, PDO::PARAM_INT);
            $consulta->execute();
            if ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                return $fila['COUNT(id)'];
            } else {
                return 0;
            }
            $consulta->closeCursor();
        } catch (Exception $e) {
            $aray[0] = 2;
            $aray[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte ";
            // echo $e->getLine();
            // die("Error :" . $e->getMessage());
            return $aray;
        }
    }

    function crearObjeto($fila)
    {
        $sede = new Sede();
        $sede->setId($fila['id']);
        $sede->setNit($fila['nit']);
        $sede->setNombre($fila['nombre']);
        $sede->setCorreo($fila['correo']);
        $sede->setCiudad($fila['ciudad']);
        $sede->setDirrecion($fila['dirrecion']);
        $sede->setTelefono($fila['telefono']);
        $sede->setEstado($fila['estado']);
        $sede->setLogo($fila['logo']);
        $sede->setCapacitaciones($this->obtenerCapacitaciones($fila['id']));
        $sede->setUsuario($this->obtenerUsuariosActivos($fila['id']));
        $sede->setIdempresa($fila['id_empresa']);
        return $sede;
    }
}
