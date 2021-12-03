<?php
foreach ($usu as $usuario) { ?>
    <div class="container">
        <table class="table table-hover">
            <tbody>
                <tr>
                    <td class="col-md-4"><b>Nombre:</b></td>
                    <td class="col-md-8"> <?php echo $usuario->getNombre(); ?></td>
                </tr>
                <tr>
                    <td class="col-md-4"><b>Apallido:</b></td>
                    <td class="col-md-8"> <?php echo $usuario->getApellido(); ?></td>
                </tr>
                <tr>
                    <td class="col-md-4"><b>Codigo:</b></td>
                    <td class="col-md-8"> <?php echo $usuario->getCodigo(); ?></td>
                </tr>
                <tr>
                    <td class="col-md-4"><b>Nombre de usuario:</b></td>
                    <td class="col-md-8"> <?php echo $usuario->getUsuario(); ?></td>
                </tr>
                <tr>
                    <td class="col-md-4"><b>Correo electronicao:</b></td>
                    <td class="col-md-8"> <?php echo $usuario->getEmail(); ?></td>
                </tr>
                <tr>
                    <td class="col-md-4"><b>Rol:</b></td>
                    <td class="col-md-8"> <?php echo $usuario->getrol(); ?></td>
                </tr>
                <tr>
                    <td class="col-md-4"><b>Capacitaciones inscritastas:</b></td>
                    <td class="col-md-8"> <?php echo $usuario->getCapacitaciones(); ?></td>
                </tr>
                <tr>
                    <td class="col-md-4"><b>Capacitaciones resueltas:</b></td>
                    <td class="col-md-8"> <?php echo $usuario->getCap_realizadas(); ?></td>
                </tr>
                <tr>
                    <td class="col-md-4"><b>Nivel de completado:</b></td>
                    <td class="col-md-8">
                        <?php
                        if ($usuario->getCapacitaciones() == 0)
                            echo 0;
                        else
                            echo ($usuario->getCap_realizadas() / ($usuario->getCapacitaciones()) * 100);

                        ?>%
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
<?php   }
