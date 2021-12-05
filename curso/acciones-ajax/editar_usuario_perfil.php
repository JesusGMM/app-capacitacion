<?php
if (isset($_POST['id'])) {
    require_once "../../controlador/usuario.controlador.php";
    $user = new ControladorUsuario(2);
    $registro = $user->editarPerfil($_POST);
    if ($registro[0] == 1) { ?>
        <script type="text/javascript">
            Swal.fire({
                position: 'top-center',
                icon: 'success',
                title: '<?php echo $registro[1]; ?>',
                confirmButtonColor: "#0d6efd",
                showConfirmButton: false,
            })
           setTimeout(function() {location.href = ''}, 1500);
        </script>
    <?php
    } else if ($registro[0] != 1) { ?>

        <script type="text/javascript">
            Swal.fire({
                position: 'top-center',
                icon: 'error',
                title: ' <?php echo $registro[1]; ?>',
                customClass: {
                    popup: 'border-boton'
                },
                confirmButtonColor: "#f27474",
                showConfirmButton: true,
            })
        </script>
<?php

    }
}
