<?php
foreach ($usu as $usuario) { ?>
    <form method="post" id="form-editar-perfil" class="row g-3 needs-validation-usuario" novalidate>
        <input type="hidden" name="id" value="<?php echo $usuario->getId(); ?>" />
        <div class="col-md-6">
            <label for="nombre" class="form-label">Nombre</label>
            <input name="nombre" type="text" class="form-control" value="<?php echo $usuario->getNombre(); ?>" placeholder="Nombres" required>
        </div>
        <div class="col-md-6">
            <label for="apellido" class="form-label">Apellido</label>
            <input name="apellido" type="text" class="form-control" value="<?php echo $usuario->getApellido(); ?>" placeholder="Apellidos" required>
        </div>
        <div class="col-md-12">
            <label for="inputEmail4" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $usuario->getEmail(); ?>" placeholder="Correo electrónico" required>
        </div>
        <div class="col-md-6">
            <label for="inputAddress" class="form-label">Nombre de usuario</label>
            <input name="usuario" type="text" class="form-control" value="<?php echo $usuario->getUsuario(); ?>" placeholder="Ejemplo n.usuario" required>
        </div>
        <div class="col-md-6">
            <label for="inputAddress2" class="form-label">Mi Codigo</label>
            <input name="codigo" type="text" class="form-control" value="<?php echo $usuario->getCodigo(); ?>" placeholder="Codigo" required>
        </div>
    </form>
<?php  }
