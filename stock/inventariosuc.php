<?php
session_start();

$mialmacen=$_SESSION['almacen_coi_ses'];

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
echo "<head><title>Lista de inventario</title>";
echo "</head>";
echo "<body bgcolor='#ffffff'>";

$f1 = Date("Y-m-d");

$q = "select id, nombre, unidadCompra, unidadAlmacen, factorAlmacen, factorExpedicion, unidadExpedicion from articulos where nombre > ' ' order by nombre";
$query = query($q);
$err = mysql_error();

if(!empty($error))
   die($err);

echo "<table width='850px' border=1>";
echo "<tr>";
echo "   <td colspan=5>Listado de inventario de fecha $f1";
echo "</tr>";

echo "<tr bgcolor='cccccc'><th>Articulo</th><th>Entradas</th><th>Salidas</th><th>Existencias</th><th>Almacen</th><th>Expedicion</th></tr>";
while($reg = fetch($query))
{
    $art = $reg->id;

    $qq="select * from stock where almacen=$mialmacen and articulo=$art";
    $q=query($qq);
    $err = mysql_error();

    if(!empty($err))
       die($err);


    $r = fetch($q);
    $saldo = $r->entradas - $r->salidas;

    if(!empty($r->entradas)) {
        echo "<tr>";
        echo "   <td>";
        echo "         $reg->nombre";
        echo "   </td>";
        echo "   <td width=10% align='right'>";
        echo "      $r->entradas";
        echo "   </td>";
        echo "   <td width=10% align='right'>";
        echo "      $r->salidas";
        echo "   </td>";
        echo "   <td width=10% align='right'>";
        echo "      $saldo";
        echo "   </td>";
        echo "   <td width=10%>";
        echo $reg->factorAlmacen." x ".$reg->unidadAlmacen;
        echo "   </td>";
            echo "   <td width=10%>";
            echo $reg->factorExpedicion." x ".$reg->unidadExpedicion;
            echo "   </td>";
        echo "</tr>";
    }
}
echo "</table>";

?>