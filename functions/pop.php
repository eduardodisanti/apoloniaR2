<?php
function autenticar_imap($usuario, $clave)
{

    $Xusuario = strtok($usuario," ");
    while($x=strtok(" "))
      {
        $Xusuario = $Xusuario.".".$x;
      }

    $mbox = imap_open("{eliseo:110/pop3}INBOX","$Xusuario","$clave");
   
    $x=imap_errors();
    echo "Error ".$x[0]."\n";
    echo "Error ".$x[1];

    return($mbox);
}

function imap_mensajes_pendientes($mbox)
{

    $reg = imap_num_recent($mbox);
    return($reg);
}

function imap_cerrar($mbox)
{
     imap_close($mbox);
}
?>
