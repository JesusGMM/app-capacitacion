<?php
require_once 'componentes/nav.php';
$curso = new ControladorCurso(1);
$registro = $curso->crear($_POST);
if ($registro[0] == 1) { ?>

    <script type="text/javascript">
        Swal.fire({
            position: 'top-center',
            icon: 'success',
            title: '<?php echo $registro[1]; ?>',
            confirmButtonColor: "#0d6efd",
            showConfirmButton: false,
        })
        setTimeout(function(){location.href='../curso/?crear-preguntas-capacitacion-id=<?php echo $registro[2] ?>'},1500);
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
<h2 style="text-align: center;">Registrar capacitación</h2>
    <form class="row g-3" method="POST" enctype="multipart/form-data">
        <div class="col-md-6">
            <label for="inputAddress" class="form-label">Titulo de la capacitación</label>
            <input type="text" class="form-control" name="titulo" id="inputAddress" placeholder="Titulo" value="<?php if(isset($_POST['titulo'])) echo $_POST['titulo']; ?>" required/>
        </div>
        <div class="col-md-6">
            <label for="inputcodigo" class="form-label">Codigo de la capacitación</label>
            <input type="text" name="codigo" class="form-control" id="inputcodigo" placeholder="Codigo" value="<?php if(isset($_POST['codigo'])) echo $_POST['codigo']; ?>" required/>
        </div>
        <div class="col-md-6" style="margin-top:2%">
            <label for="inputState" class="form-label">Estado</label>
            <select name="estado" id="inputState" class="form-select">
                <option value="2" selected>En borrador</option>
            </select>
        </div>
        <div class="col-md-6" style="margin-top:2%">
            <label for="inputAddress3" class="form-label">Cantidad de preguntas</label>
            <input type="number" class="form-control" name="cantidad" id="inputAddress3" min="1" placeholder="Numero de preguntas" value="<?php if(isset($_POST['cantidad'])) echo $_POST['cantidad']; ?>" required/>
        </div>
        <div class="col-md-6" style="margin-top:2%">
            <label for="url" class="form-label">Url del video <b >Ayuda: </b> <a href="https://localhost/app_capacitacion/curso/" target="_blank" style="margin-bottom:2%"> Como copiar una URL</a> </label>
            <div class="form-floating">
                <textarea name="url" style="height: 150px" class="form-control" id="Textarea" ><?php if(isset($_POST['url'])) echo $_POST['url']; ?></textarea>
                <label for="Textarea">Video instructivo de la capacitación</label>
            </div>
        </div>
        <div class="col-md-6" style="margin-top:2%">
            <label for="inputAddress2" class="form-label">Descripcion de la capacitación</label>
            <div class="form-floating">
                <textarea name="descripcion" style="height: 150px" class="form-control" id="floatingTextarea" ><?php if(isset($_POST['descripcion'])) echo $_POST['descripcion']; ?></textarea>
                <label for="floatingTextarea">Descripción</label>
            </div>
        </div>

        <div class="col-md-6" style="margin-top:2%">
            <label for="inputAddress9" class="form-label">Duración de la prueba</label>
            <input type="number" class="form-control" name="tiempo" id="inputAddress9" min="0" placeholder="Tiempo en minutos" value="<?php if(isset($_POST['tiempo'])) echo $_POST['tiempo']; else echo 0; ?>" required/>
        </div>
        <div class="col-md-6" style="margin-top:2%">
            <label for="file" class="form-label">Seleccionar imagen</label>
            <input type="file" class="form-control" name="imagen" id="file" onchange="subirImagen(event)" required/>
        </div>


        <div class="col-md-6" style="margin-top:2%" id="file-preview-zone">
        </div>
        <div class="col-md-8" style="margin-top:2%">
            <button type="submit" class="btn btn-primary">Guardar capacitación</button>
        </div>
        
    </form>       
</div>

