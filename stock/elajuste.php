<?php
require_once("class/Mateo.phpm");
session_start();
$m = $_SESSION['mateo'];
$tema = $m->getTema();

require("../functions/db.php");
$link=conectar();

if($cmd=='dl')
 {
   $query = "delete from tmpajustes where almacen=$id and articulo=$articulo";
   query($query);
 }
  else
    if($cmd=='add')
         {  
	    $query = "insert into tmpajustes values($id, $articulo, $cantidad, $codigo)";
	    query($query);
	 }
    else
      if($cmd=='actualizar')
        {
	   $query = "select * from tmpajustes where almacen=$id";
           $qry = query($query);

           while($reg = fetch($qry))
	       {
	        $cod = $reg->codigo;
	        $art = $reg->articulo;
		$can = $reg->cantidad;
		$alm = $reg->almacen; 

		$hoy = date("Y-m-d");
		$ahora=date("H:i");
		
                $lq = "insert into Movstock values($cod,$art, '$hoy', '$ahora', $alm, $alm, 'A', 0, $can, '$m->usuario','')";

                query($lq);
                $lq = "select entradas, articulo from stock where almacen=$alm and articulo=$art";
                $qlq = query($lq);
                $lreg = fetch($qlq);
                if(!empty($lreg->articulo))
		  {
		    if($cod==1)
                        $lq = "update stock set entradas=entradas + $can where articulo=$art and almacen=$alm";
		    else
		       $lq = "update stock set salidas=salidas + $can where articulo=$art and almacen=$alm";
		  }
                else
		   {
		    if($cod==1)
                      $lq = "insert into stock values($alm, $art, $can, 0, 0)";
                    else
   	              $lq = "insert into stock values($alm, $art, 0, $can, 0)"; 
		   }

                query($lq);
	        query("delete from tmpajustes where almacen=$id and articulo=$art");
	       }
	   }

if(empty($id))
   $id=0;
echo "<body bgcolor='#ffffff'>";
$query = "select almacen, articulo, cantidad, nombre, unidadAlmacen, tmpajustes.codigo  from tmpajustes, articulos where almacen= $id and articulos.id = articulo order by nombre";

$qry = query($query);

echo "<table width='99%' bgcolor='#000000' cellspacing='1'>";
echo "<tr bgcolor='#cccccc'><th>&nbsp;</th><th>Articulo</th><th>Entradas</th><th>Salidas</th><th>Unidad</th></tr>";
while($reg=fetch($qry))
{
  $art = $reg->articulo;
  $nom = $reg->nombre;
  $can = $reg->cantidad;
  $uni = $reg->unidadAlmacen;
  $cod = $reg->codigo;

  echo "<tr bgcolor='#ffffff'>";
  echo "   <td>";
  echo "       <a href='elajuste.php?id=$id&articulo=$art&cmd=dl'><img src='../img/basura.png' border=0></a>";
  echo "   </td>";
  echo "   <td>$nom</td>";
  if($cod == 1) {
     echo "   <td align=right>$can</td>";
     echo "   <td>&nbsp;&nbsp;</td>";
  }
     else {
               echo "   <td align=right>&nbsp;&nbsp;</td>";
               echo "   <td>$can</td>";
     }
  echo "   <td align=center>$uni</td>";
  echo "</tr>";

}
echo "</table>";

?>

