<?php

  require("../functions/imap.php");


 $usuario = strtok($xusuario, "@");

$mensajes = "0";
$estado   = "X";
		
$mensajes="Err";
 if(!empty($coiusuario)) {
   $mbox = autenticar_imap($usuario, $clave);
   if(!empty($mbox))
     {
        $mensajes = imap_mensajes_pendientes($mbox);
        $estado   = "S";        
     }
   else
      {
        $mensajes = "0";
        $estado   = "X";
      }

   echo "$estado|$mensajes";
 }  

?>
