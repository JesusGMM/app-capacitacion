<?php
if (isset($_POST['idempresa'])) {
    require_once "../../controlador/empresacontrolador.php";
    $empre = new EmpresaControlador(2);
    $registro = $empre->eliminar($_POST['idempresa']);
    if ($registro[0] == 1) { ?>

        <script type="text/javascript">
            Swal.fire({
                position: 'top-center',
                icon: 'success',
                title: '<?php echo $registro[1]; ?>',
                confirmButtonColor: "#0d6efd",
                showConfirmButton: false,
            })
           setTimeout(function() {location.href = '../curso/?lista-empresa'}, 1500);
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