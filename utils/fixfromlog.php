<?php

include("../functions/db.php");

$db = conectar();

$a = "/usr/mysql/mysql/log/625.log.sql";
$fp = fopen("$a", "r");

while($reg=fgets($fp)) {

  $tok = strtok($reg, "/*/");

  $epi = substr($tok, 12, 9);

//  echo "EPI ES:*".$epi."*\n";
  if($epi == "Episodios") {

     query($tok);
     echo $tok."\n";
  }

}

desconectar();
fclose($fp);
?>
