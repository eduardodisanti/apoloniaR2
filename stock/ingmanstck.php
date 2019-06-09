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
echo "<head><title>Ingreso de pedidos</title>";
echo "<script>";
echo "
function actualizar()
{
  var xid;

    xid = document.getElementById &&
    document.getElementById ('articulo').value;

    xcant = document.getElementById && document.getElementById ('cantidad').value;

    id = document.getElementById &&
    document.getElementById ('almacen').value;

    var f = document.getElementById('frm');

    f.src = 'elingman.php?id='+id+'&cmd=actualizar';
}

function agregar()
{
  var xid;

  xid = document.getElementById &&
                        document.getElementById ('articulo').value;

  xcant = document.getElementById && document.getElementById ('cantidad').value;

  id = document.getElementById &&
                          document.getElementById ('almacen').value;

  lote = document.getElementById &&
                            document.getElementById ('lote').value;
  
  vence = document.getElementById &&
                            document.getElementById ('vence').value;
				
  var f = document.getElementById('frm');

  f.src = 'elingman.php?id='+id+'&articulo='+xid+'&cantidad='+xcant+'&lote='+lote+'&vence='+vence+'&cmd=add';
}

function recargar()
{
    id = document.getElementById &&
                              document.getElementById ('almacen').value;

  var f = document.getElementById('frm');

    f.src = 'elingman.php?id='+id;
}
";

echo "</script>";
echo "</head>";
echo "<body bgcolor='#ffffff'>";

//echo "<form action='pedido.php' method='post'>";
echo "<table width='850px' bgcolor='#880000'>";
echo "<tr>";
echo "   <td>Ingreso para la sucursal ";

echo "<select name='almacen' id='almacen'>";
 $query="select * from almacenes order by nombre";
 $qry = query($query);
  while($reg = fetch($qry))
   {
       $id = $reg->id;
       if($id==$almacen)
            $sel="selected";
      else
            $sel="";

       $nombre= $reg->nombre;
       echo "<option value='$id' $sel>$nombre</option>";
   }
echo "</select>";
echo "<input type='submit' value='Recargar' OnClick='recargar();'>";
echo "   </td>";
echo "</tr>";
echo "</table>";

echo "<iframe src='elingman.php?id=$almacen' width=850px height=250 id=frm>";
echo "</iframe>";

echo "<table border=0 bgcolor='#cccccc' width=850px>";
echo "<tr>";
echo "<td>";

echo "<select name='articulo' id='articulo' length=100>";
$query="select id, nombre, unidadAlmacen from articulos order by nombre";
$qry = query($query);
while($reg = fetch($qry))
 {
    $id = $reg->id;
    $nombre = $reg->nombre;
    $unidad = $reg->unidadAlmacen;
  
    echo "<option value='$id'>$nombre - POR $unidad (almacen)</option>";
 }

echo "</select>";
echo "</td>";
echo "<td>Cantidad</td>";
echo "<td><input type='text' name='cantidad' id='cantidad' length=3 size=3></td>";
echo "</tr>";
echo "<tr>";
echo "<td>Lote <input type='text' name='lote' id='lote' length=12 size=12 value='$lote'>";
echo " Vence <input type='text' name='vence' id='vence' length=10 size=10 value='$vence'></td>";
echo "<td><input type='submit' name='cmd' value='Agregar' OnClick='agregar();'></td>";
echo "</tr>";
echo "<tr>";
echo "<td colspan=3 align=center>";
echo "<input type='submit' name='cmd' value='Actualizar' OnClick='actualizar();'></td>";
echo "</tr>";
echo "</table>";
//echo "</form>";

?>

