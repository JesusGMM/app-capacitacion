<?php
require_once 'componentes/nav.php';
if (isset($_POST['buscar'])) {
    $buscar = $_POST['buscar'];
} else {
    $buscar = "";
    $empieza = 0;
    $fin = 9;
}
$curso = new ControladorCurso(1);
$capacitacion = new Curso;
$capacitacion = $curso->listarCapacitacion($buscar, $empieza, $fin);
?>
<div class="container" style="padding-top: 4rem">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php
        if (is_object($capacitacion[0])) {
            foreach ($capacitacion as $cap) { ?>
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <span>
                                <b>
                                    <?php
                                    if ($cap->getEstado() == 1)
                                        echo "Publicada";
                                    else
                                        echo "En borrador"; ?>
                                </b>
                            </span>
                            <?php if ($_SESSION['rol_app_cap'] == 1) {  ?>
                                <button type="button" class="btn btn-outline-danger" style="float: right; padding: 1%;" onclick="eliminar('<?php echo  $cap->getCodigo(); ?>')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="22" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                    </svg>
                                </button>
                            <?php } ?>
                        </div>
                        <div class="card-body">
                            <?php
                            if (!empty(trim($cap->getImagen())))
                                echo '<img style="height: 220px;" src="../componentes/imagenes/' . $cap->getImagen() . '" class="card-img-top" alt="Capacitación sin imagen">';
                            else
                                echo 'no hay imagen';
                            ?>

                            <h5 class="card-title" style="text-align: center; margin-top: 1rem;">
                                <?php echo $cap->getNombre(); ?>
                            </h5>
                            <p class="card-text">
                                <?php echo $cap->getDescripcion(); ?>
                            </p>

                            <div class="card-footer" style="text-align: center;">
                                <a href="#" class="btn btn-success" style="margin-bottom:2%;">Realizar</a>
                                <?php
                                if ($_SESSION['rol_app_cap'] == 1) {
                                    if ($cap->getEstado() == 1)
                                        echo "<button type='button' class='btn btn-danger' style='margin-bottom:2%;margin-left:2%;'  onclick='despublicar(" . '"' . $cap->getCodigo() . '"' . ")'>Des publicar</button>";
                                    else
                                        echo "<button type='button' class='btn btn-primary' style='margin-bottom:2%;margin-left:2%;' onclick='cursos(" . '"' . $cap->getCodigo() . '"' . "," . '"publicar"' . ")'>Publicar</button>";
                                    echo "<a href='../vista/?editar-capacitacion-id=".$cap->getId()."' class='btn btn-primary' style='margin-bottom:2%; margin-left:2%;'>Editar capacitacion</a>";
                                    echo "<a href='../vista/?editar-preguntas-capacitacion-id=".$cap->getId()."' class='btn btn-primary' style='margin-bottom:2%; margin-left:2%;'>Editar preguntas</a>"; ?>
                                    <script type="text/javascript">
                                        function despublicar(id) {
                                            Swal.fire({
                                                title: '¿Está seguro de mover a borrador?',
                                                text: "Tenga en cuenta que si el curso lo están realizando en estos momentos puede generar un error al estudiante que lo esté realizando",
                                                icon: 'question',
                                                showCancelButton: true,
                                                confirmButtonColor: '#d33',
                                                cancelButtonColor: '#3085d6',
                                                cancelButtonText: 'Cancelar',
                                                confirmButtonText: 'Despublicar'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    cursos(id, 'despublicar');
                                                }
                                            })
                                        }

                                        function eliminar(id) {
                                            Swal.fire({
                                                title: '¿Está seguro de eliminar la capacitacion?',
                                                text: "Esta operación no se puede deshacer",
                                                icon: 'question',
                                                showCancelButton: true,
                                                confirmButtonColor: '#d33',
                                                cancelButtonColor: '#3085d6',
                                                cancelButtonText: 'Cancelar',
                                                confirmButtonText: 'Eliminar'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    cursos(id, 'eliminar');
                                                }
                                            })
                                        }

                                        function cursos(id, acciones) {
                                            var datos = {
                                                codigo: id,
                                                accion: acciones
                                            }
                                            $.ajax({
                                                url: 'acciones-ajax/acciones_curso.php',
                                                type: 'post',
                                                data: datos,
                                                success: function(id_respuesta) {
                                                    $('#id_respuesta').html(id_respuesta)
                                                }
                                            });
                                        }
                                    </script>

                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        } ?>
        <div id="id_respuesta">
        </div>
    </div>

</div>