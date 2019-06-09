<?php

include("functions/db.php");

session_start();

conectar();


$paciente    = $pac;
$pieza       = $diente;
$piezaHasta  = $dienteHasta;
$estado      = $est;
$procedimiento = $procedimiento;
$fecha = Date("Y-m-d");
$hora = Date("U");

conectar();
$q = "select Ordenes, ImporteTaller from Procedimientos where Codigo=$procedimiento";

$qry = query($q);
$reg = fetch($qry);

$ordenes = $reg->Ordenes;
$taller  = $reg->ImporteTaller;

$q = "insert into Deudas values($paciente, $procedimiento, $pieza, $ordenes, $taller)";
query($q);

$err = mysql_error();


query("insert into CuentaCorriente values($paciente,'$fecha','$hora', $pieza, $procedimiento,'D', $taller,'Y','S')");

$err = mysql_error();

if(empty($err))
   $ret = "ACK";
   else
      $ret = "NAK+".$err.$q;
         
	 desconectar();

	 echo $ret;
?>
