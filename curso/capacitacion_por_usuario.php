<?php
require_once 'componentes/nav.php';
$usu = $user->buscarUsuarios($_SESSION['id_app_cap'], 1);
if ($usu[0]->getRol() == 'Administrador general')
    $usu = $user->buscarUsuarios($_GET['id'], 1);
else
    $_GET['id'] = $_SESSION['id_app_cap'];
?>
<div class="container padin">
    <h3 style="text-align: center; margin-bottom: 2%;"><?php if ($_SESSION['id_app_cap'] != $_GET['id']) echo "Capacitaciónes asignadas a " . $usu[0]->getNombre() . " " . $usu[0]->getApellido();
                                                        else echo "Mis resultados"; ?></h3>
    <div class="input-group mb-3">
        <span class="input-group-text" id="buscar">Buscar</span>
        <input id="busqueda-cursos-resueltos" type="text" class="form-control" aria-describedby="buscar" onkeyup="buscarCursoResueltos(1)" />
    </div>
    <div class="row row-cols-1 row-cols-md-3 g-4" id="cursos-resueltos">
        <?php require_once 'usuario/mis_resultados.php'; ?>
    </div>
</div>