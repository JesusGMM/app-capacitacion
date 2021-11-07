<?php
if (isset($_POST['asignar'])) {
    require_once "../../controlador/usuario.controlador.php";
    $user = new ControladorUsuario(2);
    

    
} else { ?>

    <script type="text/javascript">
        Swal.fire({
            position: 'top-center',
            icon: 'info',
            title: 'No ha seleccionado capacitaciones',
            confirmButtonColor: "#3fc3ee",
            showConfirmButton: true,
        })
    </script>
<?php
}