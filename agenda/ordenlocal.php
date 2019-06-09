<?php

   $orden="";
   sprintf($set,""); // Setear largo de pagina a 36 lineas
   
   $anio=strtok($fecha,"-");
   $mes=strtok("-");
   $dia=strtok("-");
   $fechaLinda="$dia/$mes/$anio";
      
   $linea01 = sprintf("C.A.D.I Tarjeta de Cita - HT-TCG-01%c\n\n",13);
   $linea02 = sprintf("Paciente : %s%c\n\n",$nombrePaciente,13);
   $linea03 = sprintf("Medico   : %s%c\n\n",$medico,13);
   $linea04 = sprintf("%s%c\n\n",$proc,13);
   $linea05 = sprintf("Paciente citado para %s - %s - nro: %s%c\n\n",$fechaLinda, $hora, $lugar,13);
   $linea06 = sprintf("C.A.D.I:  8 de Octubre 2492 Tel.: 480-2063%c\n",13);
   $linea07 = sprintf("Informacion de interes:%c\n",13);
   $linea08 = sprintf("El paciente debe presentarse con documento de Identidad y recibo vigente.%c\n",13);\n",13);
   $linea09 = sprintf("Las URGENCIAS son atendidas de lunes a viernes de 08:00 a 22:00 hrs y sabados de 08:00 a 19:00 hrs.%c\n",13);
   $linea10 = sprintf("POR ANOTACIONES, CANCELACIONES Y CONSULTAS EN GENERAL DIRIJASE A NUESTRO SERVICIO DE ATENCION TELEFONICA%c\n",13);
   $linea11 = sprintf("Tel: 480 2063 (FAVOR ACLARAR A LA TELEFONISTA EN QUE SUCURSAL SE ASISTE USTED).%c\n",13);
   $linea12 = sprintf("DE LUNES A VIERNES  DE 08:00 A 20:00 HRS Y SABADOS DE 08:00 A 13:00 HRS.%c\n",13);
   $linea13 = sprintf("Usted puede cancelar su hora hasta 15 minutos antes de la hora de cita, de lo contrario no podra ser anotado nuevamente por 30 dias%c\n",13); 
   $linea14 = sprintf("Usted podra confirmar sus asistencia hasta 30 mintuos pasados la hora de cita%c\n",13); 
   $linea15 = sprintf("%c\n\n\n\n\n\n\n\n\n\n\n",13);
   //$ff = sprintf("%c",12);
   $ff = "";
   
   $orden= $set.
	$linea01.
	$linea02.
	$linea03.
	$linea04.
	$linea05.
	$linea06.
	$linea07.
	$linea08.
	$linea09.
	$linea10.
	$linea11.
	$linea12.
	$linea13.
	$linea14.
	$linea15.
	$ff;

   $ced=Date("U");
   if(empty($ced))
      $ced=1;

/*   $fp=fopen("tmp/ci$ced.prn","w");
   fputs($fp, $orden);
   fclose($fp);

   exec("lpr -P lp1 tmp/ci$ced.prn");

   unlink("tmp/ci$ced.prn");
   */

   echo $orden; 
?>
<script>
window.close();
</script>

