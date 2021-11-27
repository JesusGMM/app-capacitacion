<?php
if (isset($_POST['buscar'])) {
    $buscar = $_POST['buscar'];
    $pagina = $_POST['pagina'];
    require_once "../controlador/curso.controlador.php";
    require_once "../controlador/usuario.controlador.php";
    session_start();
} else {
    $buscar = "";
    $pagina = 1;
}
$fin = 9;
$empieza = ($pagina - 1) * $fin;

$curso = new ControladorCurso(1);
$user = new ControladorUsuario(1);

$usuario = $user->buscarUsuarios($_SESSION['id_app_cap'], 1);

$capacitacion = $curso->listarCapacitacion($usuario[0]->getRol(), $usuario[0]->getId(), $buscar, 1,  $empieza, $fin, 1);
$totalcursos = $curso->contarCursos($buscar, $usuario[0]->getRol(), $usuario[0]->getId(), 1, 1); ?>


<div class="container">
    <?php
    if ($usuario[0]->getRol() == 'Administrador general') { ?>
        <ul class="nav nav-tabs">
            <li class="nav-item tabs">
                <a class="nav-link active" id="publicar" onclick="listadoCurso(1)"><b>Publicadas</b></a>
            </li>
            <li class="nav-item tabs">
                <a class="nav-link" id="borrador" onclick="listadoCurso(2)"><b>En borrador</b></a>
            </li>
        </ul>
    <?php } ?>
    <div class="row">


        <div class="row row-cols-1 row-cols-md-3 g-2" id="publicas">
            <?php
            if (is_object($capacitacion[0])) {
                foreach ($capacitacion as $cap) {
                    if ($cap->getEstado() ==  1)
                        require 'componentes/curso.php';
                }
            } else {
                echo "<h1 style='text-align: center; width: 100%;'>{$capacitacion[1]}</h1>";
            }
            if ($totalcursos != 0) {
                $total_paginas = ceil($totalcursos / $fin);
                if ($total_paginas > 1) { ?>
                    <div class="col-md-12">
                        <nav aria-label="Page navigation example" style="float: right;">
                            <ul class="pagination">
                                <li class="page-item <?php if (1 == $pagina) echo "disabled"; ?>">
                                    <a class="page-link" type="button" onclick="buscarCursoPublicos(<?php echo $pagina - 1; ?>)">&laquo;</a>
                                </li>
                                <?php
                                if ($total_paginas > 5)
                                    echo ' <div class="pagination overflow-auto" style="width: 10.6rem;">';
                                for ($i = 1; $i <= $total_paginas; $i++) {
                                    if ($i == $pagina)
                                        echo '<li class="page-item active"><a class="page-link" id="pagina' . $i . '" href="#">' . $i . '</a></li>';
                                    else
                                        echo '<li class="page-item" style="cursor:pointer;"><a class="page-link" id="pagina' . $i . '" onclick="buscarCursoPublicos(' . $i . ')">' . $i . '</a></li>';
                                }
                                if ($total_paginas > 5)
                                    echo '</div>'; ?>
                                <li class="page-item <?php if ($total_paginas == $pagina) echo "disabled"; ?>">
                                    <a class="page-link" type="button" onclick="buscarCursoPublicos(<?php echo $pagina + 1; ?>)">&raquo;</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
            <?php
                }
            }
            ?>
        </div>
        <?php
        if ($usuario[0]->getRol() == 'Administrador general') { ?>
            <div class="row row-cols-1 row-cols-md-3 g-2" id="borradores" style="display: none;">
                <?php
                $capacitacion = $curso->listarCapacitacion($usuario[0]->getRol(), $usuario[0]->getId(), $buscar, 2,  $empieza, $fin, 1);
                if (is_object($capacitacion[0])) {
                    foreach ($capacitacion as $cap) {
                        if ($cap->getEstado() ==  2)
                            require 'componentes/curso.php';
                    }
                } else {
                    echo "<h1 style='text-align: center; width: 100%;'>{$capacitacion[1]}</h1>";
                }
                $totalcursos = $curso->contarCursos($buscar, $usuario[0]->getRol(), $usuario[0]->getId(),2, 1);
                if ($totalcursos != 0) {
                    $total_paginas = ceil($totalcursos / $fin);
                    if ($total_paginas > 1) { ?>
                        <div class="col-md-12">
                            <nav aria-label="Page navigation example" style="float: right;">
                                <ul class="pagination">
                                    <li class="page-item <?php if (1 == $pagina) echo "disabled"; ?>">
                                        <a class="page-link" type="button" onclick="buscarCursoBorrador(<?php echo $pagina - 1; ?>)">&laquo;</a>
                                    </li>
                                    <?php
                                    if ($total_paginas > 5)
                                        echo ' <div class="pagination overflow-auto" style="width: 10.6rem;">';
                                    for ($i = 1; $i <= $total_paginas; $i++) {
                                        if ($i == $pagina)
                                            echo '<li class="page-item active"><a class="page-link" id="pagina' . $i . '" href="#">' . $i . '</a></li>';
                                        else
                                            echo '<li class="page-item" style="cursor:pointer;"><a class="page-link" id="pagina' . $i . '" onclick="buscarCursoBorrador(' . $i . ')">' . $i . '</a></li>';
                                    }
                                    if ($total_paginas > 5)
                                        echo '</div>'; ?>
                                    <li class="page-item <?php if ($total_paginas == $pagina) echo "disabled"; ?>">
                                        <a class="page-link" type="button" onclick="buscarCursoBorrador(<?php echo $pagina + 1; ?>)">&raquo;</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                <?php
                    }
                }

                ?>
            </div>
        <?php
        } ?>
        <div id="id_respuesta">
        </div>
    </div>
</div>