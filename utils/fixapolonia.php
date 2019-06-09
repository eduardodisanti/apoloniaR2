<?php

include("../functions/db.php");

$db = conectar();

$a = "/srv/tmp/apolonia.sql";
$fp = fopen("$a", "r");

$ok = 0;
$er = 0;
$le = 0;

while($reg=fgets($fp)) {

  $le++;

  $epi = substr($reg, 13,9);

  if($epi=="Episodios")
    {
      if(substr($reg,0,4)!="LOCK") {
         query($reg);  
	 $err = mysql_error();
	 if(!empty($err)) {
	   $er++;
	 }
      }
    }
}

echo "\nLeidos $le - errores $er - ok = $ok\n";
desconectar();
fclose($fp);
?>
