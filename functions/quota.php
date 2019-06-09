<?php

  $MAXCUOTA = 100;

   function calcularQuotaUsada($email) { 

     $MAXCUOTA = 100;
                $usuario = strtok($email, "@");
   		$a = exec("du -sm /home/$usuario");

                $a = $a * 100 / $MAXCUOTA;
   		return($a);
  }
  function alertarSobreQuota($curr, $MAX) {


      $difa = $curr - $MAX;
      echo "<font color='#ff0000'>";
      echo "Usted esta exediendose en $difa MB de su cuota de disco de $MAX MB<br>Por favor <b>borre algunos de sus correos <b> inecesarios";
      echo "</font>"; 
      if($difa > $MAX)
         echo "<script>alert('El exceso de uso de disco es GRAVE - Borre algunos correos o el sistema lo hara por usted')</script>";
  }
?>
