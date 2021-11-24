<?php
if (isset($_POST['accion'])) {
    if ($_POST['accion'] == 'asignar') {
        $titulo = "Asignar capacitación";
        $botones = "<button type='button' class='btn btn-primary' onclick='asignar()'>Asignar</button>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                    <script>
                    function asignar() {
                        $.ajax({
                            url: 'acciones-ajax/asignar_capacitaciones.php',
                            type: 'post',
                            data: $('#form-asignar').serialize(),
                            success: function(id_respuesta) {
                                $('#id_respuesta').html(id_respuesta)
                            }
                        });          
                    }
                    </script>";
    } else if ($_POST['accion'] == 'Eliminar') {
        $titulo = "Eliminar usuario";
        $botones = "<button type='button' class='btn btn-danger' onclick='eliminar()'>Eliminar</button>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                    <script>
                    function eliminar() {
                        var datos = { id: ".$_POST['id_usuario']." }
                        $.ajax({
                            url: 'acciones-ajax/eliminar_usuario.php',
                            type: 'post',
                            data: datos,
                            success: function(id_respuesta) {
                                $('#id_respuesta').html(id_respuesta)
                            }
                        });          
                    }
                    </script>";
    } else if ($_POST['accion'] == 'informacion') {
        $titulo = "Informacion del usuario";
        $botones = "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>";
    } else if ($_POST['accion'] == 'editar') {
        $titulo = "Editar usuario";
        $botones = "<button type='button' class='btn btn-primary' onclick='editar()'>Guardar cambios</button>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                    <script>
                    function editar() {
                        $.ajax({
                            url: 'acciones-ajax/editar_usuario.php',
                            type: 'post',
                            data: $('#form-editar').serialize(),
                            success: function(id_respuesta) {
                                $('#id_respuesta').html(id_respuesta)
                            }
                        });          
                    }
                    </script>";
    }
    require_once "../../controlador/usuario.controlador.php";
    $user = new ControladorUsuario(2);
    $usu = $user->buscarUsuarios($_POST['id_usuario'], 2);
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
