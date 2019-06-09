<?php

include("functions/db.php");

session_start();

conectar();


$paciente    = $pac;
$pieza       = $diente;
$estado      = $est;
$procedimiento = $proc;
$comentario  = $coment;
$usuario     = $usr;
$fecha       = date("Y-m-d");


$q = "insert into ProximaVez values($paciente, $procedimiento, '', '$fecha', '', 0, $pieza, 0)";
query($q);

$q = "update ProximaVez set Procedimiento=$procedimiento, Numero=$pieza, Fecha='$fecha' where Paciente=$paciente";
query($q);
$err = $err.mysql_error();

if(empty($err))
   $ret = "ACK";
   else
      $ret = "NAK+".$q.$err;
         
	 desconectar();

	 echo $ret;
?>
