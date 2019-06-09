<?php

require_once("marca.phpm");
require_once("tarjeta.phpm");
require_once("Usuario.phpm");

$tarjeta = new Tarjeta();
$tarjeta->setDB("mysql");
$tarjeta->setFuncionario($funcionario);

$u = $tarjeta->Funcionario;
$laclave = $u->clave;

if($laclave==$clave)
 {
	$anio=Date("Y");
	$mes =Date("m");
	$tarjeta->setAnio($anio);
	$tarjeta->setMes($mes);

	$m = new Marca();
	$m->ahora();
	$tarjeta->nuevaMarca($m);
	include("imprimirtarjeta.phtml");
	tablaT($tarjeta);
 } 
   else
      {
       $PROBLEMA="La clave no es correcta";
       include("marcar.php");
      }
?>
