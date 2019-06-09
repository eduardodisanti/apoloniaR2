<?php

   session_start();

   $coiusuario = $_SESSION['coiusuario'];
   $coiclave   = $_SESSION['coiclave'];

   if(empty($coiusuario))
      $coiusuario="di santi eduardo";

    $hal = "../hermes/respuestas/$coiusuario";

    $hand=@fopen($hal,"r");
    $x = @fgets($hand); 
  
  if(empty($x))
    $x="X|0";

   echo $x;
?>
