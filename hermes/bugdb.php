<?php
  require_once("DB.php");
  require_once("class/hermes.phpm");
  
  session_start();
  
  $m = $_SESSION['Apolonia_hermes'];

  include("templates/bugdb.phtml");

?>
