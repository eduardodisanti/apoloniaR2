<?php

   if($coinivelusuario < 7)
         die("Usted no puede ejecutar este comando, su nivel es $coinivelusuario");
   $db=mysql_connect("elias","apolonia","virgen");
   mysql_select_db("apolonia");

   if($cmd=="Agregar")
      {
          $r=mysql_query("insert into PlanOrtodoncia values($Medico,$Paciente,$Plan)");
      } else
          	if($cmd=="Borrar")
	    	{
		      $hoy = Date("Y-m-d");
		      $r=mysql_query("delete from PlanOrtodoncia where Medico=$Medico and Paciente=$Paciente");
		      mysql_query("insert into AltasPO values($Paciente, '$hoy')");
	    	} 
                  else
                     if($cmd=="Actualizar")  {
		      
		           $r=mysql_query("update PlanOrtodoncia set Contrato=$contrato where Paciente=$Paciente and Medico=$Medico"); 
		     }

   echo "<center><h2>Plan de Ortodoncia Fija</h2></center><hr>";
   echo "<center>";
   echo "<table border=0><tr>\n";
   echo " <form action=\"planortod.php\" method=post>\n";
            echo "   <td>\n";
            echo "      <select name=\"Medico\">";
            $qm=mysql_query("select Numero,Nombre,Medico,Capacidad from Medicos,CapOrtodoncia where Medicos.Numero = CapOrtodoncia.Medico order by Nombre");

	    //die(mysql_query());
            while($qreg=mysql_fetch_object($qm))
             {
		   if(empty($Medico))
		        $Medico=$qreg->Numero;

                   if($Medico==$qreg->Medico)
                    {
                       $selected="SELECTED";
                       $maxcap=$qreg->Capacidad;
                    }
                   else
                       $selected="";

                    echo "<option value=\"$qreg->Numero\" $selected>$qreg->Nombre</option>";
             }
            echo "      </select>";
            echo "      <input type=\"submit\" name=\"cmd\" value=\"Cambiar\">";
   echo "</tr></table>";
   echo "</form>";
   echo "<table border=1 width=99%>\n";
   echo "<tr>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Paciente";
   echo "    </td>\n";
   echo "    <td align=\"center\">\n";
   echo "        Paciente";
   echo "    </td>\n";
   echo "    <td align=\"center\">\n";
   echo "        Tipo contrato";
   echo "    </td>\n";

   echo "</tr>\n";

   if(!empty($Medico))
     {
   	$ORDEN="Pac";
   	$hoy = Date("y-m-d");
   	$result=mysql_query("select Paciente,Medico,Pacientes.Nombre as Pac, Contrato from PlanOrtodoncia,Pacientes where Medico=$Medico and Cedula=Paciente order by $ORDEN");
   	$cuenta=0;
   	while(($reg=mysql_fetch_object($result))!=null)
      	{
	 $paciente=$reg->Paciente;
	 $medico=$reg->Medico;
	 $contrato=$reg->Contrato;
	 $pac=$reg->Pac;
         $cuenta= $cuenta + 1;
          echo "<tr>\n";
            echo "<form action=\"planortod.php\" method=post>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"hidden\" name=\"Paciente\" value=\"$paciente\">$paciente";
	    echo "   </td>\n";
            echo "   <td>\n";
            echo "   $pac";
            echo "   </td>\n";

	    echo "   <td align='center'>\n";
            echo "      <input type=\"text\" name=\"contrato\" value=\"$contrato\" size=5>";
            echo "   </td>\n";

	    echo "   <td>\n";
	    echo "     <input type=\"submit\" name=\"cmd\" value=\"Borrar\">";
	    echo "     <input type=\"submit\" name=\"cmd\" value=\"Actualizar\">";
            echo "     <input type=\"hidden\" name=\"Medico\" value=\"$Medico\">";
	    echo "   </td>\n";
	    echo "</form>\n";
	  echo "</tr>";
      	}
       	if($cuenta < $maxcap)
       	 {
          echo "<tr>\n";
            echo "<form action=\"planortod.php\" method=post>\n";
	    echo "   <td>\n";
	    echo "   <input type=\"text\" size=8 name=\"Paciente\" value=\"\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	&nbsp;&nbsp;";
	    echo "   </td>\n";
	    echo "   <td>";
	    echo "	<input type = text size=4 name='Plan' value='0'>";
	    echo "   </td>";
	    echo "   <td>\n";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Agregar\">";
	    echo "   </td>\n";
            echo "<input type=\"hidden\" name=\"Medico\" value=\"$Medico\">";
	    echo "</form>\n";
	  echo "</tr>\n";
	  }
	}
   echo "</table>";
   mysql_close();
?>
