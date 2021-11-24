<?php
require_once 'componentes/nav.php';
$curso = new ControladorCurso(1);
$user = new ControladorUsuario(1);
$usu = $user->buscarUsuarios($_GET['id'], 1);
foreach ($usu as $usuario) {
?>
    <div class="container" style="padding-top: 4rem; margin-bottom: 2%;">
        <h3 style="text-align: center; margin-bottom: 2%;"><?php if ($_SESSION['rol_app_cap'] == 1 && $_SESSION['id_app_cap'] != $_GET['id']) echo "Capacitaciónes asignadas a " . $usuario->getNombre() . " " . $usuario->getApellido();
                                                            else echo "Mis resultados"; ?></h3>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            $sincursos = true;
            $capacitacion = new Curso;
            $capacitacion = $curso->listarCapacitacion("", "", "", 1);
            foreach ($capacitacion as $cap) {
                $cap_asignada = $user->validarCurso($usuario->getId(), $cap->getId(), 1);
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
                                    $acertadas = $user->resultados($usuario->getId(), $cap->getId(), $cap->getCan_pregutas(), 1);
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
                                } else if ($_SESSION['rol_app_cap'] == 1) echo "<br><b>Capacitación sin resolver</b>"; ?>


                            </div>
                            <div class="card-footer" style="text-align: center;">
                                <?php
                                if ($cap_asignada[2] != 0) {
                                    echo '<a href="../vista/?ver-resulatados=' . $cap->getId() . '" class="btn btn-success" style="margin-top:2%">Revisar</a>';
                                } else if ($_SESSION['rol_app_cap'] == 1) {
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
                                                    eliminar(id, '<?php echo $usuario->getId(); ?>');
                                                }
                                            })
                                        }

                                        function eliminar(idCap, idUsuario) {
                                            var datos = {
                                                codigo: idCap,
                                                usuario: idUsuario,
                                                accion: 'quitar_capacitacion'
                                            }
                                            $.ajax({
                                                url: 'acciones-ajax/asignar_capacitaciones.php',
                                                type: 'post',
                                                data: datos,
                                                success: function(id_respuesta) {
                                                    $('#id_respuesta').html(id_respuesta)
                                                }
                                            });
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
            if ($sincursos) echo "<h3 style='text-align: center; width: 100%;'>Sin capacitaciónes</h3>";

            ?>
        </div>
    </div>
<?php }
