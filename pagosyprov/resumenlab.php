<?php
function date_diff($date2, $date1)
  {
      $s = strtotime($date2) - strtotime($date1);
      $d = intval($s/86400);
      return($d);
  }
if(empty($cmd))
  $cmd=bajar;

require("../functions/db.php");
$link=conectar();


    $hoy = Date("Y-m-d");
echo "<center><h4>Resumen de trabajos asignados a laboratorios</h4></center><hr>";
      $query="select Laboratorio, Laboratorios.descripcion as lab, count(TrabSoc.Paciente) as cant from TrabSoc, Laboratorios where Fecha='$hoy' and Laboratorios.id = TrabSoc.Laboratorio and Entregado <= 4 group by TrabSoc.Laboratorio order by descripcion";
      $qry = query($query);
echo mysql_error();
 
echo "Lista de trabajos que del dia $hoy asignados a laboratorios<br>";
     
echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "	<th colspan=1>Laboratorio</th>";
echo "	<th>Cantidad de trabajos</th>";
echo "</tr>\n";

while($reg = fetch($qry))
 {
	$lab    = $reg->lab;
	$cant   = $reg->cant;
	$id     = $reg->Laboratorio;

	echo "<tr bgcolor='#ffffff'>";
	echo "<td>$id) $lab</td>";
	echo "<td>$cant</td>"; 
	echo "</tr>\n";
 }
 echo "</table>";
?>

<center><a href='#' onclick='window.print()'>Imprimir</a></center>

