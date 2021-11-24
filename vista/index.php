
  <?php
  require_once '../componentes/heder.php';
  require_once "../controlador/usuario.controlador.php";
  require_once "../controlador/curso.controlador.php";
  require_once "../controlador/pregunta.controlador.php";
  if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {
    $rutas = true;
    if ($_SESSION['rol_app_cap'] == 1) {
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
      } else {
        $rutas = true;
      }
    }

    if ($rutas) {
      if (empty($_GET)) {
        require_once("cursos.php");
      } else if (isset($_GET["id"])) {
        require_once("capacitacion_por_usuario.php");
      } else  if (isset($_GET["video"])) {
        require_once("fase_video.php");
      } else if (isset($_GET["ver-resulatados"])) {
        require_once("revision.php");
      } else if (isset($_GET["realizar-capacitacion"])) {
        require_once("fase_preguntas.php");
      }else {
        require_once("404.php");
      }
    }
  } else {
    header("Location: ../login/");
  }
  require_once '../componentes/footer.php';
