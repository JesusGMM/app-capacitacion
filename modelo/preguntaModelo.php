<?php


class ModeloPregunta
{

    private $db;
    private $array;

    function __construct($var)
    {
        if ($var == 1) {
            require_once("../clases/pregunta.php");
        } else if ($var == 2) {
            require_once("../../clases/pregunta.php");
        }
        require_once("conexion.php");
        $this->db = conectar::conexion();
        $this->array = array();
    }

    //CREAR PREGUNTAS
    function crearPreguntas($id, $cantidad)
    {
        try {
            $sql = "INSERT INTO `preguntas`( `id_capacitacion`) VALUES (:id)";
            $pregunta = $this->db->prepare($sql);
            $pregunta->bindParam(":id", $id, PDO::PARAM_INT);
            for ($i = 1; $i <= $cantidad; $i++) {
                $pregunta->execute();
            }
            if ($pregunta->rowCount() > 0) {
                $array[] = 1;
            } else {
                $array[] = 3;
                $array[] = "Curso no registrado inténtelo nuevamente";
            }
            $pregunta->closeCursor();
        } catch (Exception $e) {
            $array[0] = 2;
            $array[1] =  "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $array;
            // echo "<br><br><br><br>";
            // echo $e->getLine();
            die("Error :" . $e->getMessage());
        }
        return $array;
    }

    // EDITAR UN PREGUNTAS
    function actualizar(Pregunta $pregunta)
    {
        $id = $pregunta->getId();
        $nombre = $pregunta->getPregunta();
        $respuesta1 = $pregunta->getRespuesta1();
        $respuesta2 = $pregunta->getRespuesta2();
        $respuesta3 = $pregunta->getRespuesta3();
        $respuesta4 = $pregunta->getRespuesta4();
        $respuesta5 = $pregunta->getRespuesta_corecta();

        try {
            $sql = "UPDATE preguntas SET pregunta = :pregunta, respuesta_A = :res1, respuesta_B = :res2, respuesta_C = :res3, respuesta_D = :res4, respuesta_correcta = :res5 WHERE id= :id";
            $actualizar = $this->db->prepare($sql);
            $actualizar->bindParam(":id", $id, PDO::PARAM_INT);
            $actualizar->bindParam(":pregunta", $nombre, PDO::PARAM_STR);
            $actualizar->bindParam(":res1", $respuesta1, PDO::PARAM_STR);
            $actualizar->bindParam(":res2", $respuesta2, PDO::PARAM_STR);
            $actualizar->bindParam(":res3", $respuesta3, PDO::PARAM_STR);
            $actualizar->bindParam(":res4", $respuesta4, PDO::PARAM_STR);
            $actualizar->bindParam(":res5", $respuesta5, PDO::PARAM_STR);
            $actualizar->execute();

            if ($actualizar->rowCount() > 0 || (!empty($respuesta5))) {
                $array[] = 1;
                $array[] = "Pregunta actualizada";
            } else {
                $array[] = 3;
                $array[] = "Pregunta no actualizada inténtelo nuevamente";
            }
            $actualizar->closeCursor();
        } catch (Exception $e) {
            $array[0] = 2;
            $array[1] =  "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $array;
            die("Error :" . $e->getMessage());
        }
        return $array;
    }


    //ELIMINAR PREGUNTA
    function eliminar($id)
    {
        try {
            $sql_eliminar = "DELETE FROM preguntas WHERE id=:id";
            $eliminar = $this->db->prepare($sql_eliminar);
            $eliminar->bindParam(":id", $id, PDO::PARAM_INT);
            $eliminar->execute();
            if ($eliminar->rowCount() > 0) {
                $array[] = 1;
                $array[] = "Pregunta eliminada";
            } else {
                $array[] = 3;
                $array[] = "Pregunta no eliminada inténtelo nuevamente";
            }
        } catch (Exception $e) {
            $array[0] = 2;
            $array[1] =  "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $array;
            die("Error :" . $e->getMessage());
        }
        return $array;
    }

    //ELIMINAR TODAS LAS PREGUNTAS
    function eliminarTodas($id)
    {
        try {
            $sql_eliminar = "DELETE FROM preguntas WHERE id_capacitacion=:id";
            $eliminar = $this->db->prepare($sql_eliminar);
            $eliminar->bindParam(":id", $id, PDO::PARAM_INT);
            $eliminar->execute();
            if ($eliminar->rowCount() > 0) {
                $array[] = 1;
                $array[] = "Preguntas eliminadas";
            } else {
                $array[] = 3;
                $array[] = "Preguntas no eliminadas inténtelo nuevamente";
            }
        } catch (Exception $e) {
            $array[0] = 2;
            $array[1] =  "Ha ocurrido un error si el error persiste comuníquese con soporte "; //. $e->getLine();
            return $array;
            die("Error :" . $e->getMessage());
        }
        return $array;
    }

    // BUSCAR UN CURSO
    function buscar($id_cap, $empieza, $finaliza)
    {
        try {
            if (empty($finaliza)) {
                $sql = "SELECT * FROM preguntas WHERE id_capacitacion= :id_pregunta ORDER BY id";
                $consulta = $this->db->prepare($sql);
                $consulta->bindParam(":id_pregunta", $id_cap, PDO::PARAM_INT);
            } else {
                $sql = "SELECT * FROM preguntas WHERE id_capacitacion= :id_pregunta ORDER BY id LIMIT :inicia, :fin";
                $consulta = $this->db->prepare($sql);
                $consulta->bindParam(":inicia", $empieza, PDO::PARAM_INT);
                $consulta->bindParam(":fin", $finaliza, PDO::PARAM_INT);
                $consulta->bindParam(":id_pregunta", $id_cap, PDO::PARAM_INT);
            }

            $consulta->execute();
            if ($consulta->rowCount() > 0) {
               while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $pregunta = new Pregunta();
                $pregunta->setId($fila['id']);
                $pregunta->setId_capacitacion($fila['id_capacitacion']);
                $pregunta->setPregunta($fila['pregunta']);
                $pregunta->setRespuesta1($fila['respuesta_A']);
                $pregunta->setRespuesta2($fila['respuesta_B']);
                $pregunta->setRespuesta3($fila['respuesta_C']);
                $pregunta->setRespuesta4($fila['respuesta_D']);
                $pregunta->setRespuesta_corecta($fila['respuesta_correcta']);
                $array[] = $pregunta;
               }
            } else {
                $array[0] = 3;
                $array[1] =  "Este curso no tiene preguntas"; //. $e->getLine();
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


    function preguntasCompletas($id, $nombre)
    {

        try {
            $sql = "SELECT * FROM preguntas WHERE id_capacitacion=:id_curso and `respuesta_correcta`=:buscar";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":id_curso", $id, PDO::PARAM_INT);
            $consulta->bindParam(":buscar", $nombre, PDO::PARAM_STR);
            $consulta->execute();

            if ($consulta->rowCount() > 0) {
                $array[0] = 3;
                $array[1] =  "Este curso no tiene todas las preguntas completadas"; //. $e->getLine();

            } else {
                $array[0] = 1;
                $array[1] =  "Preguntas completadas";
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
}
