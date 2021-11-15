<?php
require_once '../componentes/heder.php';
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
        setTimeout(function(){location.href='../vista/?crear-preguntas-capacitacion-id=<?php echo $registro[2] ?>'},1500);
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
<div class="container" style="padding-top: 4rem; padding-bottom: 4rem;">
    <form class="row g-3" method="POST" action="" enctype="multipart/form-data">
        <div class="col-md-6">
            <label for="inputAddress" class="form-label">Titulo de la capacitación</label>
            <input type="text" class="form-control" name="titulo" id="inputAddress" placeholder="Titulo" value="<?php if(isset($_POST['titulo'])) echo $_POST['titulo']; ?>" required>
        </div>
        <div class="col-md-6">
            <label for="inputcodigo" class="form-label">Codigo de la capacitación</label>
            <input type="text" name="codigo" class="form-control" id="inputcodigo" placeholder="Codigo" value="<?php if(isset($_POST['codigo'])) echo $_POST['codigo']; ?>" required>
        </div>
        <div class="col-md-6" style="margin-top:2%">
            <label for="inputState" class="form-label">Estado</label>
            <select name="estado" id="inputState" class="form-select">
                <option value="2" selected>Guardar en borrador</option>
                <option value="1">Publicar capacitación</option>
            </select>
        </div>
        <div class="col-md-6" style="margin-top:2%">
            <label for="inputAddress3" class="form-label">Cantidad de preguntas</label>
            <input type="number" class="form-control" name="cantidad" id="inputAddress3" min="1" placeholder="Numero de preguntas" value="<?php if(isset($_POST['cantidad'])) echo $_POST['cantidad']; ?>" required>
        </div>
        <div class="col-md-6" style="margin-top:2%">
            <label for="url" class="form-label">Url del video <b >Ayuda: </b> <a href="https://localhost/app_capacitacion/vista/" target="_blank" style="margin-bottom:2%"> Como copiar una URL</a> </label>
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
            <input type="number" class="form-control" name="tiempo" id="inputAddress9" min="1" placeholder="Tiempo en minutos" value="<?php if(isset($_POST['tiempo'])) echo $_POST['tiempo']; ?>" required>
        </div>
        <div class="col-md-6" style="margin-top:2%">
            <label for="file" class="form-label">Seleccionar imagen</label>
            <input type="file" class="form-control" name="imagen" id="file" required>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                var fileUpload = document.getElementById('file');
                fileUpload.onchange = function(e) {
                    var name = document.getElementById("file").files[0].name;
                    var ext = name.split('.').pop().toLowerCase();
                    if (jQuery.inArray(ext, [
                            'gif', 'png',
                            'jpg', 'jpeg'
                        ]) == -1) {
                        Swal.fire({
                            position: 'top-center',
                            icon: 'warning',
                            title: 'Archivo de imagen no válido',
                            showConfirmButton: true,
                        })
                        document.getElementById("file").value = '';
                    } else {
                        var f = document.getElementById("file").files[0];
                        if (f.size > 4194304) {
                            Swal.fire({
                                position: 'top-center',
                                icon: 'warning',
                                title: 'El tamaño del archivo de imagen es muy grande',
                                showConfirmButton: true,
                            })
                            document.getElementById("file").value = '';
                        } else {
                            readFile(e.srcElement);
                        }
                    }
                }
            });

            function readFile(input) {
                
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        
                        var filePreview = document.createElement('img');
                        filePreview.id = 'file-preview';
                        filePreview.style.cssText = 'height:250px; width:100%';
                        //e.target.result contents the base64 data from the image uploaded
                        filePreview.src = e.target.result;
                        // console.log(e.target.result);
                        document.getElementById('file-preview-zone').innerHTML="";
                        var previewZone = document.getElementById('file-preview-zone');
                        previewZone.appendChild(filePreview);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>

        <div class="col-md-6" style="margin-top:2%" id="file-preview-zone">
        </div>
        <div class="col-md-8" style="margin-top:2%">
            <button type="submit" class="btn btn-primary">Guardar capacitación</button>
        </div>
        
    </form>       
</div>

<?php
require_once '../componentes/footer.php';
