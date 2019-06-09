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

         echo "<tr><td colspan='5' bgcolor='#ffffff' align='right'>Total : </td><td bgcolor='ffffff' align='right'>";
	 echo number_format($guita, 2);
	 echo "</td></tr>";
}

function asignar($lab, $ser, $num, $fec, $serie, $numero) {

   $query = "insert into RecFact values('$serie', $lab, $numero, '$ser', $num)";
   query($query);
}

require("../../functions/db.php");
$link=conectar();


if(empty($comando))
 {
     echo "<center><b>Ingreso de recibos</b></center>";
     echo "<form action='pagos.php' method=post>\n";
     echo "<center><table border=0 width='60%' bgcolor='#449944'>\n";
     echo "<tr>";
     echo "   <td align=right>Serie</td>";
     echo "   <td><input type='text' width='1' size='1' name='serie'></td>";
     echo "</tr>";
     echo "<tr>";
     echo "   <td align=right>Numero de recibo</td>";
     echo "   <td><input type='text' width='10' size=10 name='numero'></td>";
     echo "</tr>";
     echo "   <td align=right>Laboratorio</td>";
     echo "   <td>";
     cargoLabs('');
     echo "   </td>";
     echo "</tr>";
     echo "<tr>";
     echo "   <td align=right>Importe</td>";
     echo "   <td><input type='text' width='10' size=10 name='importe'></td>";
     echo "</tr>";
     echo "<tr>";
     echo "   <td align=right>Fecha</td>";
     echo "   <td><input type='text' width='10' size=10 name='fecha'></td>";
     echo "</tr>";
     echo "<tr>";
     echo "   <td align=right>Cheque</td>";
     echo "   <td><input type='text' width='15' size=15 name='cheque'></td>";
     echo "</tr>";


     echo "   <th colspan=2><input type='submit' name='comando' value='Ingresar'></th>";
     echo "</tr>";
     echo "</table></center>\n";
     echo "</form>\n";

 }
else {

        if($comando == "Ingresar") {

	      $query = "insert into Recibos values('$serie', $numero, $lab, $importe, '$fecha', '$cheque')";
	      query($query);
	}

        if($comando == 'Asignar') {
             $i = 0;
             while($reg = $pagar[$i])
	       {
		 $num=strtok($pagar[$i],"|");
		 $fec=strtok("|");
		 $ser=strtok("|");
                 asignar($lab, $ser, $num, $fec, $serie, $numero);
		 $i++;
               }

	  }

        echo "Recibo : $serie $numero<br>";
	$query = "select Serie, Numero, FactLab.Laboratorio, Fecha, Laboratorios.descripcion as labdesc, sum(Trabajos.Costo) as importe from FactLab, Laboratorios, Trabajos where FactLab.Laboratorio = $lab and Laboratorios.id = FactLab.Laboratorio and Trabajos.id = Trabajo group by Laboratorio, Serie, Numero, Fecha";

	echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
	echo "<tr bgcolor='#cccccc'>";
	echo "	<th colspan=4>Documento</th>";
	echo "	<th>Laboratorio</th>";
	echo "  <th>Importe</th>";

	echo "</tr>\n";

	$q = query($query);
	$labANT=0;
	$guita = 0;
	$totalTotal = 0;

	echo "<form action='pagos.php' method='post'>";
	while($reg = fetch($q))
 	{
		$tra = $reg->Laboratorio;
		$fec = $reg->Fecha;
        	$nlab= $reg->labdesc;
		$importe= $reg->Importe;
		$estado = $reg->Episodio;
		$ser    = $reg->Serie;
		$fact   = $reg->Numero;
		$precio = $reg->importe;
		$ced    = $reg->Paciente;
		$lab    = $reg->Laboratorio;

                $qq = query("select * from RecFact where SerieFact='$ser' and NumeroFact=$fact and LabRecibo=$lab");

		$qr = fetch($qq);

                $lanum = $qr->LabRecibo;
		if(empty($lanum))
		  $mostrar = true;
		else
		  $mostrar = false;
		
     		if($labANT==0)
        		$labANT=$lab;

     		if($labANT != $lab) {

        		total($guita);
        		$labANT = $lab;
			$guita = 0;
     		}
             if($mostrar) {
     		echo "<tr bgcolor='#ffffff'>";
     		echo "     <td>$fec</td>";
     		echo "     <td>";
     		echo "        <input type='checkbox' value='$fact|$fec|$ser' name='pagar[]'>";
     		echo "     </td>";
     		echo "	<td>$ser</td>";
     		echo "     <td>$fact</td>";
     		echo "     <td>$nlab</td>";
     		echo "     <td align='right'>";
		echo number_format($precio, 2);
		echo "      </td>";
     		echo "</tr>";

     		$guita = $guita + $precio;
     		$totalTotal = $totalTotal + $precio;
	      }
 	}
 total($guita);
 //total($totalTotal);

 echo "</table>";
 echo "<input type='hidden' name='lab' value='$lab'>";
 echo "<input type='hidden' name='serie' value='$serie'>";
 echo "<input type='hidden' name='numero' value='$numero'>";
 echo "<center><input type='submit' name='comando' value='Asignar'></center>";
 echo "<a href='pagos.php'>Otro recibo</a>";
 echo "</form>";
}
?>
