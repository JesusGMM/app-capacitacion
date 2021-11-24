<?php
foreach ($usu as $usuario) { ?>
    <form method="post" action="" id="form-editar" class="row g-3">
        <input type="hidden" name="id" value="<?php echo $usuario->getId(); ?>" />
        <div class="col-md-6">
            <label for="nombre" class="form-label">Nombre</label>
            <input name="nombre" type="text" class="form-control" value="<?php echo $usuario->getNombre(); ?>" placeholder="Nombres" required>
        </div>
        <div class="col-md-6">
            <label for="apellido" class="form-label">Apellido</label>
            <input name="apellido" type="text" class="form-control" value="<?php echo $usuario->getApellido(); ?>" placeholder="Apellidos" required>
        </div>
        <div class="col-md-6">
            <label for="inputEmail4" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $usuario->getEmail(); ?>" placeholder="Correo electrónico" required>
        </div>
        <div class="col-md-6">
            <label for="perfil" class="form-label">Tipo de usuario</label>
            <select name="perfil" id="perfil" class="form-select" required>
                <option value='1'>Administrador</option>
                <option value='2' <?php if ($usuario->getRol() == "Capacitante") echo "selected"; ?>>Estudiante</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Cambiar Contraseña</label>
            <input name="contrasena" type="password" class="form-control"  placeholder="Contraseña">
        </div>
        <div class="col-6">
            <label for="inputAddress" class="form-label">Nombre de usuario</label>
            <input name="usuario" type="text" class="form-control" value="<?php echo $usuario->getUsuario(); ?>" placeholder="Ejemplo n.usuario" required>
        </div>
        <div class="col-6">
            <label for="inputAddress2" class="form-label">Codigo del usuario</label>
            <input name="codigo" type="text" class="form-control" value="<?php echo $usuario->getCodigo(); ?>" placeholder="Codigo" required>
        </div>
    </form>
<?php  }
