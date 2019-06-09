<?php

   if(empty($usuario)) $usuario = "vazquez.soledad";
  
   $a = exec("du -sm /home/$usuario");
   $b = exec("du -sm /home/$usuario/mail");

   echo $a + $b;
?>
