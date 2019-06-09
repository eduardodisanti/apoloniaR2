<?php

  function elegirSucursal($xsucursal)
  {
    $q = "select Sucursal from Consultorios group by Sucursal";
    $qry = mysql_query($q);

     echo "   <select name='sucursal'>";
     while($reg = mysql_fetch_object($qry)) {

          $sucursal = $reg->Sucursal;
	  if($sucursal == $xsucursal)
	     $sel = "selected";
	  else
	     $sel = "";
           echo "<option value='$sucursal' $sel>$sucursal</option>";
     }
     echo "   </select>";

  }

   $db=mysql_connect("elias","apolonia","virgen");
   mysql_select_db("apolonia");

   if($cmd=="Agregar")
      {
          $r=mysql_query("insert into HorasTurno values('$sucursal', $dia, $horario, $duracion)");
      } else
          if($cmd=="Borrar")
	    {
		$r=mysql_query("delete from HorasTurno where Sucursal=$sucursal and Turno=$turno and Dia = $dia");
	    }
	     else
          	if($cmd=="Actualizar")
	    	{
		 $r=mysql_query("update HorasTurno set Duracion=$duracion where Sucursal='$sucursal' and Dia=$dia and Horario=$horario"); 
	    	}

   $err = mysql_error();
   if(!empty($err))
        die("Error, avisar $err");

   echo "<center><h3>Mantenimiento de Horas x turno</h3></center><hr>";
   echo "<table border=0 width=99% bgcolor='#000000'>\n";
   echo "<tr bgcolor='#ffffff'>\n";
   echo "    <td align=\"center\" colspan=1 width='20px'>\n";
   echo "        Sucursal";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Dia";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Horario";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Duracion";
   echo "    </td>\n";
   echo "    </td>\n";


   echo "    <td align=\"center\">\n";
   echo "        cmd";
   echo "    </td>\n";
   echo "</tr>\n";
   $ORDEN="Descripcion";
   $result=mysql_query("select * from HorasTurno order by Sucursal");

   while(($reg=mysql_fetch_object($result)))
      {
         $sucursal=$reg->Sucursal;
	 $dia=$reg->Dia;
         $horario=$reg->Horario;
         $duracion=$reg->Duracion;

          echo "<tr bgcolor='#ffffff'>\n";
            echo "<form action=\"horasturnos.php\" method=post>\n";
	    echo "   <td>\n";
	    elegirSucursal($sucursal);
	    echo "   </td>\n";
	    echo "   <td>\n";
            echo "   <td>\n";
            echo "      <input type=\"text\" size=1 name=\"dia\" value=\"$dia\">";
            echo "   </td>\n";
	    echo "   </td>\n";
	    echo "   <td align='right'>\n";
	    echo "	<input type=\"text\" size=2 name=\"horario\" value=\"$horario\">";
	    echo "   </td>\n";
            echo "   <td align='right'>\n";
            echo "      <input type=\"text\" size=2 name=\"duracion\" value=\"$duracion\">";
            echo "   </td>\n";
            echo "   <td>";
	    echo "   <input type=\"submit\" name=\"cmd\" value=\"Actualizar\">";
	    echo "   </td>\n";
	    echo "</form>\n";
	  echo "</tr>\n";
      }
      echo "<tr bgcolor='#ffffff'>\n";
	  echo "<form action=\"horasturnos.php\" method=post>\n";
	  echo "   <td>\n";
	  elegirSucursal($sucursal);
	  echo "   </td>\n";
	  echo "   <td>\n";
	  echo "      <input type=\"text\" size=1 name=\"dia\" value=\"$dia\">";
	  echo "   </td>\n";
	  echo "   <td align='right'>\n";
	  echo "      <input type=\"text\" size=2 name=\"horario\" value=\"$horario\">";
	  echo "   </td>\n";
	  echo "   <td align='right'>\n";
	  echo "      <input type=\"text\" size=2 name=\"duracion\" value=\"$duracion\">";

            echo "   <td>";
            echo "      <input type=\"submit\" name=\"cmd\" value=\"Agregar\">";
            echo "   </td>\n";
	    echo "</form>\n";
   echo "</tr>\n";
   echo "</table>";
   mysql_close();
?>
