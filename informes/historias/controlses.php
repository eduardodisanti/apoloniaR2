<?php
     $link=mysql_connect("elias","root","virgen");
     $db = mysql_select_db("apolonia");

     $query = mysql_query("select Paciente,Pacientes.Nombre npac,Procedimientos.Nombre as nproc,Procedimientos.Sesiones as normal, Diente,CSesiones.Sesiones as cant from CSesiones,Pacientes,Procedimientos where CSesiones.Sesiones > Procedimientos.Sesiones and Pacientes.Cedula = CSesiones.Paciente and Procedimientos.Codigo = CSesiones.Procedimiento and CSesiones.Sesiones = $xcant and Procedimiento=$procedimiento order by Paciente,Procedimiento,Diente");

      $err=mysql_error();
      if(!empty($err))
        die($err);

      echo "<center><h3>Pacientes que utilizaron $xcant sesiones del procedimiento $procedimiento $namproc</h3>";
      echo "<table border=0 bgcolor=\"#000000\" cellpadding=2>\n";
           echo "<tr bgcolor=\"#cccccc\">\n";
           echo "   <td align=right>Cedula</td>";
           echo "   <td>Paciente</td>";
           echo "   <td>Pieza</td>";
           echo "   <td align=right>Sesiones</td>";
           echo "   <td>Procedimiento</td>";
           echo "   <td>Acordado</td>";
           echo "</tr>\n";

      while($reg=mysql_fetch_object($query))
        {
           $ced = $reg->Paciente;
           $nom = $reg->npac;
           $dien= $reg->Diente;
           $cant= $reg->cant;
           $nproc=$reg->nproc;
           $normal=$reg->normal;
           
  
           echo "<tr>\n";
           echo "   <td bgcolor=\"#ffffff\"><a href=\"../../historias/conshist.php?paciente=$ced\" target=\"_blank\">$ced</a></td>";
           echo "   <td bgcolor=\"#ffffff\">$nom</td>";
           echo "   <td bgcolor=\"#ffffff\">$dien</td>";
           echo "   <td bgcolor=\"#ffffff\">$cant</td>";
           echo "   <td bgcolor=\"#ffffff\">$nproc</td>"; 
           echo "   <td bgcolor=\"#ffffff\">$normal</td>";
           echo "</tr>\n";
        }
      echo "</table>";
      echo "</center>";
      mysql_close();
?>
<hr>
<button onclick="javascript:window.close()">Cerrar</button>

