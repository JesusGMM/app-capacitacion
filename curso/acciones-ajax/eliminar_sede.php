<?php
if (isset($_POST['idsede'])) {
    require_once "../../controlador/sedecontrolador.php";
    $sedecontrol = new SedeControlador(2);
    $registro = $sedecontrol->eliminarSede($_POST['idsede'],2);
    if ($registro[0] == 1) { ?>

        <script type="text/javascript">
            Swal.fire({
                position: 'top-center',
                icon: 'success',
                title: '<?php echo $registro[1]; ?>',
                confirmButtonColor: "#0d6efd",
                showConfirmButton: false,
            })
           setTimeout(function() {location.href = '../curso/?lista-sede'}, 1500);
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