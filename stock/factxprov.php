<?php

echo "<script src='../ajax/kajax.js'></script>";
echo "<script>";
echo "
function modificar(numero, id, elemento, elemento1, rid, remito) 
{
  var xid, precio, resultado;
  
    xid =    document.getElementById(elemento);
    valor = xid.value;

    xidd=    document.getElementById(elemento1);
    valor1 = xidd.value;
    
    ridd=    document.getElementById(rid);
    valor2 = ridd.value;
    


    //alert(\"numero=\"+numero+\"&articulo=\"+id+\"&valor=\"+valor+\"&lote=\"+rid+\"&remito=\"+remito+\"&cantidad=\"+valor);
    // aca hago mi llamada tipo AJAX para actualizar esta fila
    
    ajax = nuevoAjax();
    
    ajax.open(\"POST\", \"../servicios/actualizarCantidadArticuloFAC.php\", true);
    ajax.onreadystatechange=function(){    
    	if(ajax.readyState==4) {
    	   resultado = ajax.responseText;
    	   //alert(resultado);
    	   xid.value = resultado;
	   if(resultado == valor1)
	      xid.disabled = true;
	   xidd.value = Number(valor1) - Number(valor);
    	}
    }
 
    ajax.setRequestHeader(\"Content-Type\",\"application/x-www-form-urlencoded\");
    ajax.send(\"numero=\"+numero+\"&articulo=\"+id+\"&valor=\"+valor+\"&lote=\"+valor2+\"&remito=\"+remito+\"&cantidad=\"+valor);
}
";
echo "</script>";

require("../functions/db.php");
$link=conectar();

$color="#cccccc";
$p=0;

echo "<table border=0 bgcolor='#000000' width=100% cellspacing=1>";
echo "<tr bgcolor='#ccccff'><th>Orden de compra</th><th>Articulo</th><th>Cantidad</th><th>Precio</th><th>Saldo</th><th>Importe compra</th><th>Importe entregado</th></tr>";

if($numero!=0)
  $trozonumero = " numero = $numero ";
else
  $trozonumero = " proveedor = $prov ";
  
$query="select articulo, nombre, fecha, cantidad, saldo, numero, precio from OrdenDeCompra, articulos where $trozonumero and articulos.id = OrdenDeCompra.articulo and numero != 0 and cantidad !=0 order by nombre";

$qry = query($query);

while($reg = fetch($qry))
 {
    $id = $reg->articulo;
    $nombre = $reg->nombre;
    $unidad = $reg->unidadCompra;
    $cantidad=$reg->cantidad;
    $remanente=$reg->saldo;
    $numero = $reg->numero;
    $precio = $reg->precio;
    $saldo  = $reg->saldo;
        
    $eid = "e".$id;
    $eeid= "ee".$id;
    $rid=  "r".$id;

$entregado = $cantidad - $saldo;

    $xprecio = number_format($precio, 2, ".",",");
    $ximporte = number_format($precio * $cantidad, 2, ".",",");
    $xentregado = number_format($precio * $entregado, 2, ".",",");
    echo "<tr bgcolor='$color'><td>$numero</td><td>$nombre</td>";
    echo "<td align='right'>$cantidad</td>";
    echo "<td align=right>";
    echo "$xprecio";
    echo "</td>";    
    echo "<td align=right>";
    echo "$saldo";
    echo "</td>";
    echo "<td align=right>";
    echo "$ximporte";
    echo "</td>";
    echo "<td align=right>";
    echo "$xentregado";
    echo "</td>";
    //onBlur='modificar($numero, $id, \"$eid\", \"$eeid\", \"$rid\", $remito)'>";

    echo "</td></tr>";
 }

echo "</table>";
?>
