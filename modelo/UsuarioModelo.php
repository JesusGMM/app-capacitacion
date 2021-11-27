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
        date_default_timezone_set('America/Bogota');
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

            if (!empty(($contrasena))) {
                $contrasena = hash('whirlpool', $contrasena);
                $sql_contrasena = "UPDATE `usuarios` SET contrasena=:contrasena WHERE id = :id";
                $actualizar_pasword = $this->db->prepare($sql_contrasena);
                $actualizar_pasword->bindParam(":id", $id, PDO::PARAM_INT);
                $actualizar_pasword->bindParam(":contrasena", $contrasena, PDO::PARAM_STR);
                $actualizar_pasword->execute();
                $actualizar_pasword->closeCursor();
                $personas[] = 1;
                $personas[] = "Contraseña actualizada";
            }
            if ($actualizar->rowCount() > 0) {
                $personas[] = 1;
                $personas[] = "Usuario actualizado";
            } else if (empty(($contrasena))) {
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
                $persona->setCap_realizadas($this->obtener_capacitaciones_resueltas($fila['id'], 2));
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


    // LISTAR LOS USUARIOS 
    function listar($busqueda, $empieza, $finaliza)
    {
        try {
            if (empty($busqueda)) {
                $sql = "SELECT * FROM usuarios ORDER BY id DESC limit :inicia, :fin ";
                $consulta = $this->db->prepare($sql);
            } else {
                $sql = "SELECT * FROM usuarios WHERE nombre LIKE :nombre OR apellido LIKE :nombre OR codigo LIKE :nombre ORDER BY id DESC limit :inicia, :fin ";
                $consulta = $this->db->prepare($sql);
                $busqueda = '%' . $busqueda . '%';
                $consulta->bindParam(":nombre", $busqueda, PDO::PARAM_STR);
            }

            $consulta->bindParam(":inicia", $empieza, PDO::PARAM_INT);
            $consulta->bindParam(":fin", $finaliza, PDO::PARAM_INT);
            $consulta->execute();
            if ($consulta->rowCount() > 0) {
                while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $persona = new Persona();
                    $persona->setId($fila['id']);
                    $persona->setCodigo($fila['codigo']);
                    $persona->setNombre($fila['nombre']);
                    $persona->setApellido($fila['apellido']);
                    $persona->setCapacitaiones($this->obtener_capacitaciones($fila['id']));
                    $persona->setCap_realizadas($this->obtener_capacitaciones_resueltas($fila['id'], 2));
                    $personas[] = $persona;
                }
            } else {
                $personas[] = 2;
                $personas[] = "No hay usuarios";
            }
            $consulta->closeCursor();
            return $personas;
        } catch (Exception $e) {
            $personas[0] = 3;
            $personas[1] =  "Ha ocurrido un error si el error persiste comuníquese con soporte ";
            return $personas;
            // echo $e->getLine();
            // die("Error :" . $e->getMessage());
        }
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
            //  die("Error :" . $e->getMessage());
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


    // VALIDAR LAS CAPACITACIONES ASIGNADAS
    function validarCapacitaciones($id, $codigo)
    {
        try {
            $sql = "SELECT * FROM `capacitaciones_usuarios` WHERE id_usuario= :usuario AND id_capacitacion= :capacitacion";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":usuario", $id, PDO::PARAM_INT);
            $consulta->bindParam(":capacitacion", $codigo, PDO::PARAM_INT);
            $consulta->execute();

            if ($consulta->rowCount() > 0) {
                $array[0] = 1;
                $array[1] =  "Este curso ya esta asignado";
                if ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $array[2] =  $fila['estado'];
                    $array[3] =  $fila['fecha_fin'];
                    $array[4] =  $fila['estado_fase1'];
                    $array[5] =  $fila['estado_fase3'];
                }
            } else {
                $array[0] = 3;
                $array[1] =  "Este curso no esta asignado"; //. $e->getLine();
            }
            $consulta->closeCursor();
        } catch (Exception $e) {
            $array[0] = 2;
            $array[1] =  "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $array;
            die("Error :" . $e->getMessage());
        }
        return  $array;
    }

    // ASIGNAR CAPACITACIONES
    function asignarCapacitaciones($id_usuario, $capacitaciones)
    {
        try {
            $fecha = date('Y-m-d H:i:s');
            $estado = 0;
            $sql = "INSERT INTO `capacitaciones_usuarios`(`id_usuario`, `id_capacitacion`, `estado`, `fecha_asignacion`) VALUES (:usuario, :codigo, :estado, :fecha)";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":usuario", $id_usuario, PDO::PARAM_INT);
            $consulta->bindParam(":codigo", $capacitaciones, PDO::PARAM_INT);
            $consulta->bindParam(":estado", $estado, PDO::PARAM_INT);
            $consulta->bindParam(":fecha", $fecha, PDO::PARAM_STR);
            $consulta->execute();
            if ($consulta->rowCount() > 0) {
                $personas[0] = 1;
                $personas[1] = "Capacitaciones asignadas";
            } else {
                $personas[0] = 3;
                $personas[1] = "Capacitaciones no asignadas inténtelo nuevamente";
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

    // QUITAR LAS CAPACITACIONES AL USUARIO
    function desAsignarCapacitaciones($id_usuario, $capacitaciones)
    {
        try {
            $sql_eliminar = "DELETE FROM `capacitaciones_usuarios` WHERE `id_usuario`=:idUsu AND `id_capacitacion`=:idCap";
            $eliminar = $this->db->prepare($sql_eliminar);
            $eliminar->bindParam(":idUsu", $id_usuario, PDO::PARAM_INT);
            $eliminar->bindParam(":idCap", $capacitaciones, PDO::PARAM_INT);
            $eliminar->execute();
            if ($eliminar->rowCount() > 0) {
                $personas[0] = 1;
                $personas[1] = "Capacitacion eliminada";
            } else {
                $personas[0] = 2;
                $personas[1] = "La capacitacion no se pudo eliminar inténtelo nuevamente";
            }
            $eliminar->closeCursor();
        } catch (Exception $e) {
            $personas[0] = 2;
            $personas[1] =  "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $personas;
            die("Error :" . $e->getMessage());
        }
        return $personas;
    }

    function iniciarCapacitaciones($id_usuario, $id_capacitacion, $duracion, $estado)
    {
        try {
            $fecha = date('Y-m-d H:i:s');
            $fechaAuxiliar = strtotime("{$duracion} minutes", strtotime($fecha));
            $fechaSalida = date('Y-m-d H:i:s', $fechaAuxiliar);

            $sql_actualizar = "UPDATE capacitaciones_usuarios SET estado=:ini,fecha_inicio=:inicia,fecha_fin=:finaliza WHERE `id_usuario`=:idUsu AND `id_capacitacion`=:idCap";
            $actualizar = $this->db->prepare($sql_actualizar);
            $actualizar->bindParam(":idUsu", $id_usuario, PDO::PARAM_INT);
            $actualizar->bindParam(":idCap", $id_capacitacion, PDO::PARAM_INT);
            $actualizar->bindParam(":ini", $estado, PDO::PARAM_INT);
            $actualizar->bindParam(":inicia", $fecha, PDO::PARAM_STR);
            $actualizar->bindParam(":finaliza", $fechaSalida, PDO::PARAM_STR);
            $actualizar->execute();
            if ($actualizar->rowCount() > 0) {
                $personas[0] = 1;
                $personas[1] = "Examen iniciado";
                $personas[2] = $duracion;
            } else {
                $personas[0] = 2;
                $personas[1] = "El examen no se pudo iniciar inténtelo nuevamente";
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

    function reiniciarCapacitaciones($id_usuario, $id_capacitacion)
    {
        try {
            $array = $this->validarCapacitaciones($id_usuario, $id_capacitacion);
            if ($array[0] == 1) {
                if ($array[0] != 2) {
                    $personas[0] = 1;
                    $personas[1] = "Examen reiniciado";
                } else {
                    $personas[0] = 1;
                    $personas[1] = "Ya el examen a finalizado";
                }
                // $fecha = strtotime(date('Y-m-d H:i:s'));
                // $fecha_fin = strtotime($array[3]);
                // $duracion = round(abs($fecha_fin - $fecha) / 60,2);
                // if ($fecha_fin > $fecha) {

                //     $personas[2] = $duracion;

                // } else {
                //     $estado = 2;
                //     $sql_actualizar = "UPDATE capacitaciones_usuarios SET estado=:ini WHERE `id_usuario`=:idUsu AND `id_capacitacion`=:idCap";
                //     $actualizar = $this->db->prepare($sql_actualizar);
                //     $actualizar->bindParam(":idUsu", $id_usuario, PDO::PARAM_INT);
                //     $actualizar->bindParam(":idCap", $id_capacitacion, PDO::PARAM_INT);
                //     $actualizar->bindParam(":ini", $estado, PDO::PARAM_INT);
                //     $actualizar->execute();
                //     if ($actualizar->rowCount() > 0) {
                //         $personas[0] = 3;
                //         $personas[1] = "El tiempo del examen ya finalizo";
                //         $personas[2] = 0;
                //     } else {
                //         $personas[0] = 2;
                //         $personas[1] = "El examen no se pudo reiniciar inténtelo nuevamente";
                //     }
                //     $actualizar->closeCursor();          
                // }
            } else {
                $personas[0] = 3;
                $personas[1] = "Este examen ya no esta en su lista";
            }
        } catch (Exception $e) {
            $personas[0] = 2;
            $personas[1] =  "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $personas;
            die("Error :" . $e->getMessage());
        }
        return $personas;
    }

    function guardarRespuesta($idUsuario, $idCap, $idPregunta, $respuesta, $fase)
    {
        try {
            $sql = "INSERT INTO `respuestas`(`id_usuario`, `id_capacitacion`, `id_pregunta`, `respuesta`, `fase`) VALUES (:usuario, :capacitacion, :pregunta, :respuesta, :fase)";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":usuario", $idUsuario, PDO::PARAM_INT);
            $consulta->bindParam(":capacitacion", $idCap, PDO::PARAM_INT);
            $consulta->bindParam(":pregunta", $idPregunta, PDO::PARAM_INT);
            $consulta->bindParam(":respuesta", $respuesta, PDO::PARAM_STR);
            $consulta->bindParam(":fase", $fase, PDO::PARAM_INT);
            $consulta->execute();
            if ($consulta->rowCount() > 0) {
                $estado = 2;
                if ($fase == 1)
                    $sql_actualizar = "UPDATE capacitaciones_usuarios SET estado_fase1=:ini WHERE `id_usuario`=:idUsu AND `id_capacitacion`=:idCap";
                else
                    $sql_actualizar = "UPDATE capacitaciones_usuarios SET estado=:fin, estado_fase3=:ini WHERE `id_usuario`=:idUsu AND `id_capacitacion`=:idCap";

                $actualizar = $this->db->prepare($sql_actualizar);
                $actualizar->bindParam(":idUsu", $idUsuario, PDO::PARAM_INT);
                $actualizar->bindParam(":idCap", $idCap, PDO::PARAM_INT);
                $actualizar->bindParam(":ini", $estado, PDO::PARAM_INT);
                if ($fase == 3)
                    $actualizar->bindParam(":fin", $estado, PDO::PARAM_INT);
                $actualizar->execute();

                $personas[0] = 1;
                $personas[1] = "Fase {$fase} registrada y completada";
            } else {
                $personas[0] = 3;
                $personas[1] = "La fase {$fase} no se pudo registrar inténtelo nuevamente";
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

    function actualizarRespuesta($idUsuario, $idCap, $idPregunta, $respuesta, $fase)
    {
        try {
            $sql = "UPDATE `respuestas` SET `respuesta`=:res WHERE `id_usuario`=:idUsu AND `id_capacitacion`=:idCap AND `id_pregunta`=:idPregunta AND `fase`=:fase";
            $actualizar = $this->db->prepare($sql);
            $actualizar->bindParam(":res", $respuesta, PDO::PARAM_STR);
            $actualizar->bindParam(":idUsu", $idUsuario, PDO::PARAM_INT);
            $actualizar->bindParam(":idCap", $idCap, PDO::PARAM_INT);
            $actualizar->bindParam(":idPregunta", $idPregunta, PDO::PARAM_INT);
            $actualizar->bindParam(":fase", $fase, PDO::PARAM_INT);
            $actualizar->execute();

            if ($actualizar->rowCount() > 0) {
                $estado = 2;
                if ($fase == 1)
                    $sql_actualizar = "UPDATE capacitaciones_usuarios SET estado_fase1=:ini WHERE `id_usuario`=:idUsu AND `id_capacitacion`=:idCap";
                else
                    $sql_actualizar = "UPDATE capacitaciones_usuarios SET estado=:fin, estado_fase3=:ini WHERE `id_usuario`=:idUsu AND `id_capacitacion`=:idCap";
                $actualizar_curso = $this->db->prepare($sql_actualizar);
                $actualizar_curso->bindParam(":idUsu", $idUsuario, PDO::PARAM_INT);
                $actualizar_curso->bindParam(":idCap", $idCap, PDO::PARAM_INT);
                $actualizar_curso->bindParam(":ini", $estado, PDO::PARAM_INT);
                if ($fase == 3)
                    $actualizar_curso->bindParam(":fin", $estado, PDO::PARAM_INT);
                $actualizar_curso->execute();

                $personas[0] = 1;
                $personas[1] = "Fase {$fase} registrada y completada";

                $actualizar_curso->closeCursor();
            } else {
                $personas[0] = 3;
                $personas[1] = "La fase {$fase} no se pudo registrar inténtelo nuevamente";
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

    function limpiarRespuesta($idUsuario, $idCap, $fase)
    {
        try {
            $respuesta = "";
            $sql = "UPDATE `respuestas` SET `respuesta`=:res WHERE `id_usuario`=:idUsu AND `id_capacitacion`=:idCap AND `fase`=:fase";
            $actualizar = $this->db->prepare($sql);
            $actualizar->bindParam(":res", $respuesta, PDO::PARAM_STR);
            $actualizar->bindParam(":idUsu", $idUsuario, PDO::PARAM_INT);
            $actualizar->bindParam(":idCap", $idCap, PDO::PARAM_INT);
            $actualizar->bindParam(":fase", $fase, PDO::PARAM_INT);
            $actualizar->execute();
            if ($actualizar->rowCount() > 0) {
                $personas[0] = 1;
                $personas[1] = "Respuestas limpiadas";
            } else {
                $personas[0] = 3;
                $personas[1] = "Las respuestas no se pudo limpiar inténtelo nuevamente";
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

    function resultadosExamen($id, $codigo, $cantidad)
    {
        try {
            $sql = "SELECT * FROM `respuestas` WHERE `id_usuario`=:usuario AND `id_capacitacion`=:idcapa";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":usuario", $id, PDO::PARAM_INT);
            $consulta->bindParam(":idcapa", $codigo, PDO::PARAM_INT);
            $consulta->execute();
            if ($consulta->rowCount() > 0) {
                $pregunta_contro = new ControladorPregunta(1);
                $preguntas = $pregunta_contro->buscarPregunta($codigo, "", "");
                $respuesta_corecta_fase1 = 0;
                $respuesta_incorecta_fase1 = 0;
                $respuesta_corecta_fase3 = 0;
                $respuesta_incorecta_fase3 = 0;
                while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    if ($fila['fase'] == 1) {
                        foreach ($preguntas as $pregunta) {
                            if ($fila['id_pregunta'] == $pregunta->getId()) {
                                if ($fila['respuesta'] == $pregunta->getRespuesta_corecta())
                                    $respuesta_corecta_fase1 = 1 + $respuesta_corecta_fase1;
                                else
                                    $respuesta_incorecta_fase1 = 1 + $respuesta_incorecta_fase1;
                            }
                        }
                    } else {
                        foreach ($preguntas as $pregunta) {
                            if ($fila['id_pregunta'] == $pregunta->getId()) {
                                if ($fila['respuesta'] == $pregunta->getRespuesta_corecta())
                                    $respuesta_corecta_fase3 = 1 + $respuesta_corecta_fase3;
                                else
                                    $respuesta_incorecta_fase3 = 1 + $respuesta_incorecta_fase3;
                            }
                        }
                    }
                }
                if ($cantidad == ($respuesta_corecta_fase1 + $respuesta_incorecta_fase1))
                    $respuesta_sin_responder_fase1 = 0;
                else
                    $respuesta_sin_responder_fase1 = $cantidad - ($respuesta_corecta_fase1 + $respuesta_incorecta_fase1);

                if ($cantidad == ($respuesta_corecta_fase3 + $respuesta_incorecta_fase3))
                    $respuesta_sin_responder_fase3 = 0;
                else
                    $respuesta_sin_responder_fase3 = $cantidad - ($respuesta_corecta_fase3 + $respuesta_incorecta_fase3);

                $porcentaje_fase1 = ($respuesta_corecta_fase1 / $cantidad) * 100;
                $porcentaje_fase3 = ($respuesta_corecta_fase3 / $cantidad) * 100;
                $total = ($porcentaje_fase1 + $porcentaje_fase3) / 2;
                unset($personas);
                $personas[] = "fase 1";
                $personas[] = $respuesta_corecta_fase1;
                $personas[] = $respuesta_incorecta_fase1;
                $personas[] = $respuesta_sin_responder_fase1;
                $personas[] = $porcentaje_fase1;
                $personas[] = "fase 3";
                $personas[] = $respuesta_corecta_fase3;
                $personas[] = $respuesta_incorecta_fase3;
                $personas[] = $respuesta_sin_responder_fase3;
                $personas[] = $porcentaje_fase3;
                $personas[] = $total;
            } else {
                $personas[0] = 3;
                $personas[1] = "No ha resuelto el examen inténtelo nuevamente";
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

    function listarRespuesta($usuario, $capacitacio, $fase)
    {
        try {
            $sql = "SELECT * FROM `respuestas` WHERE `id_usuario`=:usuario AND `id_capacitacion`=:idcapa AND `fase`=:idfase";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":usuario", $usuario, PDO::PARAM_INT);
            $consulta->bindParam(":idcapa", $capacitacio, PDO::PARAM_INT);
            $consulta->bindParam(":idfase", $fase, PDO::PARAM_INT);
            $consulta->execute();
            if ($consulta->rowCount() > 0) {
                while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $personas[] = $fila;
                }
                $consulta->closeCursor();
            } else {
                $personas[0] = 3;
                $personas[1] = "No ha resuelto el examen inténtelo nuevamente";
            }
        } catch (Exception $e) {
            $personas[0] = 2;
            $personas[1] =  "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $personas;
            die("Error :" . $e->getMessage());
        }
        return $personas;
    }


    function cantidadUsuarios($busqueda)
    {
        try {
            if (empty($busqueda)) {
                $sql = "SELECT COUNT(id) FROM `usuarios`";
                $consulta = $this->db->prepare($sql);
            } else {
                $sql = "SELECT  COUNT(id) FROM usuarios WHERE nombre LIKE :nombre OR apellido LIKE :nombre OR codigo LIKE :nombre";
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
}
