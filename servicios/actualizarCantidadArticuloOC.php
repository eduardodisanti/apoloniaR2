<?php

require("../functions/db.php");
$link=conectar();

$hoy=Date("Y-m-d");

$query = "select cantidad from OrdenDeCompra where proveedor=$proveedor and articulo=$articulo and numero=0";
$qry = query($query);
$resultado = filas($qry);


if($resultado==0)			// **** NO EXISTE !!!!
		$query1 = "insert into OrdenDeCompra values($proveedor, $articulo, $cantidad, 0, $cantidad, 0, '$hoy', $cantidad)";
else
		$query1 = "update OrdenDeCompra set cantidad=$cantidad, cantidadproforma = $cantidad, saldo=$cantidad where proveedor=$proveedor and articulo=$articulo and numero=0";
		
query($query1);
$error = mysql_error();

if(empty($error))
  $result = number_format($cantidad);
else
  $result = $error;
  
echo $result;
?>
