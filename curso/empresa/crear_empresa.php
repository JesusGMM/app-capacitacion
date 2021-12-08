<?php
require_once 'componentes/nav.php';
require_once "../controlador/empresacontrolador.php";
$empresa = new EmpresaControlador(1);
$registro = $empresa->crear($_POST);
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
            location.href = '../curso/?lista-empresa'
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
} ?>

<div class="container padin">
    <h2 style="text-align: center;">Registrar Empresa</h2>
    <form method="post" class="row g-3 needs-validation-empresa" enctype="multipart/form-data" novalidate>
        <div class="col-md-6">
            <label for="validationCustom01" class="form-label">Nombre</label>
            <div class="input-group has-validation">
                <input type="text" class="form-control" id="validationCustom01" name="nombre" value="<?php if (isset($_POST['nombre'])) echo $_POST['nombre']; ?>" required/>
                <div class="invalid-feedback">
                    Nombre de la empresa es requerido
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label for="validationCustom02" class="form-label">NIT</label>
            <div class="input-group has-validation">
                <input type="text" class="form-control" id="validationCustom02" name="nit" value="<?php if (isset($_POST['nit'])) echo $_POST['nit']; ?>" required/>
                <div class="invalid-feedback">
                    NIT requerido
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label for="validationCustomUsername" class="form-label">Correo Electronico</label>
            <div class="input-group has-validation">
                <span class="input-group-text" id="inputGroupPrepend">@</span>
                <input type="email" class="form-control" id="validationCustomUsername" name="email" aria-describedby="inputGroupPrepend"  value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" required/>
                <div class="invalid-feedback">
                    El correo es requerido
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label for="validationCustom03" class="form-label">Ciudad</label>
            <input type="text" class="form-control" name="ciudad" id="validationCustom03" value="<?php if (isset($_POST['ciudad'])) echo $_POST['ciudad']; ?>" />
        </div>
        <div class="col-md-6">
            <label for="validationCustom04" class="form-label">Dirrecion</label>
            <input type="text" class="form-control" name="dirrecion" id="validationCustom04" value="<?php if (isset($_POST['dirrecion'])) echo $_POST['dirrecion']; ?>" />
        </div>
        <div class="col-md-6">
            <label for="validationCustom05" class="form-label">Telefono</label>
            <input type="text" class="form-control" name="telefono" id="validationCustom05" value="<?php if (isset($_POST['telefono'])) echo $_POST['telefono']; ?>" />
        </div>
        <div class="col-md-6">
            <label for="flexSwitchCheckChecked" class="form-label">Estado Activo o inactivo</label>
            <div class="form-check form-switch">
                <input class="form-check-input check-estado" name="estado" type="checkbox" id="flexSwitchCheckChecked" checked />
            </div>
        </div>
        <div class="col-md-6" style="margin-top:2%">
            <label for="file" class="form-label">Logo</label>
            <input type="file" class="form-control" name="imagen" id="file" onchange="subirImagen(event)" />
        </div>

        <div class="col-md-6" style="margin-top:2%" id="file-preview-zone">
        </div>

        <div class="col-12">
            <button class="btn btn-primary" type="submit">Guardar Empresa</button>
        </div>
    </form>
</div>