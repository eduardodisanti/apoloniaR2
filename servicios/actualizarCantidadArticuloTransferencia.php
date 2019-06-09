<?php

require("../functions/db.php");
$link=conectar();

$query = "select * from transito where documento=$numero and articulo=$articulo";
$qry = query($query);
$reg = fetch($qry);

$entregado = $reg->entregado;
$cantidad  = $reg->cantidad;

$total = $entregado + $valor;

		$query1 = "update transito set entregado=$total where documento=$numero and articulo=$articulo";
		
query($query1);
$error = mysql_error();

if(empty($error))
  $result = $valor;
else
  $result = $error;
  
echo $result;
?>
