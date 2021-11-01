<?php
session_start();
if (isset($_SESSION['nombre_pagina']))
  $nombre_pagina = $_SESSION['nombre_pagina'];
else
  $nombre_pagina = "App Capacitacion";
?>
<!DOCTYPE html>
<html lang="en" <head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title><?php echo $nombre_pagina; ?></title>
<!-- Estilo de boostrapt -->

<link href="../componentes/css/bootstrap.min.css" rel="stylesheet">
<!-- Estilo de personalizados -->
<link href="../componentes/css/login.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="../componentes/js/jquery-3.6.0.min.js" type="text/javascript"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
<?php
  if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {

  
if (isset($_POST['iniciar_seccion'])) { // validar ingreso

}  // validacion de rutas --
else if (isset($_POST['accion'])) { //maneja las rutas a las que nos dirigimos
    require_once("{$_POST['vista']}.php");
} } else {
  header("Location: ../login/");
} ?>
<script src="../componentes/js/bootstrap.min.js" type="text/javascript"></script>
</body>

</html>
