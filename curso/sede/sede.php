<?php
require_once 'componentes/nav.php';
?>
<div class="container padin">

    <h3 style="text-align:center; margin-bottom: 2%;">Listado de sedes</h3>
    <div class="input-group mb-3">
        <span class="input-group-text" id="buscar">Buscar</span>
        <input id="busqueda-sede" type="text" class="form-control" aria-describedby="buscar" onkeyup="buscarSede(1)" />
    </div>
    <div id="lista-sede">
        <?php
        require_once 'sede/listar_sede.php';
        ?>
    </div>

    <div id="id_modal">
    </div>
</div>