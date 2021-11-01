<?php
require_once '../componentes/heder.php';
require_once 'componentes/nav.php';
?>
<div class="container" style="padding-top: 4rem;">
    <form class="row g-3" type="POST" id="crear" enctype="multipart/formdata">
        <div class="col-md-6">
            <label for="inputAddress" class="form-label">Titulo de la capacitación</label>
            <input type="text" class="form-control" name="titulo" id="inputAddress" placeholder="Titulo" required>
        </div>
        <div class="col-md-6">
            <label for="inputcodigo" class="form-label">Codigo de la capacitación</label>
            <input type="text" name="codigo" class="form-control" id="inputcodigo" placeholder="Codigo" required>
        </div>
        <div class="col-md-6" style="margin-top:2%">
            <label for="inputState" class="form-label">Estado</label>
            <select name="estado" id="inputState" class="form-select">
                <option value="borrador" selected>Guardar borrador</option>
                <option value="publicar">Publicar capacitación</option>
            </select>
        </div>
        <div class="col-md-6" style="margin-top:2%">
            <label for="inputAddress3" class="form-label">Cantidad de preguntas</label>
            <input type="number" class="form-control" name="cantidad" id="inputAddress3" min="1" placeholder="Numero" required>
        </div>
        <div class="col-md-6" style="margin-top:2%">
            <label for="url" class="form-label">Url del video</label>
            <input type="text" name="url" class="form-control" id="url" placeholder="Video" required>
        </div>
        <div class="col-md-6" style="margin-top:2%">
            <label for="file" class="form-label">Seleccionar imagen</label>
            <input type="file" class="form-control" id="file" required>
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
                        if (f.size > 8097153) {
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
                        filePreview.style.cssText = 'height:200px; width:430px';
                        //e.target.result contents the base64 data from the image uploaded
                        filePreview.src = e.target.result;
                        // console.log(e.target.result);

                        var previewZone = document.getElementById('file-preview-zone');
                        previewZone.appendChild(filePreview);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>

        <div class="col-md-6" style="margin-top:2%">
            <label for="inputAddress2" class="form-label">Descripcion de la capacitación</label>
            <div class="form-floating">
                <textarea name="descripcion" style="height: 150px" class="form-control" id="floatingTextarea"></textarea>
                <label for="floatingTextarea">Descripción</label>
            </div>
        </div>
        <div class="col-md-6" style="width: 250px; margin-top:2%" id="file-preview-zone">
        </div>
        <div class="col-12" style="margin-top:2%">
            <button type="submit" class="btn btn-primary">Crear</button>
        </div>
    </form>
</div>
<script>
    function crearUsuario(){
        $.ajax({
            url: './vistas/modulos/actualizar_planes.php',
            data: $('#crear').serialize(),
            type: 'post',
            beforeSend: function() {
                $("#label<?php echo $item['id']; ?>").html("Procesando");
            },
            error: function() {
                $("#label<?php echo $item['id']; ?>").html("Hubo un error");
            },
            success: function(label<?php echo $item['id']; ?>) {
                $("#label<?php echo $item['id']; ?>").html(label<?php echo $item['id']; ?>);
            }
        });
    }
</script>
<?php
require_once '../componentes/footer.php';
