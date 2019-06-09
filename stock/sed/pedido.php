<?php
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
function agregar()
{
  var xid;

  xid = document.getElementById &&
                        document.getElementById ('articulo').value;

  xcant = document.getElementById && document.getElementById ('cantidad').value;

  id = document.getElementById &&
                          document.getElementById ('almacen').value;
  var f = document.getElementById('frm');

  f.src = 'elpedido.php?id='+id+'&articulo='+xid+'&cantidad='+xcant+'&cmd=add';
}

function recargar()
{
    id = document.getElementById &&
                              document.getElementById ('almacen').value;

  var f = document.getElementById('frm');

    f.src = 'elpedido.php?id='+id;
}
";

echo "</script>";
echo "</head>";
echo "<body bgcolor='#ffffff'>";

//echo "<form action='pedido.php' method='post'>";
echo "<table width='800px' bgcolor='#880000'>";
echo "<tr>";
echo "   <td>Pedido para la sucursal ";

echo "<select name='almacen' id='almacen'>";
echo "<option value='0'>---Elegir---</option>";
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
echo "<input type='submit' value='Recargar' OnClick='recargar();'>$almacen";
echo "   </td>";
echo "</tr>";
echo "</table>";

echo "<iframe src='elpedido.php?id=$almacen' width=860 height=340 id=frm>";
echo "</iframe>";

echo "<table border=0 bgcolor='#cccccc'>";
echo "<tr>";
echo "<td>";

echo "<select name='articulo' id='articulo'>";
$query="select id, nombre, unidadAlmacen from articulos order by nombre";
$qry = query($query);
while($reg = fetch($qry))
 {
    $id = $reg->id;
    $nombre = $reg->nombre;
    $unidad = $reg->unidadAlmacen;
  
    echo "<option value='$id'>$nombre - POR $unidad</option>";
 }

echo "</select>";
echo "</td>";
echo "<td>Cantidad</td>";
echo "<td><input type='text' name='cantidad' id='cantidad' length=3 size=3></td>";
echo "<td><input type='submit' name='cmd' value='Agregar' OnClick='agregar();'></td>";
echo "</tr>";
echo "</table>";
//echo "</form>";

?>

