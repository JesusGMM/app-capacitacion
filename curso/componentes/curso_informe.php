<?php
if (isset($_POST['buscar'])) {
    $buscar = $_POST['buscar'];
    $pagina = $_POST['pagina'];
    $rol = $_POST['rol'];
    $var = 2;
    require_once "../../controlador/curso.controlador.php";
} else {
    $buscar = "";
    $pagina = 1;
    $var = 1;
    $rol = $usuario[0]->getRol();
}
$fin = 9;
$empieza = ($pagina - 1) * $fin;
$curso = new ControladorCurso($var);
$capacitacion = $curso->listarCapacitacion($rol, "", $buscar, 1, $empieza, $fin, $var);
$totalcursos = $curso->contarCursos($buscar, $rol, "", 1, $var);
echo '<input type="hidden" id="rol" value="' . $rol . '"/>';
foreach ($capacitacion as $cap) {
    $inscritos = $curso->cantidadInscritos($cap->getId(), $var);
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

                Usuarios inscritos: <?php echo $inscritos; ?>

            </div>
            <div class="card-footer" style="text-align: center;">
                <button class="btn btn-success" style="margin-top:2%" onclick="vermodal('detalles',<?php echo $cap->getId(); ?>)" >Detalles</button>
            </div>
        </div>
    </div>
    <?php

}
if ($totalcursos != 0) {
    $total_paginas = ceil($totalcursos / $fin);
    if ($total_paginas > 1) { ?>
        <div class="col-md-12">
            <nav aria-label="Page navigation example" style="float: right;">
                <ul class="pagination">
                    <li class="page-item <?php if (1 == $pagina) echo "disabled"; ?>">
                        <a class="page-link" type="button" onclick="buscarCursoInformes(<?php echo $pagina - 1; ?>)">&laquo;</a>
                    </li>
                    <?php
                    if ($total_paginas > 5)
                        echo ' <div class="pagination overflow-auto" style="width: 10.6rem;">';
                    for ($i = 1; $i <= $total_paginas; $i++) {
                        if ($i == $pagina)
                            echo '<li class="page-item active"><a class="page-link" id="pagina' . $i . '" href="#">' . $i . '</a></li>';
                        else
                            echo '<li class="page-item" style="cursor:pointer;"><a class="page-link" id="pagina' . $i . '" onclick="buscarCursoInformes(' . $i . ')">' . $i . '</a></li>';
                    }
                    if ($total_paginas > 5)
                        echo '</div>'; ?>
                    <li class="page-item <?php if ($total_paginas == $pagina) echo "disabled"; ?>">
                        <a class="page-link" type="button" onclick="buscarCursoInformes(<?php echo $pagina + 1; ?>)">&raquo;</a>
                    </li>
                </ul>
            </nav>
        </div>
<?php
    }
}
