<?php
if (isset($_POST['idempresa'])) {
    require_once "../../controlador/sedecontrolador.php";
    $sedecontrol = new SedeControlador(2);
    $sedes = $sedecontrol->listarSedes($_POST['idempresa'], 1, 2); ?>
    <label for="sede" class="form-label" style="margin-bottom: 2.5%;">Sede</label>
    <select class="form-select" name="idsede" id="sede">
        <option value="0">Sin sede</option>
        <?php
        if (is_object($sedes[0])) {
            foreach ($sedes as $sede) {
                echo '<option value="' . $sede->getId() . '">' . $sede->getNombre() . '</option>';
            }
        } ?>
    </select>
    <script type="text/javascript">
        $(document).ready(function() {
            <?php if ($_POST['acion'] == 1) { ?>
                $('#sede').select2({
                    theme: "classic"
                });
            <?php } else { ?>
                $('#sede').select2({
                    dropdownParent: $('#staticBackdrop .modal-content'),
                    theme: "classic"
                });
            <?php } ?>
        });
    </script>
<?php }
