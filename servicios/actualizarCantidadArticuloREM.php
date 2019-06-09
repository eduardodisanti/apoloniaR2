<?php

require("../functions/db.php");
$link=conectar();

$hoy=Date("Y-m-d");

$unidadAjuste=1;

$query0 = "select * from articulos where id=$articulo";
$qry = query($query0);

$reg=fetch($qry);
$unidad=$reg->factorAlmacen;

if(empty($unidad))
  $unidad=1;

$cantidad = $cantidad * $unidad;

$query = "select cantidad from OrdenDeCompra where articulo=$articulo and numero=$numero";

$qry = query($query);
$resultado = filas($qry);


if($resultado==0)			// **** NO EXISTE !!!!
	$query1 = "insert into OrdenDeCompra values($proveedor, $articulo, $cantidad, 0, $valor, $numero, '$hoy', $cantidad)";
else
	$query1 = "update OrdenDeCompra set saldo=saldo - $valor where articulo=$articulo and numero=$numero";
		
query($query1);
$error = mysql_error();

$query2 = "insert into remitos values ('$serie', $remito, $articulo, '$hoy', $cantidad, '$lote', '$vence', $numero)";
query($query2);

$error.=mysql_error();
$ahora = Date("H:i");
$query3 = "insert into Movstock values (1, $articulo, '$hoy', '$ahora', 0, 0,'R','$remito', $cantidad,'$usuario','$lote')";
query($query3);

$error.=mysql_error();
$query40 = "insert into stock values(0, $articulo, 0, 0, 0)";
query($query40);
$query4 = "update stock set entradas=entradas + $cantidad where almacen=0 and articulo=$articulo";
query($query4);
$error.=mysql_error();

$query41 = "insert into lotes values('$lote','$vence',$articulo,$cantidad)";
query($query41);
// si existe no importa 

if(empty($error))
  $result = number_format($cantidad);
else
  $result = $error;
  
echo $result;
?>
