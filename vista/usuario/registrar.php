<?php
require_once 'vista/componentes/nav.php';
?>
<div class="container" style="padding-top: 4rem;">

    <h3 style="text-align:center; margin-bottom: 2%;">Registrar Usuario</h3>
    <form class="row g-3">
        <div class="col-md-6">
            <label for="nombre" class="form-label">Nombre</label>
            <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Nombres" required>
        </div>
        <div class="col-md-6">
            <label for="apellido" class="form-label">Apellido</label>
            <input name="apellido" type="text" class="form-control" id="apellido" placeholder="Apellidos" required>
        </div>
        <div class="col-md-6">
            <label for="inputEmail4" class="form-label">Email</label>
            <input type="email" class="form-control" id="inputEmail4" placeholder="Correo electrónico" required>
        </div>
        <div class="col-md-6">
            <label for="perfil" class="form-label">Tipo de usuario</label>
            <select id="perfil" class="form-select" required>
                <option value="capacitando" selected>A Capacitar</option>
                <option value="abmin">Administrador</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="inputPassword4" class="form-label">Password</label>
            <input type="password" class="form-control" id="inputPassword4" placeholder="Contraseña" required>
        </div>
        <div class="col-6">
            <label for="inputAddress" class="form-label">Nombre de usuario</label>
            <input type="text" class="form-control" id="inputAddress" placeholder="Ejemplo n.usuario" required>
        </div>
        <div class="col-6">
            <label for="inputAddress2" class="form-label">Codigo del usuario</label>
            <input type="text" class="form-control" id="inputAddress2" placeholder="Codigo" required>
        </div>
        
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Registrar</button>
        </div>
    </form>
</div>