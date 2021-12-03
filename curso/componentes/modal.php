<?php
if (isset($_POST['accion'])) {
    if ($_POST['accion'] == 'asignar') {
        $titulo = "Asignar capacitación";
        $botones = "<button type='button' class='btn btn-primary' onclick='asignar()'>Asignar</button>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>";
    } else if ($_POST['accion'] == 'Eliminar') {
        $titulo = "Eliminar usuario";
        $botones = "<button type='button' class='btn btn-danger' onclick='eliminarUsuario(" . $_POST['id_usuario'] . ")'>Eliminar</button>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>";
    } else if ($_POST['accion'] == 'informacion') {
        $titulo = "Informacion del usuario";
        $botones = "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>";
    } else if ($_POST['accion'] == 'editar') {
        $titulo = "Editar usuario";
        $botones = "<button type='button' class='btn btn-primary' onclick='editar()'>Guardar cambios</button>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>";
    } else if ($_POST['accion'] == 'detalles') {
        $titulo = "Informacion de la capacitación";
        $botones = "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>";
    }

    if ($_POST['accion'] == 'detalles') {
        require_once "../../controlador/curso.controlador.php";
        $curso = new ControladorCurso(2);
    } else {
        require_once "../../controlador/usuario.controlador.php";
        $user = new ControladorUsuario(2);
        $usu = $user->buscarUsuarios($_POST['id_usuario'], 2);
    }
?>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"><?php echo $titulo; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    if ($_POST['accion'] == 'editar') {
                        require_once '../usuario/editar.php';
                    } else if ($_POST['accion'] == 'Eliminar') {
                        foreach ($usu as $usuario) { ?>
                            <div class="container">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <td class="col-md-4"><b>Nombre:</b></td>
                                            <td class="col-md-8"> <?php echo $usuario->getNombre(); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-4"><b>Apallido:</b></td>
                                            <td class="col-md-8"> <?php echo $usuario->getApellido(); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-4"><b>Codigo:</b></td>
                                            <td class="col-md-8"> <?php echo $usuario->getCodigo(); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-4"><b>Correo electronicao:</b></td>
                                            <td class="col-md-8"> <?php echo $usuario->getEmail(); ?></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                    <?php   }
                    } else if ($_POST['accion'] == 'informacion') {
                        require_once '../usuario/informacion.php';
                    } else if ($_POST['accion'] == 'asignar') {
                        require_once '../usuario/asignacion.php';
                    } else if ($_POST['accion'] == 'detalles') {
                        require_once 'detalles_curso.php';
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
            $('#staticBackdrop').modal('toggle')
        });
    </script>
<?php  }
