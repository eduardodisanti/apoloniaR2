<?php
require_once("class/Mateo.phpm");
session_start();
$m = $_SESSION['mateo'];
$tema = $m->getTema();

require("../functions/db.php");
$link=conectar();

if($cmd=='dl')
 {
   $query = "delete from tmpingman where almacen=$id and articulo=$articulo";
   query($query);
 }
  else
    if($cmd=='add')
         {  
	    $query = "insert into tmpingman values($id, $articulo, $cantidad, '$lote', '$vence')";  
	    query($query);
	 }
    else
      if($cmd=='actualizar')
	   {
	       $query = "select * from tmpingman where almacen=$id";
           $qry = query($query);

           while($reg = fetch($qry))
	       {
	        $art = $reg->articulo;
		 	$can = $reg->cantidad;
		 	$lot = $reg->lote;
		 	$ven = $reg->vence;
		 	$alm = $reg->almacen; 

			$hoy = date("Y-m-d");
			$ahora=date("H:i");
			
            $lq = "insert into Movstock values(1,$art, '$hoy', '$ahora', $alm, $alm, 'I', 0, $can, '$m->usuario','$lot')";
            query($lq);
            $lq = "select entradas from stock where almacen=$alm and articulo=$art";
            $qlq = query($lq);
            $lreg = fetch($qlq);
            if(!empty($lreg->entradas))
                $lq = "update stock set entradas=entradas + $can where articulo=$art and almacen=$alm";
            else
                $lq = "insert into stock values($alm, $art, $can, 0, 0)";
            query($lq);
            
            if(!empty($lot)) {
		         $lq = "insert into lotes values('$lot', '$ven', $art, $can)";
		         query($lq);
		    }
		 	query("delete from tmpingman where almacen=$id and articulo=$art");
	       }
	   }

if(empty($id))
   $id=0;
echo "<body bgcolor='#ffffff'>";
$query = "select almacen, articulo, cantidad, nombre, unidadAlmacen, factorAlmacen, lote, tmpingman.vence from tmpingman, articulos where almacen= $id and articulos.id = articulo order by nombre";

$qry = query($query);

echo "<table width='99%' bgcolor='#000000' cellspacing='1'>";
echo "<tr bgcolor='#cccccc'><th>&nbsp;</th><th>Articulo</th><th>Cantidad</th><th>Unidad</th><th>Lote</th><th>Vence</th></tr>";
while($reg=fetch($qry))
{
  $art = $reg->articulo;
  $nom = $reg->nombre;
  $can = $reg->cantidad;
  $uni = $reg->unidadAlmacen;
  $lot = $reg->lote;
  $ven = $reg->vence;
  $fac = $reg->factorAlmacen;

  echo "<tr bgcolor='#ffffff'>";
  echo "   <td>";
  echo "       <a href='elingman.php?id=$id&articulo=$art&cmd=dl'><img src='../img/basura.png' border=0></a>";
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

