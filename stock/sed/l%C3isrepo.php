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
echo "<head><title>Lista de inventario</title>";
echo "</head>";
echo "<body bgcolor='#ffffff'>";

$f1 = Date("Y-m-d");

$q = "select id, nombre from articulos where nombre > ' ' order by familia, nombre";
$query = query($q);
echo mysql_error();
echo "<table width='850px' border=1>";
echo "<tr>";
echo "   <td colspan=5>Listado para inventario de fecha $f1";
echo "</tr>";

echo "<tr bgcolor='cccccc'><th>Articulo</th><th>Existencias</th><th>&nbsp;&nbsp</th><th>&nbsp;&nbsp</th><th>&nbsp;&nbsp</th></tr>";
while($reg = fetch($query))
{
    $art = $reg->id;

    $qq="select * from Stock where Lugar=0 and articulo=$art";
    $q=query($qq);

    $r = fetch($q);
    $saldo = $r->Entradas - $r->Salidas;

	echo "<tr>";
	echo "   <td>";
	echo "         $reg->nombre";
	echo "   </td>";
	echo "   <td width=10% align='right'>";
	echo "      $saldo";
	echo "   </td>";
	echo "   <td width=10%>";
	echo "     &nbsp;&nbsp";
	echo "   </td>";
	echo "   <td width=10%>";
	echo "     &nbsp;&nbsp";
	echo "   </td>";
        echo "   <td width=10%>";
        echo "     &nbsp;&nbsp";
        echo "   </td>";
	echo "</tr>";
}
echo "</table>";

?>
