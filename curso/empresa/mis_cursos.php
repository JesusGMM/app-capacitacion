<?php
if (isset($_POST['buscar'])) {
    session_start();
    $buscar = $_POST['buscar'];
    $pagina = $_POST['pagina'];
    $_GET['empresa-id-cursos'] = $_POST['idempresa'];
    require_once "../../controlador/curso.controlador.php";
    $var = 2;
} else {
    $buscar = "";
    $pagina = 1;
    $var = 1;
}

$fin = 9;
$empieza = ($pagina - 1) * $fin;

$curso = new ControladorCurso($var);
$capacitacion = $curso->listarCapacitacionEmpresa($_GET['empresa-id-cursos'], $buscar, $empieza, $fin, $var);

if (is_object($capacitacion[0])) {
    foreach ($capacitacion as $cap) {
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
                    echo $cap->getCan_pregutas(); ?>

                </div>
                <div class="card-footer" style="text-align: center;">
                    <button  class="btn btn-success" style="margin-top: 2%;" onclick="vermodalempresa('detalles',<?php echo $cap->getId(); ?>)">Detalles</button>
                    <button type='button' class='btn btn-danger' style="margin-top: 2%;" onclick="quitarCursoEmpresa(<?php echo $cap->getId() . ',' .  $_GET['empresa-id-cursos'];  ?>)">Quitar capacitación</button>
                </div>
            </div>
        </div>
        <?php

    }

    $totalcursos = $curso->contarCursosEmpresa($buscar, $_GET['empresa-id-cursos'], $var);

    if ($totalcursos != 0) {
        $total_paginas = ceil($totalcursos / $fin);
        if ($total_paginas > 1) { ?>
            <div class="col-md-12">
                <nav aria-label="Page navigation example" style="float: right;">
                    <ul class="pagination">
                        <li class="page-item <?php if (1 == $pagina) echo "disabled"; ?>">
                            <a class="page-link" type="button" onclick="buscarCursoEmpresa(<?php echo ($pagina - 1) . ',' . $_GET['empresa-id-cursos']; ?>)">&laquo;</a>
                        </li>
                        <?php
                        if ($total_paginas > 5)
                            echo ' <div class="pagination overflow-auto" style="width: 10.6rem;">';
                        for ($i = 1; $i <= $total_paginas; $i++) {
                            if ($i == $pagina)
                                echo '<li class="page-item active"><a class="page-link" id="pagina' . $i . '" href="#">' . $i . '</a></li>';
                            else
                                echo '<li class="page-item" style="cursor:pointer;"><a class="page-link" id="pagina' . $i . '" onclick="buscarCursoEmpresa(' . $i . ',' . $_GET['empresa-id-cursos'] . ')">' . $i . '</a></li>';
                        }
                        if ($total_paginas > 5)
                            echo '</div>'; ?>
                        <li class="page-item <?php if ($total_paginas == $pagina) echo "disabled"; ?>">
                            <a class="page-link" type="button" onclick="buscarCursoEmpresa(<?php echo ($pagina + 1) . ',' . $_GET['empresa-id-cursos']; ?>)">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
<?php
        }
    }
} else echo "<h3 style='text-align: center; width: 100%;'>" . $capacitacion[1] . "</h3>";
