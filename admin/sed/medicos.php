<?php

   $db=mysql_connect("elias","apolonia","virgen");
   mysql_select_db("apolonia");

   if($cmd=="Agregar")
      {
          $r=mysql_query("insert into Medicos values($codigo,'$nombre',$espe,'$activo', '$externo', $cedula, $numeroexterno)");
      } else
          if($cmd=="Borrar")
	    {
		$r=mysql_query("delete from Medicos where Numero=$codigo");
	    }
	     else
          	if($cmd=="Actualizar")
	    	{
			$r=mysql_query("update Medicos set Nombre='$nombre', especialidad=$espe, Activo='$activo', Externo='$externo', Cedula=$cedula, numeroExterno=$numeroexterno where Numero=$codigo");
	    	}

   echo "<center><h4>Mantenimiento de medicos</h4></center>";
   echo "<table border=1 width=99%>\n";
   echo "<tr>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        <a href=\"medicos.php?orden=1\">Codigo</a>";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        <a href=\"medicos.php?orden=2\">Nombre</a>";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Especialidad";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Activo";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Externo";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Cedula";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Nro.externo";
   echo "    </td>\n";
   echo "    <td align=\"center\">\n";
   echo "        cmd";
   echo "    </td>\n";
   echo "</tr>\n";
   if($orden==1)
      $ORDEN="Numero";
   else
      $ORDEN="Nombre";
   $result=mysql_query("select * from Medicos order by $ORDEN");

   while(($reg=mysql_fetch_object($result))!=null)
      {
         $cod=$reg->Numero;
	 $nom=$reg->Nombre;
	 $esp=$reg->especialidad;
	 $activo=$reg->Activo;
	 $externo=$reg->Externo;
	 $cedula=$reg->Cedula;
	 $numeroexterno=$reg->numeroExterno;

          echo "<tr>\n";
            echo "<form action=\"medicos.php\" method=post>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=8 name=\"codigo\" value=\"$cod\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=40 name=\"nombre\" value=\"$nom\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=5 name=\"espe\" value=\"$esp\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=1 name=\"activo\" value=\"$activo\">";
	    echo "   </td>\n";
	     echo "   <td>\n";
	    echo "      <input type=\"text\" size=1 name=\"externo\" value=\"$externo\">";
	    echo "   </td>\n";
	    echo "<td>\n";
	    echo "      <input type=\"text\" size=7 name=\"cedula\" value=\"$cedula\">";
            echo "   </td>\n";
	    echo "<td>\n";
            echo "      <input type=\"text\" size=7 name=\"numeroexterno\" value=\"$numeroexterno\">";
            echo "   </td>\n";

	    echo "   <td>\n";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Actualizar\">";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Borrar\">";
	    echo "   </td>\n";
	    echo "</form>\n";
	  echo "</tr>\n";
      }
          echo "<tr>\n";
            echo "<form action=\"medicos.php\" method=post>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=8 name=\"codigo\" value=\"\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=40 name=\"nombre\" value=\"\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=5 name=\"espe\" value=\"\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=1 name=\"activo\" value=\"S\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "      <input type=\"text\" size=1 name=\"externo\" value=\"N\">";
	    echo "   </td>\n";

            echo "   <td>\n";
            echo "      <input type=\"text\" size=7 name=\"cedula\" value=\"0\">";
            echo "   </td>\n";
	    echo "<td>\n";
            echo "      <input type=\"text\" size=7 name=\"numeroexterno\" value=\"$numeroexterno\">";
            echo "   </td>\n";

	    echo "   <td>\n";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Agregar\">";
	    echo "   </td>\n";
	    echo "</form>\n";
	  echo "</tr>\n";
   echo "</table>";
   mysql_close();
?>
