<?php
function date_diff($date2, $date1)
  {
      $s = strtotime($date2) - strtotime($date1);
      $d = intval($s/86400);
      return($d);
  }

function total($guita) {

         echo "<tr><td colspan='7' bgcolor='#ffffff' align='right'>Total : </td><td bgcolor='ffffff' align='right'>$guita</td></tr>";
}

if(empty($cmd))
  $cmd=bajar;

require("../../functions/db.php");
$link=conectar();


echo "<center><h4>Ajustar factura</h4></center><hr>";
 
echo "Lista de documentos con numero $factura<br>";
     
$query = "select Serie, Numero, Fecha, Trabajos.descripcion as desctrab, Paciente, Pacientes.Nombre as pacnomb, Pieza, FactLab.Laboratorio as Laboratorio, Laboratorios.descripcion as labdesc, Costo from FactLab, Trabajos, Pacientes, Laboratorios where FactLab.Numero = $fact and Serie = '$serie' and FactLab.Laboratorio=$lab and Trabajos.id = FactLab.Trabajo and Pacientes.Cedula=FactLab.Paciente and Laboratorios.id = FactLab.Laboratorio order by Laboratorio, Fecha, Serie, Numero";

echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "	<th colspan=3>Documento</th>";
echo "	<th>Laboratorio</th>";
echo "	<th>Trabajo</th>";
echo "  <th>Paciente</th>";
echo "  <th>Pieza</th>";
echo "  <th>Importe</th>";

echo "</tr>\n";

$q = query($query);
echo mysql_error();
$labANT=0;
$guita = 0;
$totalTotal = 0;

while($reg = fetch($q))
 {
	$pac = $reg->Paciente;
	$nom = $reg->pacnomb;
	$tra = $reg->Laboratorio;
	$des = $reg->desctrab;
	$fec = $reg->Fecha;
        $nlab= $reg->labdesc;
	$importe= $reg->Importe;
	$estado = $reg->Episodio;
	$pieza  = $reg->Pieza;
	$ser    = $reg->Serie;
	$fact   = $reg->Numero;
	$precio = $reg->Costo;
	$ced    = $reg->Paciente;
	$lab    = $reg->Laboratorio;

     if($labANT==0)
        $labANT=$lab;

     if($labANT != $lab) {

        total($guita);
        $labANT = $lab;
	$guita = 0;
     }

     echo "<tr bgcolor='#ffffff'>";
     echo "     <td>$fec</td>";
     echo "	<td>$ser</td>";
     echo "     <td>$fact</td>";
     echo "     <td>$nlab</td>";
     echo "     <td>$des</td>";
     echo "     <td><b>$ced</b> $nom</td>";
     echo "     <td>$pieza</td>";
     echo "     <td align='right'>$precio</td>";
     echo "</tr>";

     $guita = $guita + $precio;
     $totalTotal = $totalTotal + $precio;
 }

 total($guita);

 echo "</table>";

  echo "<form action='factura.php'>";
  echo "<tr bgcolor='#ffffff'>";
  echo "     <td></td>";
  echo "</tr>";
  echo "</form>";

?>
