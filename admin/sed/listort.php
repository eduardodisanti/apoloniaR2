<?php

   if($coinivelusuario < 3)
         die("Usted no puede ejecutar este comando, su nivel es $coinivelusuario");
   $db=mysql_connect("elias","apolonia","virgen");
   mysql_select_db("apolonia");

   $result=mysql_query("select CapOrtodoncia.Medico, Nombre, count(Paciente) as cuenta, Capacidad from PlanOrtodoncia, CapOrtodoncia, Medicos where PlanOrtodoncia.Medico = Numero and PlanOrtodoncia.Medico = CapOrtodoncia.Medico group by Medico");

   echo "<table border=1>";
   echo "<tr><th>Medico</th><th>Capacidad</th><th>Capacidad maxima</th><th>Pac. en asistencia</th></tr>";
   while(($reg=mysql_fetch_object($result))!=null)
    {
       $medico=$reg->Medico;
       $nombre=$reg->Nombre;
       $count =$reg->cuenta;
       $cap   =floor($reg->Capacidad / 3 * 4);
       $cap1  = $reg->Capacidad;

       echo "<tr><td>$nombre</td><td align=right>$cap1</td><td align=right>$cap</td><td align=right>$count</td></tr>";
    }

   echo "</table>";
   mysql_close();
?>
