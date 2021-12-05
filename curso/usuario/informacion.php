<?php
foreach ($usu as $usuario) { ?>
    <div class="container">
        <table class="table table-hover">
            <tbody>
                <?php
                if ($usuario->getIdempresa() != 0 && $usuario->getrol() != 'Administrador general') {
                    require_once "../../controlador/empresacontrolador.php";
                    $empre = new EmpresaControlador(2);
                    $empresas = $empre->buscarEmpresa($usuario->getIdempresa(), 2); ?>
                    <tr>
                        <td class="col-md-4"><b>Empresa:</b></td>
                        <td class="col-md-8">
                            <label style="width: 50%;"><b>Nombre: </b> <?php echo $empresas[0]->getNombre(); ?></label>
                            <label style="width: 40%;"><b>Nit: </b><?php echo $empresas[0]->getNit(); ?></label>
                        </td>
                    </tr>
                    <?php if ($usuario->getIdsede() != 0) {
                        require_once "../../controlador/sedecontrolador.php";
                        $sedecontrol = new SedeControlador(2);
                        $sedes = $sedecontrol->buscarSede($usu[0]->getIdsede(), 2); ?>
                        <tr>
                            <td class="col-md-4"><b>Sede:</b></td>
                            <td class="col-md-8">
                                <label style="width: 50%;"><b>Nombre: </b> <?php echo $sedes[0]->getNombre(); ?></label>
                                <label style="width: 40%;"><b>Nit: </b><?php echo $sedes[0]->getNit(); ?></label>
                            </td>
                        </tr>
                <?php }
                } ?>
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
