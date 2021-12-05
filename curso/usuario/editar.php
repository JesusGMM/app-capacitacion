<?php
require_once "../../controlador/empresacontrolador.php";
$empre = new EmpresaControlador(2);
$empresas = $empre->listarEmpresaTodas(1,2);
require_once "../../controlador/sedecontrolador.php";
$sedecontrol = new SedeControlador(2);
$sedes = $sedecontrol->listarSedes($usu[0]->getIdempresa(), 1, 2);
foreach ($usu as $usuario) { ?>
    <form method="post" id="form-editar" class="row g-3 needs-validation-usuario" novalidate>
        <input type="hidden" name="id" value="<?php echo $usuario->getId(); ?>" />
        <div class="col-md-6" id="cargar-empresas" <?php if ($usuario->getRol() == "Administrador general") echo "style='display: none;'"; ?>>
            <label for="empresa" class="form-label" style="margin-bottom: 2.5%;">Empresa</label>
            <select class="form-select" name="idempresa" id="empresa-editar" onchange="listarSedesEmpresa($(this).val(),2)" required>
                <?php
                if (is_object($empresas[0])) {
                    foreach ($empresas as $empresa) {
                        if ($empresa->getId() == $usuario->getIdempresa())
                            echo '<option value="' . $empresa->getId() . '" selected>' . $empresa->getNombre() . '</option>';
                        else
                            echo '<option value="' . $empresa->getId() . '">' . $empresa->getNombre() . '</option>';
                    }
                } ?>
            </select>
        </div>
        <div class="col-md-6" id="cargar-sedes" <?php if ($usuario->getRol() == "Administrador general") echo "style='display: none;'"; ?>>
            <label for="sede" class="form-label" style="margin-bottom: 2.5%;">Sede</label>
            <select class="form-select" name="idsede" id="sede-editar">
                <option value="0">Sin sede</option>
                <?php
                if (is_object($sedes[0])) {
                    foreach ($sedes as $sede) {
                        if ($sede->getId() == $usuario->getIdsede())
                            echo '<option value="' . $sede->getId() . '" selected>' . $sede->getNombre() . '</option>';
                        else
                            echo '<option value="' . $sede->getId() . '">' . $sede->getNombre() . '</option>';
                    }
                } ?>
            </select>
        </div>
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
            <select name="perfil" id="perfil" class="form-select" onchange="validarPerfil($(this).val())" required>
                <option value='1'>Administrador</option>
                <option value='2' <?php if ($usuario->getRol() == "Estudiante") echo "selected"; ?>>Estudiante</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Cambiar Contraseña</label>
            <input name="contrasena" type="password" class="form-control" placeholder="Contraseña">
        </div>
        <div class="col-6">
            <label for="inputAddress" class="form-label">Nombre de usuario</label>
            <input name="usuario" type="text" class="form-control" value="<?php echo $usuario->getUsuario(); ?>" placeholder="Ejemplo n.usuario" required>
        </div>
        <div class="col-6">
            <label for="inputAddress2" class="form-label">Codigo del usuario</label>
            <input name="codigo" type="text" class="form-control" value="<?php echo $usuario->getCodigo(); ?>" placeholder="Codigo" required>
        </div>
        <div class="col-md-6">
            <label for="flexSwitchCheckChecked" class="form-label">Estado Activo o inactivo</label>
            <div class="form-check form-switch">
                <input class="form-check-input check-usuario" name="estado" type="checkbox" id="flexSwitchCheckChecked" checked />
            </div>
        </div>
    </form>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#sede-editar').select2({
                dropdownParent: $('#staticBackdrop .modal-content'),
                theme: "classic",
                width: "100%"
            });
            $('#empresa-editar').select2({
                dropdownParent: $('#staticBackdrop .modal-content'),
                width: "100%",
                theme: "classic",
            });
        });
    </script>
<?php  }
