<?php
if ((isset($_GET['video'])) && (!empty(trim($_GET['video'])))) {
    $user = new ControladorUsuario(1);
    $cap_asignada = $user->validarCurso($_SESSION['id_app_cap'], $_GET['video'], 1);
    if ($cap_asignada[0] == 1) {
        $curso = new ControladorCurso(1);
        $cap = $curso->listarCapacitacion("Administrador general", "",$_GET['video'],"", "", "", 1);
        foreach ($cap as $capacitacion) { ?>
            <div class="container" style="padding-top: 2%;">
                <h3>Fase 2</h3>
                <h1 style="text-align: center; margin-top: 1rem;  margin-bottom: 2rem;"><?php echo $capacitacion->getNombre(); ?></h1>
                <div id="contenedor-video" style="text-align:center;">
                    <?php echo $capacitacion->getUrl(); ?>
                </div>
                <div style="text-align:center; margin-top: 1rem;">
                    <button type="button" class="btn btn-primary" onclick="realizarFase3(<?php echo $capacitacion->getId(); ?>)">Ir a la fase 3</button>
                </div>

                <h5 style="padding-top: 2%;"><b>Nota: </b> Observe todo el video para un mejor resultado</h5>

                <div id="id_respuesta">
                </div>
            </div>
        <?php }
    } else {
        ?>
        <script type="text/javascript">
            Swal.fire({
                position: 'top-center',
                icon: 'error',
                title: 'No cuenta con este curso en su listado',
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
            title: 'La capacitacion no existe',
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
