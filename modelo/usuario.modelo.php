<?php


class ModeloUsuario
{

    private $db;
    private $personas;

    function __construct($var)
    {
        require_once("conexion.php");
        if ($var == 1) {
            require_once("../clases/persona.php");
        } else {
            require_once("../../clases/persona.php");
        }

        $this->db = conectar::conexion();
        $this->personas = array();
    }

    // VALIDAR SI EL USUARIO YA EXISTE
    function validarUsuario($usuario)
    {
        try {
            $sql = "SELECT id FROM usuarios WHERE usuario=:usuario";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":usuario", $usuario, PDO::PARAM_STR);
            $consulta->execute();
            if ($consulta->rowCount() > 0) {
                $personas[0] = 3;
                $personas[1] = "El nombre de usuario ya existe";
            } else {
                $personas[0] = 1;
            }
        } catch (Exception $e) {
            $personas[0] = 2;
            $personas[1] =  "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $personas;
            die("Error :" . $e->getMessage());
        }
        return $personas;
    }

    // REGISTRAR UN USUARIO
    function registrar(Persona $usuario)
    {
        $codigo = $usuario->getCodigo();
        $nombre = $usuario->getNombre();
        $apellido = $usuario->getApellido();
        $nombre_usu = $usuario->getUsuario();
        $contrasena = $usuario->getPasword();
        $rol = $usuario->getRol();
        $correo = $usuario->getEmail();

        try {
            $sql = "INSERT INTO `usuarios`(`codigo`,`nombre`, `apellido`, `usuario`, `contrasena`, `correo`, `rol`) VALUES (:codigo,:nombre,:apellido,:usuario,:contrasena,:correo,:rol)";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":codigo", $codigo, PDO::PARAM_STR);
            $consulta->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $consulta->bindParam(":apellido", $apellido, PDO::PARAM_STR);
            $consulta->bindParam(":usuario", $nombre_usu, PDO::PARAM_STR);
            $consulta->bindParam(":contrasena", $contrasena, PDO::PARAM_STR);
            $consulta->bindParam(":correo", $correo, PDO::PARAM_STR);
            $consulta->bindParam(":rol", $rol, PDO::PARAM_INT);
            $consulta->execute();
            if ($consulta->rowCount() > 0) {
                $personas[] = 1;
                $personas[] = "Usuario registrado";
            } else {
                $personas[] = 3;
                $personas[] = "Usuario no registrado inténtelo nuevamente";
            }
            $consulta->closeCursor();
        } catch (Exception $e) {
            $personas[0] = 2;
            $personas[1] =  "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $personas;
            die("Error :" . $e->getMessage());
        }
        return $personas;
    }


    // EDITAR UN USUARIO
    function actualizar(Persona $usuario)
    {
        $id = $usuario->getId();
        $codigo = $usuario->getCodigo();
        $nombre = $usuario->getNombre();
        $apellido = $usuario->getApellido();
        $nombre_usu = $usuario->getUsuario();
        $contrasena = $usuario->getPasword();
        $rol = $usuario->getRol();
        $correo = $usuario->getEmail();

        try {
            $sql = "UPDATE `usuarios` SET codigo = :codigo, nombre = :nombre, apellido = :apellido, usuario = :usuario, correo = :correo, rol = :rol WHERE id= :id";
            $actualizar = $this->db->prepare($sql);
            $actualizar->bindParam(":id", $id, PDO::PARAM_INT);
            $actualizar->bindParam(":codigo", $codigo, PDO::PARAM_STR);
            $actualizar->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $actualizar->bindParam(":apellido", $apellido, PDO::PARAM_STR);
            $actualizar->bindParam(":usuario", $nombre_usu, PDO::PARAM_STR);
            $actualizar->bindParam(":correo", $correo, PDO::PARAM_STR);
            $actualizar->bindParam(":rol", $rol, PDO::PARAM_INT);
            $actualizar->execute();

            if ($actualizar->rowCount() > 0) {
                if (!empty(($contrasena))) {
                    $contrasena = hash('whirlpool', $contrasena);
                    $sql_contrasena = "UPDATE `usuarios` SET contrasena=:contrasena WHERE id = :id";
                    $actualizar_pasword = $this->db->prepare($sql_contrasena);
                    $actualizar_pasword->bindParam(":id", $id, PDO::PARAM_INT);
                    $actualizar_pasword->bindParam(":contrasena", $contrasena, PDO::PARAM_STR);
                    $actualizar_pasword->execute();
                    $actualizar_pasword->closeCursor();
                }
                $personas[] = 1;
                $personas[] = "Usuario actualizado";
            } else {
                $personas[] = 3;
                $personas[] = "Usuario no actualizado inténtelo nuevamente";
            }
            $actualizar->closeCursor();
        } catch (Exception $e) {
            $personas[0] = 2;
            $personas[1] =  "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $personas;
            die("Error :" . $e->getMessage());
        }
        return $personas;
    }

    //ELIMINAR USUARIO
    function eliminar($id)
    {
        try {
            $sql_eliminar = "DELETE FROM usuarios WHERE id=:id";
            $eliminar = $this->db->prepare($sql_eliminar);
            $eliminar->bindParam(":id", $id, PDO::PARAM_INT);
            $eliminar->execute();
            if ($eliminar->rowCount() > 0) {
                $personas[] = 1;
                $personas[] = "Usuario eliminado";
            } else {
                $personas[] = 2;
                $personas[] = "Usuario no eliminado inténtelo nuevamente";
            }
        } catch (Exception $e) {
            $personas[0] = 2;
            $personas[1] =  "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $personas;
            die("Error :" . $e->getMessage());
        }
        return $personas;
    }

    // BUSCAR UN USUARIO
    function buscarUsuario($id)
    {
        try {
            $sql = "SELECT * FROM usuarios WHERE id= :id_usuario";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":id_usuario", $id, PDO::PARAM_INT);
            $consulta->execute();

            if ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $persona = new Persona();
                $persona->setId($fila['id']);
                $persona->setNombre($fila['nombre']);
                $persona->setApellido($fila['apellido']);
                $persona->setCodigo($fila['codigo']);
                $persona->setUsuario($fila['usuario']);
                $persona->setEmail($fila['correo']);
                $persona->setRol($this->obtenerRol($fila['rol']));
                $persona->setCapacitaiones($this->obtener_capacitaciones($fila['id']));
                $persona->setCap_realizadas($this->obtener_capacitaciones_resueltas($fila['id'], "Realializado"));
                $personas[] = $persona;
                return  $personas;
                $consulta->closeCursor();
            } else {
                return 0;
            }
            $consulta->closeCursor();
        } catch (Exception $e) {
            $personas[0] = 2;
            $personas[1] =  "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $personas;
            die("Error :" . $e->getMessage());
        }
    }


    // LISTAR TODOS LOS USUARIOS 
    function listar($empieza, $finaliza)
    {
        try {
            $sql = "SELECT * FROM usuarios ORDER BY id DESC limit :inicia, :fin ";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":inicia", $empieza, PDO::PARAM_INT);
            $consulta->bindParam(":fin", $finaliza, PDO::PARAM_INT);
            $consulta->execute();

            while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $persona = new Persona();
                $persona->setId($fila['id']);
                $persona->setCodigo($fila['codigo']);
                $persona->setNombre($fila['nombre']);
                $persona->setApellido($fila['apellido']);
                $persona->setCapacitaiones($this->obtener_capacitaciones($fila['id']));
                $persona->setCap_realizadas($this->obtener_capacitaciones_resueltas($fila['id'], "Realializado"));
                $personas[] = $persona;
            }
            $consulta->closeCursor();
            return $personas;
        } catch (Exception $e) {
            $personas[0] = 2;
            $personas[1] =  "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $personas;
            die("Error :" . $e->getMessage());
        }
    }

    // LISTAR USUARIOS CON FILTROS
    function buscar($busqueda, $empieza, $finaliza)
    {
        try {
            $sql = "SELECT * FROM usuarios WHERE usuario=:usuario and contrasena=:contrasena";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":usuario", $empieza, PDO::PARAM_STR);
            $consulta->bindParam(":contrasena", $empieza, PDO::PARAM_STR);
            $consulta->execute();

            $fila = $consulta->fetch(PDO::FETCH_ASSOC);
            $persona = new Persona();
            $persona->setId($fila['id']);
            $persona->setNombre($fila['nombre']);
            $persona->setApellido($fila['apellido']);
            $persona->setRol($fila['rol']);
            $persona->setCapacitaiones($this->obtener_capacitaciones($fila['id']));
            $persona->setCap_realizadas($this->obtener_capacitaciones_resueltas($fila['id'], "Realializado"));
            $personas[] = $persona;
            $consulta->closeCursor();
            return $personas;
        } catch (Exception $e) {
            $personas[0] = 2;
            $personas[1] =  "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $personas;
            die("Error :" . $e->getMessage());
        }
        return  $personas;
    }

    // OBTENER LA CANTIDAD DE CAPACITACIONES
    function obtener_capacitaciones($id)
    {
        try {
            $sql = "SELECT COUNT(id) FROM `capacitaciones_usuarios` WHERE id_usuario= :id_usuario";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":id_usuario", $id, PDO::PARAM_INT);
            $consulta->execute();

            if ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                return $fila['COUNT(id)'];
            } else {
                return 0;
            }
            $consulta->closeCursor();
        } catch (Exception $e) {
            $personas[0] = 2;
            $personas[1] =  "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $personas;
            die("Error :" . $e->getMessage());
        }
    }

    // OBTENER LAS CAPACITACIONES REALIZADAS
    function obtener_capacitaciones_resueltas($id, $estado)
    {
        try {
            $sql = "SELECT COUNT(id) FROM `capacitaciones_usuarios` WHERE id_usuario= :id_usuario AND estado=:estado";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":id_usuario", $id, PDO::PARAM_INT);
            $consulta->bindParam(":estado", $estado, PDO::PARAM_STR);
            $consulta->execute();

            if ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                return $fila['COUNT(id)'];
            } else {
                return 0;
            }
            $consulta->closeCursor();
        } catch (Exception $e) {
            $personas[0] = 2;
            $personas[1] =  "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $personas;
            die("Error :" . $e->getMessage());
        }
    }

    // OBTENER EL ROL DEL USUARIO
    function obtenerRol($id)
    {
        try {
            $sql = "SELECT nombre FROM `roles` WHERE id= :id_rol";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":id_rol", $id, PDO::PARAM_INT);
            $consulta->execute();

            if ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                return $fila['nombre'];
            } else {
                return "Sin rol";
            }
            $consulta->closeCursor();
        } catch (Exception $e) {
            $personas[0] = 2;
            $personas[1] =  "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $personas;
            die("Error :" . $e->getMessage());
        }
    }
}
