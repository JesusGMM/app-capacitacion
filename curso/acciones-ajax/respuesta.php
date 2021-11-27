<?php
if (isset($_POST['fase']) && ($_POST['fase'] == '1' || $_POST['fase'] == '3')) {
    require_once "../../controlador/pregunta.controlador.php";
    require_once "../../controlador/usuario.controlador.php";
    $pregunta_contro = new ControladorPregunta(2);
    $user = new ControladorUsuario(2);
    $cap_asignada = $user->validarCurso($_POST['id_usuario'], $_POST['id_capacitacion'], 2);
    if ($cap_asignada[0] == 1 && $cap_asignada[2] != 2) {
        if (($cap_asignada[4] == 0 && $_POST['fase'] == '1') || ($cap_asignada[5] == 0 && $_POST['fase'] == '3'))
            $guardar = $user->guardarRespuesta($_POST, 2);
        else if (($cap_asignada[4] != 0 && $_POST['fase'] == '1') || ($cap_asignada[5] != 0 && $_POST['fase'] == '3'))
            $guardar = $user->actualizarRespuesta($_POST, 2);

        if ($guardar[0] == 1 && $_POST['fase'] == '1') {
?>
            <script type="text/javascript">
                Swal.fire({
                    position: 'top-center',
                    icon: 'success',
                    title: '<?php echo $guardar[1]; ?>',
                    confirmButtonColor: "#f27474",
                    showConfirmButton: false,
                })
                setTimeout(function() {
                    location.href = '../curso/?video=<?php echo $_POST['id_capacitacion']; ?>'
                }, 1500);
            </script>
        <?php
        } else if ($guardar[0] == 1 && $_POST['fase'] == '3') {
        ?>
            <script type="text/javascript">
                Swal.fire({
                    position: 'top-center',
                    icon: 'success',
                    title: 'Examen completado',
                    confirmButtonColor: "#f27474",
                    showConfirmButton: false,
                })
                setTimeout(function() {
                    location.href = '../curso/?id=<?php echo $_POST['id_usuario']; ?>'
                }, 1500);
            </script>
        <?php
        } else {
        ?>
            <script type="text/javascript">
                Swal.fire({
                    position: 'top-center',
                    icon: 'error',
                    title: '<?php echo $guardar[1]; ?>',
                    confirmButtonColor: "#f27474",
                    showConfirmButton: true,
                })
            </script>
        <?php
        }
    } else {
        ?>

        <script type="text/javascript">
            Swal.fire({
                position: 'top-center',
                icon: 'error',
                title: '<?php echo $cap_asignada[1]; ?>',
                confirmButtonColor: "#f27474",
                showConfirmButton: true,
            })
        </script>
<?php

    }
}
