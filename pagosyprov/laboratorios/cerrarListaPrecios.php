<?php
function date_diff($date2, $date1)
  {
      $s = strtotime($date2) - strtotime($date1);
      $d = intval($s/86400);
      return($d);
  }

require("../../functions/db.php");
$link=conectar();

if($comando=='Cerrar') {

   $query = "select TrabLab.Laboratorio as lab, Trabajo, Costo, TipoIva.valor valor from Trabajos, TrabLab, TipoIva where TrabLab.Trabajo = Trabajos.id and Trabajos.tipoIva = TipoIva.id";

   $q = query($query);

   while($reg=fetch($q)) {

     $lab = $reg->lab;
     $tra = $reg->Trabajo;
     $cos = $reg->Costo;
     $val = $reg->valor;

     $query = "insert into histprec values(1,$lab,$anio,$mes,$lab,$cos,$val)";
     query($query);
   }
}

echo "<center><h4>Cerrar lista de precios</h4></center><hr>";
if(empty($comando))
 {
     echo "<form action='cerrarListaPrecios.php' method=post>\n";
     echo "<center><table border = 1 width='30%'>\n";
     echo "<tr>";
     echo "   <td align='right'>Anio</td>";
     echo "   <td><input type='text' size='4' name='anio'></td>";
     echo "</tr>";
     echo "   <td  align='right'>Mes</td>";
     echo "   <td><input type='text' size='2' name='mes'></td>";
     echo "</tr>";
     echo "   <td align='right'><input type='submit' name='comando' value='Cerrar'></td>";
     echo "   <td>&nbsp;&nbsp</td>";
     echo "</tr>";
     echo "</table></center>\n";
     echo "</form>\n";
 }
 echo "</table>";
?>
