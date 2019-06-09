<?php

echo "<script src='../ajax/kajax.js'></script>";
echo "<script>";
echo "
function modificar(numero, id, elemento, elemento1, rid, numero, remito) 
{
  var xid, precio, resultado;
  
    xid =    document.getElementById(elemento);
    valor = xid.value;

    xidd=    document.getElementById(elemento1);
    valor1 = xidd.value;
    
    ridd=    document.getElementById(rid);
    valor2 = ridd.value;
    

     if(remito==0) {
       alert(\"Error - debe ingresar numero de remito de proveedor\");
     } else {

//    alert(\"numero=\"+numero+\"&articulo=\"+id+\"&valor=\"+valor+\"&lote=\"+rid+\"&numero=\"+numero+\"&+\"&remito=\"+remito+\"&cantidad=\"+valor);
    // aca hago mi llamada tipo AJAX para actualizar esta fila
    
    ajax = nuevoAjax();
    
    ajax.open(\"POST\", \"../servicios/actualizarCantidadArticuloREM.php\", true);
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
    ajax.send(\"numero=\"+numero+\"&articulo=\"+id+\"&valor=\"+valor+\"&lote=\"+valor2+\"&numero=\"+numero+\"&cantidad=\"+valor+\"&remito=\"+remito);
 }
}
";
echo "</script>";

require("../functions/db.php");
$link=conectar();

$color="#cccccc";
$p=0;

echo "<table border=0 bgcolor='#000000' width=100% cellspacing=1>";
echo "<tr bgcolor='#ccccff'><th>Orden de compra</th><th>Articulo</th><th>Remanente</th><th>Lote</th><th>Entregado</th></tr>";

if($numero!=0)
  $trozonumero = " numero = $numero ";
else
  $trozonumero = " proveedor = $prov ";
  
$query="select articulo, nombre, fecha, cantidad, saldo, numero from OrdenDeCompra, articulos where $trozonumero and articulos.id = OrdenDeCompra.articulo and numero != 0 and cantidad !=0 order by nombre";

$qry = query($query);

while($reg = fetch($qry))
 {
    $id = $reg->articulo;
    $nombre = $reg->nombre;
    $unidad = $reg->unidadCompra;
    $cantidad=$reg->cantidad;
    $remanente=$reg->saldo;
    $numero = $reg->numero;
        
    $eid = "e".$id;
    $eeid= "ee".$id;
    $rid=  "r".$id;

    $xprecio = number_format($precio, 2, ".",",");
    echo "<tr bgcolor='$color'><td>$numero ($remito)</td><td>$nombre</td><td align='right'><input id='$eeid' size=9 value='$remanente' disabled></td>";
    echo "<td align=rigth>";
    if($remanente != 0)
       echo "<input id='$rid' size=9>";
    else
       echo "&nbsp;";
    echo "</td>";
    echo "<td align=right>";
    if($remanente != 0)
       echo "<input id='$eid' size=9 value='$remanente' onBlur='modificar($numero, $id, \"$eid\", \"$eeid\", \"$rid\", $numero, $remito)'>";
    else
       echo "&nbsp;";
    echo "</td></tr>";
 }

echo "</table>";
?>
