<?php
require("../../functions/db.php");
$link=conectar();


    $hoy = Date("Y-m-d");
echo "<center><h4>Laboratorios(TT-EAL-03) DOCUMENTO QUE CUANDO SE IMPRIME PIERDE VALIDEZ</h4></center><hr>";
      $query="select * from Laboratorios order by descripcion";

    $qry = query($query);
echo mysql_error();
 
     
echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "	<th colspan=1>Codigo</th>";
echo "	<th>Nombre</th>";
echo "  <th>Razon social</th>";
echo "  <th>Domicilio</th>";
echo "  <th>Telefono</th>";
echo "  <th>email</th>";
echo "  <th>RUC</th>";
echo "  <th>Cupo</th>";
echo "  <th>Categoria</th>";
echo "</tr>\n";

while($reg = fetch($qry))
 {
       $codigo = $reg->id;
       $desc   = $reg->descripcion;
       $rs     = $reg->razonSocial;
       $ruc    = $reg->ruc;
       $tel    = $reg->telefono;
       $dom    = $reg->domicilio;
       $cupo   = $reg->Cupo;
       $email  = $reg->email;
       $cat    = $reg->categoria;

 	echo "<tr bgcolor='#ffffff'>";
	echo "<td>$codigo</td>";
	echo "<td>$desc</td>"; 
	echo "<td>$rs</td>";
	echo "<td>$dom</td>";
	echo "<td>$tel</td>";
	echo "<td>$email</td>";
	echo "<td>$ruc</td>";
	echo "<td>$cupo</td>";
	echo "<td>$cat</td>";
	echo "</tr>\n";
 }
 echo "</table>";

?>

<center><a href='#' onclick='window.print()'>Imprimir</a></center>

