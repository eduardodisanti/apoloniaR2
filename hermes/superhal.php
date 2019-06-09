<?php

   session_start();

   $coiusuario = $_SESSION['coiusuario'];
   $coiclave   = $_SESSION['coiclave'];

   $minutos = Date("i") % 20;
         $hal = "http://hermes.kcreativa.com/script/hal3.php?cliente=111";

         $hand=fopen($hal,"r");
         while($x = fgets($hand))
	 {
	    $usuario = strtok($x, "|");
	    $sino    = strtok("|");
	    $cant    = strtok("|");
            $fp = fopen("respuestas/$usuario", "w");
	    fprintf($fp, "$sino|$cant");
	    fclose($fp);
	 }
?>
