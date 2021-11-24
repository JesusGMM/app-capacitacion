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
            $cap = $curso->listarCapacitacion($_GET['realizar-capacitacion'], "", "", 1);

            foreach ($cap as $capacitacion) {
?>
                <!-- <div class="container" style="padding-top: 2%; display: flex; ">
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
                        foreach ($preguntas as $clave => $pregun) {
                            require 'componentes/preguntas.php';
                        }
                        ?>
                    </div>
                </form>
                <div class="container">
                    <div class="row">
                        <div class="col-md-8" style="margin-top: 2%">
                            <?php
                            if ($_GET['fase'] == 1)
                                echo '<button type="button" class="btn btn-primary" onclick="realizar()">Enviar y continuar a la fase 2</button>';
                            else if ($_GET['fase'] == 3)
                                echo '<button type="button" class="btn btn-primary" onclick="realizar()">Enviar y finalizar</button>'; ?>
                        </div>

                        <!-- <div class="col-md-4" style="display:flex; margin-top:2%;">
                        <nav>
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" type="button" onclick="">&laquo; Anterior</a>
                                </li>

                                <li class="page-item " aria-current="page">
                                    <select class="page-link" id="id_pag" onchange="paginar($(this).val())">
                                        <?php
                                        //  for ($i = 1; $i <= 15; $i++) {

                                        //    if ($i == 5) {
                                        //    echo "<option value='" . $i . "' selected>" . $i . "</option>";
                                        //     } else {
                                        //    echo "<option value='" . $i . "'>" . $i . "</option>";
                                        //    }
                                        //  }
                                        ?>

                                    </select>
                                </li>

                                <li class="page-item">
                                    <a class="page-link" type="button" onclick="">Siguiente &raquo;</a>
                                </li>
                            </ul>
                        </nav>
                    </div> -->
                    </div>
                </div>
                <script type="text/javascript">
                    function realizar() {
                        Swal.fire({
                            title: 'NOTA',
                            icon: 'info',
                            text: "Antes de enviar verificar que esten respondidas todas preguntas",
                            showCancelButton: true,
                            confirmButtonColor: '#0d6efd',
                            cancelButtonColor: '#6c757d',
                            cancelButtonText: 'Volver',
                            confirmButtonText: 'Enviar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: 'acciones-ajax/respuesta.php',
                                    type: 'post',
                                    data: $("#form_respuesta").serialize(),
                                    beforeSend: function() {
                                        $('#id_respuesta').html(id_respuesta).html('<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
                                    },
                                    success: function(id_respuesta) {
                                        $('#id_respuesta').html(id_respuesta)
                                    }
                                });
                            }
                        })
                    }
                </script>
                <div id="id_respuesta">
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
                            location.href = '../vista/'
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
                title: 'No cuenta con este curso en su listado',
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
            title: 'La capacitacion no existe',
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
