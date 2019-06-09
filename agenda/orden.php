<body bgcolor="#A4D2DB">
<center>
<table border=0 width=90%>
<tr>
<td><font size=+2>CADI Medica Uruguaya</font></td>
<td align=right><Font size=3>Tarjeta de Cita</font></td>
</tr>
<br>
</table>
<?
   $anio=strtok($fecha,"-");
   $mes=strtok("-");
   $dia=strtok("-");
   $fechaLinda="$dia/$mes/$anio";
   echo "<table boder=0 width=95%>\n";
   echo "<tr>\n";
   echo "	<td>\n";
   echo "	Paciente:";
   echo "	</td>\n";
   echo "       <td>\n";
   echo "       $ced";
   echo "       </td>\n";
   echo "       <td>\n";
   echo "       $nombrePaciente";
   echo "       </td>\n";
   echo "</tr>\n";
   echo "<tr>\n";
   echo "       <td>\n";
   echo "       Medico:";
   echo "       </td>\n";
   echo "       <td>\n";
   echo "       $proc";
   echo "       </td>\n";
   echo "       <td>\n";
   echo "       <font size=+3>$medico</font>";
   echo "       </td>\n";
   echo "</tr>\n";
   echo "<tr>\n";
   echo "       <td>\n";
   echo "       Fecha:";
   echo "       </td>\n";
   echo "       <td>\n";
   echo "       <font size=+3>$fechaLinda</font>";
   echo "       </td>\n";
   echo "       <td>\n";
   echo "       <font size=+3>$Hora: $hora su n&uacute;mero es $lugar</font>";
   echo "       </td>\n";
   echo "</tr>\n";

   echo "</table>\n";
?>
<br>
<table width=95%>
<tr><td>&nbsp;&nbsp;</td></tr>
<tr><td>Centro Odontológico Integral: 8 de Octubre 2492 Tel.: 480-2063</td></tr>
</table>
<table border=0 width=95%>
<tr><td>
<U>Informaci&oacute;n de inter&eacute;s:</U><br>
Las <u>URGENCIAS</u> ser&aacute;tendidas de lunes a viernes de 08:00 a 22:00 hrs y s&aacute;bados de 08:00 a 19:00 hrs.<br>
El paciente deber&aacute; presentarse con C&eacute;dula de Identidad y recibo vigente.<br>
NUEVO SERVICIO DE ATENCIÓN TELEFÓNICA PARA  ANOTACIONES, CANCELACIONES Y CONSULTAS EN GENERAL.
Tel: 480 2063 (FAVOR DE ACLARAR A LA TELEFONISTA EN QUE SUCURSAL SE AsISTE USTED)<br>
HORARIO DE LUNES A VIERNES  DE 08:00 A 20:00 HRS Y SÁBADOS DE 08:00 A 13:00 HRS.<br>
Usted puede cancelar su hora hasta <b>15 minutos</b> antes de la hora de cita, de lo contrario no podrá se anotado nuevamente por un período de 30 días
</td></tr>
</table>
<script>window.print()</script>
<script>window.close()</script>
