<?php
require_once("class/Mateo.phpm");
session_start();
//$m = $_SESSION['mateo'];
//$tema = $m->getTema();

require("../functions/db.php");
$link=conectar();

if(empty($id))
   $id=1;
echo "<body bgcolor='#ffffff'>";
$query = "select articulos.nombre art, Entradas, Salidas from stock, articulos where id = articulo and stock.almacen=$almacen order by nombre";

$qry = query($query);

echo "<table width='99%' bgcolor='#000000' cellspacing='1'>";
echo "<tr bgcolor='#cccccc'><th>Articulo</th><th>Entradas</th><th>Salidas</th><th>Saldo</th></tr>";
while($reg=fetch($qry))
{

  $art = $reg->art;
  $ent = $reg->Entradas;
  $sal = $reg->Salidas;
  $sdo = $ent - $sal;
      
  echo "<tr bgcolor='#ffffff'>";
  echo "   <td>$art</td>";
  echo "   <td align=right>$ent</td>";
  echo "   <td align=right>$sal</td>";
  echo "   <td align=right>$sdo</td>";
  echo "</tr>";

}
echo "</table>";

?>

