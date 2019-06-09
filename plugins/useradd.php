<?php

function crear_usuario($usuario, $clave) {
   $fp = fopen(".usr.tmp","w");
   fputs($fp, "$usuario:$clave\n");
   system("newusers .usr.tmp");
}
?>
