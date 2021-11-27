<?php
session_start();
if (isset($_POST['login'])) {
  require_once "controlador/login.controlador.php";
  $login = new ControllerLogin();
  $ingreso = $login->ctrIngresoUsuario($_POST['usuario'], $_POST['password']);
  if ($ingreso) {
    header("Location: curso/");
  } else {
    header("Location: login/?ingreso=" . $ingreso);
  }
} else if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {
  header("Location: curso/");
} else {
  header("Location: login/");
}
