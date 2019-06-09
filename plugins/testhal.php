<?php

   $coiusuario = "eduardo";

   $hal = "http://hermes.kcreativa.com/script/hal.php?cliente=111&usuario=".urlencode($coiusuario);
    $hand=fopen($hal,"r");
    $x = fgets($hand);

   $sino=strtok($x,"|");
   $cant=strtok("|");

   switch($sino)
    {
      case "X" : $mensaje="No puedo comunicarme con Hermes ($coiusuario)";
                 $imagen="img/x.png";
                break;
      case "N" : $mensaje="Hermes no tiene nada para responderle ($coiusuario)";
                 $imagen="img/pacing.gif";
                break;
      case "S" : $mensaje="Hermes tiene $cant respuestas sobre sus reclamos ($coiusuario)";
                 $imagen="img/lghtbulb.gif";
                break;
    }

   echo "$mensaje\n";
   fclose($hand);
?>
