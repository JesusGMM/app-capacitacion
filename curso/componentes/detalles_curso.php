<?php
require_once "../../controlador/curso.controlador.php";
require_once "../../controlador/usuario.controlador.php";
require_once "../../controlador/empresacontrolador.php";
require_once "../../controlador/sedecontrolador.php";
$controlusu = new ControladorUsuario(2);
$cantidadinscritos = $curso->cantidadInscritos($_POST['id_usuario'], 2);
$cantidadempresaInscritas = $curso->contarCursosEmpresaInscrito($_POST['id_usuario'], 2);
$cantidadsedesInscritas = $curso->contarCursosSedeInscrito($_POST['id_usuario'], 2);
$independientes = false;
if ($cantidadempresaInscritas != 0) {
    $idempresasInscritas = $curso->listarTodasCapacitacionEmpresa($_POST['id_usuario'], 2);
    if (is_array($idempresasInscritas)) {

        $empre = new EmpresaControlador(2);
        foreach ($idempresasInscritas as $id) {
            $empresas = $empre->buscarEmpresa($id, 2);
            if (is_object($empresas[0])) { ?>
                <div class="card border-secondary mb-3" style="max-width: 100%;">
                    <div class="card-body text-secondary">
                        <h5 class="card-title text-center"> <b>Empresa </b> <?php echo $empresas[0]->getNombre(); ?></h5>

                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Sedes</th>
                                        <th scope="col">Nit</th>
                                        <th scope="col">Usuarios</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>

                                        <?php
                                        if ($cantidadsedesInscritas != 0) {
                                            $idsedesInscritas = $curso->listarTodasCapacitacionSede($_POST['id_usuario'], 2);
                                            if (is_array($idsedesInscritas)) {

                                                $controlsede = new SedeControlador(2);
                                                $cant = 0;
                                                foreach ($idsedesInscritas as $idSede) {
                                                    $sedes = $controlsede->buscarSede($idSede, 2);
                                                    if (is_object($sedes[0])) {
                                                        foreach ($sedes as $sede) {
                                                            if ($cant != 0) {
                                                                echo '</tr><tr>';
                                                            }
                                                            if ($sede->getIdempresa() == $id) {
                                                                echo '<td class="col-md-4">' . $sede->getNombre() . '</td>';
                                                                echo '<td class="col-md-4">' . $sede->getNit() . '</td>';
                                                                if ($cantidadinscritos != 0) {
                                                                    $idusuarioInscritas = $curso->listarTodasCapacitacionUsuario($_POST['id_usuario'], 2);
                                                                    if (is_array($idusuarioInscritas)) {

                                                                        echo '<td class="col-md-4">';
                                                                        foreach ($idusuarioInscritas as $idusuario) {
                                                                            $usuarios = $controlusu->buscarUsuarios($idusuario, 2);
                                                                            if (is_object($usuarios[0])) {
                                                                                foreach ($usuarios as $usuario) {

                                                                                    if ($usuario->getIdempresa() == $id && $usuario->getIdsede() == $sede->getId()) {
                                                                                        echo  $usuario->getNombre() . ' ' . $usuario->getApellido() . '<br>';
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                        echo '</td>';
                                                                    }
                                                                }
                                                            }
                                                            $cant++;
                                                        }
                                                    }
                                                }
                                                if ($cantidadinscritos != 0) {
                                                    $idusuarioInscritas = $curso->listarTodasCapacitacionUsuario($_POST['id_usuario'], 2);
                                                    if (is_array($idusuarioInscritas)) {

                                                        echo '</tr><tr></tr><td class="col-md-4"></td>';
                                                        echo '<td class="col-md-4"></td>';
                                                        echo '<td class="col-md-4">';
                                                        foreach ($idusuarioInscritas as $idusuario) {
                                                            $usuarios = $controlusu->buscarUsuarios($idusuario, 2);
                                                            if (is_object($usuarios[0])) {
                                                                foreach ($usuarios as $usuario) {
                                                                    if ($usuario->getIdempresa() == $id && $usuario->getIdsede() == 0) {
                                                                        echo  $usuario->getNombre() . ' ' . $usuario->getApellido() . '<br>';
                                                                    }
                                                                    if ($usuario->getIdempresa() == 0)
                                                                        $independientes = true;
                                                                }
                                                            }
                                                        }
                                                        echo '</td>';
                                                    }
                                                }
                                            }
                                        } ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php
            }
        }
    }
}

if ($cantidadinscritos != 0) {
    if ($independientes) {
        $idusuarioInscritas = $curso->listarTodasCapacitacionUsuario($_POST['id_usuario'], 2);
        if (is_array($idusuarioInscritas)) { ?>
            <div class="card border-secondary mb-3" style="max-width: 100%;">
                <div class="card-body text-secondary">
                    <h5 class="card-title text-center"> Usuarios independientes </h5>
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Correo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($idusuarioInscritas as $idusuario) {
                                    $usuarios = $controlusu->buscarUsuarios($idusuario, 2);
                                    if (is_object($usuarios[0])) {
                                        foreach ($usuarios as $usuario) {
                                            if ($usuario->getIdempresa() == 0) { ?>
                                                <tr>
                                                    <td class="col-md-4"><?php echo $usuario->getNombre() . " " . $usuario->getApellido(); ?></td>
                                                    <td class="col-md-4"><?php echo $usuario->getCodigo(); ?></td>
                                                    <td class="col-md-4"><?php echo $usuario->getEmail(); ?></td>
                                                </tr>
                                <?php
                                            }
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
<?php
        }
    }
} else {
    echo "<h4 class='text-center'>Sin información</h4>";
}
