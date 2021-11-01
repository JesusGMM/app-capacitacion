<?php
if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") { ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light nav-fijo">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="true" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../vista/?crear-capacitacion">Crear capacitación</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Modificar capacitación</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../vista/?resultados">Ver resultados</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Usuarios
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="../vista/?registrar-usuario">Crear usuario</a></li>
                            <li><a class="dropdown-item" href="#">Modificar usuario</a></li>
                            <li><a class="dropdown-item" href="#">Eliminar usuario</a></li>
                            <li><a class="dropdown-item" href="#">Asignar capacitación</a></li>
                            <li><a class="dropdown-item" href="../vista/?lista-usuario">Ver usuario</a></li>
                            <li><a class="dropdown-item" href="cerrar_sesion.php">Cerrar sesion</a></li>
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
