<?php
     $link=mysql_connect("elias","root","virgen");
     $db = mysql_select_db("apolonia");

     $q="select Year(Fecha) as anio, Month(Fecha) as mes, count(*) as cant from Horarios where Vino='N' and Paciente !=0 group by Year(Fecha), Month(Fecha) order by Year(Fecha) desc, Month(Fecha) desc";

      echo "<center><h3>Evolucion del ausentismo</h3>";
      echo "<table border=0 bgcolor=\"#000000\" cellpadding=1 cellspasing=1>\n";
           echo "<tr bgcolor=\"#cccccc\">\n";
           echo "   <th>Fecha</th>";
           echo "   <th>Pacientes</th>";
           echo "</tr>\n";

   $meses = 0;
   $cant  = 0;
   $query=mysql_query($q);
   echo mysql_error();
   while($reg=mysql_fetch_object($query))
    {
      $an = $reg->anio;
      $mes = $reg->mes;
      $can= $reg->cant;

           echo "<tr bgcolor=\"#ffffff\">\n";
           echo "   <td align=left>$an / $mes</td>";
           echo "   <td align='right'>$can</td>";
           echo "</tr>\n";

	   $meses++;
	   $cant+=$can;
    }

      $prom = $cant / $meses;
      echo "<tr bgcolor=\"#ffffff\">\n";
      echo "   <td align=left>Promedio mensual</td>";
      echo "   <td align='right'>$prom</td>";
      echo "</tr>\n";

      echo "</table></center>";
      mysql_close();
?>
<hr>
<button onclick="javascript:history.back()">Volver</button>


