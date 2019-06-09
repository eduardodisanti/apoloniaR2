<?php

session_start();
$coisucursal_ses=$_SESSION['coisucursal_ses'];

function date_diff($date2, $date1)
  {
      $s = strtotime($date2) - strtotime($date1);
      $d = intval($s/86400);
      return($d);
  }
if(empty($cmd))
  $cmd=bajar;

require("../../functions/db.php");
$link=conectar();


echo "<center><h4>Cantidad de trabajos en una misma pieza -</h4></center>";
if(empty($comando))
 {

     echo "<form action='repepieza.php' method=post>\n";
     echo "<center><table border = 0 width='60%'>\n";
     $hoy=Date("Y-m-d");
     echo "<tr>";
     echo "  <td>Fecha desde<input type='text' name='desde' value='$hoy'></td>";
     echo "  <td>Fecha hasta<input type='text' name='hasta' value='$hoy'></td>";
     echo "</tr>";
     echo "<tr><td colspan=2><input type='submit' name='comando' value='Ejecutar'></td></tr>";
     echo "</table></center>\n";

     echo "</form>\n";
 }
else
 {

$query = "select Paciente, Pieza, count(*) as cuenta from HistTrabSoc where Episodio=8 and Pieza !=0 and Fecha <='$desde' and Fecha >='$fechahasta' group by Paciente,Pieza order by Pieza, Paciente";

echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "  <th>Pieza</th>";
echo "  <th>Cantidad</th>";
echo "</tr>\n";

$pacAnt=0;
$repA = 0;
$total = 0;
$q = query($query);
echo mysql_error();
while($reg = fetch($q))
 {
	$pieza = $reg->Pieza;
	$rep    = $reg->cuenta;
	$pac    = $reg->Paciente;

       if($rep > 1) {
                if($pieza != $pacAnt) { 
			echo "<tr bgcolor='#ffffff'>";
			echo "  <td>$pieza</td>";
			echo "  <td align='right'>$repA</td>";
			echo "</tr>\n";

			$pacAnt = $pieza;
			$total = $total + $repA;
			$repA   = 0;
		} else 
		          $repA+=$rep;
	}
 }
echo "<tr bgcolor='#ffffff'>";
echo "  <td>Total</td>";
echo "  <td align='right'>$total</td>";
echo "</tr>\n";

  echo "</table>";
  echo " <center><a href='javascript:window.print()'>Imprimir</a></center>";
}
?>
