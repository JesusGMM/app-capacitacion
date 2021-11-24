<?php
$respuesta = "";
$corecta = 0;
foreach ($resultado as $res) {
    if ($res['id_pregunta'] == $pregun->getId()) {
        $respuesta = $res['respuesta'];
        if ($res['respuesta'] == $pregun->getRespuesta_corecta())
            $corecta = 1;
    }
}
?>
<div class="col-md-6">
    <div class="border" style="padding:2%; margin: 2%;">
        Pregunta numero <?php echo $clave + 1; ?>
        <h3 style="text-align: center;">¿<?php echo $pregun->getPregunta(); ?>?</h3>
        <div class="form-check">
            <input class="form-check-input" type="radio" id="respuesta1" disabled <?php if ($respuesta == 'A') echo "checked"; ?>>
            <label class="form-check-label" for="respuesta1">
                <B>A)</B> <?php echo $pregun->getRespuesta1(); ?>
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" id="respuesta2" disabled <?php if ($respuesta == 'B') echo "checked"; ?>>
            <label class="form-check-label" for="respuesta2">
                <b>B)</b> <?php echo $pregun->getRespuesta2(); ?>
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" id="respuesta3" disabled <?php if ($respuesta == 'C') echo "checked"; ?>>
            <label class="form-check-label" for="respuesta3">
                <b>C)</b> <?php echo $pregun->getRespuesta3(); ?>
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" id="respuesta4" disabled <?php if ($respuesta == 'D') echo "checked"; ?>>
            <label class="form-check-label" for="respuesta4">
                <b>D)</b> <?php echo $pregun->getRespuesta4(); ?>
            </label>
        </div>
        <div class="card-footer" style="margin-top: 1rem;">
            Respuesta Correcta: <?php echo $pregun->getRespuesta_corecta(); ?>
            <br>
            <?php
            if (!empty($respuesta))
                echo "Tu respuesta: {$respuesta}<br>";
            else
                echo "Pregunta sin responder <br>";

            if ($corecta == 1)
                echo ' <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
            </svg> Correcta';
            else
                echo ' <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
            </svg> Incorrecta';
            ?>
        </div>
    </div>

</div>