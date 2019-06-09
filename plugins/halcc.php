<?php

   session_start();

   $coiusuario = $_SESSION['coiusuario'];
   $coiclave   = $_SESSION['coiclave'];
   $ultimoestadohermes = $_SESSION['ultimoestadohermes'];

   $minutos = Date("i") % 20;
   if($minutos == 0 || empty($ultimoestadohermes))
     {
         $hal = "http://hermes.kcreativa.com/script/hal.php?cliente=111&usuario=".urlencode($coiusuario);

         $hand=fopen($hal,"r");
         $x = fgets($hand); 
	 $_SESSION['ultimoestadoermes']=$x;
     } else 
            $x="$ultimoestadohermes";
  if(empty($x))
    $x="X|0";

   echo $x;
?>
