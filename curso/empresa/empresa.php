<?php
require_once 'componentes/nav.php';
?>
<div class="container padin">

    <h3 style="text-align:center; margin-bottom: 2%;">Listado de empresas</h3>
    <div class="input-group mb-3">
        <span class="input-group-text" id="buscar">Buscar</span>
        <input id="busqueda-empresa" type="text" class="form-control" aria-describedby="buscar" onkeyup="buscarEmpresa(1)" />
    </div>
    <div id="lista-empresa">
        <?php
        require_once 'empresa/listar_empresa.php';
        ?>
    </div>

    <div id="id_modal">
    </div>
</div>