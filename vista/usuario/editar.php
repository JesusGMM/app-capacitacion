
<form class="row g-3">
    <div class="col-md-6">
        <label for="nombre" class="form-label">Nombre</label>
        <input name="nombre" type="text" class="form-control" value="<?php echo "Jesus"; ?>" placeholder="Nombres" required>
    </div>
    <div class="col-md-6">
        <label for="apellido" class="form-label">Apellido</label>
        <input name="apellido" type="text" class="form-control" value="<?php echo "Martinez"; ?>" placeholder="Apellidos" required>
    </div>
    <div class="col-md-6">
        <label for="inputEmail4" class="form-label">Email</label>
        <input type="email" class="form-control" value="<?php echo "admin@gmail.com"; ?>" placeholder="Correo electrónico" required>
    </div>
    <div class="col-md-6">
        <label for="perfil" class="form-label">Tipo de usuario</label>
        <select id="perfil" class="form-select" required>
            <option value="capacitando">A Capacitar</option>
            <option value="abmin" selected>Administrador</option>
        </select>
    </div>
    <div class="col-md-6">
        <label for="inputPassword4" class="form-label">Cambiar Password</label>
        <input type="password" class="form-control" id="inputPassword4" placeholder="Contraseña">
    </div>
    <div class="col-6">
        <label for="inputAddress" class="form-label">Nombre de usuario</label>
        <input type="text" class="form-control" value="<?php echo "J.martinez"; ?>" placeholder="Ejemplo n.usuario" required>
    </div>
    <div class="col-6">
        <label for="inputAddress2" class="form-label">Codigo del usuario</label>
        <input type="text" class="form-control" value="<?php echo "001-JM"; ?>" placeholder="Codigo" required>
    </div>
</form>