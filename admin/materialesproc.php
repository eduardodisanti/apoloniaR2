<?php

   $db=mysql_connect("elias","apolonia","virgen");
   mysql_select_db("apolonia");


   $err = mysql_error();
   if(!empty($err))
        die("Error, avisar $err");

   echo "<center><h3>Vinculacion de Procedimientos de HC con Materiales</h3></center><hr>";
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
   $ORDEN="Nombre";
   $result=mysql_query("select Codigo, Nombre from Procedimientos where Activo='S' order by $ORDEN");

   while(($reg=mysql_fetch_object($result)))
      {
         $cod=$reg->Codigo;
	 $nom=$reg->Nombre;

          echo "<tr bgcolor='#ffffff'>\n";
            echo "<form action=\".php\" method=post>\n";
	    echo "   <td>\n";
	    echo "	$cod";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	$nom";
            echo "   <td>";
	    echo " <a href='mat_proc.php?procedimiento=$cod' target='_blank'>Materiales</a>";
	    echo "   </td>\n";
	    echo "</form>\n";
	  echo "</tr>\n";

	  $query = mysql_query("select procedimiento, articulo, nombre from articulosprocedimiento, articulos where articulos.id = articulo and procedimiento=$cod");
	  while($rr = mysql_fetch_object($query)) {

            echo "<tr bgcolor='#dddddd'><td align=right>";
                echo $rr->procedimiento;
            echo "</td>";
	    echo "<td colspan=2>$rr->nombre</td>";
	    echo "</tr>";
	  }
      }
   echo "</table>";
   mysql_close();
?>
