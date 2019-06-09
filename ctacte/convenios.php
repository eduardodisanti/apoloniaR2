<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php

 require_once("../class/usuario.php");
 

   $db=mysql_connect("127.0.0.1","apolonia","virgen");
   mysql_select_db("apolonia");


$usr = new usuario($coiusuario,$coiclave);
 if($usr->nivel < 7)
    {
      die("<center><br>No tiene autorizaci&oacute;n para ejecutar este comando<br><a href=\"../index1.php\">Pulse aqui para volver</a>\n<center>");

    }

   if($cmd=="Agregar")
      {
          $r=mysql_query("insert into Convenios values($pac,'$fecha',$importe,$cuotas,$cuotas)");
      } else
          if($cmd=="Borrar")
	    {
		$r=mysql_query("delete from Convenios where Paciente=$pac");
	    }
	     else
          	if($cmd=="Actualizar")
	    	{
			$r=mysql_query("update Convenios set Fecha='$fecha', Importe=$importe, Cuotas=$cuotas  where Paciente=$pac");
	    	}

   echo "<center><h4>Mantenimiento de Convenios</h4></center><hr>";
   echo "<table border=1 width=99%>\n";
   echo "<tr>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        <a href=\"convenios.php?orden=1\">Cedula</a>";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        <a href=\"convenios.php?orden=2\">Nombre</a>";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Fecha";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Importe";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Cuotas";
   echo "    </td>\n";
   echo "    <td align=\"center\">\n";
   echo "        cmd";
   echo "    </td>\n";
   echo "</tr>\n";
   if($orden==1)
      $ORDEN="Paciente";
   else
      $ORDEN="Pacientes.Nombre";
   $result=mysql_query("select Paciente,Fecha,Importe,Cuotas,Pacientes.Nombre as Nombre,Quedan from Convenios,Pacientes where Pacientes.Cedula=Paciente order by $ORDEN");

   while($reg=mysql_fetch_object($result))
      {
        $pac=$reg->Paciente;
	 	$nom=$reg->Nombre;
	 	$imp=$reg->Importe;
        $cuo=$reg->Cuotas;
        $fec=$reg->Fecha;
        $quedan=$reg->Quedan;

        echo "<tr>\n";
        echo "<form action=\"convenios.php\" method=post>\n";
	    echo "   <td>\n";
	    echo "	$pac";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	$nom";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "  <input type=\"text\" size=8 name=\"fecha\" value=\"$fec\">";
	    echo "   </td>\n";
            echo "   <td>\n";
            echo "  <input type=\"text\" size=9 name=\"importe\" value=\"$imp\">";
            echo "   </td>\n";
            echo "   <td>\n";
            echo "  <input type=\"text\" size=2 name=\"cuotas\" value=\"$cuo\">($quedan)";
            echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Actualizar\">";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Borrar\">";
	    echo "   </td>\n";
	    echo "<input type=\"hidden\" name=\"pac\" value=\"$pac\">";
	    echo "</form>\n";
	  echo "</tr>\n";
      }
          echo "<tr>\n";
            echo "<form action=\"convenios.php\" method=post>\n";
            echo "   <td>\n";
            echo "      <input type=\"text\" size=8 name=\"pac\">";
            echo "   </td>\n";
            echo "   <td>\n";
            echo "      &nbsp;&nbsp;";
            echo "   </td>\n";
            echo "   <td>\n";
            echo "  <input type=\"text\" size=8 name=\"fecha\">";
            echo "   </td>\n";
            echo "   <td>\n";
            echo "  <input type=\"text\" size=9 name=\"importe\">";
            echo "   </td>\n";
            echo "   <td>\n";
            echo "  <input type=\"text\" size=2 name=\"cuotas\">";
            echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Agregar\">";
	    echo "   </td>\n";
	    echo "</form>\n";
	  echo "</tr>\n";
   echo "</table>";
   mysql_close();
?>
