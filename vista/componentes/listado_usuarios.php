<?php
if (isset($_POST['buscar'])) {
    $buscar = $_POST['buscar'];
} else {
    $buscar = "";
    $empieza = 0;
    $fin = 10;
}
$user = new ControladorUsuario(1);
$usuarios = new Persona;
$usuarios = $user->listar($buscar, $empieza, $fin);
// var_dump($usuarios);
if (empty($usuarios)) {
    echo "<h3>No hay usuarios registrados</h3>";
} else { ?>
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
        <tbody>
            <?php
            foreach ($usuarios as $usuario) { ?>

                <tr>
                    <th scope="row"><?php echo $usuario->getCodigo(); ?></th>
                    <td><?php echo $usuario->getNombre(); ?></td>
                    <td><?php echo $usuario->getApellido(); ?></td>
                    <td>Inscritas <?php echo $usuario->getCapacitaiones(); ?> realizadas <?php echo $usuario->getCap_realizadas(); ?></td>
                    <td>
                        <form method="get" action="../vista/">

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
<?php

}
