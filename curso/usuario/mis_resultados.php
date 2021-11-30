<?php
if (isset($_POST['buscar'])) {
    session_start();
    $buscar = $_POST['buscar'];
    $pagina = $_POST['pagina'];
    $_GET['id'] = $_POST['idusuario'];
    $var = 2;

    require_once "../../controlador/curso.controlador.php";
    require_once "../../controlador/usuario.controlador.php";
} else {
    $buscar = "";
    $pagina = 1;
    $var = 1;
}

$fin = 9;
$empieza = ($pagina - 1) * $fin;

$user = new ControladorUsuario($var);
$usu = $user->buscarUsuarios($_SESSION['id_app_cap'], $var);
$usuario = $usu;
if ($usu[0]->getRol() == 'Administrador general')
    $usu = $user->buscarUsuarios($_GET['id'], $var);

if (is_array($usu)) {
    foreach ($usu as $usuarios) {
        $curso = new ControladorCurso($var);
        $sincursos = true;
        $capacitacion = $curso->listarCapacitacion($usuarios->getRol(), $usuarios->getId(), $buscar, "", $empieza, $fin, $var);
        if (is_object($capacitacion[0])) {
            foreach ($capacitacion as $cap) {
                $cap_asignada = $user->validarCurso($usuarios->getId(), $cap->getId(), $var);
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
                                    $acertadas = $user->resultados($usuarios->getId(), $cap->getId(), $cap->getCan_pregutas(), $var);
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

            $totalcursos = $curso->contarCursos($buscar, $usuarios->getRol(), $usuarios->getId(), 2, $var);

            if ($totalcursos != 0) {
                $total_paginas = ceil($totalcursos / $fin);
                if ($total_paginas > 1) { ?>
                    <div class="col-md-12">
                        <nav aria-label="Page navigation example" style="float: right;">
                            <ul class="pagination">
                                <li class="page-item <?php if (1 == $pagina) echo "disabled"; ?>">
                                    <a class="page-link" type="button" onclick="buscarCursoResueltos(<?php echo ($pagina - 1) . ',' . $_GET['id']; ?>)">&laquo;</a>
                                </li>
                                <?php
                                if ($total_paginas > 5)
                                    echo ' <div class="pagination overflow-auto" style="width: 10.6rem;">';
                                for ($i = 1; $i <= $total_paginas; $i++) {
                                    if ($i == $pagina)
                                        echo '<li class="page-item active"><a class="page-link" id="pagina' . $i . '" href="#">' . $i . '</a></li>';
                                    else
                                        echo '<li class="page-item" style="cursor:pointer;"><a class="page-link" id="pagina' . $i . '" onclick="buscarCursoResueltos(' . $i . ',' . $_GET['id'] . ')">' . $i . '</a></li>';
                                }
                                if ($total_paginas > 5)
                                    echo '</div>'; ?>
                                <li class="page-item <?php if ($total_paginas == $pagina) echo "disabled"; ?>">
                                    <a class="page-link" type="button" onclick="buscarCursoResueltos(<?php echo ($pagina + 1) . ',' . $_GET['id']; ?>)">&raquo;</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
<?php
                }
            }
        }
        if ($sincursos) echo "<h3 style='text-align: center; width: 100%;'>Sin capacitaciónes</h3>";
    }
} else {
    echo "<h3 style='text-align: center; width: 100%;'>Sin capacitaciónes</h3>";
}
