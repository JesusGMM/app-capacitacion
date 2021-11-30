<?php
require_once 'componentes/nav.php';
if (((isset($_GET['crear-preguntas-capacitacion-id'])) && (!empty(trim($_GET['crear-preguntas-capacitacion-id'])))) || ((isset($_GET['editar-preguntas-capacitacion-id'])) && (!empty(trim($_GET['editar-preguntas-capacitacion-id']))))) {
    if (isset($_GET['crear-preguntas-capacitacion-id']))
        $id_capacitacion = $_GET['crear-preguntas-capacitacion-id'];
    else
        $id_capacitacion = $_GET['editar-preguntas-capacitacion-id'];

    $curso = new ControladorCurso(1);
    $pregunta_contro = new ControladorPregunta(1);
    $capacitacion = $curso->buscarCapacitacion($id_capacitacion);
    if (is_object($capacitacion[0])) {
        foreach ($capacitacion as $cap) {

            if (isset($_POST['atras'])) {
                $pregunta = $_POST['pregunta_actual'] - 1;
            } else if (isset($_POST['siguiente'])) {
                $pregunta = $_POST['pregunta_actual'] + 1;
            } else if (isset($_POST['pregunta'])) {
                $pregunta = $_POST['pregunta'];
            } else {
                $pregunta = 1;
            }

            $empieza = ($pregunta - 1);
            $preguntas = $pregunta_contro->buscarPregunta($id_capacitacion, $empieza, 1 ,1);

            if (isset($_POST['id_pregunta']))
                $actualizar = $pregunta_contro->actualizarPregunta($_POST, 1);
            else
                $actualizar[] = 0;

            if (is_object($preguntas[0]) && $actualizar[0] < 2) {
                foreach ($preguntas as $pregun) {

?>
                    <div class="container padin">
                        <div class="col-md-12">
                            <h2 style="text-align: center;"><?php echo $cap->getNombre(); ?></h2>
                        </div>
                        <form id="form-preguntas" method="POST" action="">
                            <div class="border row g-3" style="margin-top: 2%; padding-bottom: 2%;">
                                <div class="col-md-12">
                                    <input type="hidden" name="pregunta_actual" value="<?php echo $pregunta; ?>">
                                    <input type="hidden" name="id_pregunta" value="<?php echo $pregun->getId(); ?>">
                                    <h4 class="form-label">Pregunta numero <?php echo $pregunta; ?></h4>
                                    <input type="text" class="form-control" name="nombre_pregunta" id="1" value="<?php echo $pregun->getPregunta(); ?>" placeholder="Pregunta 1">
                                </div>
                                <div class="col-md-10">
                                    <label class="form-label">Respuesta A</label>
                                    <input type="text" class="form-control" name="respuesta1" value="<?php echo $pregun->getRespuesta1(); ?>" placeholder="Respuesta A">
                                </div>
                                <div class="col-md-10">
                                    <label class="form-label">Respuesta B</label>
                                    <input type="text" class="form-control" name="respuesta2" value="<?php echo $pregun->getRespuesta2(); ?>" placeholder="Respuesta B">
                                </div>
                                <div class="col-md-10">
                                    <label class="form-label">Respuesta C</label>
                                    <input type="text" class="form-control" name="respuesta3" value="<?php echo $pregun->getRespuesta3(); ?>" placeholder="Respuesta C">
                                </div>
                                <div class="col-md-10">
                                    <label class="form-label">Respuesta D</label>
                                    <input type="text" class="form-control" name="respuesta4" value="<?php echo $pregun->getRespuesta4() ?>" placeholder="Respuesta D">
                                </div>
                                <div class="col-md-4" style="margin-right:10%;">
                                    <label class="form-label">Respuesta Correcta</label>
                                    <select name="respuesta_correcta" class="form-select">

                                        <option value="A" <?php if ($pregun->getRespuesta_corecta() == 'A') echo "selected"; ?>>A</option>
                                        <option value="B" <?php if ($pregun->getRespuesta_corecta() == 'B') echo "selected"; ?>>B</option>
                                        <option value="C" <?php if ($pregun->getRespuesta_corecta() == 'C') echo "selected"; ?>>C</option>
                                        <option value="D" <?php if ($pregun->getRespuesta_corecta() == 'D') echo "selected"; ?>>D</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <nav>
                                        <ul class="pagination">
                                            <?php
                                            if ($pregunta < 2)
                                                echo '<li class="page-item disabled"> <span class="page-link">&laquo; Anterior</span></li>';
                                            else
                                                echo '<li class="page-item"><input type="Submit" class="page-link" name="atras" value="&laquo; Anterior"></li>';
                                            ?>
                                            <li class="page-item">
                                                <select name="pregunta" class="page-link" onchange="this.form.submit()">
                                                    <?php
                                                    for ($i = 1; $i <= $cap->getCan_pregutas(); $i++) {
                                                        if ($pregunta == $i)
                                                            echo '<option value="' . $i . '" selected>Pregunta ' . $i . '</option>';
                                                        else
                                                            echo '<option value="' . $i . '">Pregunta ' . $i . '</option>';
                                                    }


                                                    ?>
                                                </select>
                                            </li>
                                            <?php
                                            if ($pregunta >=  $cap->getCan_pregutas())
                                                echo '<li class="page-item disabled"> <span class="page-link">Siguiente &raquo;</span></li>';
                                            else
                                                echo '<li class="page-item"><input type="Submit" class="page-link" name="siguiente" value="Siguiente &raquo;"></li>';
                                            ?>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div id="id_respuesta">
                            </div>
                        </form>
                        <div class="container" style="padding-top: 2%;">
                            <button type="button" class="btn btn-primary" style="margin-bottom: 2%;" onclick='GuardarPregunta(1,"<?php echo $cap->getCodigo(); ?>")'>Guardar</button>
                            <?php
                            if ($cap->getEstado() == 1) { ?>
                                <button type="button" class="btn btn-primary" style="margin-bottom: 2%;" onclick='GuardarPregunta(2,"<?php echo $cap->getCodigo(); ?>")'>Guardar y Despublicar</button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-primary" style="margin-bottom: 2%;" onclick='GuardarPregunta(3,"<?php echo $cap->getCodigo(); ?>")'>Guardar y Publicar</button>
                            <?php } ?>

                            <button type="button" class="btn btn-danger" style="margin-bottom: 2%;" onclick='eliminarPregunta("<?php echo $cap->getCodigo(); ?>")'>Eliminar pregunta</button>
                            <a  style="margin-bottom: 2%;" href='../curso/' class="btn btn-secondary">Salir</a>
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <script type="text/javascript">
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: '<?php if (is_object($preguntas[0])) echo $actualizar[1]; else echo $preguntas[1]; ?>',
                        customClass: {
                            popup: 'border-boton'
                        },
                        confirmButtonColor: "#f27474",
                        showConfirmButton: true,
                    })
                    setTimeout(function() {
                        location.href = '../curso/'
                    }, 2000);
                </script>
        <?php

            }
        }
    } else {
        ?>
        <script type="text/javascript">
            Swal.fire({
                position: 'top-center',
                icon: 'error',
                title: ' <?php echo $capacitacion[1]; ?>',
                customClass: {
                    popup: 'border-boton'
                },
                confirmButtonColor: "#f27474",
                showConfirmButton: true,
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
            title: 'La capacitacion no existe o no tiene preguntas',
            customClass: {
                popup: 'border-boton'
            },
            confirmButtonColor: "#f27474",
            showConfirmButton: true,
        })
        setTimeout(function() {
            location.href = '../curso/'
        }, 2000);
    </script>
<?php
}
