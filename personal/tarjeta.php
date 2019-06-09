<?php

require_once("marca.phpm");
require_once("tarjeta.phpm");
require_once("Usuario.phpm");

$tarjeta = new Tarjeta();
$tarjeta->setDB("mysql");
$tarjeta->setFuncionario($funcionario);

$anio=Date("Y");
$mes =Date("m");
$tarjeta->setAnio($anio);
$tarjeta->setMes($mes);


include("imprimirtarjeta.phtml");
tablaT($tarjeta);

?>
