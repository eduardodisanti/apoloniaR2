<?php

session_start();
$coisucursal_ses=$_SESSION['coisucursal_ses'];

function date_diff($date2, $date1)
  {
      $s = strtotime($date2) - strtotime($date1);
      $d = intval($s/86400);
      return($d);
  }
if(empty($cmd))
  $cmd=bajar;

require("../functions/db.php");
$link=conectar();

$hoy=date("d-m-Y");

echo "<center><h4>Listado de trabajos de laboratorio Emitido : $hoy</h4></center>";
if(empty($comando))
 {

      $query="select Sucursal from Consultorios group by Sucursal order by Sucursal";
      $qry = query($query);

     echo "<form action='../informes/estadoTrabajos.php' method=post>\n";
     echo "Sucursal   <select name='sucursal'>";
     echo "<option value='0'>Todos</option>";
     while($reg=fetch($qry))
       {
         if($reg->Sucursal=="$coisucursal_ses")
	   $sel="SELECTED";
	 else
	   $sel="";
         echo "<option value='$reg->Sucursal' $sel>$reg->Sucursal</option>"; 
       }
     echo "<option value='999'>Sin Sucursal</option>";
     echo "</select>";

     $query="select id,descripcion from Laboratorios order by descripcion ";
     $qry = query($query);

     echo "<br>Laboratorio : <select name='codLabo'>";
     echo "<option value=''>Todos</option>";
     while($reg=fetch($qry))
        {
         echo "<option value='$reg->id' $sel>$reg->descripcion</option>";
        }
	 echo "</select>";
     echo "<center><table border = 0 width='60%'>\n";
     echo "<tr>";
     echo "   <td>Filtro de trabajos</td>";
     echo "   <td>";

     $query="select * from EstadosTrabajo where Codigo > 0 order by Codigo";
     $qry = query($query);

     echo "<select name='estado'>";
     while($reg=fetch($qry))
     {
	$cod = $reg->Codigo;
	$des = $reg->Descripcion;

        echo "<option value='$cod'>$des</option>";
     }
     echo "</select>";

     echo "   </td>";
     echo "</tr>";
     $hoy=Date("Y-m-d");
     echo "<tr>";
     echo "   <td><input type='submit' name='comando' value='Ejecutar'></td>";
     echo "   <td>&nbsp;&nbsp</td>";
     echo "</tr>";
     echo "<tr>";
     echo "  <td>Fecha desde<input type='text' name='desde' value='$hoy'></td>";
     echo "  <td>Fecha hasta<input type='text' name='hasta' value='$hoy'></td>";
     echo "</tr>";
     echo "</table></center>\n";
     echo "<input type='hidden' name='comando' value='$cmd'>";

     echo "</form>\n";
 }
