<?php
if(empty($f1) || empty($f2))
 {
   echo "<center><h2>Informe de Urgencias por sucursal</h2>";
   echo "<form action=\"conemexmed.php\" method=\"post\">";
   echo "    <table border='0' bgcolor='#000000\>";
   echo "    <tr bgcolor='#ffffff'>";
   echo "        <td bgcolor='#ffffff'>";
   echo "             Fecha de inicio (AAAAMMDD)";
   echo "        </td>";
   echo "        <td bgcolor='#ffffff'>";
   echo "             <input type='text' value='$f1' name='f1' length='8'>";
   echo "        </td>";
   echo "    </tr>";
   echo "    <tr>";
   echo "        <td bgcolor='#ffffff'>";
   echo "             Fecha final     (AAAAMMDD)";
   echo "        </td>";
   echo "        <td bgcolor='#ffffff'>";
   echo "             <input type='text' value='$f2' name='f2' length='8'>";
   echo "        </td>";
   echo "    </tr>";
   echo "    <tr>";
   echo "        <td colspan=2 align='center' bgcolor='#ffffff'>";
   echo "             <input type='submit' value='Ejecutar'>";
   echo "        </td>";
   echo "    </tr>";
   echo "    </table>";
   echo "</form>";
   echo "</center>";
 }
else
 {
     $link=mysql_connect("elias","root","virgen");
     $db = mysql_select_db("apolonia");

   $q="select Sucursal, Medicos.Nombre, count(Horarios.Consultorio) as vistos from Horarios, Consultorios, Medicos where Consultorio=Codigo and Fecha >= '$f1' and Fecha <= '$f2' and Procedimiento = 693  and Medicos.Numero = Horarios.Medico group by Medico order by Nombre";

     echo "<center><h3>Consultas por sucursal entre $f1 y $f2</h3>";
      echo "<table border=0 bgcolor=\"#000000\" cellpadding=2>\n";
           echo "<tr bgcolor=\"#cccccc\">\n";
	   echo "   <td align=right>Medico</td>";
           echo "   <td>Pacientes vistos</td>";
           echo "</tr>\n";

   $query=mysql_query($q);
   while($reg=mysql_fetch_object($query))
    {
      $suc = $reg->Sucursal;
      $med = $reg->Nombre;
      $vistos= $reg->vistos;
           echo "<tr bgcolor=\"#ffffff\">\n";
	   echo "   <td align=left>$med</td>";
           echo "   <td align=\"right\">$vistos</td>";
           echo "</tr>\n";
    }

      echo "</table></center>";
      mysql_close();
 }
?>
<hr>
<button onclick="javascript:history.back()">Volver</button>


