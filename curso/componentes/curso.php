<div class="col">
    <div class="card">
        <div class="card-header" style="text-align: center;">
            <span>
                <b>
                    <?php
                    if ($usuario[0]->getRol() == 'Administrador general')
                        echo "Codigo: " . $cap->getCodigo();
                    else
                        echo $cap->getNombre(); ?>
                </b>
            </span>
            <?php if ($usuario[0]->getRol() == 'Administrador general') {  ?>
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
                echo '<img style="height: 150px;" src="../componentes/imagenes/' . $cap->getImagen() . '" class="card-img-top" alt="Capacitación sin imagen">';

            ?>

            <h5 class="card-title" style="text-align: center; margin-top: 1rem;">
                <?php if ($usuario[0]->getRol() == 'Administrador general') echo $cap->getNombre(); ?>
            </h5>
            <p class="card-text" style="height:170px; overflow:auto;">
                <?php echo $cap->getDescripcion(); ?>
                <br>
                <b>Numero de preguntas: </b><?php echo $cap->getCan_pregutas(); ?>
                <br>
                <b> Tiempo limite: </b><?php echo $cap->getTiempo(); ?> Min
                <br>
            </p>
            <div class="card-footer" style="text-align: center;">
                <?php
                if ($usuario[0]->getRol() == 'Administrador general') {
                    if ($cap->getEstado() == 1) {
                        echo "<button type='button' class='btn btn-success' style='margin-bottom:2%;margin-left:2%;' onclick='realizar(" . '"' . $cap->getId() . '"' . ")'>Realizar</button>";
                        echo "<button type='button' class='btn btn-danger' style='margin-bottom:2%;margin-left:2%;'  onclick='despublicar(" . '"' . $cap->getCodigo() . '"' . ")'>Des publicar</button>";
                    } else
                        echo "<button type='button' class='btn btn-primary' style='margin-bottom:2%;margin-left:2%;' onclick='cursos(" . '"' . $cap->getCodigo() . '"' . "," . '"publicar"' . ")'>Publicar</button>";
                    echo "<a href='../curso/?editar-capacitacion-id=" . $cap->getId() . "' class='btn btn-primary' style='margin-bottom:2%; margin-left:2%;'>Editar capacitacion</a>";
                    echo "<a href='../curso/?editar-preguntas-capacitacion-id=" . $cap->getId() . "' class='btn btn-primary' style='margin-bottom:2%; margin-left:2%;'>Editar preguntas</a>";
                } else {
                    $cap_asignada = $user->validarCurso($_SESSION['id_app_cap'], $cap->getId(), 1);
                    if ($cap_asignada[0] == 1 && $cap_asignada[2] != 2)
                        echo "<button type='button' class='btn btn-success' style='margin-bottom:2%;margin-left:2%;' onclick='realizar(" . '"' . $cap->getId() . '"' . ")'>Realizar</button>";
                    else
                        echo '<a href="../curso/?ver-resulatados=' . $cap->getId() . '" class="btn btn-success" style="margin-top:2%">Revisar</a>';
                } ?>
            </div>
        </div>
    </div>
</div>