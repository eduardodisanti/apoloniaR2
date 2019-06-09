<?php
function date_diff($date2, $date1)
  {
      $s = strtotime($date2) - strtotime($date1);
      $d = intval($s/86400);
      return($d);
  }
if(empty($cmd))
  $cmd=bajar;


echo "<center><h4>Vencimiento de trabajos de laboratorio</h4></center><hr>";
if(empty($comando))
 {
     echo "<form action='../informes/venctrab.php' method=post>\n";
     echo "<center><table border = 0 width='60%'>\n";
     echo "<tr>";
     echo "   <td>Fecha vencimiento desde (AAAA-MM-DD)</td>";
     echo "   <td><input type='text' width='10' name='FECHADESDE'></td>";
     echo "</tr>";
     echo "<tr>";
     echo "   <td>Fecha vencimiento  hasta (AAAA-MM-DD)</td>";
     echo "   <td><input type='text' width='10' name='FECHAHASTA'></td>";
     echo "</tr>";
     echo "<tr>";
     echo "   <td><input type='submit' name='comando' value='Ejecutar'></td>";
     echo "   <td>&nbsp;&nbsp</td>";
     echo "</tr>";
     echo "</table></center>\n";
     echo "<input type='hidden' name='comando' value='$cmd'>";
     echo "</form>\n";
 }
else
 {
 
    require("../functions/db.php");
    $hoy = Date("Y-m-d");
     if(empty($FECHADESDE))
          $FECHADESDE=$hoy;
     if(empty($FECHAHASTA))
        $FECHAHASTA = $hoy;
     $link=conectar();
     
     if($accion=="bajar")
        {
	  $query = "update TrabSoc set Entregado='S' where Paciente=$pac and Trabajo=$trabajo and Fecha='$fecha'";
	  $q = query($query);
	  $query = "insert into HistTrabSoc values($pac, $trabajo, '$hoy', 'E')";
          $q = query($query);
	}
     
     // *********** primero determino cual es el procedimiento mas largo
     
     $query = "select tiempo from Trabajos order by tiempo desc";
     $q = query($query);
     $reg= fetch($q);
     $tiempomax = $reg->tiempo;

echo "Lista de trabajos que vencen entre $FECHADESDE y $FECHAHASTA<br>";
     
     $FECHADESDE = $FECHADESDE;
     $FECHADESDE = date("Y-m-d", strtotime("-$tiempomax day ".$FECHADESDE));

$query = "select Paciente, Trabajo, Fecha, descripcion, tiempo, Nombre from TrabSoc, Trabajos, Pacientes where Fecha >= '$FECHADESDE' and Fecha <='$FECHAHASTA' and Trabajo = id and Paciente = Cedula and Entregado='N' order by Paciente, Fecha,descripcion";
echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "	<th colspan=2>Paciente</th>";
echo "	<th>Procedimiento</th>";
echo "	<th>Solicitado</th>";
echo "	<th>Vencimiento</th>";
echo "  <th>Accion</th>";
echo "</tr>\n";

$q = query($query);
while($reg = fetch($q))
 {
	$cedula = $reg->Paciente;
	$nombre = $reg->Nombre;
	$trabajo= $reg->Trabajo;
	$desctra= $reg->descripcion;
	$tiempo = $reg->tiempo;
	$fecha  = $reg->Fecha;
	$vence = date("Y-m-d", strtotime("+$tiempo day ".$fecha));

         if($vence >= $FECHADESDE && $vence <= $FECHAHASTA)
          {	
		echo "<tr bgcolor='#ffffff'>";
		echo "  <td>$nombre</td>";
		echo "  <td align='center'>$cedula</td>";
		echo "  <td>$desctra</td>";
		echo "	<td>$fecha</td>";
		echo "  <td>";
		if($cmd=="bajar")
		  {
		   echo "<a href='venctrab.php?cmd=bajar&accion=bajar&pac=$cedula&trabajo=$trabajo&fecha=$fecha&cmd=bajar&comando=seguir'>Marcar entregado</a>";
		  }
		echo "</td>";
		echo "<td>$vence</td>";
		echo "</tr>\n";
         }
 }
 echo "</table>";
}
?>
