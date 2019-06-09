<?php

include("functions/db.php");

session_start();

conectar();


$paciente    = $pac;
$pieza       = $diente;
$piezaHasta  = $dienteHasta;
$estado      = $est;
$procedimiento = $proc;
$comentario  = $coment;
$usuario     = $usr;
$fecha       = date("Y-m-d");
$hora        = date("H:i:s");


$q = "delete from ParaHacer where Paciente=$paciente and Pieza=$pieza and PiezaHasta=$piezaHasta and Procedimiento=$proc";
query($q);

$q = "insert into actosmedicos values($usuario, '$fecha', '$hora', $paciente, 'R','N')";
query($q);

$err = mysql_error();

if(empty($err))
   $ret = "ACK";
else
   $ret = "delParaHacer.do*NAK+".$err.$q;
   
desconectar();

echo $ret;
?>