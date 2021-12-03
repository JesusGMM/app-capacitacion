<?php
session_start();
if (isset($_SESSION["iniciarSesionAppCap"]) && $_SESSION["iniciarSesionAppCap"] == "ok") {
  require_once "../controlador/usuario.controlador.php";
  require_once "../controlador/curso.controlador.php";
  require_once "../controlador/pregunta.controlador.php";
  $user = new ControladorUsuario(1);
  $usuario = $user->buscarUsuarios($_SESSION['id_app_cap'], 1);

  require_once '../componentes/heder.php';

  $rutas = true;
  if ($usuario[0]->getRol() == 'Administrador general') {
    $rutas = false;
    if (isset($_GET["lista-usuario"])) {
      require_once("usuario/usuario.php");
    } else if (isset($_GET["registrar-usuario"])) {
      require_once("usuario/registrar.php");
    } else if (isset($_GET["crear-capacitacion"])) {
      require_once("crear_capacitacion.php");
    } else if (isset($_GET["resultados"])) {
      require_once("resultados.php");
    } else if ((isset($_GET["crear-preguntas-capacitacion-id"])) || (isset($_GET["editar-preguntas-capacitacion-id"]))) {
      require_once("crear_preguntas.php");
    } else if (isset($_GET["editar-capacitacion-id"])) {
      require_once("editar_capacitacion.php");
    } else if (isset($_GET["informe"])) {
      require_once("informe.php");
    } else if (isset($_GET["registrar-empresa"])) {
      require_once("empresa/crear_empresa.php");
    } else if (isset($_GET["registrar-sede"])) {
      require_once("sede/crear_sede.php");
    } else if (isset($_GET["lista-empresa"])) {
      require_once("empresa/empresa.php");
    } else if (isset($_GET["lista-sede"])) {
      require_once("sede/sede.php");
    } else if (isset($_GET["empresa-id-cursos"])) {
      require_once("capacitaciones_empresa.php");
    } else if (isset($_GET["sede-id-cursos"])) {
      require_once("capacitaciones_sedes.php");
    } else {
      $rutas = true;
    }
  }

  if ($rutas) {
    if (empty($_GET)) {
      require_once("listado_cursos.php");
    } else if (isset($_GET["id"])) {
      require_once("capacitacion_por_usuario.php");
    } else  if (isset($_GET["video"])) {
      require_once("fase_video.php");
    } else if (isset($_GET["ver-resulatados"])) {
      require_once("revision.php");
    } else if (isset($_GET["realizar-capacitacion"])) {
      require_once("fase_preguntas.php");
    } else {
      require_once("404.php");
    }
  }

  require_once '../componentes/footer.php';
} else {
  header("Location: ../login/");
}