else
 {
     if($accion=="cerrar")
       {
         if(!empty($sucursal))
            $limit = "and TrabSoc.Sucursal = '$sucursal'";
	 	 else
	   		$limit="";

	 	 if(!empty($codLabo))
	        {
	         $limit = $limit." and TrabSoc.Laboratorio = $codLabo";
	        }

	 	  $limit = $limit." and Fecha>='$desde' and Fecha<='$hasta'";
	   	  $limit = $limit." and Impreso='N'";
          $query = "update TrabSoc set Impreso='S' where Entregado=4 $limit and Salida >='$desde' and Salida <= '$hasta' and Impreso='N'";

	 	  $q = query($query);
        }

     if($accion=="bajar")
        {
          $estadio=$estado+1;

	  	  if($estado==4 && $sucursalTrabajo=="CENTRAL")
	         $estadio=7;
	      $query = "update TrabSoc set Entregado=$estadio, Salida='$fecha' where Paciente=$pac and Trabajo=$trabajo and Fecha='$fecha'";
	      $q = query($query);
	      $query = "insert into HistTrabSoc values($pac, $trabajo, '$hoy', $pieza, $estadio, $Laboratorio)";
          $q = query($query);
        }
     if($accion=="retroceder" && estado > 1)
        {
          $estadio=$estado - 1;
          $query = "update TrabSoc set Entregado=$estadio, Salida='$fecha' where Paciente=$pac and Trabajo=$trabajo and Fecha='$fecha'";
          $q = query($query);
          $query = "insert into HistTrabSoc values($pac, $trabajo, '$hoy', $pieza, $estadio, $Laboratorio)";
          $q = query($query);
        }

if(!empty($sucursal))
  $limit = "and TrabSoc.Sucursal = '$sucursal'";
else
  $limit="";

if(!empty($codLabo))
  {
    $limit = $limit." and TrabSoc.Laboratorio = $codLabo";
  }

$limit = $limit." and Fecha>='$desde' and Fecha<='$hasta'";
$limit = $limit." and Impreso='N'";

$estado1 = $estado + 1;

$query = "select Paciente, Trabajo, Fecha, Trabajos.descripcion, tiempo, Nombre, Entregado, EstadosTrabajo.Descripcion as Nest, TrabSoc.Laboratorio as Lab, Laboratorios.descripcion as nLab, TrabSoc.Sucursal as SucursalT, Pieza, Repeticiones, Salida, Vence from TrabSoc, Trabajos, Pacientes, EstadosTrabajo, Laboratorios where (Entregado=$estado or Entregado=88) and Trabajo = Trabajos.id and Paciente = Cedula $limit and Entregado = EstadosTrabajo.Codigo and Laboratorios.id = TrabSoc.Laboratorio and Salida >='$desde' and Salida <= '$hasta' order by Paciente, Fecha, descripcion";

echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "	<th colspan=2>Paciente</th>";
echo "	<th>Procedimiento</th>";
echo "  <th>Pieza</th>";
echo "	<th>Solicitado</th>";
echo "	<th>Estado</th>";
echo "  <th>Vence</th>";
echo "  <th>Laboratorio</th>";
echo "</tr>\n";

$q = query($query);
echo mysql_error();
while($reg = fetch($q))
 {
	$cedula = $reg->Paciente;
	$nombre = $reg->Nombre;
	$trabajo= $reg->Trabajo;
	$desctra= $reg->descripcion;
	$tiempo = $reg->tiempo;
	$fecha  = $reg->Fecha;
	$sucursalTrabajo = $reg->SucursalT;
	$pieza  = $reg->Pieza;
	$rep    = $reg->Repeticiones;
    $estadoActual = $reg->Entregado;
    $Laboratorio = $reg->Lab;
    $nest   = $reg->Nest;
    $nlab   = $reg->nLab;
    $salida = $reg->Salida;
    $vence  = $reg->Vence;

   $retq = "select Fecha, Episodio from HistTrabSoc where Paciente=$cedula and Trabajo=$trabajo and Fecha='$fecha' order by Episodio desc limit 1";
   $retqq= query($retq);
   $regret = fetch($retqq);
   $fechar = $regret->Fecha;
   $episo = $regret->Episodio;
   

   if(!empty($fechar)) {
   
       if($episo == 8)
         $RETRA = "*** SEGUNDO TRABAJO <br>";
       else
         $RETRA = "*** RETRABAJO <br>";
       
       
   }

	//$vence = date("Y-m-d", strtotime("+$tiempo day ".$fecha));

               if($estadoActual == $estado)
                  $color="#ffffff";
	       else
	          $color="#cfffff";

               if($rep > 1)
	        {
	         $nombre = "<font color='#ff0000'>(Retrabajo)</font> ".$nombre;
                }

		echo "<tr bgcolor='$color'>";
		echo "  <td>$nombre</td>";
		echo "  <td align='center'>$cedula</td>";
		echo "  <td>$RETRA $desctra</td>";
		echo "  <td>$pieza</th>";
		echo "	<td>$fecha</td>";
		echo "  <td>";
		if($cmd=="bajar")
		  {
		   if($estadoActual == $estado)
		   echo "<a href='estadoTrabajos.php?cmd=bajar&accion=bajar&pac=$cedula&trabajo=$trabajo&fecha=$fecha&cmd=bajar&comando=seguir&Laboratorio=$Laboratorio&estado=$estadoActual&sucursalTrabajo=$sucursalTrabajo&codLabo=$codLabo&desde=$desde&hasta=$hasta&sucursal=$sucursal&pieza=$pieza'>$nest</a>";
		   else
		       echo $nest;
		   echo "<br><a href='estadoTrabajos.php?cmd=bajar&accion=retroceder&pac=$cedula&trabajo=$trabajo&fecha=$fecha&comando=seguir&Laboratorio=$Laboratorio&estado=$estadoActual&sucursalTrabajo=$sucursalTrabajo&codLabo=$codLabo&desde=$desde&hasta=$hasta&sucursal=$sucursal'>(<--)</a>";
		  }
		echo "</td>";
		echo "<td>$vence</td>";
		echo "<td>$nlab</td>"; 
		echo "</tr>\n";
 }
 echo "</table>";
  echo " <center><a href='javascript:window.print()'>Imprimir</a>      <a href='estadoTrabajos.php?cmd=cerrar&accion=cerrar&fecha=$fecha&codLabo=$codLabo&desde=$desde&hasta=$hasta&sucursal=$sucursal&comando=cerrar'>Cerrar la lista</a></center>";
}
?>
