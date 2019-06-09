<?php
  require_once("DB.php");
  require_once("class/bug.phpm");
  
  session_start();
  
  $m = $_SESSION['Apolonia_bugdb'];

  include("templates/bugdb.phtml");

?>
