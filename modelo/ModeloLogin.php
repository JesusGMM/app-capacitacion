<?php


class ModeloLogin
{

    private $db;
    private $personas;

    function __construct()
    {
        require_once("conexion.php");
        require_once("clases/persona.php");
        $this->db = conectar::conexion();
        $this->personas = array();
    }

    function iniciarsesionusu($nomusu, $pasw)
    {
        try {
            $sql = "SELECT * FROM usuarios WHERE usuario=:usuario and contrasena=:contrasena";
            $consulta = $this->db->prepare($sql);
            $consulta->bindParam(":usuario", $nomusu, PDO::PARAM_STR);
            $consulta->bindParam(":contrasena", $pasw, PDO::PARAM_STR);
            $consulta->execute();

            $fila = $consulta->fetch(PDO::FETCH_ASSOC);
            $persona = new Persona();
            $persona->setId($fila['id']);
            $persona->setNombre($fila['nombre']);
            $persona->setApellido($fila['apellido']);
            $persona->setRol($fila['rol']);
            $personas[] = $persona;
            $consulta->closeCursor();
            return $personas;
        } catch (Exception $e) {
            // echo $e->getLine();
            // die("Error :" . $e->getMessage());
        }
    }
}
