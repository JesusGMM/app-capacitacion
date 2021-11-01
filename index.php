<?php
session_start();
  if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {

  } 
  else {
    header("Location: login/");
  }

  ?>
