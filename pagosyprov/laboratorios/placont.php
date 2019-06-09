<?php
function date_diff($date2, $date1)
  {
      $s = strtotime($date2) - strtotime($date1);
      $d = intval($s/86400);
      return($d);
  }
if(empty($cmd))
  $cmd=bajar;

require("../../functions/db.php");
$link=conectar();


echo "<center><h4>Informe de facturacion pagos e laboratorios</h4></center><hr>";
if(empty($comando))
 {
      $query="select * from Laboratorios order by descripcion";
      $qry = query($query);

     echo "<form action='placont.php' method=post>\n";
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
     echo "   <td><input type='text' name='to' value='patriciaibarruri@ccea.com.uy'></td>";
     echo "   <td>&nbsp;&nbsp</td>";
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
     
$subject = "Lista de trabajos de laboratorio entre $FECHADESDE y $FECHAHASTA PT-PPP-02<br>";
    
$cuerpo = "";

if($Laboratorio != 0)
  $limit = "and FactLab.Laboratorio = $Laboratorio";
else
  $limit="";

$query = "select FactLab.Laboratorio as numlab, Laboratorios.descripcion as nomlab ,Serie,Numero,Fecha, Trabajo, Trabajos.descripcion desctra, Pieza, sum(histprec.precio) as Costo, histprec.impuestos as iva from FactLab, Trabajos, Laboratorios, histprec where Fecha >= '$FECHADESDE' and Fecha <='$FECHAHASTA' and Trabajo = Trabajos.id  $limit and FactLab.Laboratorio = Laboratorios.id and 
histprec.proveedor = FactLab.Laboratorio and
histprec.anio = Year(Fecha) and
histprec.mes  = Month(Fecha) and
histprec.tipo = 1 and
histprec.articulo = Trabajos.id 
group by FactLab.Laboratorio, Serie, Numero, Fecha, histprec.impuestos
order by FactLab.Laboratorio, Serie, Numero, Fecha";


$cuerpo.= "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
$cuerpo.="<tr bgcolor='#cccccc'>";
$cuerpo.="	<th>Serie</th>";
$cuerpo.= "  <th>Numero</th>";
$cuerpo.= "	<th>Fecha</th>";
$cuerpo.= "  <th>Precio</th>";
$cuerpo.= "  <th>IVA</th>";
$cuerpo.= "  <th>Importe</th>";
$cuerpo.= "  <th>Cheque</th>";
$cuerpo.= "  <th>Recibo</th>";
$cuerpo.= "  <th>Fecha</th>";
$cuerpo.= "  <th>Importe</th>";
$cuerpo.= "</tr>\n";

$q = query($query);
$cuerpo.= mysql_error();
$labAnt=0;
$guita = 0;
$guitaTotal = 0;
$importePagos = 0;
$totalPagos = 0;

while($reg = fetch($q))
 {
    $cols=1;

	$numlab  = $reg->numlab;
	$serie   = $reg->Serie;
	$numero  = $reg->Numero;
	$fecha   = $reg->Fecha;
        $nombreLab=$reg->nomlab;
	$importe= $reg->Importe;
	$pieza  = $reg->Pieza;
	$precio = $reg->Costo;
	$iva    = $reg->iva;
	$importe= $precio + ($precio * $iva / 100);

        if($numlab!=$labAnt)
	  {
	     if($labAnt!=0)
	       {
	         $cuerpo.= "<tr><td colspan=5 bgcolor='#cccccc' align='right'><font size='+1'><b>Importe </b></font></td><td align='right' bgcolor='#cccccc'>";
		 $cuerpo.= number_format($guita, 2);
		 $cuerpo.= "</td>";
		 $cuerpo.= "<td colspan=3 bgcolor='#cccccc' align='right'><font size='+1'><b> Pagos  </b></font></td><td align='right' bgcolor='#cccccc'>";
                 $cuerpo.= number_format($importePagos, 2);
                 $cuerpo.= "</td>";
		 $cuerpo.= "</tr>";
	       }
	     $cuerpo.= "<tr><td colspan=10 bgcolor='#cccccc' align='center'><font size='+1'><b>$nombreLab</b></font></td></tr>";
	     $labAnt=$numlab;
	     $guita = 0;
	     $importePagos = 0;
	  }
	$cuerpo.= "<tr bgcolor='#ffffff'>";
	$cuerpo.= "  <td align='center'>$serie</td>";
	$cuerpo.= "  <td>$numero</td>";
	$cuerpo.= "	<td>$fecha</td>";
        $cuerpo.= "  <td align='right'>";
        $cuerpo.= number_format($precio, 2);
        $cuerpo.= "   </td>";
        $cuerpo.= "  <td align='right'>";
        $cuerpo.= number_format($iva, 2);
        $cuerpo.= "   </td>";

	$cuerpo.= "  <td align='right'>";
        $cuerpo.= number_format($importe, 2);
	$cuerpo.= "   </td>";

	$pq = "select NumeroRecibo, SerieRecibo, Cheque, importe, fecha from RecFact, Recibos where SerieFact='$serie' and NumeroFact = $numero and Laboratorio = $numlab and serie=SerieRecibo and NumeroRecibo=numero and laboratorio=LabRecibo";

        $controlcol=0;
	$pqq = query($pq);
	while($preg = fetch($pqq)) {

	    $nr = $preg->NumeroRecibo;
	    $sr = $preg->SerieRecibo;
            $simp=$preg->importe;
	    $cheq=$preg->Cheque;
	    $sfec=$preg->fecha;

	    $xsimp = number_format($importe, 2);
	    $cuerpo.= "<td align='center'>$cheq</td><td>($sr)$nr</td><td>$sfec</td><td align='right'>$xsimp</td>";
	    $importePagos+=$importe;
	    $totalPagos+=$importe;
	    $controlcol++;
	}
	if($controlcol==0)
	   $cuerpo.= "<td colspan=4>&nbsp;&nbsp;</td>";

	$cuerpo.= "</tr>\n";

	$guita+=$importe;
	$guitaTotal+=$importe;
 }
 $cuerpo.= "<tr><td colspan=5 bgcolor='#cccccc' align='right'><font size='+1'><b>Importe </b></font></td><td align='right' bgcolor='#cccccc'>";
 $cuerpo.= number_format($guita,2);
 $cuerpo.= "</td>";
 $cuerpo.= "<td colspan=3 bgcolor='#cccccc' align='right'><font size='+1'><b> Pagos  </b></font></td><td align='right' bgcolor='#cccccc'>";
 $cuerpo.= number_format($importePagos, 2);
 $cuerpo.= "</td>";
 $cuerpo.= "</tr>";
 $cuerpo.= "<tr><td colspan=5 bgcolor='#ffffff'>Total</td><td bgcolor='ffffff' align='right'>";
 $cuerpo.= number_format($guitaTotal, 2);
 $cuerpo.= "</td>";
 $cuerpo.= "<td colspan=3 bgcolor='#ffffff' align='right'><font size='+1'><b>Pagos</b></font></td><td align='right' bgcolor='#ffffff'>";
 $cuerpo.= number_format($totalPagos, 2);
 $cuerpo.= "</td>";
 $cuerpo.= "</tr>";
 $cuerpo.= "</table>";
}

echo $cuerpo;
$headers="From: CADI <adm@cadi.com.uy>\n";
$headers.="Content-Type: text/html; charset=UTF-8\n";
$mail_sent = mail( $to, $subject, $cuerpo, $headers );
?>
<center><a href='javascript:window.print()'>Imprimir</a></center>
