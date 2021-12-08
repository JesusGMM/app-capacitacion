<?php
if (isset($_POST['buscar'])) {
    session_start();
    $buscar = $_POST['buscar'];
    $pagina = $_POST['pagina'];
    $_GET['sede-id-cursos'] = $_POST['idsede'];
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
$capacitacion = $curso->listarCapacitacionSede($_GET['sede-id-cursos'], $buscar, $empieza, $fin, $var);

if (is_object($capacitacion[0])) {
    foreach ($capacitacion as $cap) {
        $inscritos = $curso->cantidadInscritosSede($cap->getId(), $_GET['sede-id-cursos'], $var);
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
                <b>Usuarios inscritos: </b><?php echo $inscritos; ?><br>
                </div>
                <div class="card-footer" style="text-align: center;">
                    <button  class="btn btn-success" style="margin-top: 2%;" onclick="vermodalsede('detalles','<?php echo $cap->getId() .'/'.$_GET['sede-id-cursos']; ?>')">Detalles</button>
                    <button type='button' class='btn btn-danger' style="margin-top: 2%;" onclick="quitarCursoSede(<?php echo $cap->getId() . ',' .  $_GET['sede-id-cursos'];  ?>)">Quitar capacitación</button>
                </div>
            </div>
        </div>
        <?php

    }

    $totalcursos = $curso->contarCursosSede($buscar, $_GET['sede-id-cursos'], $var);

    if ($totalcursos != 0) {
        $total_paginas = ceil($totalcursos / $fin);
        if ($total_paginas > 1) { ?>
            <div class="col-md-12">
                <nav aria-label="Page navigation example" style="float: right;">
                    <ul class="pagination">
                        <li class="page-item <?php if (1 == $pagina) echo "disabled"; ?>">
                            <a class="page-link" type="button" onclick="buscarCursoSede(<?php echo ($pagina - 1) . ',' . $_GET['sede-id-cursos']; ?>)">&laquo;</a>
                        </li>
                        <?php
                        if ($total_paginas > 5)
                            echo ' <div class="pagination overflow-auto" style="width: 10.6rem;">';
                        for ($i = 1; $i <= $total_paginas; $i++) {
                            if ($i == $pagina)
                                echo '<li class="page-item active"><a class="page-link" id="pagina' . $i . '" href="#">' . $i . '</a></li>';
                            else
                                echo '<li class="page-item" style="cursor:pointer;"><a class="page-link" id="pagina' . $i . '" onclick="buscarCursoSede(' . $i . ',' . $_GET['sede-id-cursos'] . ')">' . $i . '</a></li>';
                        }
                        if ($total_paginas > 5)
                            echo '</div>'; ?>
                        <li class="page-item <?php if ($total_paginas == $pagina) echo "disabled"; ?>">
                            <a class="page-link" type="button" onclick="buscarCursoSede(<?php echo ($pagina + 1) . ',' . $_GET['sede-id-cursos']; ?>)">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
<?php
        }
    }
} else echo "<h3 style='text-align: center; width: 100%;'>" . $capacitacion[1] . "</h3>";
