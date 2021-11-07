<?php
require_once 'componentes/nav.php';
?>
<div class="container" style="padding-top: 4rem;">

    <h3 style="text-align:center; margin-bottom: 2%;">Listado de usuarios</h3>
    <div class="input-group mb-3">
        <span class="input-group-text" id="buscar">Buscar</span>
        <input type="text" class="form-control" aria-describedby="buscar">
    </div>
    <div id="lista-usuarios" class="table-responsive">
        <?php
        require_once 'usuario/listado_usuarios.php';
        ?>
    </div>
    <script>
        function vermodal(accion,id) {
            var form_data = new FormData();
            form_data.append("accion", accion);
            form_data.append("id_usuario", id);
            $.ajax({
                url: 'componentes/modal.php',
                method: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function(id_modal) {
                    $("#id_modal").html(id_modal)
                }
            });

        }
    </script>

    <div id="id_modal">
    </div>
</div>