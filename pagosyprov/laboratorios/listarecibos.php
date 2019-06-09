<?php
function date_diff($date2, $date1)
  {
      $s = strtotime($date2) - strtotime($date1);
      $d = intval($s/86400);
      return($d);
  }

function total($guita) {

         echo "<tr><td colspan='4' bgcolor='#ffffff' align='right'>Total : </td><td bgcolor='#ffffff' align='right'>";
	 echo number_format($guita, 2);
	 echo "</td></tr>";
}

if(empty($cmd))
  $cmd=bajar;

require("../../functions/db.php");

function sacarListaFacturas($ser, $lab, $fact) {

   $query = "select * from RecFact where SerieRecibo='$ser' and LabRecibo=$lab and NumeroRecibo='$fact'";
   $q = query($query);
   
   while($reg = fetch($q))
      {
	  echo "<tr bgcolor='#EEEEEE'>";
          $serief = $reg->SerieFact;
	  $numerof= $reg->NumeroFact;
	  echo "<td colspan=3>&nbsp;&nbsp;</td>";
	  echo "<td>$serief - $numerof</td>";
	  echo "<td>&nbsp;&nbsp;</td>";
	  $tab++;
      }
}

$link=conectar();


echo "<center><h4>Busqueda de recibos</h4></center><hr>";
if(empty($comando))
 {
     echo "<form action='listarecibos.php' method=post>\n";
     echo "<center><table border = 0 width='60%'>\n";
     echo "<tr>";
     echo "   <td>Numero de Recibo</td>";
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
 
echo "Lista de recibos con numero $factura<br>";
     
$query = "select serie, numero, fecha, Recibos.numero, laboratorio,  Laboratorios.descripcion as labdesc, importe from Recibos, Laboratorios where numero = $factura and Laboratorios.id = Recibos.laboratorio order by laboratorio, fecha, serie, numero";

echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "	<th colspan=3>Documento</th>";
echo "	<th>Laboratorio</th>";
echo "  <th>Importe</th>";

echo "</tr>\n";

$q = query($query);
echo mysql_error();
$labANT=0;
$guita = 0;
$totalTotal = 0;

while($reg = fetch($q))
 {
	$fec = $reg->fecha;
        $nlab= $reg->labdesc;
	$importe= $reg->importe;
	$ser    = $reg->serie;
	$fact   = $reg->numero;
	$precio = $reg->importe;
	$lab    = $reg->laboratorio;

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
     echo "     <td align='right'>";
     echo number_format($precio, 2);
     echo "</td>";
     echo "</tr>";

     sacarListaFacturas($ser, $lab, $fact);

     $guita = $guita + $precio;
     $totalTotal = $totalTotal + $precio;
 }
 total($guita);
 total($totalTotal);

 echo "</table>";
}
?>
