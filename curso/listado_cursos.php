<?php
require_once 'componentes/nav.php';
?>
<div class="container padin">
    <div class="input-group mb-3">
        <span class="input-group-text" id="buscar">Buscar</span>
        <input id="busqueda-cursos-publicos" type="text" class="form-control" aria-describedby="buscar" style="z-index: auto;" onkeyup="buscarCursoPublicos(1)" />
    </div>
    <div id="lista-cursos">
        <?php require_once 'cursos.php'; ?>
    </div>
</div>