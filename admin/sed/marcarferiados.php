<?
  $link=mysql_connect("elias","apolonia","virgen") or
                         die("Error, no se puede abrir la base de datos".mysql_error());
      $db=mysql_select_db("apolonia"); 

   if($cmd=="marcar")
     {
        if($feriado=="SI")
           $marca="N";
        else
           $marca="S";
        mysql_query("update Calendario set Feriado='$marca' where Fecha='$fecha'");
     }
      $qq="select * from Calendario Order by Fecha"; 

   echo "<center>\n";
   echo "<h1>Marcar feriados</h1><hr>\n";
   echo "<table border=\"1\" width=60%>\n";
   echo "<tr bgcolor=\"#ccfcfc\"><td align=center>Fecha</td><td align=center>Dia de la semana</td><td align=center>Feriado</td></tr>";
   $query=mysql_query($qq);
   while($rowi=mysql_fetch_object($query))
     { 
        $fecha=$rowi->Fecha;
        $dia=$rowi->DiaDeLaSemana;
        if($dia==1)
           $xdia="Lunes";
        if($dia==2)
           $xdia="Martes";
        if($dia==3)
           $xdia="Miercoles";
        if($dia==4)
           $xdia="Jueves";
        if($dia==5)
           $xdia="Viernes";
        if($dia==6)
           $xdia="Sabado";
        if($dia==7)
           $xdia="Domingo";

        $feriado=$rowi->Feriado;
        if($feriado=="S")
           {
             $xferiado="SI";
             echo "<tr bgcolor=\"#ffffff\">";
           }
        else
           {
             $xferiado="NO";
             echo "<tr bgcolor=\"\">";
           }
        echo "  <td>$fecha</td>\n";
        echo "  <td>$xdia</td>\n";
        echo "  <td><a href=\"marcarferiados.php?fecha=$fecha&feriado=$xferiado&cmd=marcar\">$xferiado</a></td>\n";
        echo "</tr>\n";
     }
   echo "</center>\n";
   echo "</table>\n";
   mysql_close();
?>
   <hr>
