<?php

require("../functions/db.php");
$link=conectar();

if($cmd=='dl')
 {
   $query = "delete from tmppedidos where almacen=$id and articulo=$articulo";
   query($query);
 }
  else
    if($cmd=='add')
         { 
	    if($id==0)
	       die("Error, debe elegir un almacen");
	    $query = "insert into tmppedidos values($id, $articulo, $cantidad, $cantidad, '$coiusuario')";  
	    query($query);
	 }

echo "<body bgcolor='#ffffff'>";
$query = "select almacen, articulo, cantidad, nombre, unidadAlmacen from tmppedidos, articulos where almacen= $id and articulos.id = articulo order by nombre";

$qry = query($query);

echo "<table width='99%' bgcolor='#000000' cellspacing='1'>";
echo "<tr bgcolor='#cccccc'><th>&nbsp;</th><th>Articulo</th><th>Cantidad</th><th>Unidad</th></tr>";
while($reg=fetch($qry))
{
  $art = $reg->articulo;
  $nom = $reg->nombre;
  $can = $reg->cantidad;
  $uni = $reg->unidadAlmacen;

  echo "<tr bgcolor='#ffffff'>";
  echo "   <td>";
  echo "       <a href='elpedido.php?id=$id&articulo=$art&cmd=dl'><img src='../img/basura.png' border=0></a>";
  echo "   </td>";
  echo "   <td>$nom</td>";
  echo "   <td>$can</td>";
  echo "   <td align=center>$uni</td>";
  echo "</tr>";
}
echo "</table>";

?>

