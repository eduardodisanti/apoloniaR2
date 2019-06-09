<?php

if(empty($comando))
 {
     echo "<center><h2>Listado de Impresiones y colocaciones en el dia</h2></center><hr>";

     if(empty($FECHADESDE))
          $FECHADESDE=Date("Y-m-d");
     if(empty($FECHAHASTA))
        $FECHAHASTA = Date("Y-m-d");

     echo "<form action='listxlab.php' method=post>\n";
     echo "<center><table border = 0 width='60%'>\n";
     echo "<tr>";
     echo "   <td>Fecha desde (AAAA-MM-DD)</td>";
     echo "   <td><input type='text' width='10' name='FECHADESDE' value='$FECHADESDE'></td>";
     echo "</tr>";
     echo "<tr>";
     echo "   <td>Fecha hasta (AAAA-MM-DD)</td>";
     echo "   <td><input type='text' width='10' name='FECHAHASTA'value='$FECHAHASTA'></td>";
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
     if(empty($FECHADESDE))
          $FECHADESDE=Date("Y-m-d");
     if(empty($FECHAHASTA))
        $FECHAHASTA = Date("Y-m-d");

     echo "<center><h5>Listado de Impresiones y colocaciones en el dia entre $FECHADESDE y $FECHAHASTA</h5></center><hr>";

     $link=mysql_connect("elias","apolonia","virgen");
     $db = mysql_select_db("apolonia");

     $q="select Fecha, Paciente, Pacientes.Nombre, Hora, Sucursal, count(Paciente) as Cantidad, Medicos.Nombre as NomMed from Horarios,Pacientes,Consultorios, Medicos where Fecha>='$FECHADESDE' and Fecha <='$FECHAHASTA' and Paciente!=0 and (Procedimiento=688 or Procedimiento=687) and Paciente=Cedula and Consultorio=Consultorios.Codigo  and Medicos.Numero = Horarios.Medico group by Fecha,Paciente order by Fecha, Pacientes.Nombre";

     echo "<table border=0 bgcolor='#000000' width='95%'>";
     echo "<tr bgcolor='#cccccc'>";
     echo "	<th>Fecha</th><th colspan=2>Paciente</th><th>Sucursal</th><th>Medico</th><th>Impresi&oacute;n</th><th>Colocaci&oacute;n</th>";
     echo "</tr>";
     $query=mysql_query($q);
     echo mysql_error();
     while($reg=mysql_fetch_object($query))
      {
          $fecha=$reg->Fecha;
          $cedula=$reg->Paciente;
          $nom=$reg->Nombre;
          $cant=$reg->Cantidad;
          $suc =$reg->Sucursal;
	  $med =$reg->NomMed;

          if($cant>1)
           { 
             echo "<tr bgcolor='#ffffff'>";
             echo "<td>$fecha</td>";
             echo "<td>$cedula</td>";
             echo "<td>$nom</td>";
             echo "<td>$suc</td>";
             echo "<td>$med</td>";

              $nq=mysql_query("select Hora from Horarios where Fecha='$fecha' and Paciente=$cedula and (Procedimiento=687 or Procedimiento=688) order by Hora");
              while($nreg=mysql_fetch_object($nq))
                {
                     $hora=$nreg->Hora;
                     echo "<td>$hora</td>";
                }
             echo "</tr>";
           }
          
      }
     echo "</table>";
     mysql_close($link);
}
?>
<hr>
<center>
<table border=0 bgcolor='#000000' cellspacing='5' cellpadding='5'>
<tr>
<td>
	<a href='javascript:window.print()'><font color='#ffffff'>Imprimir</font></a>
</td>
<td>
	<a href='javascript:window.close()'><font color='#ffffff'>Cerrar</font></a>
</td>
</tr>
</table>
</center>
