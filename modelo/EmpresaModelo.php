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
                if ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $aray[0] = 3;
                    $aray[1] = "El Nit ya existe";
                    $aray[2] = "empresa";
                    $aray[3] = $fila['id'];
                }
            } else {
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
                    $aray[0] = 1;
                }
            }
        } catch (Exception $e) {
            $aray[0] = 2;
            $aray[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte ";
            //. $e->getLine();
            //die("Error :" . $e->getMessage());
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
            // echo $e->getLine();
            // die("Error :" . $e->getMessage());
        }
        return $aray;
    }


    // ACTUALIZAR UN EMPRESA
    function actualizar(Empresa $empresa)
    {
        $id = $empresa->getId();
        $codigo = $empresa->getNit();
        $nombre = $empresa->getNombre();
        $email = $empresa->getCorreo();
        $ciudad = $empresa->getCiudad();
        $direcion = $empresa->getDirrecion();
        $telefono = $empresa->getTelefono();
        $imagen = $empresa->getLogo();
        $estado = $empresa->getEstado();

        try {
            $sql = "UPDATE empresa SET nit=:nit, nombre=:nombre, correo=:email, ciudad=:ciudad, dirrecion=:dirrecion, telefono=:telefono, estado=:estado, logo=:foto WHERE id=:idempresa";
            $actualizar = $this->db->prepare($sql);
            $actualizar->bindParam(":idempresa", $id, PDO::PARAM_INT);
            $actualizar->bindParam(":nit", $codigo, PDO::PARAM_STR);
            $actualizar->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $actualizar->bindParam(":email", $email, PDO::PARAM_STR);
            $actualizar->bindParam(":ciudad", $ciudad, PDO::PARAM_STR);
            $actualizar->bindParam(":telefono", $telefono, PDO::PARAM_INT);
            $actualizar->bindParam(":estado", $estado, PDO::PARAM_INT);
            $actualizar->bindParam(":dirrecion", $direcion, PDO::PARAM_STR);
            $actualizar->bindParam(":foto", $imagen, PDO::PARAM_STR);
            $actualizar->execute();

            if ($actualizar->rowCount() > 0) {
                require_once '../../controlador/sedecontrolador.php';
                $sede = new SedeControlador(2);
                $sedes = $sede->listarSedes($id, "", 2);
                if (is_object($sedes[0])) {
                    foreach ($sedes as $idsede) {
                        $sed =  $sede->actualizarEstado($idsede->getId(), $estado, 2);
                        var_dump($sed);
                    }
                }
                var_dump($sedes);

                require_once '../../controlador/usuario.controlador.php';
                $usua = new ControladorUsuario(2);
                $usuarios = $usua->listarUsuarioEmpresaSede($id, 0, "", 2);
                if (is_object($usuarios[0])) {
                    foreach ($usuarios as $idusua) {
                        $usua->actualizarEstado($idusua->getId(), $estado, 2);
                    }
                }

                $aray[0] = 1;
                $aray[1] = "Empresa actualizada";
            } else {
                $aray[0] = 3;
                $aray[1] = "Empresa no actualizado inténtelo nuevamente";
            }
            $actualizar->closeCursor();
        } catch (Exception $e) {
            $aray[0] = 2;
            $aray[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte ";
            //echo $e->getLine();
            // die("Error :" . $e->getMessage());
        }
        return $aray;
    }

    //ELIMINAR EMPRESA
    function eliminar($id_empresa)
    {
        try {
            $sql_eliminar = "DELETE FROM empresa WHERE id=:id";
            $eliminar = $this->db->prepare($sql_eliminar);
            $eliminar->bindParam(":id", $id_empresa, PDO::PARAM_INT);
            $eliminar->execute();
            if ($eliminar->rowCount() > 0) {
                require_once '../../controlador/sedecontrolador.php';
                $sede = new SedeControlador(2);
                $sedes = $sede->listarSedes($id_empresa, "", 2);
                if (is_object($sedes[0])) {
                    foreach ($sedes as $idsede) {
                        $sede->eliminarSede($idsede->getId(), 2);
                    }
                }

                require_once '../../controlador/usuario.controlador.php';
                $usua = new ControladorUsuario(2);
                $usuarios = $usua->listarUsuarioEmpresaSede($id_empresa, 0, "", 2);
                if (is_object($usuarios[0])) {
                    foreach ($usuarios as $idusua) {
                        $usua->eliminar($idusua->getId());
                    }
                }
                $aray[0] = 1;
                $aray[1] = "Empresa eliminada";
            } else {
                $aray[0] = 2;
                $aray[1] = "Empresa no eliminada inténtelo nuevamente";
            }
        } catch (Exception $e) {
            $aray[0] = 2;
            $aray[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte ";
            //echo $e->getLine(); 
            //die("Error :" . $e->getMessage());
        }
        return $aray;
    }


    // LISTAR LAS EMPRESAS 
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
        } catch (Exception $e) {
            $aray[0] = 3;
            $aray[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte ";
            // echo $e->getLine();
            // die("Error :" . $e->getMessage());
        }
        return $aray;
    }

    function listarTodas($activas)
    {
        try {
            if (!is_numeric($activas)) {
                $sql = "SELECT * FROM empresa";
                $consulta = $this->db->prepare($sql);
            } else {
                $sql = "SELECT * FROM empresa WHERE estado=:estado";
                $consulta = $this->db->prepare($sql);
                $consulta->bindParam(":estado", $activas, PDO::PARAM_INT);
            }

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
            //echo $e->getLine();
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
            $aray[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte ";
            //echo $e->getLine();
            // die("Error :" . $e->getMessage());
            return $aray;
        }
    }

    // VALIDAR LAS CAPACITACIONES ASIGNADAS
    function validarCapacitaciones($id, $codigo)
    {
        try {
            $sql = "SELECT * FROM `capacitaciones_empresa` WHERE id_empresa= :empresa AND id_capacitacion= :capacitacion";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":empresa", $id, PDO::PARAM_INT);
            $consulta->bindParam(":capacitacion", $codigo, PDO::PARAM_INT);
            $consulta->execute();

            if ($consulta->rowCount() > 0) {
                $aray[0] = 1;
                $aray[1] = "Este curso ya esta asignado";
            } else {
                $aray[0] = 3;
                $aray[1] = "Este curso no esta asignado";
            }
            $consulta->closeCursor();
        } catch (Exception $e) {
            $aray[0] = 2;
            $aray[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte ";
            //echo $e->getLine();            
            //die("Error :" . $e->getMessage());
        }
        return $aray;
    }

    // OBTENER LA CANTIDAD DE CAPACITACIONES
    function obtenerCapacitaciones($id)
    {
        try {
            $sql = "SELECT COUNT(id) FROM `capacitaciones_empresa` WHERE id_empresa= :id";
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
            //echo $e->getLine();            
            //  die("Error :" . $e->getMessage());
            return $aray;
        }
    }

    // OBTENER LA CANTIDAD DE SEDES ACTIVAS
    function obtenerSedesActivas($id)
    {
        try {
            $estado = 1;
            $sql = "SELECT COUNT(id) FROM `sede` WHERE id_empresa= :id AND estado=:estado";
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
            //echo $e->getLine();            
            //  die("Error :" . $e->getMessage());
            return $aray;
        }
    }

    // OBTENER LA CANTIDAD DE USUARIOS ACTIVOS
    function obtenerUsuariosActivos($id)
    {
        try {
            $estado = 1;
            $sql = "SELECT COUNT(id) FROM `usuarios` WHERE id_empresa=:id AND estado=:estado";
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

    // ASIGNAR CAPACITACIONES
    function asignarCapacitaciones($id_empresa, $capacitaciones)
    {
        try {
            $fecha = date('Y-m-d H:i:s');
            $sql = "INSERT INTO `capacitaciones_empresa`(`id_empresa`, `id_capacitacion`) VALUES (:empresa, :codigo)";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":empresa", $id_empresa, PDO::PARAM_INT);
            $consulta->bindParam(":codigo", $capacitaciones, PDO::PARAM_INT);
            $consulta->execute();
            if ($consulta->rowCount() > 0) {
                require_once '../../controlador/sedecontrolador.php';
                $sede = new SedeControlador(2);
                $sedes = $sede->listarSedes($id_empresa, 1, 2);
                if (is_object($sedes[0])) {
                    foreach ($sedes as $idsede) {
                        $sede->asignar_capacitaciones($idsede->getId(), $capacitaciones, 2);
                    }
                }

                require_once '../../controlador/usuario.controlador.php';
                $usua = new ControladorUsuario(2);
                $usuarios = $usua->listarUsuarioEmpresaSede($id_empresa, 0, 1, 2);
                if (is_object($usuarios[0])) {
                    foreach ($usuarios as $idusua) {
                        $usua->asignarCapacitaciones($idusua->getId(), $capacitaciones, 2);
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
            //echo $e->getLine();
            //die("Error :" . $e->getMessage());
        }
        return $aray;
    }

    // QUITAR LAS CAPACITACIONES A LA EMPRESA
    function desAsignarCapacitaciones($id_empresa, $capacitaciones)
    {
        try {
            $sql_eliminar = "DELETE FROM `capacitaciones_empresa` WHERE `id_empresa`=:idempre AND `id_capacitacion`=:idCap";
            $eliminar = $this->db->prepare($sql_eliminar);
            $eliminar->bindParam(":idempre", $id_empresa, PDO::PARAM_INT);
            $eliminar->bindParam(":idCap", $capacitaciones, PDO::PARAM_INT);
            $eliminar->execute();
            if ($eliminar->rowCount() > 0) {
                require_once '../../controlador/sedecontrolador.php';
                $sede = new SedeControlador(2);
                $sedes = $sede->listarSedes($id_empresa, "", 2);
                if (is_object($sedes[0])) {
                    foreach ($sedes as $idsede) {
                        $sede->desasignarCapacitaciones($idsede->getId(), $capacitaciones, 2);
                    }
                }

                require_once '../../controlador/usuario.controlador.php';
                $usua = new ControladorUsuario(2);
                $usuarios = $usua->listarUsuarioEmpresaSede($id_empresa, 0, "", 2);
                if (is_object($usuarios[0])) {
                    foreach ($usuarios as $idusua) {
                        $foo = array('usuario' => $idusua->getId(), 'codigo' => $capacitaciones);
                        $usua->quitarCapacitacion($foo, $capacitaciones, 2);
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
            //echo $e->getLine();
            //die("Error :" . $e->getMessage());
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
        $empresa->setCapacitaciones($this->obtenerCapacitaciones($fila['id']));
        $empresa->setSedes($this->obtenerSedesActivas($fila['id']));
        $empresa->setUsuario($this->obtenerUsuariosActivos($fila['id']));
        return $empresa;
    }
}
