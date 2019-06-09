<?php

   $db=mysql_connect("elias","apolonia","virgen");
   mysql_select_db("apolonia");

   if($cmd=="Agregar")
      {
          $r=mysql_query("insert into Suplentes values('$Fecha','$Consultorio',$Turno,$Suplente)");
          echo "insert into Suplentes values('$Fecha','$Consultorio',
$Turno,$Suplente)";
      } else
          if($cmd=="Borrar")
	    {
		$r=mysql_query("delete from Suplentes where Fecha='$Fecha' and Consultorio='$Consultorio' and Turno=$Turno");
                echo "Borrado $Fecha, $Consultorio, $Turno.".mysql_error();
	    }
	     else
          	if($cmd=="Actualizar")
	    	{
			$r=mysql_query("update Suplentes set Suplente=$Suplente where Fecha='$Fecha' and Conslutorio='$Consultorio' and Turno=$Turno");
	    	}

   echo "<center><h2>Manejo de Suplentes</h2></center><hr>";
   echo "<table border=1 width=99%>\n";
   echo "<tr>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Fecha";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Consultorio";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Turno";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Suplente";
   echo "    </td>\n";
   echo "    <td align=\"center\">\n";
   echo "        cmd";
   echo "    </td>\n";
   echo "</tr>\n";
   $ORDEN="Fecha, Turno, Consultorio";
   $hoy = Date("y-m-d");
   $result=mysql_query("select Fecha,Consultorio,Turno,Suplente,Nombre from Suplentes,Medicos where Fecha >= '$hoy' and Numero=Suplente order by $ORDEN");

   while(($reg=mysql_fetch_object($result))!=null)
      {
         $fecha=$reg->Fecha;
	 $consultorio=$reg->Consultorio;
	 $turno=$reg->Turno;
	 $suplente=$reg->Suplente;
	 $nombre=$reg->Nombre;

          echo "<tr>\n";
            echo "<form action=\"suplentes.php\" method=post>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=10 name=\"Fecha\" value=\"$fecha\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "*	<input type=\"text\" size=5 name=\"Consultorio\" value=\"$consultorio\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=5 name=\"Turno\" value=\"$turno\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=5 name=\"Suplente\" value=\"$suplente\">$nombre";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Actualizar\">";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Borrar\">";
	    echo "   </td>\n";
	    echo "</form>\n";
	  echo "</tr>\"";
      }
          echo "<tr>\n";
            echo "<form action=\"suplentes.php\" method=post>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=8 name=\"Fecha\" value=\"\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=40 name=\"Consultorio\" value=\"\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=5 name=\"Turno\" value=\"\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=5 name=\"Suplente\" value=\"\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	&nbsp;&nbsp;";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Agregar\">";
	    echo "   </td>\n";
	    echo "</form>\n";
	  echo "</tr>\n";
   echo "</table>";
   mysql_close();
?>
