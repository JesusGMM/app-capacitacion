<?php
if (isset($_POST['accion'])) {
    require_once "../../controlador/curso.controlador.php";
    $curso_contro = new ControladorCurso(2);
    if ($_POST['accion'] == 'publicar') {
        $curso = $curso_contro->actualizarEstado($_POST, 1);
        $mensaje = "Capacitación publicada";
    } else if ($_POST['accion'] == 'despublicar') {
        $curso = $curso_contro->actualizarEstado($_POST, 2);
        $mensaje = "Capacitación en borrador";
    } else if ($_POST['accion'] == 'eliminar') {
        $curso = $curso_contro->eliminar($_POST);
        $mensaje = $curso[1];
    } ?>
    <script type="text/javascript">
        Swal.fire({
            position: 'top-center',
            icon: 'success',
            title: '<?php echo $mensaje; ?>',
            confirmButtonColor: "#0d6efd",
            showConfirmButton: false,
        })
        setTimeout(function() {
            location.href = ''
        }, 1500);
    </script>
<?php
}
