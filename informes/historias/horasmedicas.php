<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2//EN">
<html>
<head>

  <meta http-equiv="CONTENT-TYPE" content="text/html; charset=iso-8859-1">
  <title></title>

  <meta name="GENERATOR" content="StarOffice/5.2 (Win32)">

<style type="text/css">
     A:link  {color:#9A3D3F}
     A:visited {color:#9A3D3F}
     A:hover {color: #C44487}

     BODY{font-family: 'Lucida Sans',serif}
</style>
</head>

<body bgcolor="#cccccc">
<center>
<Font size=6>Horas medicas</font><hr>
<form action="horasmedicas.php" method="post">
<?php

function calculoHoras($inicial, $final) {

   $hh1 = strtok($inicial,":");
   $mm1 = strtok(":");
   $ss1 = strtok(":");

   $hh2 = strtok($final,":");
   $mm2 = strtok(":");
   $ss2 = strtok(":");

   $hhd = $hh2 - $hh1;
   $mmd = $mm2 - $mm1;
   $ssd = $ss2 - $ss1;

   if($mmd < 0) {
      $hhd++;
      $mmd = 60 + $mmd;
   }

   if($mmd == 60) {
      $hhd++;
      $mmd = 0;
   }

   //$x = sprintf("%02d:%02d", $hhd, $mmd);
   $x = $hhd * 100 + $mmd;
   return($x);
}


 $link=mysql_connect("elias","root","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");

 if(empty($comando))
  {
    $hoy=date("Ymd");
    echo "<b>Paso 1</b>, Ingrese las fechas  <br>";
   echo "<input type=\"hidden\" name=\"comando\" value=\"Paso2\">\n";
  }

if($comando=="Paso2")
  {
    echo "<input type=\"hidden\" name=\"fecha1\" value=\"$fecha1\" length=8 maxlength=8>";
    echo "<input type=\"hidden\" name=\"fecha2\" value=\"$fecha2\" length=8 maxlength=8>";


    $Xci=$ci;
    $codproc=strtok($proc,") ");
    if(empty($fecha1))
      $fecha1=date("Ymd");

   if(empty($fecha2))
      $fecha2=date("Ymd");

 if($medico==0)
  {
      $med1 = 0;
      $med2 = 999999;
  }
    else
      {
           $med1 = $medico;
           $med2 = $medico;
      }

$orden = "Medicos.Nombre, Cedula, Fecha, Turno, Hora";
    $query=mysql_query("select Horarios.Fecha, Horarios.Turno, Horarios.Consultorio, Horarios.Medico,Medicos.Nombre,Medicos.Numero as codmed, Medicos.Cedula, 
                             Horarios.Hora, Horarios.HoraCita
                        from Horarios, Medicos where 
				                     Fecha >= '$fecha1' and Fecha <= '$fecha2' and 
                                                     Horarios.Medico >= $med1 and Horarios.Medico <= $med2 and
                                                     Horarios.Medico = Medicos.Numero
                                        order by $orden") or
                       die("Error en horarios : ".mysql_error());

    echo "<table border=1 width=80%>\n";
    echo "<tr align=center bgcolor=\"#FFFFFF\"><th colspan=2>Titulares</th></tr>\n";
    echo "<tr align=center bgcolor=\"#FFFFFF\">";
    echo "   <th>Medico</th>\n";
    echo "   <th>Horas Trabajadas</th>\n";
    echo "</tr>\n";
    $color="#ACCCCC";

    $efectivas = 0;

    $medicoAnt = 0;
    $horaAnt   = 0;
    $fechaAnt = "";
    $totalTitulares = $totalSuplentes = 0;

while($rowi=mysql_fetch_object($query)) {

          $Turno=$rowi->Turno;
          $Consultorio=$rowi->Consultorio;
          $codmed = $rowi->codmed;
          $Fecha  = $rowi->Fecha;
	  $cita   = $rowi->Hora;
	  $cedula = $rowi->Cedula;

          if($fechaAnt=="")
	      $fechaAnt=$Fecha;

          if($fechaAnt != $Fecha) {

              $efectivas += calculoHoras($horaInicial, $horaFinal);
	      $totalTitulares+= calculoHoras($horaInicial, $horaFinal);

	      $horaInicial = $cita;
	      $horaFinal   = $cita;
	      $fechaAnt    = $Fecha;
	  }

          if($medicoAnt!=$cedula) {
	    if($medicoAnt!=0)
	        {
		    $efectivas+= calculoHoras($horaInicial, $horaFinal);
		    $totalTitulares+= calculoHoras($horaInicial, $horaFinal);
		    $efectivas = $efectivas / 100; 
		    $resto = $efectivas % 100;
		    echo "<tr>\n";
	            echo "      <td>$Medico</td>";
		    $xefectivas = number_format($efectivas, 0, ".",",");
                    echo "      <td align=right>$xefectivas</td>";
	            echo "</tr>\n";
		}
	        $horaInicial = $cita;
		$horaFinal = $cita;
                $medicoAnt = $cedula;
                $contratadas = $efectivas = $faltas = 0;
		$Medico = $rowi->Nombre;
		$fechaAnt = $Fecha;
	  }

          $q = "select Suplente from Suplentes where Fecha='$Fecha' and Turno=$Turno and Consultorio='$Consultorio'";
	  $rq = mysql_query($q);
	  $qreg = mysql_fetch_object($rq);
	  $Suplente = $qreg->Suplente;

	  if(empty($Suplente))
	      $horaFinal = $cita;
       }

         $efectivas+= calculoHoras($horaInicial, $horaFinal);
	 $totalTitulares+=calculoHoras($horaInicial, $horaFinal);

	 $efectivas = $efectivas / 100;
	 $resto = $efectivas % 100;
         echo "<tr>\n";
         echo "      <td>$Medico</td>";
	 $xefectivas = number_format($efectivas, 0, ".",",");
         echo "      <td align=right>$xefectivas</td>";
         echo "</tr>\n";

         $totalTitulares = $totalTitulares / 100;
         echo "<tr>\n";
         echo "      <td>$totalTitulares</td>";
	 $xtotalTitulares = number_format($totalTitulares, 0, ".", ",");
         echo "      <td align=right>$xtotalTitulares</td>";
         echo "</tr>\n";


    echo "</table>\n";

    $orden = "Medicos.Nombre, Medicos.Cedula, Horarios.Fecha, Horarios.Turno, Horarios.Hora";
    $query=mysql_query("select Horarios.Fecha, Horarios.Turno, Horarios.Consultorio, Suplente,Medicos.Nombre,Medicos.Numero as codmed, Cedula, 
                              Horarios.Hora, Horarios.HoraCita
    		                                          from Horarios, Medicos, Suplentes where
			                                                               Horarios.Fecha >= '$fecha1' and Horarios.Fecha <= '$fecha2' and
			                                                               Suplente >= $med1 and Suplente <= $med2 and
			                                                               Suplente             = Medicos.Numero and
										       Horarios.Fecha       = Suplentes.Fecha and
                                                                                       Horarios.Consultorio = Suplentes.Consultorio and
										       Horarios.Turno       = Suplentes.Turno
			                                          order by $orden") or
			 die("Error en horarios : ".mysql_error());

       echo "<table border=1 width=80%>\n";
       echo "<tr align=center bgcolor=\"#FFFFFF\"><th colspan=2>Suplentes</th></tr>\n";
       echo "<tr align=center bgcolor=\"#FFFFFF\">";
       echo "   <th>Medico</th>\n";
       echo "   <th>Horas Trabajadas</th>\n";
       echo "</tr>\n";
       $color="#ACCCCC";

       $efectivas = 0;

       $medicoAnt = 0;
       $horaAnt   = 0;
       $Medico    = "";
       $horaInicial = $horaFinal = "00:00:00";
       $fechaAnt="";
       $efectivas = 0;
      while($rowi=mysql_fetch_object($query)) {

         $Turno=$rowi->Turno;
         $Consultorio=$rowi->Consultorio;
         $Medico = $rowi->Nombre;
         $codmed = $rowi->codmed;
         $Fecha  = $rowi->Fecha;
         $cita   = $rowi->Hora;
	 $cedula = $rowi->Cedula;

          if($fechaAnt=="")
	                $fechaAnt=$Fecha;

          if($fechaAnt != $Fecha) {
                $efectivas      += calculoHoras($horaInicial, $horaFinal);
                $totalSuplentes += calculoHoras($horaInicial, $horaFinal);;

                $horaInicial = $cita;
                $horaFinal   = $cita;
                $fechaAnt = $Fecha;
          }

         if($medicoAnt!=$cedula) {
                if($medicoAnt!=0)
                 {
                     $efectivas      += calculoHoras($horaInicial, $horaFinal);
		     $totalSuplentes += calculoHoras($horaInicial, $horaFinal);;
		     $efectivas = $efectivas / 100;
                     echo "<tr>\n";
                     echo "      <td>$Medico</td>";
		     $xefectivas = number_format($efectivas, 0, ".",",");
                     echo "      <td align=right>$xefectivas</td>";
                     echo "</tr>\n";
		     $efectivas = 0;
                 }
         $horaInicial = $cita;
         $horaFinal = $cita;
         $medicoAnt = $cedula;
         $contratadas = $efectivas = $faltas = 0;
	 $Medico = $rowi->Nombre;
      }
      $horaFinal = $cita;
   }
   $efectivas+= calculoHoras($horaInicial, $horaFinal);
   $totalSuplentes += calculoHoras($horaInicial, $horaFinal);
   $efectivas = $efectivas / 100;
   $xefectivas = number_format($efectivas, 0, ".",",");
   echo "<tr>\n";
   echo "      <td>$Medico</td>";
   echo "      <td align=right>$xefectivas</td>";
   echo "</tr>\n";

   $totalSuplentes = $totalSuplentes / 100;
   $xtotalSuplentes = number_format($totalSuplentes, 0, ".",",");
   echo "      <td>Horas Suplentes</td>";
   echo "      <td align=right>$xtotalSuplentes</td>";

   echo "<tr>\n";
   echo "      <td>Horas totales</td>";
   $total = ($totalTitulares + $totalSuplentes);
   $xtotal = number_format($total, 0, ".",",");
   echo "      <td align=right>$xtotal</td>";
   echo "</tr>\n";

echo "</tr>\n";

   echo "</table>\n";
 } 
echo "Fecha desde: <input type=\"text\" name=\"fecha1\" value=\"$fecha1\" size=10><br>";
echo "Fecha hasta: <input type=\"text\" name=\"fecha2\" value=\"$fecha2\" size=10><br><br>";

mysql_close();
?>

   <br>
   <input type="submit" name="comando" value="Paso2">
   <hr>
<?php
   echo "<font size=+2><a href=\"index.php\">Menu principal</a></font>";
?>
</form>
</body>
</html>
