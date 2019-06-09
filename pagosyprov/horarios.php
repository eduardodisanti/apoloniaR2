<?php
     $link=mysql_connect("elias","apolonia","virgen");
     $db = mysql_select_db("apolonia");

     $q="select Sucursal, Especialidades.Nombre as esp, Fecha, Turno, Medicos.Nombre as xnombre, count(*) as lugares from Horarios, Consultorios, Medicos, Especialidades where Horarios.Fecha >= '$fechadesde' and Horarios.Fecha <= '$fechahasta' and Horarios.Medico = Medicos.Numero and Horarios.Consultorio = Consultorios.Codigo and Especialidades.Codigo = Medicos.especialidad group by Sucursal, Consultorio, esp, Fecha, Turno order by Sucursal, esp, Fecha, Medico, Turno";

      echo "<center><h3>Lista de Horarios</h3>";
      echo "<table border=0 bgcolor=\"#000000\" cellpadding=1 cellspasing=1>\n";
           echo "<tr bgcolor=\"#cccccc\">\n";
           echo "   <th>Sucursal</th>";
           echo "   <th>Especialidad</th>";
           echo "   <th>Fecha</th>";
           echo "   <th>Turno</th>";
           echo "   <th>Medico</th>";
           echo "   <th>Lugares</th>";
           echo "</tr>\n";

   $query=mysql_query($q);
   echo mysql_error();
   while($reg=mysql_fetch_object($query))
    {
      $suc = $reg->Sucursal;
      $esp = $reg->esp;
      $fecha= $reg->Fecha;
      $hors= $reg->horas;
      $lugares = $reg->lugares;
      $turno   = $reg->Turno;
      $medico  = $reg->xnombre;

           echo "<tr bgcolor=\"#ffffff\">\n";
           echo "   <td align=left>$suc</td>";
           echo "   <td>$esp</td>";
           echo "   <td>$fecha</td>";
           echo "   <td>$turno</td>";
           echo "   <td>$medico</td>";
           echo "   <td>$lugares</td>";
           echo "</tr>\n";
    }

      echo "</table></center>";
      mysql_close();
?>
<hr>
<button onclick="javascript:history.back()">Volver</button>


