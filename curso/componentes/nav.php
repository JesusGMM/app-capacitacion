<?php
if (isset($_SESSION["iniciarSesionAppCap"]) && $_SESSION["iniciarSesionAppCap"] == "ok") {
?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light nav-fijo">
        <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="../componentes/logos/logo-menu.png" alt=""  height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="true" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="../curso">Inicio</a>
                    </li>
                    <?php if ($usuario[0]->getRol() == 'Administrador general') { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../curso/?crear-capacitacion">Crear capacitación</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../curso/?informe">Informe resultados</a>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../curso/?id=<?php echo $_SESSION['id_app_cap']; ?>">Mis resultados</a>
                    </li>
                    <?php if ($usuario[0]->getRol() == 'Administrador general') { ?>
                       
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Empresas
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">                          
                                <li><a class="dropdown-item" href="../curso/?lista-empresa">Listar empresas</a></li>
                                <li><a class="dropdown-item" href="../curso/?lista-sede">Listar sedes</a></li>
                                <li><a class="dropdown-item" href="../curso/?registrar-empresa">Crear empresa</a></li>
                                <li><a class="dropdown-item" href="../curso/?registrar-sede">Crear sede</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Usuarios
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="../curso/?registrar-usuario">Crear usuario</a></li>
                                <li><a class="dropdown-item" href="../curso/?lista-usuario">Listar Usuarios</a></li>
                            </ul>
                        </li>
                    <?php } else { ?>


                    <?php } ?>
                </ul>
                <ul class="navbar-nav d-flex" aria-labelledby="navbarDropdownMenuLink">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Mi perfil</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="right: 0; left: auto;">
                            <li><a class="dropdown-item" href="cerrar_sesion.php">Editar perfil</a></li>
                            <li><a class="dropdown-item" href="cerrar_sesion.php">Cerrar sesión</a></li>
                        </ul>
                    </li>

                </ul>

            </div>
        </div>
    </nav>
<?php
} else {
    header("Location: ../login/");
}
