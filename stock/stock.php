<?php
  require_once("DB.php");
  require_once("class/Mateo.phpm");
  require_once("class/ListaArticulos.phpm");
  
  session_start();
  
  $m = $_SESSION['mateo'];
  $tema = $m->getTema();
  $empresa=$m->getInstitucion();
  $logo = $m->getLogo();
      
  include("templates/stock.phtml");

?>