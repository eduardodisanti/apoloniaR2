<?php

echo "<script src='../ajax/kajax.js'></script>";
echo "<script>";
echo "

function eliminarArticulo(prov, id) {

  var xid, resultado;
  
  var precio = 0;

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

function modificarPrecio(prov, id, elemento) 
{
  var xid, precio, resultado;
  
    xid =    document.getElementById(elemento);
    precio = xid.value;

    // aca hago mi llamada tipo AJAX para actualizar esta fila
    
    ajax = nuevoAjax();
    
    ajax.open(\"POST\", \"../servicios/actualizarPrecioArticuloOC.php\", true);
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

function modificarCantidad(prov, id, elemento) 
{
  var xid, cantidad, resultado;
  
    xid =    document.getElementById(elemento);
    cantidad = xid.value;

    // aca hago mi llamada tipo AJAX para actualizar esta fila
    
    ajax = nuevoAjax();
    
    ajax.open(\"POST\", \"../servicios/actualizarCantidadArticuloOC.php\", true);
    ajax.onreadystatechange=function(){    
    	if(ajax.readyState==4) {
    	   resultado = ajax.responseText;
    //	   alert(resultado);
    	   xid.value = resultado;
    	}
    }
    
    ajax.setRequestHeader(\"Content-Type\",\"application/x-www-form-urlencoded\");
    ajax.send(\"proveedor=\"+prov+\"&articulo=\"+id+\"&cantidad=\"+cantidad);
}

";


echo "</script>";

require("../functions/db.php");
$link=conectar();

$color="#cccccc";
$p=0;

echo "<table border=0 bgcolor='#000000' width=100% cellspacing=1>";
echo "<tr bgcolor='#ccccff'><th>acc</th><th>Articulo</th><th>Unidad de compra</th><th>Cantidad</th><th>Precio</th></tr>";

$query="select id, nombre, unidadCompra from articulos where nombre > ' ' order by nombre";

$qry = query($query);
while($reg = fetch($qry))
 {
    $id = $reg->id;
    $nombre = $reg->nombre;
    $unidad = $reg->unidadCompra;
    
    $pq="select * from OrdenDeCompra where proveedor=$prov and articulo=$id and numero=0";
    $pqr = query($pq);

    $pqrreg = fetch($pqr);
    $precio = $pqrreg->precio;
    if(empty($precio))
         $precio=0;
    $cantidad = $pqrreg->cantidad;
    if(empty($cantidad))
         $cantidad=0;
         
/*    $cantidadproforma = $pqrreg->cantidad;
    if(empty($cantidadproforma))
       $cantidadproforma=0;
       
    if($cantidadproforma==0) {

      $profq = query("select cantidad from Proforma where articulo=$id");
      $profr = fetch($profq);
      $cantproforma = $profr->cantidad;
      if(empty($cantproforma))
         $cantproforma = -1;

      query("update OrdenDeCompra set cantidadproforma=$cantproforma where proveedor=$prov and articulo=$id and numero=0");
      //echo "update OrdenDeCompra set cantidadproforma=$cantproforma ".mysql_error();
    }
    
    if($cantproforma != -1) {
       $cantidad = $cantidaproforma;
    }
   */
    $apq="select precio from artprov where proveedor=$prov and articulo=$id";
    $apqr = query($apq);

    $areg = fetch($apqr);
   
    $precioartp = $areg->precio;
    if(empty($precioartp))
      $precioartp = 0;
      
    if($precioartp !=0 || empty($precioartp)) {

    		$xprecio = number_format($precio, 2, ".",",");
    		echo "<tr bgcolor='$color'>";
    		echo "<td>";
    		echo "    <a href='#' onclick='javascript:eliminarArticulo($prov, $id)'><img src='img/borrar16.png' border=0></a>";
    		echo "</td>";
    		echo "<td>$nombre</td><td>$unidad</td>";
    		echo "<td align=right>";
    		$eid = "ec".$id.$prov;
    		echo "<input id='$eid' size=9 value='$cantidad' onBlur='modificarCantidad($prov, $id, \"$eid\")'>";
    		echo "</td>";
    		echo "<td align=right>";
    		$eid = "ep".$id.$prov;
    		echo "<input id='$eid' size=9 value='$xprecio' onBlur='modificarPrecio($prov, $id, \"$eid\")'>";
    		echo "</td></tr>";
   }
 }

echo "</td>";
echo "</tr>";
echo "</table>";
?>
