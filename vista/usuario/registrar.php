<?php
require_once 'componentes/nav.php';
$user = new ControladorUsuario(1);
$registro = $user->crear($_POST);
if ($registro[0] == 1) { ?>

    <script type="text/javascript">
        Swal.fire({
            position: 'top-center',
            icon: 'success',
            title: 'Usuario registrado',
            confirmButtonColor: "#0d6efd",
            showConfirmButton: false,
        })
        setTimeout(function(){location.href='../vista/?lista-usuario'},1500);
    </script>
<?php
} else if($registro[0] == 2) { ?>

    <script type="text/javascript">
        Swal.fire({
            position: 'top-center',
            icon: 'error',
            title: ' <?php echo $registro[1]; ?>',
           customClass: {popup:'border-boton'},
            confirmButtonColor: "#f27474",
            showConfirmButton: true,
        })
    </script>
<?php

} else if ($registro[0] == 3)  { ?>

    <script type="text/javascript">
        Swal.fire({
            position: 'top-center',
            icon: 'info',
            title: '<?php echo $registro[1]; ?>',
            confirmButtonColor: "#3fc3ee",
            showConfirmButton: true,
        })
    </script>
<?php

} ?>
<div class="container" style="padding-top: 4rem;">
    <h3 style="text-align:center; margin-bottom: 2%;">Registrar Usuario</h3>
    <form method="post" action="" class="row g-3">
        <div class="col-md-6">
            <label for="nombre" class="form-label">Nombre</label>
            <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Nombres" value="<?php if(isset($_POST['nombre'])) echo $_POST['nombre']; ?>" required>
        </div>
        <div class="col-md-6">
            <label for="apellido" class="form-label">Apellido</label>
            <input name="apellido" type="text" class="form-control" id="apellido" placeholder="Apellidos" value="<?php if(isset($_POST['apellido'])) echo $_POST['apellido']; ?>" required>
        </div>
        <div class="col-md-6">
            <label for="inputEmail4" class="form-label">Email</label>
            <input name="correo" type="email" class="form-control" id="inputEmail4" placeholder="Correo electrónico" value="<?php if(isset($_POST['correo'])) echo $_POST['correo']; ?>" required>
        </div>
        <div class="col-md-6">
            <label for="perfil" class="form-label">Tipo de usuario</label>
            <select name="roles" id="perfil" class="form-select" required>
                <option value="2" >Estudiante</option>
                <option value="1">Administrador</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="inputPassword4" class="form-label">Password</label>
            <input name="contrasena" type="password" class="form-control" id="inputPassword4" placeholder="Contraseña" required>
        </div>
        <div class="col-6">
            <label for="inputAddress" class="form-label">Nombre de usuario</label>
            <input name="usuario" type="text" class="form-control" id="inputAddress" placeholder="Ejemplo Pepito001" required>
        </div>
        <div class="col-6">
            <label for="inputAddress2" class="form-label">Codigo del usuario</label>
            <input name="codigo" type="text" class="form-control" id="inputAddress2" placeholder="Codigo" value="<?php if(isset($_POST['codigo'])) echo $_POST['codigo']; ?>" required>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Registrar</button>
        </div>
    </form>
</div>