<?php
require("../../functions/db.php");
require("../../functions/ortfija.php");
$link=conectar();


    $hoy = Date("Y-m-d");
echo "<center><h4>INFORME GENERAL DE ORTODONICA FIJA TT-ORF-01 Copia no controlada</h4></center><hr>";

$query = "select Paciente, Nombre, Contrato from PlanOrtodoncia, Pacientes where Paciente = Cedula order by Paciente";

    $qry = query($query);
    echo mysql_error();

    
$enTrat = 0;
$condeuda  = 0;

echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "	<th colspan=1>MAT</th>";
echo "	<th>Paciente</th>";
echo "  <th>Deuda</th>";
echo "  <th>Cuota</th>";
echo "</tr>\n";

while($reg = fetch($qry))
{

     $pac = $reg->Paciente;
     $deuda = deudaOrtFija($pac);
     $contrato = $reg->Contrato;
     $orden = tipoContrato($contrato);

     $uq = "select * from Ordenes where id='$orden'";
     $uuq = query($uq);
     $ureg = fetch($uuq);

     $valor = $ureg->Valor;
     $enTrat++;
     if($deuda > 1) {
        $color='#FFFFFF';
 	echo "<tr bgcolor='$color'>";
	echo "<td>$reg->Paciente</td>";
	echo "<td>$reg->Nombre</td>"; 
	echo "<td>$deuda</td>";
	echo "<td align='right'>$valor</td>";
	echo "</tr>\n";
	$condeuda++;
     }
 }

 $indice = ($condeuda / $enTrat) * 100;
 echo "<tr bgcolor='#ffffff'><td colspan=4>&nbsp;&nbsp;</td></tr>";
 echo "<tr bgcolor='#fcfcfc'>";
 echo "	<td colspan=3>Pacientes en tratamiento</td>";
 echo " <td colspan=1 align=right>$enTrat</td>";
 echo "</tr>";
 echo "<tr bgcolor='#fcfcfc'>";
 echo " <td colspan=3>Total de pacientes que deben 2 meses y mas</td>";
 echo " <td colspan=1 align=right>$condeuda</td>";
 echo "</tr>";
 echo "<tr bgcolor='#fcfcfc'>";
 echo " <td colspan=3>Morosidad $condeuda / $enTrat</td>";
 echo " <td colspan=1 align=right>$indice</td>";
 echo "</tr>";
 echo "</table>";
?>
<center>
	<B>LOS MESES ADEUDADOS SE COMPUTAN EL 20 DE CADA MES<BR>
           EN CORCONDANCIA CON EL RECIBO MUCAM</B>
</center>
<center><a href='#' onclick='window.print()'>Imprimir</a></center>

