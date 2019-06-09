<?php

include("functions/db.php");

session_start();

conectar();

$paciente    = $pac;
$pieza       = $diente;

$q = "select Procedimiento from Episodios where Paciente=$pac and Pieza=$diente group by Pieza";

$qry = query($q);
$resultado = "";

while($reg=fetch($qry)) {

   $proc = $reg->Procedimiento;
   $resultado.=$proc."|";
}

echo $resultado;
desconectar();

?>
