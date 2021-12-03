<?php
require_once "../../controlador/curso.controlador.php";
foreach ($empresas as $empresa) {
    $curso = new ControladorCurso(2);
    $capacitacion = $curso->listarCapacitacion('Administrador general', $empresa->getId(),"", "", "", "", 2);
?>
    <div class="container">
        <form id="form-asignar-empresa">
            <input type="hidden" name="id_empresa" value="<?php echo $empresa->getId(); ?>"/>
            <table class="table table-hover" style="text-align: center;">
                <thead>
                    <tr>
                        <th scope="col">Codigo</th>
                        <th scope="col">Asignar</th>
                        <th scope="col">Capacitación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($capacitacion as $cap) {
                        $cap_asignada = $empre->validarCurso($empresa->getId(), $cap->getId(), 2);
                        if ($cap_asignada[0] == 3 && $cap->getEstado() == 1 ){
                            echo '<tr><th scope="col">' . $cap->getCodigo();
                            echo '</th><td class="col"><input name="asignar[]" class="form-check-input" type="checkbox" value="'. $cap->getId().'">';
                            echo '</td><td class="col-md-8">' . $cap->getNombre();
                            echo "</td></tr>";
                        }
                    } ?>
                </tbody>
            </table>
        </form>
    </div>
<?php   }
