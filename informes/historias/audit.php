<?php

$link=mysql_connect("elias","root","virgen");
$db = mysql_select_db("apolonia");
if($cmd=="auditar")
 {
    $hoy = Date("Y-m-d");
    $q = mysql_query("update Auditoria set Auditada=1, FechaAud = '$hoy'  where Paciente=$pac and Fecha='$fecha' and Pieza=$pieza and Tipo=$tipo");

    echo mysql_error();
 }

echo "<center><h2>Historias para auditar</h2></center><hr>";
if(empty($cmd))
 {
     echo "<form action='audit.php' method=post>\n";
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
     echo "   <td colspan=2><input type='submit' name='cmd' value='Ejecutar!'></td>";
     echo "</tr>";
     echo "</table></center>\n";
     echo "</form>\n";
}
else
 {
     if(empty($FECHADESDE))
          $FECHADESDE='2003-07-01';
     if(empty($FECHAHASTA))
        $FECHAHASTA = '2006-12-31';

     echo "<h3>Historias para auditar generadas entre $FECHADESDE y $FECHAHASTA </h3>";

     $q1 = mysql_query("select Paciente, Fecha,Tipo,Pieza,Auditada,Nombre from Auditoria, Pacientes where Fecha >= '$FECHADESDE' and Fecha <= '$FECHAHASTA' and Pacientes.Cedula = Paciente and Auditada = 0 order by Fecha");

     echo "<table border=1>";
     echo "<tr><th>Paciente</th><th>Fecha</th><th>Tipo</th><th>Pieza</th><th>Auditada</th></tr>";
     while($reg=mysql_fetch_object($q1))
        {
           echo "<tr>";
	   $pac   = $reg->Paciente;
	   $nombpac=$reg->Nombre;
	   $fecha = $reg->Fecha;
	   $tipo  = $reg->Tipo;
	   $pieza = $reg->Pieza;
	   $audit = $reg->Auditada;

           if($tipo==1)
	     $xtipo = "Laboratorio";
	   else
	     $xtipo = "Sesiones excedidas";

	   $ellink="<a href='../../historias/mostrarepisodioconnombre.php?paciente=$pac'>";
	   echo "<td>$ellink $pac </a>$nombpac</td><td>$fecha</td><td>$xtipo</td><td>$pieza</td>";
	   echo "<td>";
	   if($audit==0)
	     {
	       echo " <a href='audit.php?cmd=auditar&pac=$pac&fecha=$fecha&tipo=$tipo&pieza=$pieza'>Auditar</a>";
	     }
	      else echo "$audit";
	   echo "</td>";
	   echo "</tr>";
	}

}
mysql_close();
?>
