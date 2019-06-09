<?php
     $link=mysql_connect("elias","apolonia","virgen");
     $db = mysql_select_db("apolonia");

     $query = mysql_query(" select CSesiones.Procedimiento as codproc, Nombre, CSesiones.Sesiones as sesiones, count(*) as Cantidad, Procedimientos.Sesiones acordado from CSesiones,Procedimientos where CSesiones.Procedimiento = Procedimientos.Codigo and CSesiones.Sesiones > Procedimientos.Sesiones group by Nombre, CSesiones.Sesiones");

      $err=mysql_error();
      if(!empty($err))
        die($err);

      $hoy=date("d-m-Y");
      echo "<center>";
      echo "<h3>Informe de sesiones que superan la cantidad acordada emision $hoy";
      echo "<table border=0 bgcolor=\"#000000\" cellpadding=2>\n";
           echo "<tr bgcolor=\"#cccccc\">\n";
           echo "   <td>Procedimiento</td>";
           echo "   <td>Sesiones</td>";
           echo "   <td>Pacientes</td>";
           echo "   <td>Acordado</td>";
           echo "</tr>\n";

      while($reg=mysql_fetch_object($query))
        {
           $nom = $reg->Nombre;
           $sesn= $reg->sesiones;
           $cant= $reg->Cantidad;
           $normal=$reg->acordado;
           $codproc=$reg->codproc;
 
           if($sesn > ($normal + 2))
                $color="#ffaaaa";
           else
             if($sesn > ($normal + 1))
                $color="#ffffaa";
                else
                   $color="#ffffff"; 
 
           $link="controlses.php?procedimiento=$codproc&xcant=$sesn&namproc=$nom";
           echo "<tr>\n";
           echo "   <td bgcolor=\"#ffffff\"><a href=\"$link\" target='_blank'>$nom</a></td>";
           echo "   <td bgcolor=\"$color\">$sesn</td>";
           echo "   <td bgcolor=\"$color\">$cant</td>";
           echo "   <td bgcolor=\"$color\">$normal</td>";
           echo "</tr>\n";
        }
      echo "</table>";
      echo "</center>";
      mysql_close();
?>
<hr>
<button onclick="javascript:window.close()">Cerrar</button>
