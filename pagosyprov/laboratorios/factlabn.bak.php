<?php
function date_diff($date2, $date1)
  {
      $s = strtotime($date2) - strtotime($date1);
      $d = intval($s/86400);
      return($d);
  }
if(empty($cmd))
  $cmd=bajar;

function facturaPaga($serie, $numero, $laboratorio) {

    $query = "select * from RecFact where LabRecibo=$laboratrorio and SerieFact='$serie' and NumeroFact='$numero'";

    $reg = query($query);

    $filas = filas($reg);

    return($filas!=0);
}

require("../../functions/db.php");
$link=conectar();


echo "<center><h4>Control de facturacion de laboratorios nueva</h4></center><hr>";
if(empty($comando))
 {
      $query="select * from Laboratorios order by descripcion";
      $qry = query($query);

     echo "<form action='factlabn.php' method=post>\n";
     echo "<select name='Laboratorio'>";
     echo "<option value='0'>Todos</option>";
     while($reg=fetch($qry))
       {
         echo "<option value='$reg->id'>$reg->descripcion</option>"; 
       }
     echo "</select>";
     echo "<center><table border = 0 width='60%'>\n";
     echo "<tr>";
     echo "   <td>Fecha vencimiento desde (AAAA-MM-DD)</td>";
     echo "   <td><input type='text' width='10' name='FECHADESDE'></td>";
     echo "</tr>";
     echo "<tr>";
     echo "   <td>Fecha vencimiento  hasta (AAAA-MM-DD)</td>";
     echo "   <td><input type='text' width='10' name='FECHAHASTA'></td>";
     echo "</tr>";
     echo "<tr>";
     echo "   <td><input type='submit' name='comando' value='Ejecutar'></td>";
     echo "   <td>&nbsp;&nbsp</td>";
     echo "</tr>";
     echo "</table></center>\n";
     echo "<input type='hidden' name='comando' value='$cmd'>";
     echo "</form>\n";
 }
else
 {
 
    $hoy = Date("Y-m-d");
     if(empty($FECHADESDE))
          $FECHADESDE=$hoy;
     if(empty($FECHAHASTA))
        $FECHAHASTA = $hoy;
     
echo "Lista de trabajos realizados entre $FECHADESDE y $FECHAHASTA<br>";
     
if($Laboratorio != 0)
  $limit = "and FactLab.Laboratorio = $Laboratorio";
else
  $limit="";

$query = "select FactLab.Laboratorio as numlab, Laboratorios.descripcion as nomlab ,Serie,Numero,Fecha, Trabajo, Trabajos.descripcion desctra, Pacientes.Nombre nompac, Cedula, Pieza, histprec.precio as Costo, histprec.impuestos as iva from FactLab, Trabajos, Pacientes, Laboratorios, histprec where Fecha <='$FECHAHASTA' and Trabajo = Trabajos.id and Paciente = Cedula $limit and FactLab.Laboratorio = Laboratorios.id and 
histprec.proveedor = FactLab.Laboratorio and
histprec.anio = Year(Fecha) and
histprec.mes  = Month(Fecha) and
histprec.tipo = 1 and
histprec.articulo = Trabajos.id 
order by FactLab.Laboratorio, Serie, Numero, Fecha, Pacientes.Nombre";

echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "	<th>Serie</th>";
echo "  <th>Numero</th>";
echo "	<th>Fecha</th>";
echo "  <th>Trabajo</th>";
echo "  <th>Paciente</th>";
echo "  <th>Precio</th>";
echo "  <th>IVA</th>";
echo "  <th>Importe</th>";
echo "</tr>\n";

$q = query($query);
echo mysql_error();
$labANT="";
$guita = 0;
$guitaTotal = 0;
$factant=0;
$totfact=0;

while($reg = fetch($q))
 {

	$nomlab  = $reg->nomlab;
	$numlab  = $reg->numlab;
	$serie   = $reg->Serie;
	$numero  = $reg->Numero;
	$desctra = $reg->desctra;
	$fecha   = $reg->Fecha;
        $nombreLab=$reg->nombreLab;
	$importe= $reg->Importe;
	$pieza  = $reg->Pieza;
	$cedula = $reg->Cedula;
	$precio = $reg->Costo;
	$iva    = $reg->iva;
	$importe= $precio + ($precio * $iva / 100);

        $facturaPaga = facturaPaga($serie, $numero, $numlab);

   if(!$facturaPaga) {
        if($factant==0)
	   $factant = $numero;

        if($factant != $numero) {
	    echo "<tr><td colspan=7 bgcolor='#cccccc' align='right'><font size='+1'>Total factura</font></td><td align='right' bgcolor='#cccccc'>";
	    echo number_format($totfact, 2);
	    echo "</td></tr>";
            $factant = $numero;
	    $totfact = 0;
	}

        if($nomlab!=$labAnt)
	  {
	     if(!empty($labAnt))
	       {
	         echo "<tr><td colspan=7 bgcolor='#cccccc' align='right'><font size='+1'><b>Importe </b></font></td><td align='right' bgcolor='#cccccc'>";
		 echo number_format($guita, 2);
		 echo "</td></tr>";
	       }
	     echo "<tr><td colspan=8 bgcolor='#cccccc' align='center'><font size='+1'><b>$nomlab</b></font></td></tr>";
	     $labAnt=$nomlab;
	     $guita = 0;
	     $totfact = 0;
	  }

	  if($estado==8)
	   {
	     $importe = $importe * -1;
             $det="*RETRABAJO*";
	   } else
	          {
		        $det="";
		  }
		echo "<tr bgcolor='#ffffff'>";
		echo "  <td align='center'>$serie</td>";
		echo "  <td>$numero</td>";
		echo "	<td>$fecha</td>";
		echo "  <td>$desctra</td>";
		echo "  <td>$cedula</td>";
                echo "  <td align='right'>";
                echo number_format($precio, 2);
                echo "   </td>";
                echo "  <td align='right'>";
                echo number_format($iva, 2);
                echo "   </td>";

		echo "  <td align='right'>";
		echo number_format($importe, 2);
		echo "   </td>";
		echo "</tr>\n";

		$guita+=$importe;
		$guitaTotal+=$importe;
		$totfact+= $importe;
       }
 }
  echo "<tr><td colspan=7 bgcolor='#cccccc' align='right'><font size='+1'>Total factura</font></td><td align='right' bgcolor='#cccccc'>";
  echo number_format($totfact, 2);
  echo "</td></tr>";

 echo "<tr><td colspan=7 bgcolor='#cccccc' align='right'><font size='+1'><b>Importe </b></font></td><td align='right' bgcolor='#cccccc'>";
 echo number_format($guita,2);
 echo "</td></tr>";
 echo "<tr><td colspan='7' bgcolor='#ffffff'>Total</td><td bgcolor='ffffff' align='right'>";
 echo number_format($guitaTotal, 2);
 echo "</td></tr>";
 echo "</table>";
}
?>
<center><a href='javascript:window.print()'>Imprimir</a></center>
