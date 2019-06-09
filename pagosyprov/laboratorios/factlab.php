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


echo "<center><h4>Control de facturacion de laboratorios</h4></center><hr>";
if(empty($comando))
 {
      if(!empty($val))
         $limit = "where id = $val"; 
      else
         $limit = "";

      $query="select * from Laboratorios $limit order by descripcion";
      $qry = query($query);

     echo "<form action='factlab.php' method=post>\n";
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
     
echo "Lista de trabajos realizados entre $FECHADESDE y $FECHAHASTA<br>";
     
if($Laboratorio != 0)
  $limit = "and HistTrabSoc.Laboratorio = $Laboratorio";
else
  $limit="";

$query = "select Paciente, Trabajo, Fecha, Trabajos.descripcion, Trabajos.Costo as Precio, tiempo, Nombre, Episodio, Laboratorios.descripcion as nombreLab, Pieza, TipoIva.valor from HistTrabSoc, Trabajos, Pacientes, Laboratorios, TipoIva where Fecha >= '$FECHADESDE' and Fecha <='$FECHAHASTA' and Trabajo = Trabajos.id and Paciente = Cedula and Trabajos.Facturable='S' and (Episodio = 5 or Episodio = 8) and Episodio != 88 $limit and HistTrabSoc.Laboratorio = Laboratorios.id and TipoIva.id = Trabajos.TipoIva group by HistTrabSoc.Paciente, HistTrabSoc.Fecha, Episodio, Trabajo order by HistTrabSoc.Laboratorio, Nombre, HistTrabSoc.Fecha, Episodio, Fecha,descripcion";

echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "	<th colspan=2>Paciente</th>";
echo "	<th>Procedimiento</th>";
echo "	<th>Entregado</th>";
echo "  <th>Precio</th>";
echo "  <th>Iva</th>";
echo "  <th>Importe</th>";
echo "</tr>\n";

$q = query($query);
echo mysql_error();
$labANT="";
$guita = 0;

while($reg = fetch($q))
 {
	$cedula = $reg->Paciente;
	$nombre = $reg->Nombre;
	$trabajo= $reg->Trabajo;
	$desctra= $reg->descripcion;
	$tiempo = $reg->tiempo;
	$fecha  = $reg->Fecha;
        $nombreLab=$reg->nombreLab;
	$precio  = $reg->Precio;
	$estado = $reg->Episodio;
	$pieza  = $reg->Pieza;
	$tiva   = $reg->iva;
	$importe= $precio + ($precio * $reg->iva)/100;

        if($nombreLab!=$labAnt)
	  {
	     if(!empty($labAnt))
	       {
	         echo "<tr><td colspan=4 bgcolor='#cccccc' align='right'><font size='+1'><b>Importe </b></font></td><td align='right' bgcolor='#cccccc'>$guita</td></tr>";
	       }
	     echo "<tr><td colspan=5 bgcolor='#cccccc' align='center'><font size='+1'><b>$nombreLab</b></font></td></tr>";
	     $labAnt=$nombreLab;
	     $guita = 0;
	  }
	  if($estado==8)
	   {
	     //$importe = $importe * -1;
             $det="*RETRABAJO*";
	   } else
	          {
		        $det="";
		  }
		echo "<tr bgcolor='#ffffff'>";
		echo "  <td>$nombre</td>";
		echo "  <td align='center'>$cedula</td>";
		echo "  <td>$desctra $det en $pieza</td>";
		echo "	<td>$fecha</td>";
		echo "  <td align='right'>$importe</td>";
		echo "</tr>\n";

		$guita+=$importe;
 }

 echo "<tr><td colspan='4' bgcolor='#ffffff'>Total</td><td bgcolor='ffffff' align='right'>$guita</td></tr>";
 echo "</table>";
}
?>
<center><a href='javascript:window.print()'>Imprimir</a></center>
