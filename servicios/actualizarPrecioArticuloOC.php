<?php

require("../functions/db.php");
$link=conectar();

$hoy=Date("Y-m-d");

$query = "select precio from OrdenDeCompra where proveedor=$proveedor and articulo=$articulo and numero=0";
$qry = query($query);
$resultado = filas($qry);


if($resultado==0)			// **** NO EXISTE !!!!
		$query1 = "insert into OrdenDeCompra values($proveedor, $articulo, 0, $precio, 0, 0, 0, '$hoy')";
else
		$query1 = "update OrdenDeCompra set precio=$precio where proveedor=$proveedor and articulo=$articulo and numero=0";
		
query($query1);
$error = mysql_error();

if(empty($error))
  $result = number_format($precio,2,'.',',');
else
  $result = $error;
  
echo $result;
?>
