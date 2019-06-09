<?php

function autenticar_imap($usuario, $clave)
{

  $Xusuario=strtok($usuario,"@");     
 
  if($usuario > " ") {
	  $mbox = @imap_open("{elias:143/imap/novalidate-cert}INBOX","$Xusuario","$clave");

  	  $x=imap_errors();
	  //if(!empty($x))
	  //    echo "<br>$x<br>";
   }      
  return($mbox);
}

function imap_mensajes_pendientes($mbox)
{

  if(!empty($mbox))
    $reg = imap_status($mbox, "{elias}INBOX",SA_ALL);

    return($reg->unseen);
}

function imap_cerrar($mbox)
{
     imap_close($mbox);
}
?>
