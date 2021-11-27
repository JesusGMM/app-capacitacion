<?php
if ((isset($_GET['realizar-capacitacion'])) && (!empty(trim($_GET['realizar-capacitacion'])))) {
    $user = new ControladorUsuario(1);
    $cap_asignada = $user->validarCurso($_SESSION['id_app_cap'], $_GET['realizar-capacitacion'], 1);
    if ($cap_asignada[0] == 1) {
        if ($cap_asignada[2] != 2) {
            if ($cap_asignada[2] == 0) {
                $inicio = $user->iniciarExamen($_SESSION['id_app_cap'], $_GET['realizar-capacitacion']);
                //  $duracion = $inicio[2];
            } else if ($cap_asignada[2] == 1) {
                $reinicio = $user->reiniciarExamen($_SESSION['id_app_cap'], $_GET['realizar-capacitacion']);
                //$duracion = $reinicio[2];
            }
            $curso = new ControladorCurso(1);
            $cap = $curso->listarCapacitacion("Administrador general", "", $_GET['realizar-capacitacion'], "", "", "", 1);

            foreach ($cap as $capacitacion) {
?>
                <div class="container" style="padding-top: 2%;">
                    <!--  <div class="container" style="padding-top: 2%; display: flex; ">
                     <div style="width: 20%;">
                    <h3 style="text-align: center;">Fase 1</h3>
                </div>
                <div style="display: flex; justify-content: right; width: 80%;">
                    <div class="temporizador" id="hora"> Hora <br> 00</div>
                    <div class="temporizador" id="minutos"> Min <br> 00</div>
                    <div class="temporizador" id="segundos"> Seg <br> 00</div>
                </div>
            </div> -->
                    <h3>Fase <?php echo $_GET['fase']; ?></h3>
                    <h1 style="text-align: center; margin-top: 1rem;  margin-bottom: 2rem;"><?php echo $capacitacion->getNombre(); ?></h1>
                    <form type="POST" enctype="multipart/formdata" id="form_respuesta">
                        <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['id_app_cap']; ?>" />
                        <input type="hidden" name="id_capacitacion" value="<?php echo $capacitacion->getId(); ?>" />
                        <input type="hidden" name="fase" value="<?php echo $_GET['fase']; ?>" />
                        <div class="row g-3">
                            <?php
                            $pregunta_contro = new ControladorPregunta(1);
                            $preguntas = $pregunta_contro->buscarPregunta($capacitacion->getId(), "", "");
                            if (is_object($preguntas[0])) {
                                foreach ($preguntas as $clave => $pregun) {
                                    require 'componentes/preguntas.php';
                                }
                            } else { ?>
                                <script type="text/javascript">
                                    Swal.fire({
                                        position: 'top-center',
                                        icon: 'error',
                                        title: 'Ya este examen no esta disponible',
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
                        </div>
                    </form>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8" style="margin-top: 2%">
                                <?php
                                if ($_GET['fase'] == 1)
                                    echo '<button type="button" class="btn btn-primary" onclick="finalizar()">Enviar y continuar a la fase 2</button>';
                                else if ($_GET['fase'] == 3)
                                    echo '<button type="button" class="btn btn-primary" onclick="finalizar()">Enviar y finalizar</button>'; ?>
                            </div>
                        </div>
                    </div>

                    <div id="id_respuesta">
                    </div>
                </div>
                <!-- 
            <script type="text/javascript">
                var f_coun = null;
                var interval = null;
                window.addEventListener("load", () => {
                    var _seconds = 0 * 1000;
                    var _minutes = <?php // echo $duracion; 
                                    ?> * 1000 * 60;
                    var _hora = 0 * 1000 * 60 * 24;
                    var miliseconds = _seconds + _minutes + _hora;
                    f_coun = new Date(new Date().getTime() + miliseconds);
                    interval = setInterval(fnCount, 1000);
                });

                var fnCount = () => {
                    var fecha_actual = new Date();
                    var milisegundos = f_coun - fecha_actual;
                    var segundos = Math.floor(milisegundos / 1000);

                    var seg = segundos % 60;
                    var minutos = Math.floor((segundos / 60) % 60);
                    var hora = Math.floor((segundos / (60 * 60)) % (60 * 60) % 24);

                    document.querySelector('#hora').innerHTML = ("Hora <br> " + ("0" + hora).slice(-2));
                    document.querySelector('#minutos').innerHTML = ("Min <br>" + ("0" + minutos).slice(-2));
                    document.querySelector('#segundos').innerHTML = ("Seg <br>" + ("0" + seg).slice(-2));

                    if (segundos < 1) {
                        clearInterval(interval);
                        Swal.fire({
                            position: 'top-center',
                            icon: 'success',
                            title: 'El tiempo ha finalizado',
                            customClass: {
                                popup: 'border-boton'
                            },
                            confirmButtonColor: "#f27474",
                            showConfirmButton: false,
                        })
                        setTimeout(function() {
                            location.href = '../curso/'
                        }, 2000);
                    }
                }
            </script> -->

            <?php
            }
        } else {
            ?>
            <script type="text/javascript">
                Swal.fire({
                    position: 'top-center',
                    icon: 'error',
                    title: 'Ya este examen no esta disponible',
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
