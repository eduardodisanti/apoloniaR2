<?php

echo "<script src='../ajax/kajax.js'></script>";
echo "<script>";
echo "
function modificar(prov, id, elemento) 
{
  var xid, precio, resultado;
  
    xid =    document.getElementById(elemento);
    precio = xid.value;

    // aca hago mi llamada tipo AJAX para actualizar esta fila
    
    ajax = nuevoAjax();
    
    ajax.open(\"POST\", \"../servicios/actualizarPrecioArticuloProveedor.php\", true);
    ajax.onreadystatechange=function(){    
    	if(ajax.readyState==4) {
    	   resultado = ajax.responseText;
    	   //alert(resultado);
    	   xid.value = resultado;
    	}
    }
    
    ajax.setRequestHeader(\"Content-Type\",\"application/x-www-form-urlencoded\");
    ajax.send(\"proveedor=\"+prov+\"&articulo=\"+id+\"&precio=\"+precio);
}
";
echo "</script>";

require("../functions/db.php");
$link=conectar();

$color="#cccccc";
$p=0;

echo "<table border=0 bgcolor='#000000' width=100% cellspacing=1>";
echo "<tr bgcolor='#ccccff'><th>Articulo</th><th>Unidad de compra</th><th>Precio</th></tr>";

$query="select id, nombre, unidadCompra from articulos where nombre > ' ' order by nombre";
$qry = query($query);
while($reg = fetch($qry))
 {
    $id = $reg->id;
    $nombre = $reg->nombre;
    $unidad = $reg->unidadCompra;
    
    $pq="select * from artprov where proveedor=$prov and articulo=$id";
    $pqr = query($pq);
    $pqrreg = fetch($pqr);
    $precio = $pqrreg->precio;
    if(empty($precio))
         $precio=0;
         
    $xprecio = number_format($precio, 2, ".",",");
    echo "<tr bgcolor='$color'><td>$nombre</td><td>$unidad</td>";
    echo "<td align=right>";
    $eid = "e".$id.$prov;
    echo "<input id='$eid' size=9 value=$xprecio onBlur='modificar($prov, $id, \"$eid\")'>";
    echo "</td></tr>";
 }

echo "</td>";
echo "</tr>";
echo "</table>";
?>