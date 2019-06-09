<?php

   $db=mysql_connect("elias","apolonia","virgen");
   mysql_select_db("apolonia");

   if($cmd=="Agregar")
      {
          $r=mysql_query("insert into Laboratorios values($Codigo,'$Nombre', '$Telefono', $Cupo, '$Categoria', $Porcentaje, '$razonsocial', '$ruc', '$domicilio', '$email', '$habilitado')");
      } else
          if($cmd=="Borrar")
	    {
		$r=mysql_query("delete from Laboratorios where id=$Codigo");
	    }
	     else
          	if($cmd=="Actualizar")
	    	{
		  $r=mysql_query("update Laboratorios set descripcion='$Nombre', telefono='$Telefono',Cupo = $Cupo, categoria='$cat', porcentaje=$porcentaje, ruc = '$ruc', razonSocial='$razonsocial', domicilio='$domicilio', email='$email', bloqueo='$bloqueo' where id=$Codigo");
	    	}

   $err = mysql_error();
   if(!empty($err))
        die("Error, avisar $err");

   echo "<center><h3>Mantenimiento de Laboratorios</h3></center><hr>";
   echo "<table border=0 width=80% bgcolor='#000000'>\n";
   echo "<tr bgcolor='#ffffff'>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Codigo";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Nombre";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Telefono";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Cupo diario";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Categoria";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Porcentaje";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Razon social";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        RUC";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Domicilio";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        email";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Bloqueado";
   echo "    </td>\n";

   echo "    <td align=\"center\">\n";
   echo "        cmd";
   echo "    </td>\n";
   
   echo "</tr>\n";
   $ORDEN="Descripcion";
   $result=mysql_query("select * from Laboratorios order by $ORDEN");

   while(($reg=mysql_fetch_object($result)))
      {
         $cod=$reg->id;
	 $nom=$reg->descripcion;
         $tel=$reg->telefono;
	 $cupo=$reg->Cupo;
	 $cat =$reg->categoria;
	 $porcentaje=$reg->porcentaje;
	 $razonsocial=$reg->razonSocial;
	 $ruc = $reg->ruc;
	 $domicilio=$reg->domicilio;
	 $email = $reg->email;
	 $bloqueo = $reg->bloqueo;

         echo "<tr bgcolor='#ffffff'>\n";
            echo "<form action=\"lab.php\" method=post>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"hidden\" size=8 name=\"Codigo\" value=\"$cod\">$cod ";
	    echo "      <a href='trablab.php?Laboratorio=$cod' target='_blank'>Trabajos</a>";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=20 name=\"Nombre\" value=\"$nom\">";
	    echo "   </td>\n";
	    echo "   <td align='right'>\n";
	    echo "	<input type=\"text\" size=10 name=\"Telefono\" value=\"$tel\">";
	    echo "   </td>\n";
	    echo "   <td align='right'>\n";
	    echo "      <input type=\"text\" size=2 name=\"Cupo\" value=\"$cupo\">";
	    echo "   </td>\n";
            echo "   <td align='right'>\n";
	    echo "      <input type=\"text\" size=1 name=\"cat\" value=\"$cat\" MAXLENGTH=1>";
	    echo "   </td>\n";
	    echo "   <td align='right'>\n";
            echo "      <input type=\"text\" size=3 name=\"porcentaje\" value=\"$porcentaje\" MAXLENGTH=3>";
            echo "   </td>\n";
            echo "   <td align='right'>\n";
            echo "      <input type=\"text\" name=\"razonsocial\" value=\"$razonsocial\">";
            echo "   </td>\n";
            echo "   <td align='right'>\n";
            echo "      <input type=\"text\" name=\"ruc\" value=\"$ruc\">";
            echo "   </td>\n";
            echo "   <td align='right'>\n";
            echo "      <input type=\"text\" name=\"domicilio\" value=\"$domicilio\">";
            echo "   </td>\n";
            echo "   <td align='right'>\n";
            echo "      <input type=\"text\" name=\"email\" value=\"$email\">";
            echo "   </td>\n";
	    echo "   <td align='right'>\n";
            echo "      <input type=\"text\" name=\"bloqueo\" value=\"$bloqueo\">";
            echo "   </td>\n";
            echo "   <td>";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Actualizar\">";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Borrar\">";
	    echo "   </td>\n";
	    echo "</form>\n";
	 echo "</tr>\n";
      }
          echo "<tr bgcolor='#ffffff'>\n";
            echo "<form action=\"lab.php\" method=post>\n";
           echo "   <td>\n";
            echo "      <input type=\"text\" size=8 name=\"Codigo\" value=\"\">";
            echo "   </td>\n";
            echo "   <td>\n";
            echo "      <input type=\"text\" size=20 name=\"Nombre\" value=\"\">";
            echo "   </td>\n";
            echo "   <td align='right'>\n";
            echo "      <input type=\"text\" size=10 name=\"Telefono\" value=\"\">";
            echo "   </td>\n";
	    echo "   <td align='right'>\n";
	    echo "      <input type=\"text\" size=2 name=\"Cupo\" value=\"\">";
	    echo "   </td>\n";
	    echo "   </td>\n";
            echo "   <td align='right'>\n";
            echo "      <input type=\"text\" size=1 name=\"Categoria\" value=\"\">";
            echo "   </td>\n";
            echo "   <td align='right'>\n";
            echo "      <input type=\"text\" size=2 name=\"Porcentaje\" value=\"\">";
            echo "   </td>\n";
            echo "   <td align='right'>\n";
            echo "      <input type=\"text\" size=10 name=\"razonsocial\" value=\"\">";
            echo "   </td>\n";
            echo "   <td align='right'>\n";
            echo "      <input type=\"text\" size=10 name=\"ruc\" value=\"\">";
            echo "   </td>\n";
            echo "   <td align='right'>\n";
            echo "      <input type=\"text\" name=\"domicilio\" value=\"\">";
            echo "   </td>\n";
            echo "   <td align='right'>\n";
            echo "      <input type=\"text\" name=\"email\" value=\"\">";
	    echo "   </td>\n";
            echo "   <td align='right'>\n";
            echo "      <input type=\"text\" name=\"bloqueo\" value=\"\">";
            echo "   </td>\n";

            echo "   <td>";
            echo "      <input type=\"submit\" name=\"cmd\" value=\"Agregar\">";
            echo "   </td>\n";
	    echo "</form>\n";
	  echo "</tr>\n";
   echo "</table>";
   mysql_close();
?>
