<?php
require_once 'componentes/nav.php';
$curso = new ControladorCurso(1);
$user = new ControladorUsuario(1);
?>
<div class="container" style="padding-top: 4rem; margin-bottom: 2%;">
    <h3 style="text-align: center; margin-bottom: 2%;">Informe de capacitaciónes</h3>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php

        $capacitacion = new Curso;
        $capacitacion = $curso->listarCapacitacion(1, 1, 1, 1);
        foreach ($capacitacion as $cap) {
            $inscritos = $curso->cantidadInscritos($cap->getId());
        ?>
            <div class="col">
                <div class="card">
                    <div class="card-header" style="text-align: center;"><b><?php echo $cap->getNombre(); ?></b></div>
                    <?php
                    if (!empty(trim($cap->getImagen())))
                        echo '<img style="height: 220px; padding:1%;" src="../componentes/imagenes/' . $cap->getImagen() . '" class="card-img-top" alt="Capacitación sin imagen">';
                    else
                        echo 'no hay imagen';
                    ?>
                    <div class="card-body"> 
                        
                        Usuarios inscritos: <?php echo $inscritos; ?>

                    </div>
                    <!--  <div class="card-footer" style="text-align: center;">
                       <a href="" class="btn btn-success" style="margin-top:2%">Detalles</a> 
                    </div>-->
                </div>
            </div>
        <?php

        }
        ?>
    </div>
</div>