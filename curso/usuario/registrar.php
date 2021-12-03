<?php
require_once 'componentes/nav.php';
require_once "../controlador/empresacontrolador.php";
$user = new ControladorUsuario(1);
$empre = new EmpresaControlador(1);
$empresas = $empre->listarEmpresaTodas(1,1);
$registro = $user->crear($_POST);
if ($registro[0] == 1) { ?>
    <script type="text/javascript">
        Swal.fire({
            position: 'top-center',
            icon: 'success',
            title: '<?php echo $registro[1]; ?>',
            confirmButtonColor: "#0d6efd",
            showConfirmButton: false,
        })
        setTimeout(function() {
            location.href = '../curso/?lista-usuario'
        }, 1500);
    </script>
<?php
} else if ($registro[0] == 2) { ?>

    <script type="text/javascript">
        Swal.fire({
            position: 'top-center',
            icon: 'error',
            title: ' <?php echo $registro[1]; ?>',
            customClass: {
                popup: 'border-boton'
            },
            confirmButtonColor: "#f27474",
            showConfirmButton: true,
        })
    </script>
<?php

} else if ($registro[0] == 3) { ?>
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

}

?>
<div class="container padin">
    <h3 style="text-align:center; margin-bottom: 2%;">Registrar Usuario</h3>
    <form method="post" class="row g-3 needs-validation-usuario" id="form-crear-usuario" novalidate>
        <div class="col-md-6">
            <label for="empresa" class="form-label" style="margin-bottom: 2.5%;">Empresa</label>
            <select class="form-select" name="idempresa" id="empresa" onchange="listarSedesEmpresa($(this).val(),1)" required>
                <option></option>
                <?php
                foreach ($empresas as $empresa) {
                    echo '<option value="' . $empresa->getId() . '">' . $empresa->getNombre() . '</option>';
                } ?>
            </select>
            <div class="invalid-feedback">
                Debe seleccionar una empresa
            </div>
        </div>
        <div class="col-md-6" id="cargar-sedes">
            <label for="sede" class="form-label" style="margin-bottom: 2.5%;">Sede</label>
            <select class="form-select" name="idsede" id="sede">
                <option value="0">Sin sede</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="nombre" class="form-label">Nombre</label>
            <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Nombres" value="<?php if (isset($_POST['nombre'])) echo $_POST['nombre']; ?>" required>
            <div class="invalid-feedback">
                Nombre es requerido
            </div>
        </div>
        <div class="col-md-6">
            <label for="apellido" class="form-label">Apellido</label>
            <input name="apellido" type="text" class="form-control" id="apellido" placeholder="Apellidos" value="<?php if (isset($_POST['apellido'])) echo $_POST['apellido']; ?>" required>
            <div class="invalid-feedback">
                Apellido es requerido
            </div>
        </div>
        <div class="col-md-6">
            <label for="inputEmail4" class="form-label">Email</label>
            <input name="correo" type="email" class="form-control" id="inputEmail4" placeholder="Correo electrónico" value="<?php if (isset($_POST['correo'])) echo $_POST['correo']; ?>" required>
            <div class="invalid-feedback">
                Correo electronico es requerido
            </div>
        </div>
        <div class="col-md-6">
            <label for="perfil" class="form-label">Tipo de usuario</label>
            <select name="roles" id="perfil" class="form-select" required>
                <option value="2">Estudiante</option>
                <option value="1">Administrador</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="inputPassword4" class="form-label">Password</label>
            <input name="contrasena" type="password" class="form-control" id="inputPassword4" placeholder="Contraseña" required>
            <div class="invalid-feedback">
                Contraseña es requerida
            </div>
        </div>
        <div class="col-6">
            <label for="inputAddress" class="form-label">Nombre de usuario</label>
            <input name="usuario" type="text" class="form-control" id="inputAddress" placeholder="Ejemplo Pepito001" required>
            <div class="invalid-feedback">
                Nombre de usuario es requerido
            </div>
        </div>
        <div class="col-6">
            <label for="inputAddress2" class="form-label">Codigo o numero de identificación</label>
            <input name="codigo" type="text" class="form-control" id="inputAddress2" placeholder="Cedula" value="<?php if (isset($_POST['codigo'])) echo $_POST['codigo']; ?>" required>
            <div class="invalid-feedback">
                La identificación es requerida
            </div>
        </div>
        <div class="col-md-6">
            <label for="flexSwitchCheckChecked" class="form-label">Estado Activo o inactivo</label>
            <div class="form-check form-switch">
                <input class="form-check-input check-usuario" name="estado" type="checkbox" id="flexSwitchCheckChecked" checked />
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Registrar</button>
        </div>
    </form>
</div>