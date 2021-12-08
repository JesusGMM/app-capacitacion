<?php
require_once "../../controlador/curso.controlador.php";
require_once "../../controlador/usuario.controlador.php";
require_once "../../controlador/sedecontrolador.php";
$controlusu = new ControladorUsuario(2);
$controlsede = new SedeControlador(2);
$porciones = explode("/", $_POST['id_sede']);
$id_sede = $porciones[1];
$id_capacitacion = $porciones[0];
$sedes = $controlsede->buscarSede($id_sede, 2);
if (is_object($sedes[0])) {
    $idusuarioInscritas = $curso->listarTodasCapacitacionUsuario($id_capacitacion, 2);
    if (is_array($idusuarioInscritas)) { ?>
        <div class="card border-secondary mb-3" style="max-width: 100%;">
            <div class="card-body text-secondary">
                <h5 class="card-title text-center"><?php echo $sedes[0]->getNombre(); ?></h5>

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
                                        if ($usuario->getIdsede() == $sedes[0]->getId()) { ?>
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
} else {
    echo "<h4 class='text-center'>Sin información</h4>";
}
