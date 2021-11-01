<div class="container" style="padding-top: 2%; display: flex; ">
    <div style="width: 20%;">
        <h3 style="text-align: center;">Fase 1</h3>
    </div>
    <div style="display: flex; justify-content: right; width: 80%;">
        <div class="temporizador" id="hora"> Hora <br> 00</div>
        <div class="temporizador" id="minutos"> Min <br> 00</div>
        <div class="temporizador" id="segundos"> Seg <br> 00</div>
    </div>
</div>
<h1 style="text-align: center; margin-top: 1rem;  margin-bottom: 2rem;">Capacitacion</h1>
<form type="POST" enctype="multipart/formdata">
    <div class="row g-3">


        <?php
        require_once 'componentes/preguntas.php';
        ?>

    </div>

</form>
<div class="container">
    <div class="row">
        <div class="col-md-8" style="margin-top: 2%">
            <button type="button" class="btn btn-primary">Enviar y continuar a la fase 2</button>
        </div>

        <div class="col-md-4" style="display:flex; margin-top:2%;">
            <nav>
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" type="button" onclick="">&laquo; Anterior</a>
                    </li>

                    <li class="page-item " aria-current="page">
                        <select class="page-link" id="id_pag" onchange="paginar($(this).val())">
                            <?php
                            for ($i = 1; $i <= 15; $i++) {

                                if ($i == 5) {
                                    echo "<option value='" . $i . "' selected>" . $i . "</option>";
                                } else {
                                    echo "<option value='" . $i . "'>" . $i . "</option>";
                                }
                            }
                            ?>

                        </select>
                    </li>

                    <li class="page-item">
                        <a class="page-link" type="button" onclick="">Siguiente &raquo;</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>


<script type="text/javascript">
    var f_coun = null;
    var interval = null;
    window.addEventListener("load", () => {
        var _seconds = 60 * 1000;
        var _minutes = 2 * 1000 * 60;
        var _hora = 0 * 1000 * 60 * 24;
        var miliseconds = _seconds + _minutes + _hora;
        f_coun = new Date(new Date().getTime() + miliseconds);
        interval = setInterval(fnCount, 1000);
    });

    var fnCount = () => {
        var fecha_actual = new Date();
        var milisegundos = f_coun - fecha_actual;
        var segundos = Math.floor(milisegundos / 1000);

        var seg = segundos % 60;
        var minutos = Math.floor((segundos / 60) % 60);
        var hora = Math.floor((segundos / (60 * 60)) % (60 * 60) % 24);

        document.querySelector('#hora').innerHTML = ("Hora <br> " + ("0" + hora).slice(-2));
        document.querySelector('#minutos').innerHTML = ("Min <br>" + ("0" + minutos).slice(-2));
        document.querySelector('#segundos').innerHTML = ("Seg <br>" + ("0" + seg).slice(-2));

        if (segundos < 1) {
            clearInterval(interval);
        }
    }
</script>