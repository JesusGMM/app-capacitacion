<?php
require_once "../../controlador/empresacontrolador.php";
if (isset($_POST['asignar'])) {

    $empre = new EmpresaControlador(2);
    $asignada = $empre->asignar($_POST, 2);

    if ($asignada[0] == 1) {
?>

        <script type="text/javascript">
            Swal.fire({
                position: 'top-center',
                icon: 'success',
                title: '<?php echo $asignada[1]; ?>',
                confirmButtonColor: "#3fc3ee",
                showConfirmButton: false,
            })
            setTimeout(function() {
                location.href = '../curso/?lista-empresa'
            }, 1500);
        </script>
    <?php
    } else {
    ?>

        <script type="text/javascript">
            Swal.fire({
                position: 'top-center',
                icon: 'error',
                title: '<?php echo $asignada[1]; ?>',
                confirmButtonColor: "#f27474",
                showConfirmButton: true,
            })
        </script>
        <?php
    }
} else if (isset($_POST['accion'])) {
    if ($_POST['accion'] == 'quitar_capacitacion') {
        $empre = new EmpresaControlador(2);
        $asignada = $empre->quitarCapacitacion($_POST, 2);
        if ($asignada[0] == 1) {
        ?>

            <script type="text/javascript">
                Swal.fire({
                    position: 'top-center',
                    icon: 'success',
                    title: '<?php echo $asignada[1]; ?>',
                    confirmButtonColor: "#3fc3ee",
                    showConfirmButton: false,
                })
                setTimeout(function() {
                    location.reload()
                }, 1500);
            </script>
        <?php
        } else {
        ?>

            <script type="text/javascript">
                Swal.fire({
                    position: 'top-center',
                    icon: 'error',
                    title: '<?php echo $asignada[1]; ?>',
                    confirmButtonColor: "#f27474",
                    showConfirmButton: true,
                })
            </script>
    <?php
        }
    }
} else { ?>
    <script type="text/javascript">
        Swal.fire({
            position: 'top-center',
            icon: 'info',
            title: 'No ha seleccionado capacitaciones',
            confirmButtonColor: "#3fc3ee",
            showConfirmButton: true,
        })
    </script>
<?php
}
