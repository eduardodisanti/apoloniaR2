<?php

   $orden="";
   sprintf($set," "); // Setear largo de pagina a 36 lineas
   
   $anio=strtok($fecha,"-");
   $mes=strtok("-");
   $dia=strtok("-");
   $fechaLinda="$dia  $mes  $anio";

   $hora     = strtok($hora,":");
   $minutos  = strtok(":");
   $horalinda= "$hora  $minutos";
      
   $linea01 = sprintf("%c\n\n\n\n",13);
   $linea02 = sprintf("                 %s%c\n",$ced,13);
   $linea03 = sprintf("                                                      %s%c\n",$seguro,13);
   $linea05 = sprintf("                  %s%c\n\n",$nombrePaciente,13);
   $linea06 = sprintf("                %s         %s%c\n\n",$fechaLinda, $horalinda, 13);
   $linea07 = sprintf("                %s%c\n\n",$medico,13);
  
   $ff="\n";
   $orden= $set.
	$linea01.
	$linea02.
	$linea03.
	$linea04.
	$linea05.
	$linea06.
	$linea07.
	$ff;

   $ced=Date("U");
   if(empty($ced))
      $ced=1;

   echo "Abriendo tmp/ci$ced.prn\n";
   $fp=fopen("tmp/ci$ced.prn","w");
   fputs($fp, $orden);
   fclose($fp);

   exec("lpr -P lp1 tmp/ci$ced.prn");

   echo "Orden: $orden";
//   unlink("tmp/ci$ced.prn");
?>
<script>
//window.close();
</script>

