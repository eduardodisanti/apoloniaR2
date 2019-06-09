<?php

echo "<script languaje='javascript'>\n";
echo "
  function actualizarDocumentos(tipdoc, numdoc) {
			
      xdoc = document.getElementById &&
      document.getElementById(tipdoc).value;
    		
      xnum = document.getElementById &&
      document.getElementById(numdoc).value;
    		
      alert(xdoc+'-'+xnum);
}
";
echo "</script>";

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
     echo "<form action='../informes/venctrabxpac.php' method=post>\n";
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
     echo "<input type='hidden' name='comando' value='$cmd'>";
     echo "</form>\n";
 }
else
 {
    require("../functions/db.php");
    $hoy = Date("Y-m-d");
     if(empty($FECHADESDE))
          $FECHADESDE=$hoy;
     if(empty($FECHAHASTA))
        $FECHAHASTA = $hoy;
     $link=conectar();
     
     if($accion=="bajar")
      {
     
	   $query = "update TrabSoc set Entregado=Entregado+1 where Paciente=$pac and Trabajo=$trabajo and Fecha='$fecha'";
	   $q = query($query);

       $estaditoX = $estadoact + 1;
	   $query = "insert into HistTrabSoc values($pac, $trabajo, '$hoy', $pieza, $estaditoX, $codlab, '$hoy')";
	   $q = query($query);

	   $err = mysql_error();
	   if(!empty($err))
	      echo $err;


	   if($facturable=='S')
	     {
	        abrirVentanaRemito($pac, $trabajo, $hoy, $pieza, $codlab);
		 $query = "update TrabSoc set Facturado='S' where Paciente=$pac and Trabajo=$trabajo and Fecha='$fecha'";
                 $q = query($query);
	     }
	 }
    if($accion=="retroceder")
      {
          $query = "update TrabSoc set Entregado=Entregado-1 where Paciente=$pac and Trabajo=$trabajo and Fecha='$fecha'";
          $q = query($query);

          $estaditoX = $estadoact - 1;
	      $query = "insert into HistTrabSoc values($pac, $trabajo, '$hoy', $pieza, $estaditoX, $codlab, '$hoy')";
          $q = query($query);
      }
     
     // *********** primero determino cual es el procedimiento mas largo
     
     echo "Lista de trabajos de $cedula<br>";
     
$query = "select Paciente, Trabajo, Fecha, Vence, Trabajos.descripcion, tiempo, Nombre, EstadosTrabajo.Descripcion as estadito, Laboratorios.descripcion as xLab, Sucursal, Facturable, Pieza, TrabSoc.Laboratorio as codlab, Entregado as estadoact, Facturado from TrabSoc, Trabajos, Pacientes, EstadosTrabajo, Laboratorios where TrabSoc.Paciente = $cedula and Trabajo = Trabajos.id and Paciente = Cedula and EstadosTrabajo.Codigo = TrabSoc.Entregado and Laboratorios.id = TrabSoc.Laboratorio order by Fecha,descripcion";
echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "	<th colspan=2>Paciente</th>";
echo "	<th>Procedimiento</th>";
echo "	<th>Estado</th>";
echo "	<th>Solicitado</th>";
echo "  <th>Estado</th>";
echo "  <th>Vence</th>";
echo "  <th>Laboratorio</th>";
echo "  <th>Sucursal</th>";
echo "</tr>\n";

$q = query($query);
echo mysql_error();
$linea=0;
while($reg = fetch($q))
 {
	$cedula = $reg->Paciente;
	$nombre = $reg->Nombre;
	$trabajo= $reg->Trabajo;
	$desctra= $reg->descripcion;
	$tiempo = $reg->tiempo;
	$fecha  = $reg->Fecha;
	$estadito=$reg->estadito;
	//$vence = date("Y-m-d", strtotime("+$tiempo day ".$fecha));
	$vence = $reg->Vence;
	$xLab  = $reg->xLab;
	$suc   = $reg->Sucursal;
	$facturable = $reg->Facturable;
	$Pieza      = $reg->Pieza;
	$codlab     = $reg->codlab;
	$estadoact  = $reg->estadoact;
	$facturado  = $reg->Facturado;

    $fact = $facturable;
    if($facturable=='S')
	   $facturable="Facturable";
	else
	   $facturable="";
	   
	echo "<tr bgcolor='#ffffff'>";
	echo "  <td>$nombre</td>";
	echo "  <td align='center'>$cedula</td>";
	echo "  <td>$desctra<br><font color='#FF0000'>$facturable</font></td>";
	echo "  <td>$estadito</td>";
	echo "	<td>$fecha</td>";
	echo "  <td>";
	if($cmd=="bajar")
	   {
	      if($facturado != 'S')
	          $permiso = true;
              else
	          $permiso = false;

              if($suc == "CENTRAL") // * ANTES SOLO CENTRAL PODIA PASAR A 7 *
                 $estadopermiso = 7;
              else
	         $estadopermiso = 7; // ** ACA DECIA 6 

	          if($estadoact < $estadopermiso)
		   echo "<a href='venctrabxpac.php?cmd=bajar&accion=bajar&pac=$cedula&trabajo=$trabajo&fecha=$fecha&cmd=bajar&comando=seguir&cedula=$cedula&pieza=$Pieza&codlab=$codlab&estadito=$estadito&estadoact=$estadoact&facturable=$fact'>$estadito</a><br>";
		  else
		      echo $estadito."<br>";

		   if($estadoact > 3 && $permiso==true) {
		        echo "<a href='venctrabxpac.php?cmd=bajar&accion=retroceder&pac=$cedula&trabajo=$trabajo&fecha=$fecha&cmd=bajar&comando=seguir&cedula=$cedula&pieza=$Pieza&codlab=$codlab&estadito=$estadito&estadoact=$estadoact'>Retroceder</a>";
		   }
		}

		echo "</td>";
		echo "<td>$vence</td>";
		echo "<td>$xLab</td>";
		echo "<td>$suc</td>";
		echo "</tr>\n";
		
		$linea++;
 }
 echo "</table>";

 echo "<center><a href='venctrabxpac.php'>Otro Paciente</a></center>";
}
?>
