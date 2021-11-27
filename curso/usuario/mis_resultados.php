<?php

$usu = $user->buscarUsuarios($_SESSION['id_app_cap'], 1);
if ($usu[0]->getRol() == 'Administrador general')
    $usu = $user->buscarUsuarios($_GET['id'], 1);

foreach ($usu as $usuarios) {
    if (isset($_POST['buscar'])) {
        $buscar = $_POST['buscar'];
        $pagina = $_POST['pagina'];
        require_once "../../controlador/curso.controlador.php";
        require_once "../../controlador/usuario.controlador.php";
        $var = 2;
    } else {
        $buscar = "";
        $pagina = 1;
        $var = 1;
    }
    $curso = new ControladorCurso($var);
    $sincursos = true;
    $capacitacion = $curso->listarCapacitacion($usuarios->getRol(), $usuarios->getId(), "", "", 0, 15, $var);
    if (is_object($capacitacion[0])) {
        foreach ($capacitacion as $cap) {
            $cap_asignada = $user->validarCurso($usuarios->getId(), $cap->getId(), 1);
            if ($cap_asignada[0] == 1) {
                $sincursos = false;
?>
                <div class="col">
                    <div class="card">
                        <div class="card-header" style="text-align: center;"><b><?php echo $cap->getNombre(); ?></b></div>
                        <?php
                        if (!empty(trim($cap->getImagen())))
                            echo '<img style="height: 220px; padding:1%;" src="../componentes/imagenes/' . $cap->getImagen() . '" class="card-img-top" alt="Capacitación sin imagen">';
                        else
                            echo 'no hay imagen';
                        ?>
                        <div class="card-body">
                            Cantidad de preguntas:
                            <?php
                            echo $cap->getCan_pregutas();

                            if ($cap_asignada[2] != 0) {
                                $acertadas = $user->resultados($usuarios->getId(), $cap->getId(), $cap->getCan_pregutas(), 1);
                                if (is_numeric($acertadas[1])) {
                                    echo "<br>";
                                    echo "Puntaje total: <b>" . $acertadas[10];
                                    echo "%</b><br>";
                                    echo "<br>";
                                    echo "<b>{$acertadas[0]}</b><br>";
                                    echo "Preguntas acertadas: " . $acertadas[1];
                                    echo "<br>";
                                    echo "Preguntas perdidas: " . $acertadas[2];
                                    echo "<br>";
                                    echo "Preguntas sin responder: " . $acertadas[3];
                                    echo "<br>";
                                    echo "Puntaje fase 1: <b>" . $acertadas[4];
                                    echo "%</b><br>";
                                    echo "<b>{$acertadas[5]}</b><br>";
                                    echo "Preguntas acertadas: " . $acertadas[6];
                                    echo "<br>";
                                    echo "Preguntas perdidas: " . $acertadas[7];
                                    echo "<br>";
                                    echo "Preguntas sin responder: " . $acertadas[8];
                                    echo "<br>";
                                    echo "Puntaje fase 3: <b>" . $acertadas[9];
                                    echo "%</b><br>";
                                } else {
                                    echo "<br> <b>";
                                    echo $acertadas[1] . "</b>";
                                }
                            } else if ($usuario[0]->getRol() == 'Administrador general') echo "<br><b>Capacitación sin resolver</b>"; ?>


                        </div>
                        <div class="card-footer" style="text-align: center;">
                            <?php
                            if ($cap_asignada[2] != 0) {
                                echo '<a href="../curso/?ver-resulatados=' . $cap->getId() . '&idUsu=' . $_GET['id'] . '" class="btn btn-success" style="margin-top:2%">Revisar</a>';
                            } else if ($usuario[0]->getRol() == 'Administrador general') {
                                echo "<button type='button' class='btn btn-danger'  onclick='quitar(" . '"' . $cap->getId() . '"' . ")'>Quitar capacitación</button>"; ?>
                                <script type="text/javascript">
                                    function quitar(id) {
                                        Swal.fire({
                                            title: '¿Está seguro de quitar la capacitación?',
                                            text: "<?php echo $cap->getNombre(); ?>",
                                            icon: 'question',
                                            showCancelButton: true,
                                            confirmButtonColor: '#d33',
                                            cancelButtonColor: '#3085d6',
                                            cancelButtonText: 'Cancelar',
                                            confirmButtonText: 'Eliminar'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                eliminarCapAsignada(id, '<?php echo $usuarios->getId(); ?>');
                                            }
                                        })
                                    }
                                </script>
                                <div id="id_respuesta">
                                </div>
                            <?php } else echo "<b>Capacitación sin resolver</b>"; ?>


                        </div>
                    </div>
                </div>
<?php
            }
        }
    }
    if ($sincursos) echo "<h3 style='text-align: center; width: 100%;'>Sin capacitaciónes</h3>";
}
