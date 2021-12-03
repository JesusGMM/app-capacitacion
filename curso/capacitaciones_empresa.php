<?php
require_once 'componentes/nav.php';
$usu = $user->buscarUsuarios($_SESSION['id_app_cap'], 1);
if ($usu[0]->getRol() == 'Administrador general') {
    require_once "../controlador/empresacontrolador.php";
    $empre = new EmpresaControlador(1);
    $empresas = $empre->buscarEmpresa($_GET['empresa-id-cursos'], 1);
    echo '<div class="container padin">';
    if (intval($empresas) != 0) { ?>
        <h3 style="text-align: center; margin-bottom: 2%;">Capacitaciónes asignadas a la empresa <?php echo $empresas[0]->getNombre(); ?></h3>
        <div class="input-group mb-3">
            <span class="input-group-text" id="buscar">Buscar</span>
            <input id="busqueda-cursos-empresa" type="text" class="form-control" style="z-index: auto;" onkeyup="buscarCursoEmpresa(1,<?php echo $_GET['empresa-id-cursos']; ?>)" />
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4" id="cursos-asigandos-empresa">
            <?php require_once 'empresa/mis_cursos.php'; ?>
        </div>
        
        <div id="id_modal">
        </div>

    <?php
    } else {
        echo "<h3 style='text-align: center; width: 100%;'>La empresa no existe</h3>";
    }
    echo '</div>';
} else { ?>
    <script type="text/javascript">
        Swal.fire({
            position: 'top-center',
            icon: 'error',
            title: 'No cuenta con permisos',
            customClass: {
                popup: 'border-boton'
            },
            confirmButtonColor: "#f27474",
            showConfirmButton: false,
        })
        setTimeout(function() {
            location.href = '../curso/'
        }, 2000);
    </script>
<?php
}
