<?php
session_start();

//if($_SESSION['coinivelusuario'] < 3)
//  die("Session no autorizada");
  
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
echo "<head><title>Ingreso de orden de remitos por proveedor</title>";
echo "<script src='../ajax/kajax.js'></script>";
echo "<script>";
echo "
function cambiarProveedor(prov) 
{
  var xid, remito;
  
   xid = document.getElementById &&
         document.getElementById ('numero').value;
             
         
         window.location='facturas.php?prov='+prov+'&numero='+xid;
}


function recargar()
{
    xid = document.getElementById &&
                              document.getElementById ('proveedor').value;


    window.location='facturas.php?prov='+xid;
}
";

echo "</script>";
echo "</head>";
echo "<body bgcolor='#ffffff'>";

if(empty($proveedor))
  $proveedor = $prov;
  
echo "<table width='99%' bgcolor='#aacccc'>";
echo "<tr>";
echo "   <td>Proveedor</td>";

echo "<td>";
echo "<select name='proveedor' id='proveedor' onChange='recargar()'>";
 $query="select * from proveedores order by nombre";
 $qry = query($query);
  while($reg = fetch($qry))
   {
       $id = $reg->id;
       if(empty($prov))
         $prov = $id;
         
       $nombre= $reg->nombre;
       if($id == $prov)
          $sel="selected";
       else
          $sel="";
          
       echo "<option value='$id' $sel>$nombre</option>";
   }
echo "</select>";
echo "<input type='submit' value='Recargar' OnClick='recargar();'>";
echo "&nbsp;&nbsp;";
//echo "<a href='imprimirrem.php?desde=$prov&hasta=$prov' target='_new'>Imprimir este remito</a>";
echo "   </td>";
echo "</tr>";
 $query="select * from proveedores where id=$prov";
 $qry = query($query);
 $reg = fetch($qry);
echo "<tr>";
echo "   <td>Telefono : </td>";
echo "   <td><b>";
echo $reg->telefono;
echo "</b>&nbsp;&nbsp;email : <b>";
echo $reg->mail;
echo "</b>&nbsp;&nbsp;Fax : <b>";
echo $reg->fax;
echo "   </b></td>";
echo "</tr>";
echo "<tr>";
echo "   <td>Contacto : </td>";
echo "   <td><b>";
echo $reg->contacto;
echo "</b>&nbsp;&nbsp;Domicilio :<b> ";
echo $reg->domicilio;
echo "   </b></td>";
echo "</tr>";
echo "<tr>";
echo "   <td>Forma de pago : </td>";
echo "   <td><b>";
echo $reg->formapago;
echo "   </b></td>";
echo "</tr>";
echo "</table>";
if(empty($numero))
	$numero=0;
echo "Factura <input type='text' name='numero' id='numero' onChange='cambiarOC($proveedor)' value=$numero>";
echo "<input type='submit' value='Validar factura' OnClick='validar();' disabled>";

echo "<iframe id='frm' src='factxprov.php?prov=$prov&numero=$numero&remito=$remito' width=99% height=295px border=0></iframe>";

?>