<?php
     $link=mysql_connect("elias","apolonia","virgen");
     $db = mysql_select_db("apolonia");

   $q="select Sucursal,Consultorio,round(sum(HoraFin)/60) as horas from Molde,Consultorios where Molde.Consultorio = Consultorios.Codigo group by Sucursal,Consultorio";

     echo "<center><h3>Horas de consulta</h3>";
      echo "<table border=0 bgcolor=\"#000000\" cellpadding=2>\n";
           echo "<tr bgcolor=\"#cccccc\">\n";
           echo "   <td align=right>Sucursal</td>";
           echo "   <td>Consultorio</td>";
           echo "   <td>Horas</td>";
           echo "</tr>\n";

   $query=mysql_query($q);
   while($reg=mysql_fetch_object($query))
    {
      $suc = $reg->Sucursal;
      $cons= $reg->Consultorio;
      $hors= $reg->horas;
           echo "<tr bgcolor=\"#ffffff\">\n";
           echo "   <td align=left>$suc</td>";
           echo "   <td>$cons</td>";
           echo "   <td align=\"right\">$hors</td>";
           echo "</tr>\n";
    }

      echo "</table></center>";
      mysql_close();
?>
<hr>
<button onclick="javascript:history.back()">Volver</button>


