<?php

  function elegirTipoIva($tipo)
  {
    $q = "select * from TipoIva";
    $qry = mysql_query($q);

     echo "   <select name='tipoiva'>";
     while($reg = mysql_fetch_object($qry)) {

          $id = $reg->id;
	  if($id == $tipo)
	     $sel = "selected";
	  else
	     $sel = "";
           echo "<option value='$id' $sel>$reg->descripcion</option>";
     }
     echo "   </select>";

  }

   $db=mysql_connect("elias","apolonia","virgen");
   mysql_select_db("apolonia");

   if($cmd=="Agregar")
      {
          $r=mysql_query("insert into Trabajos values($Codigo,'$Nombre',$Tiempo, $Costo, 0, $Etapas, '$Facturable', '$Activo', $Zona, '$tipoiva')");
      } else
          if($cmd=="Borrar")
	    {
		$r=mysql_query("delete from Trabajos where id=$Codigo");
	    }
	     else
          	if($cmd=="Actualizar")
	    	{
			$r=mysql_query("update Trabajos set Descripcion='$Nombre', Tiempo=$Tiempo, Costo=$Costo, Etapas=$Etapas, Facturable='$Facturable', Activo='$Activo',Zona=$Zona, TipoIva='$tipoiva' where id=$Codigo");
	    	}

   $err = mysql_error();
   if(!empty($err))
        die("Error, avisar $err");

   echo "<center><h3>Mantenimiento de Trabajos</h3></center><hr>";
   echo "<table border=0 width=99% bgcolor='#000000'>\n";
   echo "<tr bgcolor='#ffffff'>\n";
   echo "    <td align=\"center\" colspan=1 width='20px'>\n";
   echo "        Cod";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Nombre";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Tiempo";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Costo";
   echo "    </td>\n";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Etapas";
   echo "    </td>\n";

   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Facturable";
   echo "    </td>\n";

   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Zona dental <br>0=cualquiera";
   echo "    </td>\n";

   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Activo";
   echo "    </td>\n";

   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Tipo de Iva";
   echo "    </td>\n";


   echo "    <td align=\"center\">\n";
   echo "        cmd";
   echo "    </td>\n";
   echo "</tr>\n";
   $ORDEN="Descripcion";
   $result=mysql_query("select Trabajos.id, Trabajos.descripcion, Tiempo, Costo,  Etapas, Facturable, Zona, Activo, TipoIva from Trabajos order by $ORDEN");

   while(($reg=mysql_fetch_object($result)))
      {
         $cod=$reg->id;
	 $nom=$reg->descripcion;
         $tie=$reg->Tiempo;
         $cos=$reg->Costo;
	 $etapas=$reg->Etapas;
	 $factu =$reg->Facturable;
	 $activo=$reg->Activo;
	 $zona  =$reg->Zona;
	 $tipoiva = $reg->TipoIva;

          echo "<tr bgcolor='#ffffff'>\n";
            echo "<form action=\"trab.php\" method=post>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"hidden\" size=8 name=\"Codigo\" value=\"$cod\">$cod";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=40 name=\"Nombre\" value=\"$nom\">";
	    echo "   </td>\n";
	    echo "   <td align='right'>\n";
	    echo "	<input type=\"text\" size=5 name=\"Tiempo\" value=\"$tie\">";
	    echo "   </td>\n";
            echo "   <td align='right'>\n";
            echo "      <input type=\"text\" size=5 name=\"Costo\" value=\"$cos\">";
            echo "   </td>\n";
            echo "   <td>\n";
	    echo "      <input type=\"text\" size=2 name=\"Etapas\" value=\"$etapas\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "      <input type=\"text\" size=1 name=\"Facturable\" value=\"$factu\">";
	    echo "   </td>\n";
            echo "   <td>\n";
            echo "      <input type=\"text\" size=3 name=\"Zona\" value='$zona'>";
	    echo "   </td>\n";
	     echo "   <td>\n";
             echo "      <input type=\"text\" size=1 name=\"Activo\" value=\"$activo\">";
             echo "   </td>\n";

             echo "   <td>\n";
	           elegirTipoIva($tipoiva);
             echo "   </td>\n";

            echo "   <td>";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Actualizar\">";
//	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Borrar\">";
	    echo "   </td>\n";
	    echo "</form>\n";
	  echo "</tr>\n";
      }
          echo "<tr bgcolor='#ffffff'>\n";
            echo "<form action=\"trab.php\" method=post>\n";
            echo "   <td>\n";
            echo "     <input type=\"text\" size=8 name=\"Codigo\" value=\"\">";
            echo "   </td>\n";
            echo "   <td>\n";
            echo "    <input type=\"text\" size=40 name=\"Nombre\" value=\"\">";
            echo "   </td>\n";
            echo "   <td align='right'>\n";
            echo "     <input type=\"text\" size=5 name=\"Tiempo\" value=\"\">";
            echo "   </td>\n";
            echo "   <td align='right'>\n";
            echo "      <input type=\"text\" size=5 name=\"Costo\" value=\"\">";
            echo "   </td>\n";

	    echo "   <td align='right'>\n";
	    echo "     <input type='text' size=1 name='Etapas' value=''>";
	    echo "   </td>\n";
	    echo "   <td align='right'>\n";
	    echo "     <input type='text' size=1 name='Facturable' value=''>";
	    echo "   </td>\n";

            echo "   <td>\n";
	    echo "     <input type='text' size=3 name='Zona' value=''>";
	    echo "   </td>\n";

            echo "   <td>\n";
	    echo "     <input type='text' size=1 name='Activo' value=''>";
	    echo "   </td>\n";

            echo "   <td>\n";
	    elegirTipoIva(" ");
            echo "   </td>\n";


            echo "   <td>";
            echo "      <input type=\"submit\" name=\"cmd\" value=\"Agregar\">";
            echo "   </td>\n";
	    echo "</form>\n";
	  echo "</tr>\n";
   echo "</table>";
   mysql_close();
?>
