<?php

include("../functions/db.php");

$db = conectar();

$a = "/srv/tmp/belloni.csv";
$fp = fopen("$a", "r");

$ok = 0;
$er = 0;
$le = 0;

while($reg=fgets($fp)) {

  $le++;

  $fecha = strtok($reg, ",");
  $cons  = strtok(",");
  $turno = strtok(",");
  $hora  = strtok(",");
  $medico= strtok(",");
  $pac   = strtok(",");
  $bloq  = strtok(",");
  $act   = strtok(",");
  $proc  = strtok(",");
  $vino  = strtok(",");
  $hcita = strtok(",");
  $fun   = strtok(",");
  $num   = strtok(",");


   $q = "insert into Horarios values('$fecha','$cons','$turno', '$hora', $medico, $pac, '$bloq', '$act', $proc, '$vino', '$hcita', $fun,$num)";

   query($q);

   $err = mysql_error();
   if(empty($err))
     $ok++;
   else
     $er++;

}

echo "\nLeidos $le - errores $er - ok = $ok\n";
desconectar();
fclose($fp);
?>
