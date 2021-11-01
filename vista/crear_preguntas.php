<?php
require_once 'componentes/nav.php';
?>

<div class="container" style="padding-top: 4rem;">
    <div class="col-md-12">
        <h2 style="text-align: center;">Nombre</h2>
    </div>
    <form type="POST">
        <div class="border row g-3" style="margin-top: 2%; padding-bottom: 2%;">
            <div class="col-md-12">
                <label for="1" class="form-label">Pregunta numero 1</label>
                <input type="text" class="form-control" name="pregunta" id="1" placeholder="Pregunta 1" required>
            </div>
            <div class="col-md-10">
                <label for="2" class="form-label">Respuesta A</label>
                <input type="text" class="form-control" name="respuesta" id="2" placeholder="Respuesta A" required>
            </div>
            <div class="col-md-10">
                <label for="2" class="form-label">Respuesta B</label>
                <input type="text" class="form-control" name="respuesta" id="2" placeholder="Respuesta B" required>
            </div>
            <div class="col-md-10">
                <label for="2" class="form-label">Respuesta C</label>
                <input type="text" class="form-control" name="respuesta" id="2" placeholder="Respuesta C" required>
            </div>
            <div class="col-md-10">
                <label for="2" class="form-label">Respuesta D</label>
                <input type="text" class="form-control" name="respuesta" id="2" placeholder="Respuesta D" required>
            </div>
            <div class="col-md-4" style="margin-right:10%;">
                <label for="2" class="form-label">Respuesta Correcta</label>
                <select name="respuesta_correcta" id="2" class="form-select">
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
            </div>
            <div class="col-md-8">
                <nav >
                    <ul class="pagination">
                        <li class="page-item">
                            <span class="page-link">&laquo; Anterior</span>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">2</span>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Siguiente &raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </form>
    <div class="container" style="padding-top: 2%; margin-bottom: 2%;">
        <button type="button" class="btn btn-primary" style="margin-bottom: 2%;">Guardar</button>
        <button type="button" class="btn btn-primary" style="margin-bottom: 2%;">Guardar y Publicar</button>
        <button type="button" class="btn btn-danger" style="margin-bottom: 2%;">Desactivar publicación</button>
    </div>
</div>