<?php
require_once 'componentes/nav.php';
?>
<div class="container" style="padding-top: 4rem;">
    <div class="row" style="padding-top: 2%;">
        <div class="col-md-7" style="padding-bottom: 1rem!important;">
            <select class="form-select form-select-sm" style="margin-bottom: 0rem!important;">
                <option value="1">Fase 1</option>
                <option value="2">Fase 3</option>
            </select>
        </div>
        <div class="col-md-5" style="display: flex; padding-bottom: 1rem!important;">
            <div class="temporizador" style="background-color: #4AC833;"> Correctas: 10</div>
            <div class="temporizador" style="background-color: #F64545;"> Incorrectas: 5</div>
            <div class="temporizador" style="background-color: #DCDA87;"> No resueltas: 5</div>
        </div>
    </div>
    <h3 style="text-align:center; margin-bottom: 2%;">Nombre</h3>
    <div class="row g-3">


        <?php
        require_once 'componentes/preguntas_resueltas.php';
        ?>

    </div>
</div>