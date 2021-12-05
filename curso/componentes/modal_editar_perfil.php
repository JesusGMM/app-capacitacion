<?php
if (isset($_POST['accion'])) {
    if ($_POST['accion'] == 'cambiar') {
        $titulo = "Cambiar contraseña";
        $botones = "<button type='button' class='btn btn-primary' id='btn-cambiar-clave' onclick='cambiarClave()' disabled>Cambiar</button>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>";
    } else if ($_POST['accion'] == 'datos') {
        $titulo = "Mis datos";
        $botones = "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>";
    } else if ($_POST['accion'] == 'editar') {
        $titulo = "Cambiar mis datos";
        $botones = "<button type='button' class='btn btn-primary' onclick='editarPerfil()'>Guardar cambios</button>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>";
    }
    session_start();
    require_once "../../controlador/usuario.controlador.php";
    $user = new ControladorUsuario(2);
    $usu = $user->buscarUsuarios($_SESSION['id_app_cap'], 2);
    

?>
    <div class="modal fade" id="mis-datos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="mis-datosLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mis-datosLabel"><?php echo $titulo; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    if ($_POST['accion'] == 'editar') {
                        require_once '../usuario/editar_perfil.php';
                    } else if ($_POST['accion'] == 'datos') {
                        require_once '../usuario/informacion.php';
                    } else if ($_POST['accion'] == 'cambiar') {
                        require_once '../usuario/cambiar_clave.php';
                    } ?>
                </div>
                <div class="modal-footer">
                    <?php echo $botones; ?>
                </div>
            </div>
        </div>
        <div id="id_respuesta">
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#mis-datos').modal('toggle')
        });
    </script>
<?php  }
