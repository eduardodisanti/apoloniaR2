<?php

   $db=mysql_connect("elias","apolonia","virgen");
   mysql_select_db("apolonia");

   if($cmd=="Agregar")
      {
          $r=mysql_query("insert into MetaTrabajos values($Codigo,'$Nombre')");
      } else
          if($cmd=="Borrar")
	    {
		$r=mysql_query("delete from Trabajos where id=$Codigo");
	    }
	     else
          	if($cmd=="Actualizar")
	    	{
			$r=mysql_query("update Trabajos set Descripcion='$Nombre' where id=$Codigo");
	    	}

   $err = mysql_error();
   if(!empty($err))
        die("Error, avisar $err");

   echo "<center><h3>Mantenimiento de Metatrabajos</h3></center><hr>";
   echo "<table border=0 width=99% bgcolor='#000000'>\n";
   echo "<tr bgcolor='#ffffff'>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Codigo";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Nombre";
   echo "    </td>\n";

   echo "    <td align=\"center\">\n";
   echo "        cmd";
   echo "    </td>\n";
   echo "</tr>\n";
   $ORDEN="Descripcion";
   $result=mysql_query("select id, Descripcion from MetaTrabajos order by $ORDEN");

   while(($reg=mysql_fetch_object($result)))
      {
         $cod=$reg->id;
	 $nom=$reg->Descripcion;

          echo "<tr bgcolor='#ffffff'>\n";
            echo "<form action=\"metatrab.php\" method=post>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"hidden\" size=8 name=\"Codigo\" value=\"$cod\">$cod";
	    echo " <a href='metatrab_trab.php?Meta=$cod' target='_blank'>Etapas</a>";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=40 name=\"Nombre\" value=\"$nom\">";
            echo "   <td>";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Actualizar\">";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Borrar\">";
	    echo "   </td>\n";
	    echo "</form>\n";
	  echo "</tr>\n";
      }
          echo "<tr bgcolor='#ffffff'>\n";
            echo "<form action=\"metatrab.php\" method=post>\n";
           echo "   <td>\n";
            echo "      <input type=\"text\" size=8 name=\"Codigo\" value=\"\">";
            echo "   </td>\n";
            echo "   <td>\n";
            echo "      <input type=\"text\" size=40 name=\"Nombre\" value=\"\">";
            echo "   </td>\n";
            echo "   <td>";
            echo "      <input type=\"submit\" name=\"cmd\" value=\"Agregar\">";
            echo "   </td>\n";
	    echo "</form>\n";
	  echo "</tr>\n";
   echo "</table>";
   mysql_close();
?>
