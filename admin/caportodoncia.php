<?php

   if($coinivelusuario < 7)
         die("Usted no puede ejecutar este comando, su nivel es $coinivelusuario");
   $db=mysql_connect("elias","apolonia","virgen");
   mysql_select_db("apolonia");

   if($cmd=="Agregar")
      {
          $r=mysql_query("insert into CapOrtodoncia values($Medico,$Capacidad, $Capacidad)");
      } else
          	if($cmd=="Actualizar")
	    	{

		      if($Capacidad > $meta)
		        {
		            $r=mysql_query("update CapOrtodoncia set Capacidad=$Capacidad where Medico=$Medico");
			} else
			      {
			         die("No puede alterarse la capacidad porque supera el maximo preestablecido"); 
			      }
	    	}

   echo "<center><h3>Capacidades de Ortodoncia Fija</h3></center><hr>";
   echo "<center>";
   echo "<table border=1 width=90%>\n";
   echo "<tr>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Medico";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Capacidad";
   echo "    </td>\n";
   echo "    <td align=\"center\">\n";
   echo "        cmd";
   echo "    </td>\n";
   echo "</tr>\n";
   $ORDEN="Nombre,Capacidad";
   $hoy = Date("y-m-d");
   $result=mysql_query("select Medico,Nombre,Capacidad, MetaCapacidad from CapOrtodoncia,Medicos where Numero=Medico order by $ORDEN");

   while(($reg=mysql_fetch_object($result))!=null)
      {
	 $capacidad=$reg->Capacidad;
	 $medico=$reg->Medico;
	 $nombre=$reg->Nombre;
	 $meta = $reg->MetaCapacidad;

          echo "<tr>\n";
            echo "<form action=\"caportodoncia.php\" method=post>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=10 name=\"Medico\" value=\"$medico\">$nombre";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "   <input type=\"text\" size=5 name=\"Capacidad\" value=\"$capacidad\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "     <input type=\"submit\" name=\"cmd\" value=\"Actualizar\">";
	    echo "   </td>\n";
	    echo "</form>\n";
	  echo "</tr>";
      }
          echo "<tr>\n";
            echo "<form action=\"caportodoncia.php\" method=post>\n";
	    echo "   <td>\n";
	    echo "	<select name=\"Medico\">";
            $qm=mysql_query("select * from Medicos order by Nombre");
            while($qreg=mysql_fetch_object($qm))
             {
                    echo "<option value=\"$qreg->Numero\">$qreg->Nombre</option>";
             }   
            echo "      </select>";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "             <input type=\"text\" size=5 name=\"Capacidad\" value=\"\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	&nbsp;&nbsp;";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Agregar\">";
	    echo "   </td>\n";
	    echo "<INPUT TYPE='HIDDEN' name='meta' value='$meta'>";
	    echo "</form>\n";
	  echo "</tr>\n";
   echo "</table>";
   mysql_close();
?>
