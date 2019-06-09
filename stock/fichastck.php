<?php
require_once("class/Mateo.phpm");

session_start();
//$m = $_SESSION['mateo'];
//$tema = $m->getTema();


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
echo "<head><title>Ficha de stock</title>";
echo "<script>";
echo "

function recargar()
{
    id = document.getElementById &&
                              document.getElementById ('articulo').value;

  var f = document.getElementById('frm');

    f.src = 'lafichastck.php?id='+id;

  var ff = document.getElementById('frm1');

    ff.src = 'existencia.php?id='+id;
}
";

echo "</script>";
echo "</head>";
echo "<body bgcolor='#ffffff'>";

//echo "<form action='pedido.php' method='post'>";
echo "<table width='850px' bgcolor='#880000'>";
echo "<tr>";
echo "   <td>Ficha de ";

echo "<select name='articulo' id='articulo' length=100>";

$query="select id, nombre, unidadAlmacen from articulos order by nombre";
$qry = query($query);
while($reg = fetch($qry))
 {
    $id = $reg->id;
    $nombre = $reg->nombre;
    $unidad = $reg->unidadAlmacen;
    
    if($id==$articulo)
      $sel="selected";
    else
     $sel="";
    echo "<option value='$id' $sel>$nombre - POR $unidad</option>";
 }

echo "</select>";
echo "<input type='submit' value='Recargar' OnClick='recargar();'>";
echo "   </td>";
echo "</tr>";
echo "</table>";

echo "<iframe src='lafichastck.php?id=$articulo&fechadesde=$fechadesde&fechahasta=$fechahasta' width=850px height=250 id=frm>";
echo "</iframe>";

echo "<iframe src='existencia.php?id=$articulo' width=850px height=100 id=frm1>";
echo "</iframe>";
echo "</table>";
//echo "</form>";

?>

