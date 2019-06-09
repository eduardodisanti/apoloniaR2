<?php

require_once("marca.phpm");
require_once("tarjeta.phpm");
require_once("Usuario.phpm");

$tarjeta = new Tarjeta();
$tarjeta->setDB("mysql");
$tarjeta->setFuncionario("di santi eduardo");

$anio=Date("Y");
$mes =Date("m");
$tarjeta->setAnio($anio);
$tarjeta->setMes($mes);

echo "datos es ".$tarjeta->getMes()."|".$tarjeta->getAnio()."\n";
$t=$tarjeta->getMarcas();
$tt=$t[1][0]->horas;
include("imprimirtarjeta.phtml");
tablaT($tarjeta);

?>
