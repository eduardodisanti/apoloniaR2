<?
 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");

 if($comando=="Borrar")
   {
     $act=mysql_query("delete from Autorizados  where Cedula=$Cedula and Fecha='$Fecha' and Medico=$Medico") or die("Error ".mysql_error()." borrando molde");
   }

 if($comando=="Agregar")
   {
     if($Medico==0 || empty($Medico))
       die("Debe poner el medico");
     $act=mysql_query("insert into Autorizados values($Cedula,'$Fecha',$Medico,'$Nota')") or die("Error ".mysql_error()." grabando autorizados");
   }

 $fechahoy=date("Y-m-d");
 $query=mysql_query("select Autorizados.Cedula,Fecha,Medico,Medicos.Nombre as nommed, Nota, Pacientes.Nombre as pac, Nota from Autorizados, Pacientes, Medicos where Autorizados.Medico = Medicos.Numero and Autorizados.Cedula = Pacientes.Cedula and Fecha >= '$fechahoy'and Autorizados.Por = coiusuario order by Fecha,Cedula") or die("Error ".mysql_error());
  echo "<table border=1 width=95%>\n";
  echo "<tr bgcolor=\"#fbfbfb\" align=center>\n";
  echo "  <td>Cedula</td>\n";
  echo "  <td>Nombre</td>\n";
  echo "  <td>Fecha</td>\n";
  echo "  <td>Medico</td>\n";
  echo "  <td>Medico</td>\n";
  echo "  <td>Nota</td>\n";
  echo "  <td>&nbsp;&nbsp;</td>\n";
  echo "</tr>\n";

       echo "<tr>\n";
       echo "<form action=\"autorizar.php\" method=\"post\">\n";
       echo "<td><input type=\"input\" value=\"0\" name=\"Cedula\" size=9 maxlength=9></td>\n";
       echo "<td>&nbsp;&nbsp;</td>\n";
       echo "<td><input type=\"input\" value=\"$fechahoy\" name=\"Fecha\" size=11 maxlength=10></td>\n";
       echo "<td><input type=\"input\" value=\"98\" name=\"Medico\" size=3 maxlength=3</td>\n";
       echo "<td>&nbsp;&nbsp;</td>\n";
       echo "<td><input type=\"textarea\" value=\"\" name=\"Nota\"></textarea></td>\n";
       echo "<td><input type=\"submit\" name=\"comando\" value=\"Agregar\">";
       echo "</td>\n";
       echo "</tr>\n";
      echo "</form>\n";
 
  while($rowi=mysql_fetch_object($query))
   {
    echo "<form action=\"autorizar.php\" method=\"post\">\n";

     echo "<input type=\"hidden\" value=\"$rowi->Cedula\" name=\"Cedula\">\n";
     echo "<input type=\"hidden\" value=\"$rowi->Fecha\" name=\"Fecha\">\n";
     echo "<input type=\"hidden\" value=\"$rowi->Medico\" name=\"Medico\">\n";
     echo "<tr>\n";
       echo "<td>$rowi->Cedula</td>\n";
       echo "<td>$rowi->pac</td>\n";
       echo "<td>$rowi->Fecha</td>\n";
       echo "<td>$rowi->Medico</td>\n";
       echo "<td>$rowi->nommed</td>\n";
       echo "<td><textarea>$rowi->Nota</textarea></td>\n";
       echo "<td>    <input type=\"submit\" name=\"comando\" value=\"Borrar\">";
       echo "</td>\n";
     echo "</tr>\n";
    echo "</form>\n";
   } 
  echo "</table>\n";
 mysql_close();
?>
<hr>
