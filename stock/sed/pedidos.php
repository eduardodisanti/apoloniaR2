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
echo "<head><title>Envio de pedidos</title>";
echo "<script>";
echo "
function crear()
{

  id = document.getElementById &&
                          document.getElementById ('almacen').value;
                          
  var f = document.getElementById('frm');

  f.src = 'enviarremito.php?id='+id+'&cmd=visualizar';
}

function imprimir()
{

  id = document.getElementById &&
                          document.getElementById ('almacen').value;
                          
  var f = document.getElementById('frm');

  f.src = 'enviarremito.php?id='+id+'&cmd=imprimir';
}

function enviar()
{

  id = document.getElementById &&
                          document.getElementById ('almacen').value;
                          
  var f = document.getElementById('frm');

  f.src = 'enviarremito.php?id='+id+'&cmd=enviar';
}

function recargar()
{
    id = document.getElementById &&
                              document.getElementById ('almacen').value;

  var f = document.getElementById('frm');

    f.src = 'elpedidocentral.php?id='+id;
}
";

echo "</script>";
echo "</head>";
echo "<body bgcolor='#ffffff'>";

//echo "<form action='pedido.php' method='post'>";
echo "<table width='860px' bgcolor='#880000'>";
echo "<tr>";
echo "   <td>Pedido para la sucursal ";

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

if(empty($almacen))
   $almacen=0;

echo "<iframe src='elpedidocentral.php?id=$almacen' width=860 height=340 id=frm>";
echo "</iframe>";

echo "<br><input type='submit' name='cmd' value='Preparar remito' OnClick='crear();'>";
//echo "<input type='submit' name='cmd' value='Imprimir' OnClick='imprimir();'>";
echo "<input type='submit' name='cmd' value='Enviar e imprimir' OnClick='enviar();'>";

?>

