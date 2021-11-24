<div class="col-md-6">
    <div class="border" style="padding:2%; margin: 2%;">
        Pregunta numero <?php echo $clave + 1; ?>
        <h3 style="text-align: center;">¿<?php echo $pregun->getPregunta(); ?>?</h3>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="<?php echo $pregun->getId(); ?>" id="respuesta1<?php echo $pregun->getId(); ?>" value="A">
            <label class="form-check-label" for="respuesta1<?php echo $pregun->getId(); ?>">
                <B>A)</B> <?php echo $pregun->getRespuesta1(); ?>
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="<?php echo $pregun->getId(); ?>" id="respuesta2<?php echo $pregun->getId(); ?>" value="B">
            <label class="form-check-label" for="respuesta2<?php echo $pregun->getId(); ?>">
                <b>B)</b> <?php echo $pregun->getRespuesta2(); ?>
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="<?php echo $pregun->getId(); ?>" id="respuesta3<?php echo $pregun->getId(); ?>" value="C">
            <label class="form-check-label" for="respuesta3<?php echo $pregun->getId(); ?>">
                <b>C)</b> <?php echo $pregun->getRespuesta3(); ?>
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="<?php echo $pregun->getId(); ?>" id="respuesta4<?php echo $pregun->getId(); ?>" value="D">
            <label class="form-check-label" for="respuesta4<?php echo $pregun->getId(); ?>">
                <b>D)</b> <?php echo $pregun->getRespuesta4(); ?>
            </label>
        </div>
    </div>
</div>
