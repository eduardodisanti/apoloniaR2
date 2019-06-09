<?php
require_once("class/Mateo.phpm");

session_start();
$m = $_SESSION['mateo'];
$tema = $m->getTema();
if(!isset($_SESSION['numeroTransferencia'])) {
  $numero=time();
  $_SESSION['numeroTransferencia'] = $numero;
} else
    $numero = $_SESSION['numeroTransferencia'];

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
echo "<head><title>Transferencias</title>";
echo "<script>";
echo "
function actualizar()
{
  var xid;

    xid = document.getElementById &&
    document.getElementById ('articulo').value;

    xcant = document.getElementById && document.getElementById ('cantidad').value;

    destino = document.getElementById &&
              document.getElementById ('almacen').value;
    numero  = document.getElementById && 
              document.getElementById('numero').value;

  var f = document.getElementById('frm');
    f.src = 'elremman.php?destino='+destino+'&numero='+numero+'&cmd=actualizar';
}

function agregar()
{
  var xid;

  xid = document.getElementById &&
                        document.getElementById ('articulo').value;

  xcant = document.getElementById && document.getElementById ('cantidad').value;

  numero = document.getElementById &&
                          document.getElementById ('numero').value;

  destino = document.getElementById &&
	                  document.getElementById ('almacen').value;

  lote = document.getElementById &&
                            document.getElementById ('lote').value;
  
  vence = document.getElementById &&
                            document.getElementById ('vence').value;
				
  var f = document.getElementById('frm');

  f.src = 'elremman.php?numero='+numero+'&articulo='+xid+'&cantidad='+xcant+'&lote='+lote+'&vence='+vence+'&destino='+destino+'&cmd=add';

}

function recargar()
{
    numero = document.getElementById &&
                              document.getElementById ('numero').value;

  var f = document.getElementById('frm');

  f.src = 'elremman.php?numero='+numero;
}
";

echo "</script>";
echo "</head>";
echo "<body bgcolor='#ffffff'>";

echo "<table width='850px' bgcolor='#880000'>";
echo "<tr>";
echo "   <td>Transferencia para la sucursal ";

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
echo " Numero <input type='text' id='numero' disabled size=12 value=$numero>";
echo "   </td>";
echo "</tr>";
echo "</table>";

echo "<iframe src='elremman.php?destino=$almacen&numero=$numero' width=850px height=250 id=frm>";
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
  
    echo "<option value='$id'>$nombre - POR $unidad</option>";
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

?>

