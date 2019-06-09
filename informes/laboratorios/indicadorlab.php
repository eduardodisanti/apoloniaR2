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


echo "<center><h4>Indicadores de no conformidad Laboratorios</h4></center><hr>";
if(empty($comando))
 {
      $query="select * from Laboratorios order by descripcion";
      $qry = query($query);

     echo "<form action='indicadorlab.php' method=post>\n";
     echo "<select name='Laboratorio'>";
     echo "<option value='0'>Todos</option>";
     while($reg=fetch($qry))
       {
         echo "<option value='$reg->id'>$reg->descripcion</option>"; 
       }
     echo "</select>";
     echo "<center><table border = 0 width='60%'>\n";
     echo "<tr>";
     echo "   <td>Fecha desde (AAAA-MM-DD)</td>";
     echo "   <td><input type='text' width='10' name='FECHADESDE'></td>";
     echo "</tr>";
     echo "<tr>";
     echo "   <td>Fecha hasta (AAAA-MM-DD)</td>";
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
     
echo "Lista de no conformidades entre $FECHADESDE y $FECHAHASTA<br>";
     
if($Laboratorio != 0)
  $limit = "where id = $Laboratorio";
else
  $limit="";

$query = "select * from Laboratorios $limit order by descripcion";
echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "	<th>Laboratorio</th>";
echo "	<th>NC x Fecha</th>";
echo "	<th>NC x Retrabajos</th>";
echo "  <th>Indice NC</th>";
echo "  <th>Total</th>";
echo "</tr>\n";

$q = query($query);
$Tncv = 0;
$Tncr = 0;
$tottrab = 0;

while($reg = fetch($q)) // Para todos los laboratorios
 {
   $descripcion = $reg->descripcion;
   $lab         = $reg->id;

   $ncvencimiento = 0;
   $ncretrabajos  = 0;
   $query = "select * from HistTrabSoc where Fecha >='$FECHADESDE' and Fecha <='$FECHAHASTA' and Laboratorio=$lab and Episodio = 3 order by Paciente, Fecha";
   $q1 = query($query);
   while($q1reg = fetch($q1)) // ** para todos los trabajos
     {
        $pac  = $q1reg->Paciente;
	$trab = $q1reg->Trabajo;
        $fecha= $q1reg->Fecha;
	$epi  = $q1reg->Episodio;
	$lab  = $q1reg->Laboratorio;

        $tiempo = 15;
	$vence = date("Y-m-d", strtotime("+$tiempo day ".$fecha));

	if($vence <= $FECHAHASTA) 
	  {
             $query = "select * from HistTrabSoc where Paciente=$pac and Trabajo=$trab and Fecha >= '$fecha' and Fecha <= '$vence' and Episodio=5 and Laboratorio=$lab"; 

             $q2 = query($query);
	     $q2reg = fetch($q2);
             $npac = $q2reg->Paciente;
	     if(empty($npac))
	        $ncvencimiento++;
	 }
     }

   $Tncv += $ncvencimiento;
   $query = "select count(*) as cant from HistTrabSoc where Fecha >= '$FECHADESDE' and Fecha <= '$FECHAHASTA' and Episodio=88 and Laboratorio=$lab";
   $q2 = query($query);
   $q2reg = fetch($q2);

   $cant = $q2reg->cant;
   $ncretrabajos += $cant;

   $query = "select count(*) as cant from HistTrabSoc where Fecha >= '$FECHADESDE' and Fecha <= '$FECHAHASTA' and Episodio=3 and Laboratorio = $lab";
   $q2 = query($query);
   $q2reg = fetch($q2);

   $trabajos = $q2reg->cant;

   $tottrab+= $trabajos;
   if($trabajos==0)
       $trabajos=1;

   echo "<tr bgcolor='#ffffff'>";
   echo "<td align='left'>$descripcion</td>";
   echo "<td align='right'>";
   echo "   <a href='ncvencimiento.php?lab=$lab&f1=$FECHADESDE&f2=$FECHAHASTA'>";
   echo "      $ncvencimiento";
   echo "   </a>";
   echo "</td>";
   echo "<td align='right'>";
   echo "   <a href='ncretrabajos.php?lab=$lab&f1=$FECHADESDE&f2=$FECHAHASTA'>$ncretrabajos</a>";
   echo "</td>";
   $indice = (($ncvencimiento + $ncretrabajos) / $trabajos) * 100;
   $xindice = sprintf("%4.2f",$indice);
   echo "<td align='right'>$xindice %</td>";
   echo "<td align='right'>$trabajos</td>";
   echo "</tr>";
   $Tncr += $cant;

 }
 echo "<tr bgcolor='#f0f0f0'>";
 echo "<td align='center'>Total</td>";
 echo "<td align='right'>$Tncv</td>";
 echo "<td align='right'>$Tncr</td>";
   $indice = (($Tncv + $Tncr) / $tottrab) * 100;
   $xindice = sprintf("%4.2f",$indice);
 echo "<td align='right'>$xindice %</td>";
 echo "<td align='right'>$tottrab</td>";

 echo "</tr>";

 echo "</table>";
}
?>
<center><a href='javascript:window.print()'>Imprimir</a></center>
