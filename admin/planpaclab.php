<?php

   if($coinivelusuario < 7)
         die("Usted no puede ejecutar este comando, su nivel es $coinivelusuario");
   $db=mysql_connect("elias","apolonia","virgen");
   mysql_select_db("apolonia");

   if($cmd=="Agregar")
      {
          $r=mysql_query("insert into PlanLabPac values($Paciente,0)");
      } else
          	if($cmd=="Borrar")
	    	{
		      $r=mysql_query("delete from PlanLabPac where Paciente=$Paciente");
	    	} 
   echo "<center><h2>Pacientes en plan de emergencia por Laboratorios</h2></center><hr>";
   echo "<center>";
   echo "<table border=1 width=99%>\n";
   echo "<tr>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Paciente";
   echo "    </td>\n";
   echo "    <td align=\"center\">\n";
   echo "        cmd";
   echo "    </td>\n";
   echo "</tr>\n";

   	$hoy = Date("y-m-d");
   	$result=mysql_query("select Paciente,Pacientes.Nombre as Pac from PlanLabPac, Pacientes where Cedula=Paciente order by Pacientes.Nombre");

	echo mysql_error();

   	$cuenta=0;
   	while(($reg=mysql_fetch_object($result))!=null)
      	{
	 $paciente=$reg->Paciente;
	 $pac=$reg->Pac;
         $cuenta= $cuenta + 1;
          echo "<tr>\n";
            echo "<form action=\"planpaclab.php\" method=post>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"hidden\" name=\"Paciente\" value=\"$paciente\">$paciente";
	    echo "   </td>\n";
	    echo "   <td>\n";
            echo "   $pac";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "     <input type=\"submit\" name=\"cmd\" value=\"Borrar\">";
	    echo "   </td>\n";
	    echo "</form>\n";
	  echo "</tr>";
      	}
          echo "<tr>\n";
            echo "<form action=\"planpaclab.php\" method=post>\n";
	    echo "   <td>\n";
	    echo "   <input type=\"text\" size=8 name=\"Paciente\" value=\"\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	&nbsp;&nbsp;";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Agregar\">";
	    echo "   </td>\n";
	    echo "</form>\n";
	  echo "</tr>\n";
   echo "</table>";
   mysql_close();
?>
