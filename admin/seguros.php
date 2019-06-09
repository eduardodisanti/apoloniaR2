<?php

   $db=mysql_connect("elias","apolonia","virgen");
   mysql_select_db("apolonia");

   if($cmd=="Agregar")
      {
          $r=mysql_query("insert into Seguros values($codigo,'$nombre','$paga','$pagasiempre','$ignorar')");
      } else
          if($cmd=="Borrar")
	    {
		$r=mysql_query("delete from Seguros where Numero=$codigo");
	    }
	     else
          	if($cmd=="Actualizar")
	    	{
			$r=mysql_query("update Seguros set Nombre='$nombre', Paga='$paga', NuncaPaga='$pagasiempre', Ignorar='$ignorar' where Numero=$codigo");
	    	}

   echo "<center><h3>Mantenimiento de Seguros</h3></center><hr>";
   echo "<table border=1 width=99%>\n";
   echo "<tr>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        <a href=\"seguros.php?orden=1\">Codigo</a>";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        <a href=\"seguros.php?orden=2\">Nombre</a>";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Paga";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Nunca Paga";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Ignorar";
   echo "    </td>\n";
   echo "    <td align=\"center\">\n";
   echo "        cmd";
   echo "    </td>\n";
   echo "</tr>\n";
   if($orden==1)
      $ORDEN="Numero";
   else
      $ORDEN="Nombre";
   $result=mysql_query("select * from Seguros order by $ORDEN");

   while(($reg=mysql_fetch_object($result))!=null)
      {
         $cod=$reg->Numero;
	 $nom=$reg->Nombre;
	 $pag=$reg->Paga;
	 $pagasiempre=$reg->NuncaPaga;
	 $ignorar = $reg->Ignorar;

          echo "<tr>\n";
            echo "<form action=\"seguros.php\" method=post>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=8 name=\"codigo\" value=\"$cod\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=40 name=\"nombre\" value=\"$nom\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=5 name=\"paga\" value=\"$pag\">";
	    echo "   </td>\n";
            echo "   <td>\n";
            echo "      <input type=\"text\" size=1 name=\"pagasiempre\" value=\"$pagasiempre\">";
            echo "   </td>\n";
            echo "   <td>\n";
            echo "      <input type=\"text\" size=1 name=\"ignorar\" value=\"$ignorar\">";
            echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Actualizar\">";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Borrar\">";
	    echo "   </td>\n";
	    echo "</form>\n";
	  echo "</tr>\n";
      }
          echo "<tr>\n";
            echo "<form action=\"seguros.php\" method=post>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=8 name=\"codigo\" value=\"\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=40 name=\"nombre\" value=\"\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=5 name=\"paga\" value=\"\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
            echo "      <input type=\"text\" size=5 name=\"pagasiempre\" value=\"\">";
            echo "   </td>\n";

	    echo "   <td>\n";
	    echo "      <input type=\"text\" size=5 name=\"ignorar\" value=\"\">";
	    echo "   </td>\n";

	    echo "   <td>\n";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Agregar\">";
	    echo "   </td>\n";
	    echo "</form>\n";
	  echo "</tr>\n";
   echo "</table>";
   mysql_close();
?>
