<?php
if (isset($_POST['buscar'])) {
    require_once "../../controlador/sedecontrolador.php";
    $buscar = $_POST['buscar'];
    $pagina = $_POST['pagina'];
    $var = 2;
} else {
    require_once "../controlador/sedecontrolador.php";
    $var = 1;
    $buscar = "";
    $pagina = 1; ?>
    <script type="text/javascript">
        window.onload = function() {
            document.getElementById("busqueda-sede").value = "";
        };
    </script>
<?php

}

$fin = 12;
$empieza = ($pagina - 1) * $fin;

$sedecontrol = new SedeControlador($var);

$sedes = $sedecontrol->listar($buscar, $empieza, $fin, $var);
$totalsedes = $sedecontrol->contarSede($buscar, $var);

if (!is_object($sedes[0])) {
    echo "<h3 class='text-center'>" . $sedes[1] . "</h3>";
} else { ?>
    <div class="table-responsive">
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th scope="col">Nit</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Ciudad</th>
                    <th scope="col">Telefono</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($sedes as $sede) { ?>

                    <tr>
                        <th scope="row"><?php echo $sede->getNit(); ?></th>
                        <td><?php echo $sede->getNombre(); ?></td>
                        <td><?php echo $sede->getCiudad(); ?></td>
                        <td><?php echo $sede->getTelefono(); ?></td>
                        <td>
                            <form method="get" action="../curso/">

                                <input type="Hidden" name="sede-id-cursos" value="<?php echo $sede->getid(); ?>" />

                                <button type="submit" class="btn btn-success btn-sm">
                                    <img src="../componentes/img/iconos/Iconos-ver.svg" />
                                </button>

                                <button type="button" class="btn btn-primary btn-sm" onclick="vermodalsede('asignar',<?php echo $sede->getid(); ?>)">
                                    <img src="../componentes/img/iconos/asignar-capacitacion.svg" />
                                </button>
                                <button type="button" class="btn btn-success btn-sm" onclick="vermodalsede('informacion',<?php echo $sede->getid(); ?>)">
                                    <img src="../componentes/img/iconos/ver-info.svg" />
                                </button>
                                <button type="button" class="btn btn-primary btn-sm" onclick="vermodalsede('editar',<?php echo $sede->getid(); ?>)">
                                    <img src="../componentes/img/iconos/editar.svg" />
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="vermodalsede('Eliminar',<?php echo $sede->getid(); ?>)">
                                    <img src="../componentes/img/iconos/delete.svg" />
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php
                } ?>
            </tbody>
        </table>
    </div>
    <?php
    if ($totalsedes != 0) {
        $total_paginas = ceil($totalsedes / $fin);
        if ($total_paginas > 1) { ?>
            <div style="float: right;">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item <?php if (1 == $pagina) echo "disabled"; ?>">
                            <a class="page-link" type="button" onclick="buscarSede(<?php echo $pagina - 1; ?>)">&laquo;</a>
                        </li>
                        <?php
                        if ($total_paginas > 5)
                            echo ' <div class="pagination overflow-auto" style="width: 10.6rem;">';
                        for ($i = 1; $i <= $total_paginas; $i++) {
                            if ($i == $pagina)
                                echo '<li class="page-item active"><a class="page-link" id="pagina' . $i . '" href="#">' . $i . '</a></li>';
                            else
                                echo '<li class="page-item" style="cursor:pointer;"><a class="page-link" id="pagina' . $i . '" onclick="buscarSede(' . $i . ')">' . $i . '</a></li>';
                        }
                        if ($total_paginas > 5)
                            echo '</div>'; ?>
                        <li class="page-item <?php if ($total_paginas == $pagina) echo "disabled"; ?>">
                            <a class="page-link" type="button" onclick="buscarSede(<?php echo $pagina + 1; ?>)">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
<?php
        }
    }
} ?>