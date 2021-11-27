<?php
require_once 'componentes/nav.php';
?>
<div class="container padin">
    <h3 style="text-align: center; margin-bottom: 2%;">Informe de capacitaciónes</h3>
        <div class="input-group mb-3">
        <span class="input-group-text" id="buscar">Buscar</span>
        <input id="busqueda-cursos-informe" type="text" class="form-control" aria-describedby="buscar" onkeyup="buscarCursoInformes(1)" />
    </div>
    <div class="row row-cols-1 row-cols-md-3 g-4" id="informe-cursos">
        <?php
        require_once 'componentes/curso_informe.php';
        ?>
    </div>
    <div id="id_modal">
    </div>
</div>