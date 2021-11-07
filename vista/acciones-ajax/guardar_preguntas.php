<?php
if (isset($_POST['pregunta_actual'])) {
    require_once "../../controlador/pregunta.controlador.php";
    require_once "../../controlador/curso.controlador.php";
    $pregunta_contro = new ControladorPregunta(2);
    $curso_contro = new ControladorCurso(2);

    $mensaje = "";
    $dir = "../vista/";
    if ($_POST['accion'] == 1) {
        $actualizar = $pregunta_contro->actualizarPregunta($_POST, 2);
        $mensaje = "Preguntas registradas";
    } else if ($_POST['accion'] == 2) {
        $actualizar = $pregunta_contro->actualizarPregunta($_POST, 2);
        $mensaje = "Preguntas registradas y capacitacion movida a borrador";
        $curso = $curso_contro->actualizarEstado($_POST, 2);
    } else if ($_POST['accion'] == 3) {
        $actualizar = $pregunta_contro->actualizarPregunta($_POST, 2);
        $mensaje = "Preguntas registradas y capacitacion publicada";
        $curso = $curso_contro->actualizarEstado($_POST, 1);
    } else if ($_POST['accion'] == 4) {
        $actualizar = $pregunta_contro->eliminarPregunta($_POST, 2);
        $curso = $curso_contro->actualizarCantidadPregunta($_POST, 2);
        $mensaje = $actualizar[1];
        if ($curso[2] != 0)
            $dir = "";
    }

?>
    <script type="text/javascript">
        Swal.fire({
            position: 'top-center',
            icon: 'success',
            title: '<?php echo $mensaje; ?>',
            confirmButtonColor: "#0d6efd",
            showConfirmButton: false,
        })
        setTimeout(function() {
            location.href = '<?php echo $dir; ?>'
        }, 1500);
    </script>
<?php
}
