<?php

   $db=mysql_connect("elias","apolonia","virgen");
   mysql_select_db("apolonia");

   if($cmd=="Agregar")
      {
          $r=mysql_query("insert into Especialidades values($codigo,'$nombre')");
      } else
          if($cmd=="Borrar")
	    {
		$r=mysql_query("delete from Especialidades where Numero=$codigo");
	    }
	     else
          	if($cmd=="Actualizar")
	    	{
			$r=mysql_query("update Especialidades set Nombre='$nombre' where Codigo=$codigo");
	    	}

   echo "<center><h2>Mantenimiento de Especialidades</h2></center><hr>";
   echo "<table border=1 width=99%>\n";
   echo "<tr>\n";
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
   $ORDEN="Nombre";
   $result=mysql_query("select * from Especialidades order by $ORDEN");

   while(($reg=mysql_fetch_object($result))!=null)
      {
	 $cod=$reg->Codigo;
	 $nom=$reg->Nombre;

          echo "<tr>\n";
            echo "<form action=\"especial.php\" method=post>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=8 name=\"codigo\" value=\"$cod\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=40 name=\"nombre\" value=\"$nom\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Actualizar\">";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Borrar\">";
	    echo "   </td>\n";
	    echo "</form>\n";
	  echo "</tr>\n";
      }
          echo "<tr>\n";
            echo "<form action=\"especial.php\" method=post>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=8 name=\"codigo\" value=\"\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=40 name=\"nombre\" value=\"\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Agregar\">";
	    echo "   </td>\n";
	    echo "</form>\n";
	  echo "</tr>\n";
   echo "</table>";
   mysql_close();
?>
