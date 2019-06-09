<?php

  require("../functions/imap.php");


 $xusuario="eduardo";
 $clave = "rupertus";
 $usuario = strtok($xusuario, "@");

$mensajes="Err";
 if(!empty($usuario)) {
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
