<?php
require_once("class/Mateo.phpm");
session_start();
$m = $_SESSION['mateo'];
$tema = $m->getTema();

require("../functions/db.php");
$link=conectar();

if($cmd=='dl')
 {
   $query = "delete from elloteman where id='$lote' and articulo=$articulo";
   query($query);
 }
  else
    if($cmd=='add')
         {  
	    $query = "insert into elloteman values('$lote', '$vence', $articulo, $cantidad)";  
	    query($query);
	 }
    else
      if($cmd=='actualizar')
	   {
	       $query = "select * from elloteman";
           $qry = query($query);

           while($reg = fetch($qry))
	       {
	        $art=  $reg->articulo;
		$can = $reg->cantidad;
		$lot = $reg->id;
		$ven = $reg->vence;

                $lq = "insert into lotes values('$lot', '$ven', $art, $cant)";
                query($lq);
	   }
     }
if(empty($id))
   $id=0;
echo "<body bgcolor='#ffffff'>";
$query = "select elloteman.id as lote, nombre, elloteman.vence as xvence, cantidad, articulo, unidadAlmacen from elloteman, articulos where articulos.id = articulo order by nombre";

$qry = query($query);
echo mysql_error();
echo "<table width='99%' bgcolor='#000000' cellspacing='1'>";
echo "<tr bgcolor='#cccccc'><th>&nbsp;</th><th>Articulo</th><th>Cantidad</th><th>Unidad</th><th>Lote</th><th>Vence</th></tr>";
while($reg=fetch($qry))
{
  $art = $reg->articulo;
  $nom = $reg->nombre;
  $can = $reg->cantidad;
  $lot = $reg->lote;
  $ven = $reg->xvence;
  $uni = $reg->unidadAlmacen;

  echo "<tr bgcolor='#ffffff'>";
  echo "   <td>";
  echo "       <a href='elloteman.php?lote=$lot&articulo=$art&cmd=dl'><img src='../img/basura.png' border=0></a>";
  echo "   </td>";
  echo "   <td>$nom</td>";
  echo "   <td>$can</td>";
  echo "   <td align=center>$uni</td>";
  echo "   <td align=center>$lot</td>";
  echo "   <td align=center>$ven</td>";
  echo "</tr>";

}
echo "</table>";

?>

