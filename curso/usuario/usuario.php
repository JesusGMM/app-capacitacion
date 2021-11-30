<?php
require_once 'componentes/nav.php';
?>
<div class="container padin">

    <h3 style="text-align:center; margin-bottom: 2%;">Listado de usuarios</h3>
    <div class="input-group mb-3">
        <span class="input-group-text" id="buscar">Buscar</span>
        <input id="busqueda" type="text" class="form-control" aria-describedby="buscar" style="z-index: auto;" onkeyup="buscarUsuario(1)" />
    </div>
    <div id="lista-usuarios">
        <?php
        require_once 'usuario/listado_usuarios.php';
        ?>
    </div>

    <div id="id_modal">
    </div>
</div>