<?php

 require("../functions/db.php");
 
 $link=conectar();

 if($comando=="Borrar")
   {
     $act=mysql_query("delete from Molde  where DiaDesde=$DiaDesde and DiaHasta=$DiaHasta and Turno=$Turno and Consultorio='$Consultorio'") or die("Error ".mysql_error()." borrando molde");
   }

 if($comando=="Agregar")
   {
     echo "insert into Molde values($diadesde,$diahasta,$turno,'$consultorio',$lugares,'$hora',$doctor,$horafin)";
     $act=mysql_query("insert into Molde values($diadesde,$diahasta,$turno,'$consultorio',$lugares,'$hora',$doctor,$horafin)") or die("Error ".mysql_error()." grabando molde");
   }

 if($comando=="Actualizar")
   {
     $act=mysql_query("update Molde set DiaDesde=$diadesde,DiaHasta=$diahasta,Turno=$turno,Consultorio='$consultorio',Lugares=$lugares,Hora='$hora',Doctor=$doctor,HoraFin=$horafin where DiaDesde=$DiaDesde and DiaHasta=$DiaHasta and Turno=$Turno and Consultorio='$Consultorio'") or die("Error ".mysql_error()." actualizando molde");
   }
 $query=mysql_query("select DiaDesde,DiaHasta,Turno,Consultorio,Lugares,Hora,Doctor,Nombre,HoraFin from Molde,Medicos where Molde.Doctor = Medicos.Numero order by DiaDesde, DiaHasta, Consultorio, Turno");
  echo "<table border=1 width=95%>\n";
  echo "<tr bgcolor=\"#fbfbfb\" align=center>\n";
  echo "  <td>Dia Desde</td>\n";
  echo "  <td>Dia Hasta</td>\n";
  echo "  <td>Turno</td>\n";
  echo "  <td>Consultorio</td>\n";
  echo "  <td>Lugares</td>\n";
  echo "  <td>Hora</td>\n";
  echo "  <td>Medico</td>\n";
  echo "  <td>Odontologo</td>\n";
  echo "  <td>Duracion</td>\n";
  echo "  <td>&nbsp;&nbsp;</td>\n";
  echo "</tr>\n";

       echo "<tr>\n";
       echo "<form action=\"molde.php\" method=\"post\">\n";
       echo "<td><input type=\"input\" value=\"\" name=\"diadesde\" size=2 maxlength=1></td>\n";
       echo "<td><input type=\"input\" value=\"\" name=\"diahasta\" size=2 maxlength=1></td>\n";
       echo "<td><input type=\"input\" value=\"\" name=\"turno\" size=2 maxlength=2</td>\n";
       echo "<td><input type=\"input\" value=\"\" name=\"consultorio\" size=5 maxlength=5></td>\n";
       echo "<td><input type=\"input\" value=\"\" name=\"lugares\" size=2 maxlenght=2></td>\n";
       echo "<td><input type=\"input\" value=\"\" name=\"hora\" size=8 maxlength=8></td>\n";
       echo "<td><input type=\"input\" value=\"\" name=\"doctor\" size=3 maxlenght=5></td>\n";
       echo "<td>$rowi->Nombre</td>\n";
       echo "<td align=right><input type=\"input\" value=\"\" name=\"horafin\" size=4></td>\n";
       echo "<td><input type=\"submit\" name=\"comando\" value=\"Agregar\">";
       echo "</td>\n";
       echo "</tr>\n";
      echo "</form>\n";
 
  while($rowi=mysql_fetch_object($query))
   {
       echo "<form action=\"molde.php\" method=\"post\">";
       echo "<input type=\"hidden\" value=\"$rowi->DiaDesde\" name=\"DiaDesde\">";
       echo "<input type=\"hidden\" value=\"$rowi->DiaHasta\" name=\"DiaHasta\">";
       echo "<input type=\"hidden\" value=\"$rowi->Turno\" name=\"Turno\">";
       echo "<input type=\"hidden\" value=\"$rowi->Consultorio\" name=\"Consultorio\">";

       echo "<tr>";
       echo "<td><input type=\"input\" value=\"$rowi->DiaDesde\" name=\"diadesde\" size=2 maxlength=1></td>\n";
       echo "<td><input type=\"input\" value=\"$rowi->DiaHasta\" name=\"diahasta\" size=2 maxlength=1></td>\n";
       echo "<td><input type=\"input\" value=\"$rowi->Turno\" name=\"turno\" size=2 maxlength=2</td>\n";
       echo "<td><input type=\"input\" value=\"$rowi->Consultorio\" name=\"consultorio\" size=5 maxlength=5></td>\n";
       echo "<td><input type=\"input\" value=\"$rowi->Lugares\" name=\"lugares\" size=2 maxlenght=2></td>\n";
       echo "<td><input type=\"input\" value=\"$rowi->Hora\" name=\"hora\" size=8 maxlength=8></td>\n";
       echo "<td><input type=\"input\" value=\"$rowi->Doctor\" name=\"doctor\" size=3 maxlength=5></td>\n";
       echo "<td>$rowi->Nombre</td>\n";
       echo "<td align=right><input type=\"input\" value=\"$rowi->HoraFin\" name=\"horafin\" size=4></td>\n";
       echo "<td><input type=\"submit\" name=\"comando\" value=\"Actualizar\">";
       echo "    <input type=\"submit\" name=\"comando\" value=\"Borrar\">";
       echo "</td>\n";
       echo "</tr>";
      echo "</form>\n";
   } 
  echo "</table>\n";
  desconectar();
?>
<hr>
<center>
    <a href="/agenda/index1.php"><font size=+1>Volvar a la agenda</a></a>
</center>
