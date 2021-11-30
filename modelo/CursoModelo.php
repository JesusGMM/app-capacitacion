<?php

class ModeloCurso {

    private $db;
    private $array;

    function __construct($var) {
        if ($var == 1) {
            require_once("../clases/curso.php");
        } else {
            require_once("../../clases/curso.php");
        }
        require_once("conexion.php");

        $this->db = conectar::conexion();
        $this->array = array();
    }

    // VALIDAR SI EL CURSO YA EXISTE
    function validarCurso($id) {
        try {
            $sql = "SELECT * FROM capacitaciones WHERE codigo=:id";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":id", $id, PDO::PARAM_STR);
            $consulta->execute();
            if ($consulta->rowCount() > 0) {
                if ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $array[0] = 3;
                    $array[1] = "El codigo del curso ya existe";
                    $array[2] = $fila['numero_preguntas'];
                    $array[3] = $fila['id'];
                }
            } else {
                $array[0] = 1;
                $array[1] = "El codigo del curso no existe";
            }
        } catch (Exception $e) {
            $array[0] = 2;
            $array[1] = "Ha ocurrido un error, si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $array;
            die("Error :" . $e->getMessage());
        }
        return $array;
    }

    // REGISTRAR UN CURSO
    function crear(Curso $curso) {
        $codigo = $curso->getCodigo();
        $nombre = $curso->getNombre();
        $descripcion = $curso->getDescripcion();
        $tiempo = $curso->getTiempo();
        $numero = $curso->getCan_pregutas();
        $url = $curso->getUrl();
        $imagen = $curso->getImagen();
        $estado = $curso->getEstado();

        try {
            $sql = "INSERT INTO capacitaciones (codigo,nombre, descripcion, numero_preguntas, tiempo, estado, link_video, imagen) VALUES (:codigo,:nombre,:descripcion,:cantidad,:duracion,:estado,:direcion,:foto)";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":codigo", $codigo, PDO::PARAM_STR);
            $consulta->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $consulta->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
            $consulta->bindParam(":cantidad", $numero, PDO::PARAM_INT);
            $consulta->bindParam(":duracion", $tiempo, PDO::PARAM_INT);
            $consulta->bindParam(":estado", $estado, PDO::PARAM_INT);
            $consulta->bindParam(":direcion", $url, PDO::PARAM_STR);
            $consulta->bindParam(":foto", $imagen, PDO::PARAM_STR);
            $consulta->execute();
            $id = $this->db->lastInsertId();
            if ($consulta->rowCount() > 0) {
                require_once "../controlador/pregunta.controlador.php";
                $controlPre = new ControladorPregunta(1);
                $array = $controlPre->crearPregunta($id, $numero);
                if ($array[0] == 1) {
                    $array[] = "Curso registrado";
                    $array[] = $id;
                }
            } else {
                $array[] = 3;
                $array[] = "Curso no registrado inténtelo nuevamente";
            }
            $consulta->closeCursor();
        } catch (Exception $e) {
            $array[0] = 2;
            $array[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $array;
            // echo "<br><br><br><br>";
            // echo $e->getLine();
            die("Error :" . $e->getMessage());
        }
        return $array;
    }

    // ACTUALIZAR UN CURSO
    function actualizar(Curso $curso) {
        $id = $curso->getId();
        $codigo = $curso->getCodigo();
        $nombre = $curso->getNombre();
        $descripcion = $curso->getDescripcion();
        $tiempo = $curso->getTiempo();
        $numero = $curso->getCan_pregutas();
        $url = $curso->getUrl();
        $imagen = $curso->getImagen();
        $estado = $curso->getEstado();

        try {
            $sql = "UPDATE capacitaciones SET codigo=:codigoCap, nombre=:titulo, descripcion=:desCap, numero_preguntas=:numCap, tiempo=:duracion, estado=:estadoCap, link_video=:urlCap, imagen=:foto WHERE id=:idCap";
            $actualizar = $this->db->prepare($sql);
            $actualizar->bindParam(":idCap", $id, PDO::PARAM_INT);
            $actualizar->bindParam(":codigoCap", $codigo, PDO::PARAM_STR);
            $actualizar->bindParam(":titulo", $nombre, PDO::PARAM_STR);
            $actualizar->bindParam(":desCap", $descripcion, PDO::PARAM_STR);
            $actualizar->bindParam(":numCap", $numero, PDO::PARAM_INT);
            $actualizar->bindParam(":duracion", $tiempo, PDO::PARAM_INT);
            $actualizar->bindParam(":estadoCap", $estado, PDO::PARAM_INT);
            $actualizar->bindParam(":urlCap", $url, PDO::PARAM_STR);
            $actualizar->bindParam(":foto", $imagen, PDO::PARAM_STR);
            $actualizar->execute();

            if ($actualizar->rowCount() > 0) {
                $array[0] = 1;
                $array[1] = "Capacitacion actualizada";
            } else {
                $array[0] = 3;
                $array[1] = "Capacitacion no actualizado inténtelo nuevamente";
            }
            $actualizar->closeCursor();
        } catch (Exception $e) {
            $array[0] = 2;
            $array[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $array;

            echo $e->getLine();
            die("Error :" . $e->getMessage());
        }
        return $array;
    }

    // ACTUALIZAR EL ESTADO
    function actualizarEstado(Curso $curso) {
        $codigo = $curso->getCodigo();
        $estado = $curso->getEstado();

        try {
            $sql = "UPDATE capacitaciones SET estado = :estado WHERE codigo=:id";
            $actualizar = $this->db->prepare($sql);
            $actualizar->bindParam(":id", $codigo, PDO::PARAM_STR);
            $actualizar->bindParam(":estado", $estado, PDO::PARAM_INT);
            $actualizar->execute();

            if ($actualizar->rowCount() > 0) {
                $array[] = 1;
                $array[] = "Estado actualizado";
            } else {
                $array[] = 3;
                $array[] = "Estado no actualizado inténtelo nuevamente";
            }
            $actualizar->closeCursor();
        } catch (Exception $e) {
            $array[0] = 2;
            $array[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $array;
            die("Error :" . $e->getMessage());
        }
        return $array;
    }

    // ACTUALIZAR LA CANTIDAD DE PREGUNTAS
    function actualizarNumeroPreguntas(Curso $curso) {
        $codigo = $curso->getCodigo();
        $cantidad = $curso->getCan_pregutas();

        try {
            $sql = "UPDATE capacitaciones SET numero_preguntas = :estado WHERE codigo=:id";
            $actualizar = $this->db->prepare($sql);
            $actualizar->bindParam(":id", $codigo, PDO::PARAM_STR);
            $actualizar->bindParam(":estado", $cantidad, PDO::PARAM_INT);
            $actualizar->execute();

            if ($actualizar->rowCount() > 0) {
                $array[] = 1;
                $array[] = "Curso actualizada";
            } else {
                $array[] = 3;
                $array[] = "Curso no actualizada inténtelo nuevamente";
            }
            $actualizar->closeCursor();
        } catch (Exception $e) {
            $array[] = 2;
            $array[] = "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $array;
            die("Error :" . $e->getMessage());
        }
        return $array;
    }

    //ELIMINAR CURSO
    function eliminarCapacitacion($codigo, $id) {
        try {
            require_once "../../controlador/pregunta.controlador.php";
            $controlPre = new ControladorPregunta(2);
            $array = $controlPre->eliminarTodasPregunta($id);
            if ($array[0] == 1 || $array[0] == 3) {
                $sql_eliminar = "DELETE FROM capacitaciones WHERE codigo=:id";
                $eliminar = $this->db->prepare($sql_eliminar);
                $eliminar->bindParam(":id", $codigo, PDO::PARAM_STR);
                $eliminar->execute();
                if ($eliminar->rowCount() > 0) {
                    $array[0] = 1;
                    $array[1] = "Capacitacion eliminada";
                } else {
                    $array[0] = 2;
                    $array[1] = "Capacitacion no eliminada inténtelo nuevamente";
                }
            }
        } catch (Exception $e) {
            $array[0] = 2;
            $array[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $array;
            die("Error :" . $e->getMessage());
        }
        return $array;
    }

    // BUSCAR UN CURSO
    function buscarCurso($id) {
        try {
            $sql = "SELECT * FROM capacitaciones WHERE id= :id_curso";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":id_curso", $id, PDO::PARAM_INT);
            $consulta->execute();

            if ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $capacitacion = new Curso();
                $capacitacion->setId($fila['id']);
                $capacitacion->setNombre($fila['nombre']);
                $capacitacion->setCodigo($fila['codigo']);
                $capacitacion->setDescripcion($fila['descripcion']);
                $capacitacion->setCan_pregutas($fila['numero_preguntas']);
                $capacitacion->setTiempo($fila['tiempo']);
                $capacitacion->setEstado($fila['estado']);
                $capacitacion->setUrl($fila['link_video']);
                $capacitacion->setImagen($fila['imagen']);
                $array[] = $capacitacion;
                $consulta->closeCursor();
            } else {
                $array[0] = 3;
                $array[1] = "Este curso no existe"; //. $e->getLine();
            }
            $consulta->closeCursor();
        } catch (Exception $e) {
            $array[0] = 2;
            $array[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $array;
            die("Error :" . $e->getMessage());
        }
        return $array;
    }

    // LISTAR TODOS LOS CURSOS 
    function listar($busqueda, $estado, $empieza, $finaliza) {
        try {

            if (empty($busqueda) && (!empty(trim($finaliza))) && (empty(trim($estado)))) {
                $sql = "SELECT * FROM capacitaciones ORDER BY id DESC limit :inicia, :fin ";
                $consulta = $this->db->prepare($sql);
                $consulta->bindParam(":inicia", $empieza, PDO::PARAM_INT);
                $consulta->bindParam(":fin", $finaliza, PDO::PARAM_INT);
            } else if (($busqueda == 1) && (!empty(trim($finaliza))) && (empty(trim($estado)))) {
                $sql = "SELECT * FROM capacitaciones WHERE estado=:estado ORDER BY id DESC limit :inicia, :fin ";
                $consulta = $this->db->prepare($sql);
                $consulta->bindParam(":inicia", $empieza, PDO::PARAM_INT);
                $consulta->bindParam(":fin", $finaliza, PDO::PARAM_INT);
                $consulta->bindParam(":estado", $busqueda, PDO::PARAM_INT);
            } else if ((!empty($busqueda)) && ((empty(trim($empieza))) && (empty(trim($finaliza)))) && (empty(trim($estado)))) {
                $sql = "SELECT * FROM capacitaciones WHERE id=:id_curso";
                $consulta = $this->db->prepare($sql);
                $consulta->bindParam(":id_curso", $busqueda, PDO::PARAM_INT);
            } else if (!empty($busqueda) && (!empty(trim($finaliza))) && (empty(trim($estado)))) {
                $sql = "SELECT * FROM capacitaciones WHERE nombre LIKE :nombre OR descripcion LIKE :nombre ORDER BY id limit :inicia, :fin ";
                $consulta = $this->db->prepare($sql);
                $busqueda = '%' . $busqueda . '%';
                $consulta->bindParam(":nombre", $busqueda, PDO::PARAM_STR);
                $consulta->bindParam(":inicia", $empieza, PDO::PARAM_INT);
                $consulta->bindParam(":fin", $finaliza, PDO::PARAM_INT);
            } else if ((empty($busqueda)) && (!empty(trim($finaliza))) && (!empty(trim($estado)))) {
                $sql = "SELECT * FROM capacitaciones WHERE estado=:estado ORDER BY id DESC limit :inicia, :fin ";
                $consulta = $this->db->prepare($sql);
                $consulta->bindParam(":inicia", $empieza, PDO::PARAM_INT);
                $consulta->bindParam(":fin", $finaliza, PDO::PARAM_INT);
                $consulta->bindParam(":estado", $estado, PDO::PARAM_INT);
            } else if (!empty($busqueda) && (!empty(trim($finaliza))) && (!empty(trim($estado)))) {
                $sql = "SELECT * FROM capacitaciones WHERE estado=:estado AND (nombre LIKE :nombre OR descripcion LIKE :nombre) ORDER BY id DESC limit :inicia, :fin ";
                $consulta = $this->db->prepare($sql);
                $busqueda = '%' . $busqueda . '%';
                $consulta->bindParam(":inicia", $empieza, PDO::PARAM_INT);
                $consulta->bindParam(":fin", $finaliza, PDO::PARAM_INT);
                $consulta->bindParam(":estado", $estado, PDO::PARAM_INT);
                $consulta->bindParam(":nombre", $busqueda, PDO::PARAM_STR);
            } else if (empty($busqueda) && (empty(trim($finaliza))) && (empty(trim($estado)))) {
                $sql = "SELECT * FROM capacitaciones ";
                $consulta = $this->db->prepare($sql);
            }
            $consulta->execute();
            if ($consulta->rowCount() > 0) {
                while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $capacitacion = new Curso();
                    $capacitacion->setId($fila['id']);
                    $capacitacion->setNombre($fila['nombre']);
                    $capacitacion->setCodigo($fila['codigo']);
                    $capacitacion->setDescripcion($fila['descripcion']);
                    $capacitacion->setCan_pregutas($fila['numero_preguntas']);
                    $capacitacion->setTiempo($fila['tiempo']);
                    $capacitacion->setEstado($fila['estado']);
                    $capacitacion->setUrl($fila['link_video']);
                    $capacitacion->setImagen($fila['imagen']);
                    $array[] = $capacitacion;
                }
            } else {
                $array[0] = 3;
                $array[1] = "No hay cursos";
            }

            $consulta->closeCursor();
            return $array;
        } catch (Exception $e) {
            $array[0] = 2;
            $array[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $array;
            die("Error :" . $e->getMessage());
        }
    }

    function listarInscritos($id) {
        try {
            $sql = "SELECT COUNT(id) FROM `capacitaciones_usuarios` WHERE id_capacitacion= :idCap";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":idCap", $id, PDO::PARAM_INT);
            $consulta->execute();

            if ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                return $fila['COUNT(id)'];
            } else {
                return 0;
            }
            $consulta->closeCursor();
        } catch (Exception $e) {
            $array[0] = 2;
            $array[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $array;
            die("Error :" . $e->getMessage());
        }
    }

    function listarCursosInscritos($buscar, $empieza, $finaliza, $id) {
        try {
            $estado = 1;
            if (empty($buscar)) {
                $sql = "SELECT capacitaciones.* FROM `capacitaciones` 
                INNER JOIN capacitaciones_usuarios ON capacitaciones_usuarios.id_capacitacion = capacitaciones.id 
                WHERE capacitaciones_usuarios.id_usuario =:idUsu AND capacitaciones.estado=:estado ORDER BY capacitaciones.id DESC limit :inicia, :fin";
                $consulta = $this->db->prepare($sql);
            } else {
                $sql = "SELECT capacitaciones.* FROM `capacitaciones` 
                INNER JOIN capacitaciones_usuarios ON capacitaciones_usuarios.id_capacitacion = capacitaciones.id 
                WHERE capacitaciones_usuarios.id_usuario =:idUsu AND capacitaciones.estado=:estado AND (capacitaciones.nombre LIKE :buscar  OR capacitaciones.descripcion LIKE :buscar) ORDER BY capacitaciones.id DESC limit :inicia, :fin ";
                $consulta = $this->db->prepare($sql);
                $buscar = '%' . $buscar . '%';
                $consulta->bindParam(":buscar", $buscar, PDO::PARAM_STR);
            }
            $consulta->bindParam(":idUsu", $id, PDO::PARAM_INT);
            $consulta->bindParam(":estado", $estado, PDO::PARAM_INT);
            $consulta->bindParam(":inicia", $empieza, PDO::PARAM_INT);
            $consulta->bindParam(":fin", $finaliza, PDO::PARAM_INT);
            $consulta->execute();

            if ($consulta->rowCount() > 0) {
                while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $capacitacion = new Curso();
                    $capacitacion->setId($fila['id']);
                    $capacitacion->setNombre($fila['nombre']);
                    $capacitacion->setCodigo($fila['codigo']);
                    $capacitacion->setDescripcion($fila['descripcion']);
                    $capacitacion->setCan_pregutas($fila['numero_preguntas']);
                    $capacitacion->setTiempo($fila['tiempo']);
                    $capacitacion->setEstado($fila['estado']);
                    $capacitacion->setUrl($fila['link_video']);
                    $capacitacion->setImagen($fila['imagen']);
                    $array[] = $capacitacion;
                }
            } else {
                $array[0] = 3;
                $array[1] = "No tienes capacitaciones asignadas";
            }
            $consulta->closeCursor();
        } catch (Exception $e) {
            $array[0] = 2;
            $array[1] = "Ha ocurrido un error si el error persiste comuníquese con soporte ";

            // echo $e->getLine();
            // die("Error :" . $e->getMessage());
        }
        return $array;
    }

    function cantidadCurso($busqueda, $idusuario, $rol, $estado) {
        try {
            if ($rol == 'Administrador general') {
                if (empty(trim($busqueda))) {
                    $sql = "SELECT COUNT(id) FROM `capacitaciones` WHERE estado=:estado";
                    $consulta = $this->db->prepare($sql);
                } else {
                    $sql = "SELECT COUNT(id) FROM `capacitaciones` WHERE estado=:estado AND (nombre LIKE :nombre OR descripcion LIKE :nombre)";
                    $consulta = $this->db->prepare($sql);
                    $busqueda = '%' . $busqueda . '%';
                    $consulta->bindParam(":nombre", $busqueda, PDO::PARAM_STR);
                }
            } else {
                $estado = 1;
                if (empty(trim($busqueda))) {
                    $sql = "SELECT COUNT(capacitaciones_usuarios.id) FROM `capacitaciones_usuarios`   
                    INNER JOIN capacitaciones ON  capacitaciones.id = capacitaciones_usuarios.id_capacitacion
                    WHERE capacitaciones_usuarios.id_usuario=:usuario AND capacitaciones.estado=:estado";
                    $consulta = $this->db->prepare($sql);
                } else {
                    $sql = "SELECT COUNT(capacitaciones_usuarios.id) FROM `capacitaciones_usuarios` 
                    INNER JOIN capacitaciones ON  capacitaciones.id = capacitaciones_usuarios.id_capacitacion
                    WHERE capacitaciones_usuarios.id_usuario=:usuario AND capacitaciones.estado=:estado AND (nombre LIKE :nombre OR descripcion LIKE :nombre)";
                    $consulta = $this->db->prepare($sql);
                    $busqueda = '%' . $busqueda . '%';
                    $consulta->bindParam(":nombre", $busqueda, PDO::PARAM_STR);
                }
                $consulta->bindParam(":usuario", $idusuario, PDO::PARAM_INT);
            }
            $consulta->bindParam(":estado", $estado, PDO::PARAM_INT);
            $consulta->execute();

            if ($consulta->rowCount() > 0) {
                $fila = $consulta->fetch(PDO::FETCH_ASSOC);

                if ($rol == 'Administrador general')
                    return $fila['COUNT(id)'];
                else
                    return $fila['COUNT(capacitaciones_usuarios.id)'];
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

}
