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
$query = "select almacenes.nombre as alm, Entradas, Salidas from stock, almacenes where Articulo=$id and almacen = almacenes.id order by almacenes.nombre";

$qry = query($query);

echo "<table width='99%' bgcolor='#000000' cellspacing='1'>";
echo "<tr bgcolor='#cccccc'><th>Almacen</th><th>Entradas</th><th>Salidas</th><th>Saldo</th></tr>";
while($reg=fetch($qry))
{

  $alm = $reg->alm;
  $ent = $reg->Entradas;
  $sal = $reg->Salidas;
  $sdo = $ent - $sal;
      
  echo "<tr bgcolor='#ffffff'>";
  echo "   <td>$alm</td>";
  echo "   <td align=right>$ent</td>";
  echo "   <td align=right>$sal</td>";
  echo "   <td align=right>$sdo</td>";
  echo "</tr>";

}
echo "</table>";

?>

