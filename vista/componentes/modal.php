<?php
if (isset($_POST['accion'])) {
    if ($_POST['accion'] == 'asignar') {
        $titulo = "Asignar capacitación";
        $botones = "<button type='button' class='btn btn-primary'>Asignar</button>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>";
    } else if ($_POST['accion'] == 'Eliminar') {
        $titulo = "Eliminar usuario";
        $botones = "<button type='button' class='btn btn-danger'>Eliminar</button>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>";
    } else if ($_POST['accion'] == 'informacion') {
        $titulo = "Informacion del usuario";
        $botones = "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>";
    } else if ($_POST['accion'] == 'editar') {
        $titulo = "Editar usuario";
        $botones = "<button type='button' class='btn btn-primary'>Guardar cambios</button>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>";
    }
?>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"><?php echo $titulo; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    if ($_POST['accion'] == 'editar') {
                        require_once '../usuario/editar.php';
                    } else if ($_POST['accion'] == 'Eliminar') {
                    } else if ($_POST['accion'] == 'informacion') {
                    } else if ($_POST['accion'] == 'asignar') {
                    }?>
                </div>
                <div class="modal-footer">
                    <?php echo $botones; ?>

                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#staticBackdrop').modal('toggle')
        });
    </script>

<?php  }
