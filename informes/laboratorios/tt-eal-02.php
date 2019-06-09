<?php
require("../../functions/db.php");
$link=conectar();


    $hoy = Date("Y-m-d");
echo "<center><h4>Trabajos de Laboratorio(TT-EAL-02) Copia DOCUMENTO QUE CUANDO SE IMPRIME PIERDE VALIDEZ</h4></center><hr>";
      $query="select Trabajos.id as id, Trabajos.descripcion,Tiempo,Costo,TipoIva,valor from Trabajos, TipoIva where Activo='S' and Facturable='S' and TipoIva=TipoIva.id order by descripcion";

    $qry = query($query);
echo mysql_error();
 
     
echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "	<th colspan=1>Codigo</th>";
echo "	<th>Nombre</th>";
echo "  <th>Tiempo</th>";
echo "  <th>Costo</th>";
echo "  <th>Tasa</th>";
echo "</tr>\n";

while($reg = fetch($qry))
 {
       $codigo = $reg->id;
       $desc   = $reg->descripcion;
       $tiempo = $reg->Tiempo;
       $costo  = $reg->Costo;
       $fact   = $reg->Facturable;
       $tasa   = $reg->valor;

       $xtasa = number_format($tasa,2,".",",");
       if($fact=="N")
         $fact="";

 	echo "<tr bgcolor='#ffffff'>";
	echo "<td align='right'>$codigo</td>";
	echo "<td>$desc</td>"; 
	echo "<td align='right'>$tiempo</td>";
	echo "<td align='right'>$costo</td>";
//	echo "<td align='center'>$fact</td>";
        echo "<td align='right'>$xtasa %</td>";

	echo "</tr>\n";
 }
 echo "</table>";

?>

<center><a href='#' onclick='window.print()'>Imprimir</a></center>

