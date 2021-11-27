<?php
require_once 'componentes/nav.php'; ?>

<div class="container padin">
    <h2 style="text-align: center;">Registrar Empresa</h2>
    <form class="row g-3 needs-validation" novalidate>
        <div class="col-md-6">
            <label for="validationCustom01" class="form-label">Nombre</label>
            <div class="input-group has-validation">
            <input type="text" class="form-control" id="validationCustom01" name="nombre" value="" required>
            <div class="invalid-feedback">
                Nombre de la empresa es requerido
            </div>
            </div>
        </div>
        <div class="col-md-6">
            <label for="validationCustom02" class="form-label">NIT</label>
            <div class="input-group has-validation">
                <input type="text" class="form-control" id="validationCustom02" name="nit" value="" required>
                <div class="invalid-feedback">
                    NIT requerido
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label for="validationCustomUsername" class="form-label">Correo Electronico</label>
            <div class="input-group has-validation">
                <span class="input-group-text" id="inputGroupPrepend">@</span>
                <input type="email" class="form-control" id="validationCustomUsername" name="email" aria-describedby="inputGroupPrepend" required>
                <div class="invalid-feedback">
                    El correo es requerido
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label for="validationCustom03" class="form-label">Ciudad</label>
            <input type="text" class="form-control" name="ciudad" id="validationCustom03">
        </div>
        <div class="col-md-6">
            <label for="validationCustom04" class="form-label">Dirrecion</label>
            <input type="text" class="form-control" name="dirrecion" id="validationCustom04">
        </div>
        <div class="col-md-6">
            <label for="validationCustom05" class="form-label">Telefono</label>
            <input type="text" class="form-control" name="dirrecion" id="validationCustom05">
        </div>
        <div class="col-md-6">
            <label for="flexSwitchCheckChecked" class="form-label">Estado Activo o inactivo</label>
            <div class="form-check form-switch">
                <input class="form-check-input" name="estado" type="checkbox" id="flexSwitchCheckChecked" checked />
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