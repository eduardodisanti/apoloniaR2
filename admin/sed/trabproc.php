<?php

   $db=mysql_connect("elias","apolonia","virgen");
   mysql_select_db("apolonia");


   $err = mysql_error();
   if(!empty($err))
        die("Error, avisar $err");

   echo "<center><h3>TT-EAL-04 Vinculacion de Procedimientos de HC con Etapas de Trabajos de Lab</h3></center><hr>";
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
            echo "<form action=\"metatrab.php\" method=post>\n";
	    echo "   <td>\n";
	    echo "	$cod";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	$nom";
            echo "   <td>";
	    echo " <a href='trab_proc.php?Procedimiento=$cod' target='_blank'>Trabajos</a>";
	    echo "   </td>\n";
	    echo "</form>\n";
	  echo "</tr>\n";

	  $query = mysql_query("select Trabajo, Procedimiento, descripcion from ProcTrab, Trabajos where Trabajos.id = Trabajo and Procedimiento=$cod");
	  while($rr = mysql_fetch_object($query)) {

            echo "<tr bgcolor='#dddddd'><td align=right>";
                echo $rr->Trabajo;
            echo "</td>";
	    echo "<td colspan=2>$rr->descripcion</td>";
	    echo "</tr>";
	  }
      }
   echo "</table>";
   mysql_close();
?>
