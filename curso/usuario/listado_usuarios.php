<?php
if (isset($_POST['buscar'])) {
    require_once "../../controlador/usuario.controlador.php";
    $buscar = $_POST['buscar'];
    $pagina = $_POST['pagina'];
    $var = 2;
} else {
    $var = 1;
    $buscar = ""; 
    $pagina = 1; ?>
      <script type="text/javascript">
        window.onload = function() {
            document.getElementById("busqueda").value = "";
        };
    </script>
<?php

}

$fin = 12;
$empieza = ($pagina - 1) * $fin;

$user = new ControladorUsuario($var);
$usuarios = $user->listar($buscar, $empieza, $fin, $var);
$totalusuarios = $user->contarUsuario($buscar, $var);

if (!is_object($usuarios[0])) {
    echo "<h3 class='text-center'>" . $usuarios[1] . "</h3>";
} else { ?>
    <div class="table-responsive text-center">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Codigo</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Capacitaciónes</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody >
                <?php
                foreach ($usuarios as $usuario) { ?>

                    <tr>
                        <th scope="row"><?php echo $usuario->getCodigo(); ?></th>
                        <td><?php echo $usuario->getNombre(); ?></td>
                        <td><?php echo $usuario->getApellido(); ?></td>
                        <td>Inscritas <?php echo $usuario->getCapacitaciones(); ?> realizadas <?php echo $usuario->getCap_realizadas(); ?></td>
                        <td>
                            <form method="get" action="../curso/">

                                <input type="Hidden" name="id" value="<?php echo $usuario->getid(); ?>" />

                                <button type="submit" class="btn btn-success btn-sm">
                                    <img src="../componentes/img/iconos/Iconos-ver.svg" />
                                </button>

                                <button type="button" class="btn btn-primary btn-sm" onclick="vermodal('asignar',<?php echo $usuario->getid(); ?>)">
                                    <img src="../componentes/img/iconos/asignar-capacitacion.svg" />
                                </button>
                                <button type="button" class="btn btn-success btn-sm" onclick="vermodal('informacion',<?php echo $usuario->getid(); ?>)">
                                    <img src="../componentes/img/iconos/ver-info.svg" />
                                </button>
                                <button type="button" class="btn btn-primary btn-sm" onclick="vermodal('editar',<?php echo $usuario->getid(); ?>)">
                                    <img src="../componentes/img/iconos/editar.svg" />
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="vermodal('Eliminar',<?php echo $usuario->getid(); ?>)">
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
    if ($totalusuarios != 0) {
        $total_paginas = ceil($totalusuarios / $fin);
        if ($total_paginas > 1) { ?>
            <div style="float: right;">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item <?php if (1 == $pagina) echo "disabled"; ?>">
                            <a class="page-link" type="button" onclick="buscarUsuario(<?php echo $pagina - 1; ?>)">&laquo;</a>
                        </li>
                        <?php
                        if ($total_paginas > 5)
                            echo ' <div class="pagination overflow-auto" style="width: 10.6rem;">';
                        for ($i = 1; $i <= $total_paginas; $i++) {
                            if ($i == $pagina)
                                echo '<li class="page-item active"><a class="page-link" id="pagina' . $i . '" href="#">' . $i . '</a></li>';
                            else
                                echo '<li class="page-item" style="cursor:pointer;"><a class="page-link" id="pagina' . $i . '" onclick="buscarUsuario(' . $i . ')">' . $i . '</a></li>';
                        }
                        if ($total_paginas > 5)
                            echo '</div>'; ?>
                        <li class="page-item <?php if ($total_paginas == $pagina) echo "disabled"; ?>">
                            <a class="page-link" type="button" onclick="buscarUsuario(<?php echo $pagina + 1; ?>)">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
<?php
        }
    }
} ?>