<?php
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


echo "<center><h4>Indicadores de Retrabajos x trabajo</h4></center><hr>";
if(empty($comando))
 {

     echo "<form action='retrabxtrab.php' method=post>\n";

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
     
echo "Lista de no conformidades entre $FECHADESDE y $FECHAHASTA<br>";
     
if($Laboratorio != 0)
  $limit = "where id = $Laboratorio";
else
  $limit="";

$query = " select Trabajo, descripcion, count(*) as cuenta from HistTrabSoc,Trabajos where Episodio=88 and Trabajo=id and Fecha >='$FECHADESDE' and Fecha <='$FECHAHASTA' group by Trabajo order by descripcion";
$q1 = query($query);

echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "	<th>Trabajo</th>";
echo "	<th>Cantidad</th>";
echo "</tr>\n";

while($q1reg = fetch($q1)) // ** para todos los trabajos
     {
	    $trab = $q1reg->Trabajo;
        $desc = $q1reg->descripcion;
	    $cant = $q1reg->cuenta;

         echo "<tr bgcolor='#ffffff'>";
         echo "	<td>$desc</td>";
         echo " <td align='right'>$cant</td>";
         echo "</tr>";
     }

 echo "</table>";
}

?>
<center><a href='javascript:window.print()'>Imprimir</a></center>
