<?php
require_once 'componentes/nav.php';
if ((isset($_GET['ver-resulatados'])) && (!empty(trim($_GET['ver-resulatados'])))) {
    $user = new ControladorUsuario(1);
    $cap_asignada = $user->validarCurso($_SESSION['id_app_cap'], $_GET['ver-resulatados'], 1);
    if ($cap_asignada[0] == 1) {
        if ($cap_asignada[2] == 2) {
            $pregunta_contro = new ControladorPregunta(1);
            $preguntas = $pregunta_contro->buscarPregunta($_GET['ver-resulatados'], "", ""); ?>
            <div class="container" style="padding-top: 4rem; margin-bottom:2%">
                <h2 style="text-align: center;">Resultados Fase 1</h2>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php
                    $resultado = $user->listarRespuesta($_SESSION['id_app_cap'], $_GET['ver-resulatados'],1);
                    foreach ($preguntas as $clave => $pregun) {
                        require 'componentes/preguntas_resueltas.php';
                    } ?>
                </div>

                <h2 style="text-align: center; margin-top: 2%;">Resultados Fase 3</h2>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php
                    $resultado = $user->listarRespuesta($_SESSION['id_app_cap'], $_GET['ver-resulatados'],3);
                    foreach ($preguntas as $clave => $pregun) {
                        require 'componentes/preguntas_resueltas.php';
                    } ?>
                </div>
            </div>
        <?php } else {
        ?>
            <script type="text/javascript">
                Swal.fire({
                    position: 'top-center',
                    icon: 'error',
                    title: 'Este examen aun no lo ha resuelto',
                    customClass: {
                        popup: 'border-boton'
                    },
                    confirmButtonColor: "#f27474",
                    showConfirmButton: false,
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
                title: 'Este examen no se lo han asignado',
                customClass: {
                    popup: 'border-boton'
                },
                confirmButtonColor: "#f27474",
                showConfirmButton: false,
            })
            setTimeout(function() {
                location.href = '../vista/'
            }, 2000);
        </script>
    <?php
    }
} else {
    ?>
    <script type="text/javascript">
        Swal.fire({
            position: 'top-center',
            icon: 'error',
            title: 'Este examen no existe',
            customClass: {
                popup: 'border-boton'
            },
            confirmButtonColor: "#f27474",
            showConfirmButton: false,
        })
        setTimeout(function() {
            location.href = '../vista/'
        }, 2000);
    </script>
<?php
}
?>