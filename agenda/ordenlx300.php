<?php

   $orden="";
   sprintf($set,"%cC%c",27,36); // Setear largo de pagina a 36 lineas
   
   $anio=strtok($fecha,"-");
   $mes=strtok("-");
   $dia=strtok("-");
   $fechaLinda="$dia/$mes/$anio";
      
   $linea01 = sprintf("%cC.A.D.I  Medica Uruguaya Tarjeta de Cita\n\n",14);
   $linea02 = sprintf("Paciente : %s\n\n",$nombrePaciente);
   $linea03 = sprintf("Medico   : %c%s\n\n",14,$medico);
   $linea04 = sprintf("%s\n\n",$proc);
   $linea05 = sprintf("Paciente citado para %c%cx1%s - %s - nro: %s%cx0\n\n",14,27,$fechaLinda, $hora, $lugar,27);
   $linea06 = sprintf("C.A.D.I:  8 de Octubre 2492 Tel.: 480-2063\n\n");
   $linea07 = sprintf("%cInformacion de interes:\n",14);
   $linea08 = sprintf("Las URGENCIAS son atendidas de lunes a viernes de 08:00 a 22:00 hrs y sabados de 08:00 a 19:00 hrs.\n");
   $linea09 = sprintf("El paciente debe presentarse con documento de Identidad y recibo vigente.\n");
   $linea10 = sprintf("NUEVO SERVICIO DE ATENCION TELEFONICA PARA  ANOTACIONES, CANCELACIONES Y CONSULTAS EN GENERAL.\n");
   $linea11 = sprintf("Tel: 480 2063 (FAVOR ACLARAR A LA TELEFONISTA EN QUE SUCURSAL SE ASISTE USTED).\n");
   $linea12 = sprintf("HORARIO DE LUNES A VIERNES  DE 08:00 A 20:00 HRS Y S�ADOS DE 08:00 A 13:00 HRS.\n");   
   $linea13 = sprintf("Usted puede cancelar su hora hasta 15 minutos antes de la hora de cita, de lo contrario no podra ser anotado nuevamente por 30 dias\n"); 
   $linea14 = sprintf("\n\n\n\n\n\n\n\n\n\n\n\n\n\n");
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
	$ff;

   $fp=fopen("tmp/ci$ced.prn","w");	
   fputs($fp, $orden);
   fclose($fp);

   exec("lpr -P lp1 tmp/ci$ced.prn");

   unlink("tmp/ci$ced.prn");
?>
<script>
window.close();
</script>
