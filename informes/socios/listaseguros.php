<?php
require("../../functions/db.php");
$link=conectar();


    $hoy = Date("Y-m-d");
echo "<center><h4>TT AIT 02 - SEGUROS Documento que cuando se imprime pierde validez</h4></center><hr>";

$query = "select Seguro, Seguros.Nombre, Seguros.Paga as spaga, Pacientes.Paga as ppaga, count(*) as cuenta from Pacientes, Seguros where Seguro=Numero and Habilitado='S' group by Seguro, Pacientes.Paga";

    $qry = query($query);
    echo mysql_error();
     
echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "	<th colspan=1>Seguro</th>";
echo "	<th>Descripcion</th>";
echo "  <th>Pagan</th>";
echo "  <th>Cantidad</th>";
echo "</tr>\n";

$total = 0;
$metaAnt=0;
while($reg = fetch($qry))
 {

     $ppaga = $reg->ppaga;
     $spaga = $reg->spaga;

     if($spaga==$ppaga)
       {
          $color = '#ffffff';
       } else
             $color = '#00ddff';

 	echo "<tr bgcolor='$color'>";
	echo "<td>$reg->Seguro</td>";
	echo "<td>$reg->Nombre</td>"; 
	echo "<td>$spaga</td>";
	echo "<td align='right'>$reg->cuenta</td>";
	echo "</tr>\n";

	$total=$total + $reg->cuenta;
 }
 echo "</table>";
 $hoy=Date("Y-m-d");
 $ahora=Date("H-t-s");

 echo "Total de socios al $hoy en $ahora es : $total";
?>

<center><a href='#' onclick='window.print()'>Imprimir</a></center>

