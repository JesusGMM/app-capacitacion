<?php
session_start();
if (!isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {
    // header("Location: login/");
} else {
    // header("Location: ../login/");
}

?>
<nav class="navbar navbar-expand-lg navbar-light bg-light nav-fijo">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Crear capacitación</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Modificar capacitación</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Ver resultados</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Usuarios
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Crear usuario</a></li>
                        <li><a class="dropdown-item" href="#">Modificar usuario</a></li>
                        <li><a class="dropdown-item" href="#">Eliminar usuario</a></li>
                        <li><a class="dropdown-item" href="#">Asignar capacitación</a></li>
                        <li><a class="dropdown-item" href="#">Ver usuario</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>