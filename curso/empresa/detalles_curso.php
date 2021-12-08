<?php
require_once "../../controlador/curso.controlador.php";
require_once "../../controlador/usuario.controlador.php";
require_once "../../controlador/empresacontrolador.php";
require_once "../../controlador/sedecontrolador.php";
$controlusu = new ControladorUsuario(2);
$empre = new EmpresaControlador(2);
$porciones = explode("/", $_POST['id_empresa']);
$id_empresa = $porciones[1];
$id_capacitacion = $porciones[0];
$cantidadinscritos = $curso->cantidadInscritos($id_capacitacion, 2);
$cantidadsedesInscritas = $curso->contarCursosSedeInscrito($id_capacitacion, 2);
$empresas = $empre->buscarEmpresa($id_empresa, 2);
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
                                $idsedesInscritas = $curso->listarTodasCapacitacionSede($id_capacitacion, 2);
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
                                                if ($sede->getIdempresa() == $id_empresa) {
                                                    echo '<td class="col-md-4">' . $sede->getNombre() . '</td>';
                                                    echo '<td class="col-md-4">' . $sede->getNit() . '</td>';
                                                    if ($cantidadinscritos != 0) {
                                                        $idusuarioInscritas = $curso->listarTodasCapacitacionUsuario($id_capacitacion, 2);
                                                        if (is_array($idusuarioInscritas)) {

                                                            echo '<td class="col-md-4">';
                                                            foreach ($idusuarioInscritas as $idusuario) {
                                                                $usuarios = $controlusu->buscarUsuarios($idusuario, 2);
                                                                if (is_object($usuarios[0])) {
                                                                    foreach ($usuarios as $usuario) {

                                                                        if ($usuario->getIdempresa() == $id_empresa && $usuario->getIdsede() == $sede->getId()) {
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
                                        $idusuarioInscritas = $curso->listarTodasCapacitacionUsuario($id_capacitacion, 2);
                                        if (is_array($idusuarioInscritas)) {
                                            echo '</tr><tr></tr><td class="col-md-4"></td>';
                                            echo '<td class="col-md-4"></td>';
                                            echo '<td class="col-md-4">';
                                            foreach ($idusuarioInscritas as $idusuario) {
                                                $usuarios = $controlusu->buscarUsuarios($idusuario, 2);
                                                if (is_object($usuarios[0])) {
                                                    foreach ($usuarios as $usuario) {
                                                        if ($usuario->getIdempresa() == $id_empresa && $usuario->getIdsede() == 0)
                                                            echo  $usuario->getNombre() . ' ' . $usuario->getApellido() . '<br>';
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
} else {
    echo "<h4 class='text-center'>Sin información</h4>";
}
