<?php
require_once("class/Mateo.phpm");

session_start();
$m = $_SESSION['mateo'];
$tema = $m->getTema();


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
echo "<head><title>Lista de stock de referencia para 10 dias</title>";

$query = "select almacenes.nombre as almnomb, articulos.nombre as artnomb, sum(unidades)/12 as ref from Movstock, almacenes, articulos where almacenes.id = Destino and articulos.id = Articulo and Fecha >='2008-01-01' group by Destino, Articulo order by almacenes.nombre, articulos.nombre";

$q = query($query);

$alm = "";

echo "<table border=1 bgcolor='#ffffff'>";
echo "<tr><th>Almacen</th><th>Articulo</th><th>Cantidad</th></tr>";
while($reg=fetch($q)) {

    $almnomb = $reg->almnomb;
    $artnomb = $reg->artnomb;

    if($alm != $almnomb) {
      $color="#cccccc";
      $alm = $almnomb;
    }
    else
      $color="#ffffff";

    $ref = $reg->ref;

    echo "<tr>";
    echo "   <td color='$color'>";
    echo "   $almnomb";
    echo "  </td>";
    echo "  <td>";
    echo "   $artnomb";
    echo "  </td>";
    echo "  <td align=right>";
    echo "  $ref";
    echo "  </td>";
    echo "</tr>";
}

echo "</table>";
?>

