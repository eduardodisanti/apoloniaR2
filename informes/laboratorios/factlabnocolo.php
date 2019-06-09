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

echo "<center><h4>Trabajos facturados y no colocados por falta de horas</h4></center><hr>";
if(empty($comando))
 {
     echo "<form action='factlabnocolo.php' method=post>\n";
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

if($FECHADESDE < '2006-11-26')
   $FECHADESDE = '2006-11-26';

echo "Lista de trabajos facturados por el laboratorio y no colocados entre $FECHADESDE y $FECHAHASTA<br>";
    
if(empty($Laboratorio))
  $Laboratorio = 0;
      
if($Laboratorio != 0)
  $limit = "and HistTrabSoc.Laboratorio = $Laboratorio";
else
  $limit="";

$query = "select Fecha,Serie,Numero,Trabajo,Paciente,Pieza, Trabajos.descripcion, Pacientes.Nombre from FactLab, Pacientes, Trabajos where Fecha >='$FECHADESDE' and Fecha <='$FECHAHASTA' and Pacientes.Cedula = Paciente and Trabajos.id = Trabajo order by Pacientes.Nombre";

echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "  <th>Fecha</th>";
echo "  <th>Cedula</th>";
echo "	<th>Paciente</th>";
echo "	<th>Trabajos</th>";
echo "  <th>Pieza</th>";
echo "</tr>\n";

$q = query($query);
echo mysql_error();
$total = 0;

while($reg = fetch($q))
 {
    $fecha = $reg->Fecha;
    $serie = $reg->Serie;
    $numero= $reg->Numero;
    $trab  = $reg->Trabajo;
    $pac   = $reg->Paciente;
    $pieza = $reg->Pieza;
    $nomb  = $reg->Nombre;
    $ntrab = $reg->descripcion;
   
    $query = "select Episodio from HistTrabSoc where Paciente=$pac and Trabajo=$trab and Fecha >='$fecha' and Pieza = $pieza and Episodio = 8";

    $qq  = query($query);
    $regq= fetch($qq);

    $episodio = $regq->Episodio;

    $listar = false;

    $fechaTOPE =  date("$fecha", strtotime("+30 day ".$fecha)); 

    $cq = query("select * from Horarios where Paciente = $pac and Fecha >='$fechaTOPE'");
    $rcq = fetch($cq);
    $cita = $rcq->Fecha;

    if(empty($episodio) && empty($cita))
       $listar = true;

    if($listar) {
       
       echo "<tr bgcolor='#ffffff'>";
       echo "    <td>$fecha</td>";
       echo "    <td>";
       echo "        <a href='../../historias/conshist.php?paciente=$pac' target='historia'>$pac</a>";
       echo "    </td>";
       echo "    <td>$nomb</td>";
       echo "    <td>$ntrab</td>";
       echo "    <td>$pieza</td>";
       echo "</tr>";

       $total++;
    }
 }
 echo "<tr bgcolor='#ffffff'><td align='right' colspan=4>Total</td><td align='right'>$total</td></tr>";
 echo "</table>";
}
?>
<center><a href='javascript:window.print()'>Imprimir</a></center>
