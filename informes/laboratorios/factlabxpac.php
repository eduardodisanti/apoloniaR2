<?php

function abrirVentanaRemito($pac, $trabajo, $hoy, $pieza, $codlab) {

    echo "<script languaje='javascript'>";
    echo "window.open('../laboratorio/remitolab.php?pac=$pac&trabajo=$trabajo&fecha=$hoy&pieza=$pieza&codlab=$codlab', 'Remito de laboratorio','width=400, height=300')";
    echo "</script>";
}

function date_diff($date2, $date1)
  {
      $s = strtotime($date2) - strtotime($date1);
      $d = intval($s/86400);
      return($d);
  }
if(empty($cmd))
  $cmd=bajar;

echo "<center><h4>Confirmaci&oacute;n de trabajos</h4></center><hr>";
if(empty($comando))
 {
     echo "<form action='factlabxpac.php' method=post>\n";
     echo "<center><table border = 0 width='60%'>\n";
     echo "<tr>";
     echo "   <td>Cedula</td>";
     echo "   <td><input type='text' width='10' name='cedula'></td>";
     echo "</tr>";
     echo "   <td>Fecha desde</td>";
     echo "   <td><input type='text' width='8' name='fdesde'></td>";
     echo "</tr>";
     echo "</tr>";
     echo "   <td>Fecha hasta</td>";
     echo "   <td><input type='text' width='8' name='fhasta'></td>";
     echo "</tr>";
     echo "<tr>";
     echo "   <td><input type='submit' name='comando' value='Ejecutar'></td>";
     echo "   <td>&nbsp;&nbsp</td>";
     echo "</tr>";
     echo "</table></center>\n";
     echo "</form>\n";
 }
else
 {
    require("../../functions/db.php");
    $hoy = Date("Y-m-d");
     if(empty($FECHADESDE))
          $FECHADESDE=$hoy;
     if(empty($FECHAHASTA))
        $FECHAHASTA = $hoy;
     $link=conectar();
     
$query = "select * from Pacientes where Cedula = $cedula";

$q = query($query);
$reg = fetch($q);
$nombre = $reg->Nombre;

echo "Lista de trabajos facturados de $cedula <b>$nombre</b><br>";


$query = "select Laboratorios.descripcion as ldesc, Serie, Numero, Fecha, Trabajo, Trabajos.descripcion ndesc, Pieza from FactLab, Trabajos, Laboratorios where Laboratorios.id = FactLab.Laboratorio and Trabajos.id = Trabajo and FactLab.Paciente = $cedula order by Trabajo, Pieza, Fecha";

echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "	<th>Laboratorio</th>";
echo "	<th>Serie</th>";
echo "	<th>Numero</th>";
echo "	<th>Fecha</th>";
echo "  <th>Trabajo</th>";
echo "  <th>Pieza</th>";
echo "</tr>\n";

$q = query($query);
echo mysql_error();
$linea=0;
while($reg = fetch($q))
 {

   $lab = $reg->ldesc;
   $ser = $reg->Serie;
   $num = $reg->Numero;
   $fec = $reg->Fecha;
   $nde = $reg->ndesc;
   $pie = $reg->Pieza;
  
   echo "<tr bgcolor='#ffffff'>";
   echo "	<td>$lab</td>";
   echo "	<td>$ser</td>";
   echo "	<td>$num</td>";
   echo "	<td>$fec</td>";
   echo "	<td>$nde</td>";
   echo "	<td>$pie</td>";
   echo "</tr>";
   $linea++;
 }
 echo "</table>";

 echo "<center><a href='factlabxpac.php'>Otro Paciente</a></center>";
}
?>
