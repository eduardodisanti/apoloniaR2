<?php
require("../../functions/db.php");
$link=conectar();


    $hoy = Date("Y-m-d");
echo "<center><h4>Trabajos que envian de CADI a los Laboratorios (TT-EAL-01 DOCUMENTO QUE CUANDO SE IMPRIME PIERDE VALIDEZ)</h4></center><hr>";
      $query="select Trabajos.id as idtrab, Trabajo, Facturable, Trabajos.descripcion as desctrab, MetaTrabajos.id as idmeta, MetaTrabajos.descripcion as descmeta from MetaTrabTrab, Trabajos, MetaTrabajos where  MetaTrabTrab.Trabajo = Trabajos.id and MetaTrabTrab.Meta = MetaTrabajos.id order by Meta, Orden";


    $qry = query($query);
echo mysql_error();
 
     
echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "	<th colspan=1>Producto Final</th>";
echo "	<th>Procedimiento</th>";
echo "  <th>Fact</th>";
echo "  <th>Laboratorios</th>";
echo "</tr>\n";

$metaAnt=0;
while($reg = fetch($qry))
 {
	$idtrab   = $reg->idtrab;
	$desctrab = $reg->desctrab;
	$idmeta   = $reg->idmeta;
	$descmeta = $reg->descmeta;
	$fact     = $reg->Facturable;

        if($fact=="S")
	   $fact="F";
	else
	   if($fact=="N")
	        $fact=" ";
	   else
	        $fact="?";
        if($metaAnt!=$idmeta)
	  {
	     $metaAnt = $idmeta;
	     $xidmeta = $idmeta;
	  }
	     else
	         {
	          $descmeta="&nbsp;";
		  $xidmeta=" ";
                 }
 	echo "<tr bgcolor='#ffffff'>";
	echo "<td>$xidmeta $descmeta</td>";
	echo "<td>$idtrab) $desctrab</td>"; 
	echo "<td>$fact</td>";
	echo "<td>";
	imprimoLab($idtrab);
	echo "</td>";
	echo "</tr>\n";
 }
 echo "</table>";

 function imprimoLab($trab)
 {
    $rq = "select descripcion from TrabLab, Laboratorios where Trabajo=$trab and id=Laboratorio group by descripcion";

    $qq = mysql_query($rq);
    while($reg=mysql_fetch_object($qq))
    {
       $desc = $reg->descripcion;
       echo "$desc - ";
    }
 }
?>

<center><a href='#' onclick='window.print()'>Imprimir</a></center>

