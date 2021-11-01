
  <?php
  require_once '../componentes/heder.php';
  require_once "../controlador/usuario.controlador.php";
  if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {

    if (isset($_POST["realizar"])) {
    } else if (isset($_GET["id"])) {
      require_once("capacitacion_por_usuario.php");
    } else if (isset($_GET["lista-usuario"])) {
      require_once("usuario/usuario.php");
    } else if (isset($_GET["registrar-usuario"])) {
      require_once("usuario/registrar.php");
    } else if (isset($_GET["crear-capacitacion"])) {
      require_once("crear_capacitacion.php");
    } else if (isset($_GET["resultados"])) {
      require_once("resultados.php");
    } else {
      require_once("cursos.php");
    }
  } else {
    header("Location: ../login/");
  }
  require_once '../componentes/footer.php';
