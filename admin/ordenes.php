<?php

   $db=mysql_connect("elias","apolonia","virgen");
   mysql_select_db("apolonia");

   if($cmd=="Agregar")
      {
          $r=mysql_query("insert into Ordenes values('$Codigo','$Nombre', $valor, $codext)");
      } else
          if($cmd=="Borrar")
	    {
		$r=mysql_query("delete from Ordenes where id=$'Codigo'");
	    }
	     else
          	if($cmd=="Actualizar")
	    	{
                  $r=mysql_query("update Ordenes set escripcion='$Nombre', Valor=$valor, codigoExterno=$codext where id='$Codigo'");
	    	}

   $err = mysql_error();
   if(!empty($err))
        die("Error, avisar $err");

   echo "<center><h3>Mantenimiento de Ordenes</h3></center><hr>";
   echo "<table border=0 width=99% bgcolor='#000000'>\n";
   echo "<tr bgcolor='#ffffff'>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Codigo";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Descripcion";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Importe";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Codigo externo";
   echo "    </td>\n";

   echo "    <td align=\"center\">\n";
   echo "        cmd";
   echo "    </td>\n";
   echo "</tr>\n";
   $ORDEN="escripcion";
   $result=mysql_query("select * from Ordenes order by $ORDEN");

   while(($reg=mysql_fetch_object($result)))
      {
         $cod=$reg->id;
	 $nom=$reg->escripcion;
         $val=$reg->Valor;
	 $codext = $reg->codigoExterno;

          echo "<tr bgcolor='#ffffff'>\n";
            echo "<form action=\"ordenes.php\" method=post>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"hidden\" size=8 name=\"Codigo\" value=\"$cod\">$cod";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=40 name=\"Nombre\" value=\"$nom\">";
	    echo "   </td>\n";
	    echo "   <td align='right'>\n";
	    echo "	<input type=\"text\" size=14 name=\"valor\" value=\"$val\">";
	    echo "   </td>\n";
            echo "   <td align='right'>\n";
            echo "      <input type=\"text\" size=14 name=\"codext\" value=\"$codext\">";
            echo "   </td>\n";
            echo "   <td>";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Actualizar\">";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Borrar\">";
	    echo "   </td>\n";
	    echo "</form>\n";
	  echo "</tr>\n";
      }
          echo "<tr bgcolor='#ffffff'>\n";
            echo "<form action=\"ordenes.php\" method=post>\n";
           echo "   <td>\n";
            echo "      <input type=\"text\" size=8 name=\"Codigo\" value=\"\">";
            echo "   </td>\n";
            echo "   <td>\n";
            echo "      <input type=\"text\" size=40 name=\"Nombre\" value=\"\">";
            echo "   </td>\n";
            echo "   <td align='right'>\n";
            echo "      <input type=\"text\" size=14 name=\"valor\" value=\"\">";
            echo "   </td>\n";
            echo "   <td>";
            echo "      <input type=\"submit\" name=\"cmd\" value=\"Agregar\">";
            echo "   </td>\n";
	    echo "</form>\n";
	  echo "</tr>\n";
   echo "</table>";
   mysql_close();
?>
