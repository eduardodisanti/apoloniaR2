<?php

   session_start();

   $coiusuario = $_SESSION['coiusuario'];
   $coiclave   = $_SESSION['coiclave'];

   $hal = urlencode($coiusuario);

         $hand=fopen($hal,"r");
         $x = fgets($hand); 

if(empty($x))
    $x="X|0";

   echo $x;
?>
