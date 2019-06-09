<?php
     $link=mysql_connect("elias","apolonia","virgen");
     $db = mysql_select_db("apolonia");

	     $q="select Paciente, Nombre, count(Paciente) as cuenta from Horarios, Pacientes where Consultorio='1LT' and Fecha >= '2004-10-01' and Fecha <= '2004-10-31' and Paciente!=0 and Cedula=Paciente group by Paciente order by cuenta desc";

      echo "<center><h3>Consultas x paciente</h3>";
      echo "<table border=0 bgcolor=\"#000000\" cellpadding=1 cellspasing=1>\n";
           echo "<tr bgcolor=\"#cccccc\">\n";
           echo "   <th>Paciente</th>";
           echo "   <th>Nombre</th>";
           echo "   <th>Cuenta</th>";
           echo "</tr>\n";

   $query=mysql_query($q);
   echo mysql_error();
   while($reg=mysql_fetch_object($query))
    {
      $pac= $reg->Paciente;
      $nom= $reg->Nombre;
      $cuenta = $reg->cuenta;

      if($cuenta>1)
         { 
           echo "<tr bgcolor=\"#ffffff\">\n";
           echo "   <td>$pac</td>";
           echo "   <td>$nom</td>";
           echo "   <td>$cuenta</td>";
           echo "</tr>\n";
         }
    }

      echo "</table></center>";
      mysql_close();
?>
<hr>
<button onclick="javascript:history.back()">Volver</button>


