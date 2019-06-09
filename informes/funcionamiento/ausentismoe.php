<?php
     $link=mysql_connect("elias","root","virgen");
     $db = mysql_select_db("apolonia");

     $q="select Sucursal, Especialidades.Nombre as esp, count(*) as lugares from Horarios, Consultorios, Medicos, Especialidades where Horarios.Fecha >= '$fechadesde' and Horarios.Fecha <= '$fechahasta' and Horarios.Medico = Medicos.Numero and Horarios.Consultorio = Consultorios.Codigo and Especialidades.Codigo = Medicos.especialidad and Vino='N' and Paciente !=0 group by Sucursal, esp order by Sucursal, esp";

      echo "<center><h3>Lista de Horarios</h3>";
      echo "<table border=0 bgcolor=\"#000000\" cellpadding=1 cellspasing=1>\n";
           echo "<tr bgcolor=\"#999999\">\n";
           echo "   <th>Sucursal</th>";
           echo "   <th>Especialidad</th>";
           echo "   <th>Lugares no utilizados</th>";
           echo "</tr>\n";

   $query=mysql_query($q);

   $sucursalAnt="";
   $color="#ffffff";

   while($reg=mysql_fetch_object($query))
    {
      $suc = $reg->Sucursal;

      if($suc != $sucursalAnt) {

          if($color=="#ffffff")
	     $color="#cccccc";
	  else
	     $color="#ffffff";

	  $sucursalAnt = $suc;
      }

      $esp = $reg->esp;
      $hors= $reg->horas;
      $lugares = $reg->lugares;

           echo "<tr bgcolor=\"$color\">\n";
           echo "   <td align=left>$suc</td>";
           echo "   <td>$esp</td>";
           echo "   <td align='right'>$lugares</td>";
           echo "</tr>\n";
    }

      echo "</table></center>";
      mysql_close();
?>
<hr>
<button onclick="javascript:history.back()">Volver</button>


