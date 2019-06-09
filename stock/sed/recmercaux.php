<?php

echo "<script src='../ajax/kajax.js'></script>";
echo "<script>";
echo "
function modificar(numero, id, elemento, elemento1) 
{
  var xid, precio, resultado;
  
    xid =    document.getElementById(elemento);
    valor = xid.value;

    xidd=    document.getElementById(elemento1);
    valor1 = xidd.value;


    //alert(\"numero=\"+numero+\"&articulo=\"+id+\"&valor=\"+valor);
    // aca hago mi llamada tipo AJAX para actualizar esta fila
    
    ajax = nuevoAjax();
    
    ajax.open(\"POST\", \"../servicios/actualizarCantidadArticuloTransferencia.php\", true);
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
    ajax.send(\"numero=\"+numero+\"&articulo=\"+id+\"&valor=\"+valor);
}
";
echo "</script>";

require("../functions/db.php");
$link=conectar();

$color="#cccccc";
$p=0;

echo "<table border=0 bgcolor='#000000' width=100% cellspacing=1>";
echo "<tr bgcolor='#ccccff'><th>Articulo</th><th>Remanente</th><th>Entregado</th></tr>";

$query="select almacen, articulo, nombre, fecha, cantidad, entregado, lote from transito, articulos where documento = $numero and articulos.id = transito.articulo order by nombre";
$qry = query($query);

while($reg = fetch($qry))
 {
    $id = $reg->articulo;
    $nombre = $reg->nombre;
    $unidad = $reg->unidadCompra;
    $cantidad=$reg->cantidad;
    $entregado=$reg->entregado;
    $remanente=$cantidad - $entregado;
        
    $eid = "e".$id;
    $eeid= "ee".$id;

    $xprecio = number_format($precio, 2, ".",",");
    echo "<tr bgcolor='$color'><td>$nombre</td><td align='right'><input id='$eeid' size=9 value='$remanente' disabled></td>";
    echo "<td align=right>";
    if($remanente != 0)
       echo "<input id='$eid' size=9 value='$remanente' onBlur='modificar($numero, $id, \"$eid\", \"$eeid\")'>";
    else
       echo "&nbsp;";
    echo "</td></tr>";
 }

echo "</td>";
echo "</tr>";
echo "</table>";
?>
