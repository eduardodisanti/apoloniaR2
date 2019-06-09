<?php
function cargoLabs($elLab)
{
   echo "<select name='lab'>";
   $qry = query("select id, descripcion from Laboratorios order by descripcion");
   while($reg = fetch($qry))
    {
       $lab = $reg->id;
       $nombre=$reg->descripcion;
       if($elLab == $lab)
           $sel = "selected";
       else
           $sel = "";
       echo "<option value='$lab' $sel>$nombre</option>";
    }
    echo "</select>";
}

function date_diff($date2, $date1)
  {
      $s = strtotime($date2) - strtotime($date1);
      $d = intval($s/86400);
      return($d);
  }

function total($guita) {

    echo "<tr><td colspan='7' bgcolor='#ffffff' align='right'>Total : </td><td bgcolor='ffffff' align='right' colspan=2>";
    echo number_format($guita, 2);
    echo "</td></tr>";

}

if(empty($cmd))
  $cmd=bajar;

require("../../functions/db.php");
$link=conectar();


echo "<center><h4>Ajuste de facturas</h4></center><hr>";
if(empty($comando))
 {
     echo "<form action='ajulab.php' method=post>\n";
     echo "<center><table border = 0 width='60%' bgcolor='#cccccc'>\n";
     echo "<tr><th><b>Si la factura existe</b></th></tr>";
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
     echo "<center><b>Si la factura no existe</b></center>";
     echo "<form action='ajufactlab.php' method=post>\n";
     echo "<center><table border=0 width='60%' bgcolor='#44AA44'>\n";
     echo "<tr>";
     echo "   <td align=right>Serie</td>";
     echo "   <td><input type='text' width='1' size='1' name='serie'></td>";
     echo "</tr>";
     echo "<tr>";
     echo "   <td align=right>Numero de factura</td>";
     echo "   <td><input type='text' width='10' size=10 name='factura'></td>";
     echo "</tr>";
     echo "   <td align=right>Laboratorio</td>";
     echo "   <td>";
     cargoLabs('');
     echo "   </td>";
     echo "</tr>";
     echo "   <th colspan=2><input type='submit' name='comando' value='Crear'></th>";
     echo "</tr>";
     echo "</table></center>\n";
     echo "</form>\n";

 }
else
 {
 
echo "Documentos con numero $factura<br>";
     
$query = "select Serie, Numero, Fecha, Trabajos.descripcion as desctrab, Paciente, Pacientes.Nombre as pacnomb, Pieza, FactLab.Laboratorio as Laboratorio, Laboratorios.descripcion as labdesc, histprec.precio as Costo, impuestos as impuesto from FactLab, Trabajos, Pacientes, Laboratorios, histprec where Numero = $factura and Trabajos.id = FactLab.Trabajo and Pacientes.Cedula=FactLab.Paciente and Laboratorios.id = FactLab.Laboratorio and tipo=1 and proveedor = FactLab.Laboratorio and anio= Year(Fecha) and mes=Month(Fecha) and articulo = FactLab.Trabajo order by Laboratorio, Fecha, Serie, Numero";

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
	$impues = $reg->impuesto;
	$tipoIVA= $reg->tipoIVA;

     if($labANT==0)
        $labANT=$lab;

     if($labANT != $lab) {

        total($guita);
        $labANT = $lab;
	$guita = 0;
     }

     $qq = query("select * from RecFact where SerieFact='$ser' and NumeroFact=$fact and LabRecibo=$lab");

     $qr = fetch($qq);

     $lanum = $qr->LabRecibo;
     if(empty($lanum))
        $mostrar = true;
     else
        $mostrar = false;

     echo "<tr bgcolor='#ffffff'>";
     echo "     <td>$fec</td>";
     echo "	<td>$ser</td>";
     echo "     <td>";
     if ($mostrar) {
        echo "          <a href='ajufactlab.php?serie=$ser&factura=$fact&lab=$lab'>";
        echo "             $fact";
        echo "           </a>";
     } else echo "$fact";
     echo "      </td>";
     echo "     <td>$nlab</td>";
     echo "     <td>$des</td>";
     echo "     <td><b>$ced</b> $nom</td>";
     echo "     <td>$pieza</td>";
     echo "     <td align='right'>";
     echo number_format($precio,2);
     echo "</td>";
     echo "</tr>";

     $guita = $guita + $precio + $precio * ($impues / 100);
     $totalTotal = $totalTotal + $precio + $precio * ($impues / 100);
 }
 total($totalTotal);

 echo "</table>";
}
?>
