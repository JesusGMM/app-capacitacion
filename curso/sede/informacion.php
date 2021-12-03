<?php
foreach ($sedes as $sede) { ?>
    <div class="container">
        <table class="table table-hover">
            <tbody>
                 <tr>
                    <td class="col-md-4"><b>Logo:</b></td>
                    <td class="col-md-8"> <img src="../componentes/logos/sede/<?php echo $sede->getLogo(); ?>" alt="Sin logo" width="70px;" height="40px;" /> </td>
                </tr>
                <tr>
                    <td class="col-md-4"><b>Nombre:</b></td>
                    <td class="col-md-8"> <?php echo $sede->getNombre(); ?></td>
                </tr>
                <tr>
                    <td class="col-md-4"><b>Nit:</b></td>
                    <td class="col-md-8"> <?php echo $sede->getNit(); ?></td>
                </tr>
                <tr>
                    <td class="col-md-4"><b>Ciudad:</b></td>
                    <td class="col-md-8"> <?php echo $sede->getCiudad(); ?></td>
                </tr>
                <tr>
                    <td class="col-md-4"><b>Dirreción de la sede:</b></td>
                    <td class="col-md-8"> <?php echo $sede->getDirrecion(); ?></td>
                </tr>
                <tr>
                    <td class="col-md-4"><b>Correo electronicao:</b></td>
                    <td class="col-md-8"> <?php echo $sede->getCorreo(); ?></td>
                </tr>
                <tr>
                    <td class="col-md-4"><b>Telefono:</b></td>
                    <td class="col-md-8"> <?php echo $sede->getTelefono(); ?></td>
                </tr>
                <tr>
                    <td class="col-md-4"><b>Capacitaciones inscritas:</b></td>
                    <td class="col-md-8"> <?php echo $sede->getCapacitaciones(); ?></td>
                </tr>
                <tr>
                    <td class="col-md-4"><b>Usuarios activos:</b></td>
                    <td class="col-md-8"> <?php echo $sede->getUsuario(); ?></td>
                </tr>

            </tbody>
        </table>

    </div>
<?php   }
