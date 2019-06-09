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



echo "<center><h4>Ciclos de consumo entre $FECHADESDE y $FECHAHASTA</h4></center><hr>";
if(empty($comando))
 {
      $query="select * from articulos order by nombre";
      $qry = query($query);
  echo mysql_error();

     echo "<form action='../stock/ciclos.php' method=post>\n";
     echo "<select name='articulo'>";
     echo "<option value='0'>Todos</option>";
     while($reg=fetch($qry))
       {
         echo "<option value='$reg->id'>$reg->nombre</option>"; 
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
    
echo "<table border=1'>";
echo "<tr bgcolor='#cccccc'>";
echo "	<th>Articulo</th>";
echo "  <th>Unidad expedicion</th>";
echo "	<th>Entradas</th>";
echo "	<th>Salidas</th>";
echo "	<th>Saldo</th>";
echo "</tr>\n";

$nombant="";
$query = "select articulo, nombre, unidadExpedicion, Movstock.Codigo as ES, sum(Unidades) as uni from articulos, Movstock where id=Articulo and Fecha >= '$FECHADESDE' and Fecha <= '$FECHAHASTA' group by nombre, Movstock.Codigo order by articulos.familia, nombre, Movstock.Codigo";
$q = query($query);
echo mysql_error();
while($reg = fetch($q))
 {

        $idart    = $reg->articulo;
	$articulo = $reg->nombre;
        $ue       = $reg->unidadExpedicion;
	$tipomov  = $reg->ES;
	$uni      = $reg->uni;
	$unidad   = $reg->unidadExpedicion;

        $linkastock = "../../stock/fichastck.php?articulo=$idart&fechadesde=$FECHADESDE&fechahasta=$FECHAHASTA";

        if($nombant=="")
	   $nombant = $articulo;

	if($nombant != $articulo)
	   {
	       echo "<tr bgcolor='#dddddd'>";
	       echo "<td align='right' colspan=2>Total</td>";
	       echo "<td align='right'>$totent</td>";
	       echo "<td align='right'>$totsal</td>";
	       $saldo = $totent - $totsal;
	       echo "<td align='right'>$saldo</td>";
	       echo "</tr>\n"; 

	       $toten = 0;
	       $totsal= 0;
               $saldo = 0;
	   }

		echo "<tr bgcolor='#ffffff'>";
		echo "  <td align='left'>";
		echo "<a href='$linkastock'>$articulo</a>";
		echo "</td>";
	        echo "  <td align='left'>$unidad</td>";
		if($tipomov==1) {
		     $entradas = $uni;
		     echo "      <td align='right'>$entradas</td>";
		     echo "      <td align='right'>&nbsp;&nbsp</td>";
		     $totent+=$entradas;
		     $salidas = 0;
		} else
		       {
		            $salidas = $uni;
		            echo "      <td align='right'>&nbsp;&nbsp</td>";
		            echo "	<td align='right'>$salidas</td>";
			    $totsal+= $salidas;
			    $entradas = 0;
		       }
		$saldo+= $entradas - $salidas;
		echo "      <td align='right'>$saldo</td>";
		echo "</tr>\n";
 }

echo "<tr bgcolor='#dddddd'>";
echo "<td align='right' colspan=2>Total</td>";
echo "<td align='right'>$totent</td>";
echo "<td align='right'>$totsal</td>";
$saldo = $totent - $totsal;
echo "<td align='right'>$saldo</td>";
echo "</tr>\n";

echo "</table>";
}
?>

