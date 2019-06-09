<?php
session_start();

if($_SESSION['coinivelusuario'] < 3)
  die("Session no autorizada");
  
function cabezal_proveedor($prov) {

 $query= "select valor from numeradores where id='ordencompra'";
 $qry  = query($query);
 $reg  = fetch($qry);
 
 $numeroOC = $reg->valor;
 query("update numeradores set valor=valor+1 where id='ordencompra'");
 
 
 $query="select * from proveedores where id=$prov";
 $qry = query($query);
 $reg = fetch($qry);
 
echo "<table width='99%' bgcolor='#aacccc'>";
echo "<tr>";
echo "   <td align=left>Orden de Compra No <b>$numeroOC</b></td><td align=right><img src='../img/logo.png' width=64px></td>";
echo "</tr>";
echo "<tr>";
echo "   <td colspan=2><font size=+2>$reg->nombre</font>&nbsp;&nbsp;<a href='http://$reg->web'>$reg->web</a></td>";;
echo "</tr>";
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
       echo "<table border=0 bgcolor='#000000' width=100% cellspacing=1>";
	   echo "<tr bgcolor='#ccccff'><th>Articulo</th><th>Unidad de compra</th><th>Precio</th><th>Cantidad</th><th>Importe</th></tr>";

  return($numeroOC);
}

require("../functions/db.php");
$link=conectar();

$color="#cccccc";
$p=0;

$numeroOC = cabezal_proveedor($desde);
$ant = $desde;

$query="select id, nombre, unidadCompra, precio, proveedor, cantidad from articulos, OrdenDeCompra where nombre > ' ' and id = OrdenDeCompra.articulo and proveedor >= $desde and proveedor <= $hasta and cantidad > 0 and numero = 0 $filtro order by proveedor, nombre";

$qry = query($query);

while($reg = fetch($qry))
 {
    $id = $reg->id;
    $nombre = $reg->nombre;
    $unidad = $reg->unidadCompra;
    $proveedor = $reg->proveedor;
    $cantidad = $reg->cantidad;
    
    if($proveedor != $ant) {
       if($ant!=0)
         echo "</table>";
       cabezal_proveedor($proveedor);
       $ant = $proveedor;
    }
    
    $precio = $reg->precio;
    if(empty($precio))
         $precio=0;
    $importe = $cantidad * $precio;   
    $total += $importe;
    $xprecio = number_format($precio, 2, ".",",");
    $ximporte = number_format($importe, 2, ".",",");
    echo "<tr bgcolor='$color'><td>$nombre</td><td>$unidad</td>";
    echo "<td align=right>";
    echo "$xprecio";
    echo "</td>";
    echo "<td align=right>";
    echo "$cantidad";
    echo "</td>";    
    echo "<td align=right>";
    echo "$ximporte";
    echo "</td>";
    echo "</tr>";
 }
 
    $xtotal = number_format($total, 2, ".",",");
    echo "<tr bgcolor='#ffffff'>";
    echo "<td align=right colspan=4>";
    echo "Total : ";
    echo "</td>";    
    echo "<td align=right>";
    echo "$xtotal";
    echo "</td>";
    echo "</tr>";
    
echo "</td>";
echo "</tr>";
echo "</table>";

$hoy = Date("Y-m-d");

$query = "update OrdenDeCompra set numero = $numeroOC, fecha='$hoy' where proveedor = $desde and numero = 0";
$qry = query($query);

?>
