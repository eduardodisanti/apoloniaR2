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


$q = "insert into ParaHacer values($paciente, $pieza, $piezaHasta, $procedimiento, '$comentario', $usuario)";
query($q);

$err = mysql_error();

$q = "update ParaHacer set Procedimiento=$procedimiento, Comentario='$comentario' where Paciente=$paciente and Pieza=$pieza and Procedimiento=$procedimiento and PiezaHasta=$piezaHasta";
query($q);

$err = mysql_error();

$q = "insert into actosmedicos values($usuario, '$fecha', '$hora', $paciente, 'R','N')";
query($q);
$err.= mysql_error();

if(empty($err))
   $ret = "ACK";
   else
      $ret = "addParaHacer-NAK+".$err;
         
	 desconectar();

	 echo $ret;
?>
