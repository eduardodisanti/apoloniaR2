<?php
function date_diff($date2, $date1)
  {
      $s = strtotime($date2) - strtotime($date1);
      $d = intval($s/86400);
      return($d);
  }

function buscar_recibo($lab,$fact,$ser) {

   $query = "select * from RecFact where SerieFact='$ser' and LabRecibo=$lab and NumeroFact = $fact";
   $q = query($query);
   $reg = fetch($q);
   
   $serie = $reg->SerieRecibo;
   $numero= $reg->NumeroRecibo;

   $doc = $serie.$numero;
   return($doc);
}

function total($leyenda, $guita) {

         echo "<tr><td colspan='7' bgcolor='#ffffff' align='right'>$leyenda</td><td bgcolor='#ffffff' align='right'>$guita</td><td bgcolor='#ffffff' colspan=3></td></tr>";
}

if(empty($cmd))
  $cmd=bajar;

require("../../functions/db.php");
$link=conectar();


echo "<center><h4>Busqueda de facturas</h4></center><hr>";
if(empty($comando))
 {
     echo "<form action='busfact.php' method=post>\n";
     echo "<center><table border = 0 width='60%'>\n";
     echo "<tr>";
     echo "   <td>Numero de factura</td>";
     echo "   <td><input type='text' width='10' name='factura'></td>";
     echo "</tr>";
     echo "   <td><input type='submit' name='comando' value='Buscar'></td>";
     echo "   <td>&nbsp;&nbsp</td>";
     echo "</tr>";
     echo "</table></center>\n";
     echo "<input type='hidden' name='comando' value='$cmd'>";
     echo "</form>\n";
 }
else
 {
 
echo "Lista de documentos con numero $factura<br>";
     
$query = "select Serie, Numero, Fecha, Trabajos.descripcion as desctrab, Paciente, Pacientes.Nombre as pacnomb, Pieza, FactLab.Laboratorio as Laboratorio, Laboratorios.descripcion as labdesc, precio as Costo, impuestos as impuesto from FactLab, Trabajos, Pacientes, Laboratorios, histprec where Numero = $factura and Trabajos.id = FactLab.Trabajo and Pacientes.Cedula=FactLab.Paciente and Laboratorios.id = FactLab.Laboratorio and histprec.tipo = 1 and proveedor = FactLab.Laboratorio and anio = Year(Fecha) and mes = Month(Fecha) and articulo = FactLab.Trabajo order by Laboratorio, Fecha, Serie, Numero";

echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "	<th colspan=3>Documento</th>";
echo "	<th>Laboratorio</th>";
echo "	<th>Trabajo</th>";
echo "  <th>Paciente</th>";
echo "  <th>Pieza</th>";
echo "  <th>Precio</th>";
echo "  <th>Impuesto</th>";
echo "  <th>Importe</th>";
echo "  <th>Recibo</th>";

echo "</tr>\n";

$q = query($query);
echo mysql_error();
$labANT=0;
$guita = 0;
$totalTotal = 0;
$totimp = 0;
$guitaTotal = 0;

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

        total("", $guita);
        $labANT = $lab;
	$guita = 0;
     }
     $doc = buscar_recibo($lab,$fact,$ser);
     echo "<tr bgcolor='#ffffff'>";
     echo "     <td>$fec</td>";
     echo "	<td>$ser</td>";
     echo "     <td>$fact</td>";
     echo "     <td>$nlab</td>";
     echo "     <td>$des</td>";
     echo "     <td>";
     echo "          <a href=../../historias/conshist.php?paciente=$ced><b>$ced</b> $nom</a>";
     echo "     </td>";
     echo "     <td>$pieza</td>";
     echo "     <td align='right'>$precio</td>";

     $pimpuesto = $precio * $reg->impuesto / 100;
     $importe = $precio + $pimpuesto;
     echo "     <td align='right'>$pimpuesto</td>";
     echo "     <td align='right'>$importe</td>";
     echo "<td>";
     echo "       <font color='#FF0000'>$doc</font>";
     echo "</td>";
     echo "</tr>";

     $totimp = $totimp + $pimpuesto;
     $guita = $guita + $precio;
     $totalTotal = $totalTotal + $precio;
     $guitaTotal = $guitaTotal + $importe;
 }
 total("Total factura : ",$guita);
 total("Subotal s/impuestos ", $totalTotal);
 total("Total ", $guitaTotal);
 echo "</table>";
}
?>
