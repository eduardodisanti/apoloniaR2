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
echo "<head><title>Lista de vencimientos</title>";
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
if(!empty($f2))
   $fhasta = $f2;
else
   $fhasta="";

$yy = Date("Y");
$mm = Date("m");
$dd = Date("d");

$mm+=2;
if($mm > 12) {

    $yy++;
    $mm = $mm - 12;
}
   

if($dd >= 1 && $dd <= 10) {
   $f2 = "$yy-$mm-10";
   $f1 = "$yy-$mm-01";
}
else
   if($dd >= 11 && $dd <= 20) {
     $f2 = "$yy-$mm-20";
     $f1 = "$yy-$mm-11";
   }
   else {
          $f2 = "$yy-$mm-31";
	  $f1 = "$yy-$mm-21";
        }	

$f2 = "$yy-$mm-31";
$f1 = "$yy-$mm-01";

$hoy = Date("Y-m-d");

echo "<form action=''>";
echo "Fecha hasta: <input type='text' name='f2' value='$f2'>";
echo "<input type='submit' name='Recargar' value='Consultar'>";
echo "</form>";

if(!empty($fhasta))
   $f2 = $fhasta;

$q = "select lotes.id as lote, lotes.vence, articulo, articulos.nombre, cantidad from lotes, articulos where lotes.vence <='$f2' and lotes.vence >= '$hoy' and lotes.articulo = articulos.id order by lotes.vence, articulos.nombre";

$query = query($q);
echo mysql_error();
echo "<table width='850px' bgcolor='#CCCCCC'>";
echo "<tr>";
echo "   <td colspan=>Articulos que vencen entre $hoy y $f2";
echo "</tr>";
echo "<tr><th>Articulo</th><th>Lote</th><th>Vence</th><th>Almacen</th></tr>";
while($reg = fetch($query)) {

	echo "<tr>";
	echo "   <td>";
	echo "         $reg->nombre";
	echo "   </td>";
	echo "   <td>";
	echo "         $reg->lote";
	echo "   </td>";
	echo "   <td>";
	echo "         $reg->vence";
	echo "   </td>";
	echo "</tr>";
	echo "<tr>";

if(!empty($reg->lote)) {

  $qq = "select nombre from Movstock, almacenes where lote = '$reg->lote' and Destino = almacenes.id";
  $qquery = query($qq);

  $lista=0;
  while($qreg = fetch($qquery)) {
        $lista++;
	echo "<tr>";
	echo "   <td colspan=5>";
	echo "         $reg1->nombre";
	echo "   </td>";
	echo "</tr>";
   }
   if($lista==0) {
       echo "<tr bgcolor='#ffffff'>";
       echo "   <td colspan=4>";
       echo "         Sin transferencias registradas con este lote";
       echo "   </td>";
       echo "</tr>";

   }
 } else
       {
           echo "<tr>";
           echo "   <td colspan=3>";
           echo "         <font color='#ff0000'>Sin lote, no se puede rastrear mercaderia</font>";
           echo "   </td>";
	   echo "</tr>";
       }
}

echo "</table>";
?>

