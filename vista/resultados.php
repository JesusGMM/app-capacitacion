<?php
require_once '../componentes/heder.php';
require_once 'componentes/nav.php';
?>
<div class="container" style="padding-top: 4rem;">
    <h3 style="text-align: center; margin-bottom: 2%;">Informe de Resultados</h3>
    <div class="row row-cols-1 row-cols-md-3 g-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" style="text-align: center;">Resultados por usuarios</h5>
                    <p class="card-text">
                        <b>Usuarios activos: </b>
                        <br>
                        <b>Usuarios que han realizado capacitaciónes: </b>
                        <br>
                        <b>Porcentaje de usuarios capacitados: </b>
                        <br>
                        <b>Porcentaje de resultados fase 1: </b>
                        <br>
                        <b>Porcentaje de resultados fase 2: </b>
                    </p>
                    <a href="resultados_por_usuario.php" class="btn btn-primary" style="margin-bottom:2%">Ver detalles</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" style="text-align: center;">Resultados por capacitación</h5>
                    <p class="card-text">
                        <b>Total de capacitaciónes: </b>
                        <br>
                        <b>Capacitaciónes activas: </b>
                        <br>
                        <b>Capacitaciónes desactivadas: </b>
                        <br>
                        <b>Capacitaciónes realizadas: </b>
                        <br>
                        <b>Porcentaje de capacitaciónes realizadas: </b>
                    </p>
                    </p>
                    <a href="#" class="btn btn-primary" style="margin-bottom:2%">Ver detalles</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
 require_once '../componentes/footer.php';