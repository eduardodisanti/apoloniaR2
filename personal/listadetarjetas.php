<?php
require_once("lista_de_usuarios.phpm");

   $listaU = new lista_de_usuarios();
   $listaU->setDB("mysql");
   $listaU->cargar();

   include("listatar.phtml");
?>
