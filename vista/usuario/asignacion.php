<?php
//foreach ($usu as $usuario) { 
?>
<div class="container">
    <form id="form-asignar">
        <table class="table table-hover" style="text-align: center;">
            <thead>
                <tr>
                    <th scope="col">Codigo</th>
                    <th scope="col">Asignar</th>
                    <th scope="col">Capacitación</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>

                    <td class="col"><input name="asignar[]" class="form-check-input" type="checkbox" value="id"> </td>

                    <td class="col-md-8"> Equipo de computo</td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
<?php  // }