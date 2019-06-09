<?php

require("../functions/db.php");
$link=conectar();

$query = "select precio from artprov where proveedor=$proveedor and articulo=$articulo";
$qry = query($query);
$resultado = filas($qry);


if($resultado==0)			// **** NO EXISTE !!!!
		$query1 = "insert into artprov values($proveedor, $articulo, $precio, 0)";
else
		$query1 = "update artprov set precio=$precio where proveedor=$proveedor and articulo=$articulo";

query($query1);
$error = mysql_error();

if(empty($error))
  $result = number_format($precio,2,'.',',');
else
  $result = $error;
  
echo $result;
?>
