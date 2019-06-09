<?php
function date_diff($date2, $date1)
  {
      $s = strtotime($date2) - strtotime($date1);
      $d = intval($s/86400);
      return($d);
  }

echo "<center><h2>Tarjetas personales</h2></center><hr>";
if(empty($comando))
 {
     echo "<form action='tarjetas.php' method=post>\n";
     echo "<center><table border = 0 width='60%'>\n";
     echo "<tr>";
     echo "   <td>Fecha desde (AAAA-MM-DD)</td>";
     echo "   <td><input type='text' width='10' name='FECHADESDE'></td>";
     echo "</tr>";
     echo "<tr>";
     echo "   <td>Fecha hasta (AAAA-MM-DD)</td>";
     echo "   <td><input type='text' width='10' name='FECHAHASTA'></td>";
     echo "</tr>";
     echo "<tr>";
     echo "   <td><input type='submit' name='comando' value='Ejecutar'></td>";
     echo "   <td>&nbsp;&nbsp</td>";
     echo "</tr>";
     echo "</table></center>\n";
     echo "</form>\n";
 }
else
 {
     if(empty($FECHADESDE))
          $FECHADESDE='2003-07-01';
     if(empty($FECHAHASTA))
        $FECHAHASTA = '2003-12-31';
     $link=mysql_connect("elias","apolonia","virgen");
     $db = mysql_select_db("apolonia");

     $q1 = mysql_query("select Fecha,Marquitas.Funcionario,usuario,Hora from Marquitas, Usuarios where Fecha >= '$FECHADESDE' and Fecha <= '$FECHAHASTA' and Marquitas.Funcionario=Usuarios.Funcionario order by usuario, Fecha, Hora");

    $funcioAnt = 0;
    $fechaAnt = 0;
    $aux = "";
    $count=0; 
     echo "<table border=1 width=800>\n";
     while($reg=mysql_fetch_object($q1))
       {
         $fecha=$reg->Fecha;
         $funcio=$reg->Funcionario;
         $hora=$reg->Hora;
         $usuario=$reg->usuario;

         if($funcioAnt==0)
            {
               $funcioAnt  = $funcio;
               $usuarioAnt = $usuario; 
            }

         if($funcio != $funcioAnt)
            {
                if($aux!="")
                     $aux = $aux."</tr>";
                echo "<tr bgcolor='#cccccc'>";
	        echo " <td>$funcioAnt</td><td colspan=12><b>$usuarioAnt</b></td>";
                echo "</tr>";
                echo $aux;
                $aux = "";
                $fechaAnt = 0;
                $count = 0;
                $funcioAnt=$funcio;

                $usuarioAnt = $usuario;
            }
         if(($fecha != $fechaAnt))
           {
             if($fechaAnt != 0)
                $aux = $aux."</tr>\n";
             $aux = $aux."<tr><td>$fecha</td>";
             $fechaAnt = $fecha;
             $count = 1;
           }
         $aux = $aux."<td>$hora</td>";
         $count = $count + 1;
       }
       $aux = $aux."</tr>";
       echo "<tr bgcolor='#cccccc'>";
       echo " <td>$funcio</td><td colspan=12><b>$usuario</b></td>";
       echo "</tr>";
       echo $aux;
       echo "</table>\n";
     mysql_close();
}
?>
