<?php
require("../functions/imap.php");
$mbox = autenticar_imap("eduardo", "9or3ay");

$x = imap_errors();
echo $x[0]." - ".$x;

$penda = imap_mensajes_pendientes($mbox);
imap_cerrar($mbox);

echo "Mensajes es $penda\n";
?>
