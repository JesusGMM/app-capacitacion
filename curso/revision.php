<?php
require_once 'componentes/nav.php';
if ((isset($_GET['ver-resulatados'])) && (!empty(trim($_GET['ver-resulatados'])))) {
    $user = new ControladorUsuario(1);
    $cap_asignada = $user->validarCurso($_GET['idUsu'], $_GET['ver-resulatados'], 1);
    if ($cap_asignada[0] == 1) {
        if ($cap_asignada[2] == 2) {
            $pregunta_contro = new ControladorPregunta(1);
            $preguntas = $pregunta_contro->buscarPregunta($_GET['ver-resulatados'], "", "",1); ?>
            <div class="container padin">
                <h2 style="text-align: center;">Resultados Fase 1</h2>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php
                    $resultado = $user->listarRespuesta($_GET['idUsu'], $_GET['ver-resulatados'], 1);
                    if (intval($resultado[0]) != 3) {
                        foreach ($preguntas as $clave => $pregun) {
                            require 'componentes/preguntas_resueltas.php';
                        }
                    } else {
                        echo '<div class="col-md-12"> <h4 style="text-align: center; margin-top: 2%;">';
                        echo $resultado[1];
                        echo '</h4></div>';
                    }
                    ?>
                </div>

                <h2 style="text-align: center; margin-top: 2%;">Resultados Fase 3</h2>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php
                    $resultado = $user->listarRespuesta($_GET['idUsu'], $_GET['ver-resulatados'], 3);
                    if (intval($resultado[0]) != 3) {
                        foreach ($preguntas as $clave => $pregun) {
                            require 'componentes/preguntas_resueltas.php';
                        }
                    } else {
                        echo '<div class="col-md-12"> <h4 style="text-align: center; margin-top: 2%;">';
                        echo $resultado[1];
                        echo '</h4></div>';
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
                location.href = '../curso/'
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
            location.href = '../curso/'
        }, 2000);
    </script>
<?php
}
?>