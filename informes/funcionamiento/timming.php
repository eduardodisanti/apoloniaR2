<?php
function date_diff($date2, $date1)
  {
      $s = strtotime($date2) - strtotime($date1);
      $d = intval($s/86400);
      return($d);
  }

echo "<center><h2>Tiempo de espera en sala de espera</h2></center><hr>";
if(empty($comando))
 {
     echo "<form action='timming.php' method=post>\n";
     echo "<center><table border = 0 width='60%'>\n";
     echo "<tr>";
     echo "   <td>Fecha desde (AAAA-MM-DD)</td>";
     echo "   <td><input type='text' width='10' name='FECHADESDE'></td>";
     echo "</tr>";
     echo "<tr>";
     echo "   <td>Fecha hasta (AAAA-MM-DD)</td>";
     echo "   <td><input type='text' width='10' name='FECHAHASTA'></td>";
     echo "</tr>";
     echo "<tr>";
     echo "   <td><input type='submit' name='comando' value='Ejecutar'></td>";
     echo "   <td>&nbsp;&nbsp</td>";
     echo "</tr>";
     echo "</table></center>\n";
     echo "</form>\n";
 }
else
 {
     if(empty($FECHADESDE))
          $FECHADESDE='2003-07-01';
     if(empty($FECHAHASTA))
        $FECHAHASTA = '2003-12-31';
     $link=mysql_connect("elias","root","virgen");
     $db = mysql_select_db("apolonia");

     $q1 = mysql_query("select count(Paciente) as Cuenta from Horarios where Paciente != 0 and Fecha >= '$FECHADESDE' and Fecha <= '$FECHAHASTA'");
     $reg = mysql_fetch_object($q1);
     $Consultas = $reg->Cuenta;
     echo "Numero de consultas hasta desde $FECHADESDE hasta $FECHAHASTA : <b>$Consultas</b><br>\n";

     $consultas = 0;
     $espera = 0;
     $revs   = 0;
     $maximo = 0;
     $minimo = 9999999999;

     $consultas = 0;
     $revs   = 0;
     $maximo = 0;
     $minimo = 9999999999;

     $minutos = 0;
     $renglones = 0;
     $promedio = 0;
     $lerdos = 0;

           $q2 = mysql_query("select timediff(horaAtencion, horaIngreso) as prom from timing where Fecha >= '$FECHADESDE' and Fecha <= '$FECHAHASTA'");
       while($regq2 = mysql_fetch_object($q2))
	  {
               $espera = $regq2->prom;

	       $hh1 = strtok($espera,":");
               $mm  = strtok(":");
	       $ss  = strtok(":");


	       if($hh1 >=0 ) {
	          $minutos+= $mm + $hh1 * 60;
		  $renglones++;

		  if($minutos > $maximo)
                       $maximo = $minutos;
		  if($minutos < $minimo)
		     $minimo = $minutos;

		  if($minutos > 30)
		     $lerdos++;
 	       }
	  }


      $promedio = number_format($minutos / $renglones, 4);

      $porcentajelerdos = $lerdos * 100 / $Consultas;

      echo "<h3>El promedio de tiempo entre fechas es de <b>$promedio</b></h3>";
      echo "<h3>Los pacientes que esperaron mas de 30 minutos fueron <b>$lerdos</b> es decir <b>$porcentajelerdos %</b></h3>";
      echo "<hr>\n";
 }
?>
