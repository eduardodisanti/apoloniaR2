<?php

   $db=mysql_connect("elias","apolonia","virgen");
   mysql_select_db("apolonia");


   $err = mysql_error();
   if(!empty($err))
        die("Error, avisar $err");

   echo "<center><h3>Mantenimiento de Trabajos x Procedimientos</h3></center><hr>";
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
	    echo "	$cod";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	$nom";
            echo "   <td>";
	    echo " <a href='metatrab_proc.php?Meta=$cod' target='_blank'>Trabajos</a>";
	    echo "   </td>\n";
	    echo "</form>\n";
	  echo "</tr>\n";
      }
   echo "</table>";
   mysql_close();
?>
