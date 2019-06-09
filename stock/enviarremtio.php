<?php

require("../functions/db.php");
$link=conectar();

if($cmd=='ud')
         {  
         	$hoy=date("Y-m-d");
	    $query = "update pedidos set saldo = saldo - ($cantidad), enviados = enviados + ($cantidad), fecha='$hoy' where almacen=$id and articulo=$articulo";
	    //die($query);  
	    query($query);
	 }

if(empty($orden))
   $orden='nombre';
   
echo "<body bgcolor='#ffffff'>";
$query = "select almacen, articulo, cantidad, nombre, unidadAlmacen, saldo, enviados, fecha from pedidos, articulos where almacen= $id and articulos.id = articulo order by $orden";

$qry = query($query);

echo "<table width='99%' bgcolor='#000000' cellspacing='1'>";
echo "<tr bgcolor='#cccccc'><th>&nbsp;</th>";
echo "<th>";
echo "     <a href='elpedidocentral.php?id=$id&orden=nombre'>Articulo</a>";
echo "</th><th>Pedido";
echo "</th><th>Saldo</th><th>Enviando</th><th>Unidad</th><th>";
echo "     <a href='elpedidocentral.php?id=$id&orden=fecha desc,nombre'>Enviado</a>";
echo "</th></tr>";
while($reg=fetch($qry))
{
  $art = $reg->articulo;
  $nom = $reg->nombre;
  $can = $reg->cantidad;
  $uni = $reg->unidadAlmacen;
  $sal = $reg->saldo;
  $fec = $reg->fecha;
  $env = $reg->enviados;
  
  if($fec=='0000-00-00')
     $fec="";
  
  $eps = "elpedidocentral.php?id=$id&articulo=$art&cmd=ud";
  echo "<tr bgcolor='#ffffff'>";
  echo "   <td>";
  echo "       <a href='$eps'><img src='img/editar16.png' border=0></a>";
  echo "   </td>";
  echo "   <td>$nom</td>";
  echo "   <td align=right>$can</td><td align=right>$sal</td>";
  echo "<td align=center>";
  if($env > 0) {
      echo "   <a href='$eps&cantidad=-$env&orden=$orden'><<</a>";  
      echo "   <a href='$eps&cantidad=-1&orden=$orden'>-</a> ";
  }
  echo "$env";
  if($env < $sal) {
      echo "   <a href='$eps&cantidad=1&orden=$orden'>+</a>";
       echo "   <a href='$eps&cantidad=$sal&orden=$orden'>>></a>";
  }
  echo "</td>";
  
  echo "   <td align=center>";
  echo "$uni";
  echo "   </td>";
  echo "   <td align=center>$fec</td>";
  echo "</tr>";
}
echo "</table>";

?>

