<?php
if (isset($_POST['buscar'])) {
    require_once "../../controlador/empresacontrolador.php";
    $buscar = $_POST['buscar'];
    $pagina = $_POST['pagina'];
    $var = 2;
} else {
    require_once "../controlador/empresacontrolador.php";
    $var = 1;
    $buscar = "";
    $pagina = 1; ?>
    <script type="text/javascript">
        window.onload = function() {
            document.getElementById("busqueda-empresa").value = "";
        };
    </script>
<?php

}

$fin = 12;
$empieza = ($pagina - 1) * $fin;

$empre = new EmpresaControlador($var);

$empresas = $empre->listar($buscar, $empieza, $fin, $var);
$totalempresas = $empre->contarEmpresa($buscar, $var);

if (!is_object($empresas[0])) {
    echo "<h3 class='text-center'>" . $empresas[1] . "</h3>";
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
                foreach ($empresas as $empresa) { ?>

                    <tr>
                        <th scope="row"><?php echo $empresa->getNit(); ?></th>
                        <td><?php echo $empresa->getNombre(); ?></td>
                        <td><?php echo $empresa->getCiudad(); ?></td>
                        <td><?php echo $empresa->getTelefono(); ?></td>
                        <td>
                            <form method="get" action="../curso/">

                                <input type="Hidden" name="empresa-id-cursos" value="<?php echo $empresa->getid(); ?>" />

                                <button type="submit" class="btn btn-success btn-sm">
                                    <img src="../componentes/img/iconos/Iconos-ver.svg" />
                                </button>

                                <button type="button" class="btn btn-primary btn-sm" onclick="vermodalempresa('asignar',<?php echo $empresa->getid(); ?>)">
                                    <img src="../componentes/img/iconos/asignar-capacitacion.svg" />
                                </button>
                                <button type="button" class="btn btn-success btn-sm" onclick="vermodalempresa('informacion',<?php echo $empresa->getid(); ?>)">
                                    <img src="../componentes/img/iconos/ver-info.svg" />
                                </button>
                                <button type="button" class="btn btn-primary btn-sm" onclick="vermodalempresa('editar',<?php echo $empresa->getid(); ?>)">
                                    <img src="../componentes/img/iconos/editar.svg" />
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="vermodalempresa('Eliminar',<?php echo $empresa->getid(); ?>)">
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
    if ($totalempresas != 0) {
        $total_paginas = ceil($totalempresas / $fin);
        if ($total_paginas > 1) { ?>
            <div style="float: right;">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item <?php if (1 == $pagina) echo "disabled"; ?>">
                            <a class="page-link" type="button" onclick="buscarEmpresa(<?php echo $pagina - 1; ?>)">&laquo;</a>
                        </li>
                        <?php
                        if ($total_paginas > 5)
                            echo ' <div class="pagination overflow-auto" style="width: 10.6rem;">';
                        for ($i = 1; $i <= $total_paginas; $i++) {
                            if ($i == $pagina)
                                echo '<li class="page-item active"><a class="page-link" id="pagina' . $i . '" href="#">' . $i . '</a></li>';
                            else
                                echo '<li class="page-item" style="cursor:pointer;"><a class="page-link" id="pagina' . $i . '" onclick="buscarEmpresa(' . $i . ')">' . $i . '</a></li>';
                        }
                        if ($total_paginas > 5)
                            echo '</div>'; ?>
                        <li class="page-item <?php if ($total_paginas == $pagina) echo "disabled"; ?>">
                            <a class="page-link" type="button" onclick="buscarEmpresa(<?php echo $pagina + 1; ?>)">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
<?php
        }
    }
} ?>