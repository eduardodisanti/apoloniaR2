<?php

require("../functions/db.php");
 $link=conectar();

function date_diff($date2, $date1)
  {
      $s = strtotime($date2) - strtotime($date1);
      $d = intval($s/86400);
      return($d);
  }
if($cmd=="Cambiar")
 {
   $query = "update TrabSoc set Sucursal='$newsuc' where Paciente=$paciente and Fecha='$fecha' and Sucursal='$cursuc' and Pieza = $pieza and Trabajo=$trabajo";
   query($query);
   $query = "update MetaTrabSoc set Sucursal='$newsuc' where Paciente=$paciente and Sucursal='$cursuc' and Pieza=$pieza";

   query($query);
  $comando="x";
  $cedula=$paciente;
 }

echo "<center><h4>Cambiar trabajos de una Sucursal a otra</h4></center><hr>";
if(empty($comando))
 {
     echo "<form action='cambiarsuc.php' method=post>\n";
     echo "<center><table border = 0 width='60%'>\n";
     echo "<tr>";
     echo "   <td>Cedula</td>";
     echo "   <td><input type='text' width='10' name='cedula'></td>";
     echo "</tr>";
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
    $hoy = Date("Y-m-d");
     if(empty($FECHADESDE))
          $FECHADESDE=$hoy;
     if(empty($FECHAHASTA))
        $FECHAHASTA = $hoy;
     
     echo "Lista de trabajos de $cedula<br>";
     
$query = "select Paciente, Trabajo, Fecha, Trabajos.descripcion, tiempo, Nombre, EstadosTrabajo.Descripcion as estadito, Laboratorios.descripcion as xLab, Sucursal, TrabSoc.Laboratorio as idlab, Pieza from TrabSoc, Trabajos, Pacientes, EstadosTrabajo, Laboratorios where TrabSoc.Paciente = $cedula and Trabajo = Trabajos.id and Paciente = Cedula and EstadosTrabajo.Codigo = TrabSoc.Entregado and Laboratorios.id = TrabSoc.Laboratorio order by Fecha,descripcion";

echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "	<th colspan=2>Paciente</th>";
echo "	<th>Procedimiento</th>";
echo "  <th>Pieza</th>";
echo "	<th>Vencimiento</th>";
echo "  <th>Estado</th>";
echo "  <th>Vence</th>";
echo "  <th>Sucursal</th>";
echo "  <th>Laboratorio</th>";
echo "  <th>cmd</th>";
echo "</tr>\n";

$q = query($query);

while($reg = fetch($q))
 {
	$cedula = $reg->Paciente;
	$nombre = $reg->Nombre;
	$trabajo= $reg->Trabajo;
	$desctra= $reg->descripcion;
	$tiempo = $reg->tiempo;
	$fecha  = $reg->Fecha;
	$estadito=$reg->estadito;
	$vence = date("Y-m-d", strtotime("+$tiempo day ".$fecha));
	$xLab  = $reg->xLab;
	$suc   = $reg->Sucursal;
	$cursuc= $reg->Sucursal;
	$pieza = $reg->Pieza;

  echo "<form action = 'cambiarsuc.php'>";
	echo "<tr bgcolor='#ffffff'>";
	echo "  <td>$nombre</td>";
	echo "  <td align='center'>$cedula</td>";
	echo "  <td>$desctra $trabajo</td>";
	echo "  <td>$pieza</td>";
	echo "  <td>$estadito</td>";
	echo "	<td>$fecha</td>";
	echo "<td>$vence</td>";
	echo "<td>";

   $query = "select Sucursal from Consultorios group by Sucursal order by Sucursal";
   $lq = query($query);
   echo "<select name='newsuc'>";
   while($labreg = fetch($lq))
     {
	$nsuc = $labreg->Sucursal;
	if($nsuc == $cursuc)
	   $select = "selected";
	else
	   $select = "";
        echo "<option value='$nsuc' $select>$nsuc</option>";
     }             
   echo "</select>";
	echo "</td>";
	echo "<td>$xLab</td>";
	echo "<td>";
	echo "   <input type='submit' name='cmd' value='Cambiar'>";
	echo "</td>";
	echo "</tr>\n";
	echo "   <input type='hidden' name='paciente' value='$cedula'>";
        echo "   <input type='hidden' name='trabajo'  value='$trabajo'>";
        echo "   <input type='hidden' name='fecha'    value='$fecha'>";
        echo "   <input type='hidden' name='cursuc'   value='$cursuc'>";
	echo "   <input type='hidden' name='pieza'   value='$pieza'>";
   echo "</form>";
 }

 echo "</table>";

 echo "<center><a href='cambiarsuc.php'>Otro</a></center>";
}
?>
