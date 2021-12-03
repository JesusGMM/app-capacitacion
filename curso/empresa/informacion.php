<?php
foreach ($empresas as $empresa) { ?>
    <div class="container">
        <table class="table table-hover">
            <tbody>
                 <tr>
                    <td class="col-md-4"><b>Logo:</b></td>
                    <td class="col-md-8"> <img src="../componentes/logos/empresa/<?php echo $empresa->getLogo(); ?>" alt="Sin logo" width="70px;" height="40px;" /> </td>
                </tr>
                <tr>
                    <td class="col-md-4"><b>Nombre:</b></td>
                    <td class="col-md-8"> <?php echo $empresa->getNombre(); ?></td>
                </tr>
                <tr>
                    <td class="col-md-4"><b>Nit:</b></td>
                    <td class="col-md-8"> <?php echo $empresa->getNit(); ?></td>
                </tr>
                <tr>
                    <td class="col-md-4"><b>Ciudad:</b></td>
                    <td class="col-md-8"> <?php echo $empresa->getCiudad(); ?></td>
                </tr>
                <tr>
                    <td class="col-md-4"><b>Dirreción de la empresa:</b></td>
                    <td class="col-md-8"> <?php echo $empresa->getDirrecion(); ?></td>
                </tr>
                <tr>
                    <td class="col-md-4"><b>Correo electronicao:</b></td>
                    <td class="col-md-8"> <?php echo $empresa->getCorreo(); ?></td>
                </tr>
                <tr>
                    <td class="col-md-4"><b>Telefono:</b></td>
                    <td class="col-md-8"> <?php echo $empresa->getTelefono(); ?></td>
                </tr>
                <tr>
                    <td class="col-md-4"><b>Capacitaciones inscritas:</b></td>
                    <td class="col-md-8"> <?php echo $empresa->getCapacitaciones(); ?></td>
                </tr>
                <tr>
                    <td class="col-md-4"><b>Sedes activas:</b></td>
                    <td class="col-md-8"> <?php echo $empresa->getSedes(); ?></td>
                </tr>
                <tr>
                    <td class="col-md-4"><b>Usuarios activos:</b></td>
                    <td class="col-md-8"> <?php echo $empresa->getUsuario(); ?></td>
                </tr>

            </tbody>
        </table>

    </div>
<?php   }
