<?php
require_once 'componentes/nav.php';
if (isset($_GET['editar-capacitacion-id'])) {
    $curso = new ControladorCurso(1);
    if (isset($_POST['codigo'])) {
        $registro = $curso->actualizarCapacitacion($_POST);
    } else {
        $registro[0] = 0;
        $cap = $curso->listarCapacitacion($usuario[0]->getRol(), "", $_GET['editar-capacitacion-id'],"", "", "",1);
    }

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
                location.href = '../curso/'
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
        <form class="row g-3" method="POST" enctype="multipart/form-data">
            <div class="col-md-6">
                <label for="inputAddress" class="form-label">Titulo de la capacitación</label>
                <input type="text" class="form-control" name="titulo" id="inputAddress" placeholder="Titulo" value="<?php if (isset($_POST['titulo'])) echo $_POST['titulo'];
                                                                                                                    else echo $cap[0]->getNombre(); ?>" required/>
            </div>
            <div class="col-md-6">
                <label for="inputcodigo" class="form-label">Codigo de la capacitación</label>
                <input type="text" name="codigo" class="form-control" id="inputcodigo" placeholder="Codigo" value="<?php if (isset($_POST['codigo'])) echo $_POST['codigo'];
                                                                                                                    else echo $cap[0]->getCodigo(); ?>" required/>
            </div>
            <div class="col-md-6" style="margin-top:2%">
                <label for="inputState" class="form-label">Estado</label>
                <select name="estado" id="inputState" class="form-select" >
                <?php
                if (isset($_POST['estado'])) {
                    if ($_POST['estado'] == '1')
                        echo ' <option value="1">Publicada</option>';
                    else
                        echo '<option value="2">En Borrador</option>';
                } else {
                    if ($cap[0]->getEstado() == '1')
                    echo ' <option value="1">Publicada</option>';
                    else
                        echo '<option value="2">En Borrador</option>';
                } ?>
                
                    
                   
                </select>
            </div>
            <div class="col-md-6" style="margin-top:2%">
                <label for="inputAddress3" class="form-label" style="width: 100%;">Cantidad de preguntas <label style="margin-left: 15%;"> <b>Nota: </b>Al disminuir se eliminan las ultimas </label> </label>
                <input type="number" class="form-control" name="cantidad" id="inputAddress3" min="1" placeholder="Numero de preguntas" value="<?php if (isset($_POST['cantidad'])) echo $_POST['cantidad'];
                                                                                                                                                else echo $cap[0]->getCan_pregutas(); ?>" required/>
            </div>
            <div class="col-md-6" style="margin-top:2%">
                <label for="url" class="form-label" style="width: 100%;">Nueva Url del video <label style="margin-left: 35%;"> <b>Ayuda: </b> <a href="https://localhost/app_capacitacion/curso/" target="_blank" style="margin-bottom:2%"> Como copiar una URL</a></label> </label>
                <div class="form-floating">
                    <textarea name="url" style="height: 150px" class="form-control" id="Textarea"><?php if (isset($_POST['url'])) echo $_POST['url'];
                                                                                                    else echo $cap[0]->getUrl(); ?></textarea>
                    <label for="Textarea">Video instructivo de la capacitación</label>
                </div>
            </div>
            <div class="col-md-6" style="margin-top:2%">
                <label for="inputAddress2" class="form-label">Descripcion de la capacitación</label>
                <div class="form-floating">
                    <textarea name="descripcion" style="height: 150px" class="form-control" id="floatingTextarea"><?php if (isset($_POST['descripcion'])) echo $_POST['descripcion'];
                                                                                                                    else echo $cap[0]->getDescripcion(); ?></textarea>
                    <label for="floatingTextarea">Descripción</label>
                </div>
            </div>

            <div class="col-md-6" style="margin-top:2%">
                <label for="inputAddress9" class="form-label">Duración de la prueba</label>
                <input type="number" class="form-control" name="tiempo" id="inputAddress9" min="1" placeholder="Tiempo en minutos" value="<?php if (isset($_POST['tiempo'])) echo $_POST['tiempo'];
                                                                                                                                            else echo $cap[0]->getTiempo(); ?>" required/>
            </div>
            <div class="col-md-6" style="margin-top:2%">
                <label for="file" class="form-label">Nueva imagen</label>
                <input type="file" class="form-control" name="imagen" id="file" onchange="subirImagen(event)" />
            </div>
   
            <input type="hidden" name="foto" value="<?php if (isset($_POST['foto'])) echo $_POST['foto'];
                                                    else echo $cap[0]->getImagen(); ?>"/>
            <input type="hidden" name="id_cap" value="<?php echo $_GET['editar-capacitacion-id']; ?>"/>
            <div class="col-md-6" style="margin-top:2%" id="file-preview-zone">

                <?php
                if (isset($_POST['foto']))
                    echo '<img style="height:250px; width:100%" src="../componentes/imagenes/' . $_POST['foto'] . '" alt="Capacitación sin imagen">';
                else
                    echo '<img style="height:250px; width:100%" src="../componentes/imagenes/' . $cap[0]->getImagen() . '" alt="Capacitación sin imagen">'; ?>
            </div>
            <div class="col-md-8" style="margin-top:2%">
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href='../curso/' class="btn btn-secondary">Cancelar</a>
            </div>

        </form>
    </div>

<?php

} else {
?>
    <script type="text/javascript">
        Swal.fire({
            position: 'top-center',
            icon: 'error',
            title: 'La capacitacion no existe',
            customClass: {
                popup: 'border-boton'
            },
            confirmButtonColor: "#f27474",
            showConfirmButton: true,
        })
        setTimeout(function() {
            location.href = '../curso/'
        }, 2000);
    </script>
<?php
}

