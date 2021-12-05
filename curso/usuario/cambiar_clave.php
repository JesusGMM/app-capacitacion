<?php
foreach ($usu as $usuario) { ?>
    <div class="container text-center" style="width: 80%;">
        <form method="post" id="form-editar-clave" class="row g-3">
            <input type="hidden" name="id" value="<?php echo $usuario->getId(); ?>" />
            <div class="col-md-12">
                <label for="nombre" class="form-label">Contraseña</label>
                <input name="clave" id="clave1" type="password" class="form-control" onkeyup="validarClave()" placeholder="Contraseña actual" required>
            </div>
            <div class="col-md-12">
                <label for="apellido" class="form-label">Nueva Contraseña</label>
                <input name="clave-nueva1" id="clave2" type="password" class="form-control" onkeyup="validarClave()" placeholder="Contraseña nueva" required>
            </div>
            <div class="col-md-12">
                <label for="inputEmail4" class="form-label">Repita la contraseña</label>
                <input type="password" id="clave3" name="clave-nueva2" class="form-control" onkeyup="validarClave()" placeholder="Contraseña nueva" required>
            </div>
            <div id="aler">

            </div>
            
            
    </div>

    </form>
<?php  }
