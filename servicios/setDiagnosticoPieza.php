<?php

include("functions/db.php");

session_start();

conectar();


$paciente    = $pac;
$pieza       = $diente;
$estado      = $est;
$diagnostico = $diag;
$comentario  = $coment;
$usuario     = $usr;
$fecha       = date("Y-m-d");


$q = "insert into Diagnosticos values($paciente, $pieza, '$fecha', $diagnostico, '$comentario', $usuario)";
query($q);

$q = "update Diagnosticos set Diagnostico=$diagnostico, Comentario='$comentario' where Paciente=$paciente and Pieza=$pieza and Fecha='$fecha'";
query($q);
$err = $err.mysql_error();

$q = "insert into piezasPaciente values($paciente, $pieza, $estado)";
query($q);

$q = "update piezasPaciente set estado=$estado where paciente=$paciente and pieza=$pieza";
query($q);
$err = $err.mysql_error();

if(empty($err))
   $ret = "ACK";
   else
      $ret = "NAK+".$err;
         
	 desconectar();

	 echo $ret;
?>

