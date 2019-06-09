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

function sacarListaRecibos($serie, $numero, $labo) {

     $query = "select SerieRecibo, NumeroRecibo, importe from RecFact, Recibos where SerieFact ='$serie' and NumeroFact = $numero and LabRecibo = $labo and Recibos.serie=SerieRecibo and LabRecibo = laboratorio and numero = NumeroRecibo";

     $q = query($query);
     $veces = 0;
     while($reg = fetch($q))
       {
           $ser = $reg->SerieRecibo;
	   $num = $reg->NumeroRecibo;
	   $importe = $reg->importe;

	   $ximporte = number_format($importe,2);
 
	   echo "<tr bgcolor='#cccccc'><td colspan=4>&nbsp;
	   &nbsp;</td><td>&nbsp;&nbsp;</td><td>($ser)-$num</td><td align=right>$ximporte</td></tr>";

           $veces++;
       }

    if($veces==0)
       echo "<tr bgcolor='#cccccc'><td colspan=4>&nbsp;
                  &nbsp;</td><td>&nbsp;&nbsp;</td><td colspan=2>&nbsp;&nbsp;</td><td align=right>";
       echo mysql_error();
       echo "</td></tr>";
}

$link=conectar();

echo "<center><h4>Cuenta de laboratorios</h4></center><hr>";
if(empty($comando))
 {
      if(!empty($val))
         $limit = "where id = $val"; 
      else
         $limit = "";

      $query="select * from Laboratorios $limit order by descripcion";
      $qry = query($query);

     echo "<form action='inflabs.php' method=post>\n";
     echo "<select name='Laboratorio'>";
     if(empty($val))
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
     
echo "Lista de facturas entre $FECHADESDE y $FECHAHASTA<br>";
     
if($Laboratorio != 0)
  $limit = "and FactLab.Laboratorio = $Laboratorio";
else
  $limit="";

$query = "select FactLab.Laboratorio as lab, Serie, Numero, Fecha, Trabajo,Paciente,Pieza, Laboratorios.descripcion as desclab, sum(Costo) as sCosto from FactLab, Trabajos,Laboratorios where Fecha >= '$FECHADESDE' and Fecha <='$FECHAHASTA' $limit and FactLab.Laboratorio=Laboratorios.id and Trabajos.id = Trabajo group by FactLab.Laboratorio, Serie, Numero order by FactLab.Laboratorio, Fecha";

echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "	<th>Serie</th>";
echo "	<th>Numero</th>";
echo "	<th>Fecha</th>";
echo "  <th>Importe</th>";
echo "  <th colspan=4>Pagos</th>";
echo "</tr>\n";

$q = query($query);

//die(mysql_error());

$labANT="";
$guita = 0;

while($reg = fetch($q))
 {

        $nombreLab = $reg->desclab;
	$importe   = $reg->sCosto;
	$serie     = $reg->Serie;
	$numero    = $reg->Numero;
	$fecha	   = $reg->Fecha;
	$labo      = $reg->lab;

      $ximporte = number_format($importe, 2);

        if($nombreLab!=$labAnt)
	  {
	     if(!empty($labAnt))
	       {
	         echo "<tr><td colspan=3 bgcolor='#cccccc' align='right'><font size='+1'><b>Importe </b></font></td><td align='right' bgcolor='#cccccc'>$guita</td><td colspan=4>&nbsp;&nbsp;</td></tr>";
	       }
	     echo "<tr><td colspan=8 bgcolor='#cccccc' align='center'><font size='+1'><b>$nombreLab</b></font></td></tr>";
	     $labAnt=$nombreLab;
	     $guita = 0;
	  }

        echo "<tr bgcolor='#ffffff'><td>$serie</td><td>$numero</td><td>$fecha</td><td align='right'>$ximporte</td><td colspan=4>&nbsp;&nbsp;</td></tr>";
	$guita+=$importe;

	sacarListaRecibos($serie, $numero, $labo);
 }

 echo "</table>";
}
?>
<center><a href='javascript:window.print()'>Imprimir</a></center>

