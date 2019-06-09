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


echo "<center><h4>Control de facturacion de laboratorios</h4></center><hr>";
if(empty($comando))
 {
      $query="select * from Laboratorios order by descripcion";
      $qry = query($query);

     echo "<form action='factlab.php' method=post>\n";
     echo "<select name='Laboratorio'>";
     echo "<option value='0'>Todos</option>";
     while($reg=fetch($qry))
       {
         echo "<option value='$reg->id'>$reg->descripcion</option>"; 
       }
     echo "</select>";
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
 
    $hoy = Date("Y-m-d");
     if(empty($FECHADESDE))
          $FECHADESDE=$hoy;
     if(empty($FECHAHASTA))
        $FECHAHASTA = $hoy;
     
echo "Lista de trabajos realizados entre $FECHADESDE y $FECHAHASTA<br>";
     
if($Laboratorio != 0)
  $limit = "and HistTrabSoc.Laboratorio = $Laboratorio";
else
  $limit="";

$query = "select Paciente, Trabajo, Fecha, Trabajos.descripcion, tiempo, Nombre, Laboratorios.descripcion as nombreLab from HistTrabSoc, Trabajos, Pacientes, Laboratorios where Fecha >= '$FECHADESDE' and Fecha <='$FECHAHASTA' and Trabajo = Trabajos.id and Paciente = Cedula and Trabajos.Facturable='S' and (Episodio >= 5) and Episodio !=88 $limit and HistTrabSoc.Laboratorio = Laboratorios.id group by HistTrabSoc.Paciente, HistTrabSoc.Fecha, HistTrabSoc.Trabajo order by HistTrabSoc.Laboratorio, Nombre, Fecha,descripcion";
echo $query;
echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "	<th colspan=2>Paciente</th>";
echo "	<th>Procedimiento</th>";
echo "	<th>Solicitado</th>";
echo "</tr>\n";

$q = query($query);
echo mysql_error();
$labANT="";

while($reg = fetch($q))
 {
	$cedula = $reg->Paciente;
	$nombre = $reg->Nombre;
	$trabajo= $reg->Trabajo;
	$desctra= $reg->descripcion;
	$tiempo = $reg->tiempo;
	$fecha  = $reg->Fecha;
        $nombreLab=$reg->nombreLab;

        if($nombreLab!=$labAnt)
	  {
	     echo "<tr><td colspan=4 bgcolor='#cccccc' align='center'><font size='+1'><b>$nombreLab</b></font></td></tr>";
	     $labAnt=$nombreLab;
	  }
		echo "<tr bgcolor='#ffffff'>";
		echo "  <td>$nombre</td>";
		echo "  <td align='center'>$cedula</td>";
		echo "  <td>$desctra</td>";
		echo "	<td>$fecha</td>";
		echo "</tr>\n";
 }
 echo "</table>";
}
?>
<center><a href='javascript:window.print()'>Imprimir</a></center>
