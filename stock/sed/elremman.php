<?php
require_once("class/Mateo.phpm");
session_start();
$m = $_SESSION['mateo'];
$tema = $m->getTema();

require("../functions/db.php");
$link=conectar();

$q = "select nombre from almacenes where id=$destino";
$qry = query($q);
$reg = fetch($qry);

$xdestino = $reg->nombre;

if($cmd=='dl')
 {
   $query = "delete from tmpremman where numero=$numero and articulo=$articulo";
   query($query);
 }
  else
    if($cmd=='add')
         {  
	    $query = "insert into tmpremman values($numero, 0, $destino, $articulo, $cantidad, '$lote')";  
	    query($query);
	 }
    else
      if($cmd=='actualizar')
	   {

	   $query = "select valor from numeradores where id='transferencias'";
	   $qry = query($query);
	   $reg = fetch($qry);
	   $numeroDOC = $reg->valor + 1;
	   query("update numeradores set valor=valor+1 where id='transferencias'");
           $qry = query($query);
           $reg = fetch($qry);

           $hoy = date("Y-m-d");
           $ahora=date("H:i");

	   $doc = "<html><head><title>Transferencia $numeroDOC</title></head>";
	   $doc.= "<body>";
	   $doc.="<table border=0>";
	   $doc.="<tr><td>Transferencia</td><td align=left>$numeroDOC</td><td>$hoy</td><td>$ahora</td><td>Para <B>$xdestino</B></td></tr>";
	   $doc.="<tr><th>Articulo</th><th>Cantidad</th><th>Lote</th><th>Vence</th></tr>";

	   unset($_SESSION['numero']);

	   $query = "select articulo,cantidad,lote,vence,destino,articulos.nombre artnombre, controlado from tmpremman,articulos,almacenes where numero=$numero and articulo=articulos.id and almacenes.id = destino";
           $qry = query($query);

           while($reg = fetch($qry))
	    {
	        $art = $reg->articulo;
		$des = $reg->artnombre;
	 	$can = $reg->cantidad;
	 	$lot = $reg->lote;
	 	$ven = $reg->vence;
	 	$destino = $reg->destino; 

                $controlado = $reg->controlado;

                $almacenControlado = $controlado == "S";
		$hoy = date("Y-m-d");
		$ahora=date("H:i");

            $doc.="<tr><td>$des</td><td align=right>$can</td><td>$lot</td><td>$ven</td></tr>";
            $lq = "insert into Movstock values(2,$art, '$hoy', '$ahora', 0, $destino, 'R', $numeroDOC, $can, '$m->usuario','$lot')";
            query($lq);

         $lq = "select entradas from stock where almacen=0 and articulo=$art";
         $qlq = query($lq);
         $lreg = fetch($qlq);
	 if(!empty($lreg->entradas))
            $lq = "update stock set salidas=salidas + $can where articulo=$art and almacen=0";
        else
            $lq = "insert into stock values($0, $art, $can, 0, 0)";
        query($lq);

            $lq = "select entradas from stock where almacen=$destino and articulo=$art";                                                                                    $qlq = query($lq);                                                              $lreg = fetch($qlq);                                                                                 
	    if(!$almacenControlado) {

            	if(!empty($lreg->entradas))
                	$lq = "update stock set entradas=entradas + $can where articulo=$art and almacen=$destino";
            	else
                   $lq = "insert into stock values($destino, $art, $can, 0, 0)";
            	query($lq);
           
            } else {
	          $aq = "insert into transito values($destino, $art, '$hoy', $can, 0, '$lot', $numeroDOC)"; 
		  query($aq);
		  echo mysql_error();
	    }

	  query("delete from tmpremman where numero=$numero and articulo=$art");
	  }

    $doc.="</table>";
    echo $doc;
    echo "<script>window.print()</script>";
   }

if(empty($id))
   $id=0;
echo "<body bgcolor='#ffffff'>";
$query = "select destino, articulo, cantidad, nombre, unidadAlmacen, lote from tmpremman, articulos where numero= $numero and articulos.id = articulo order by nombre";
$qry = query($query);

echo "<table width='99%' bgcolor='#000000' cellspacing='1'>";
echo "<tr bgcolor='#cccccc'><th>&nbsp;</th><th>Articulo</th><th>Cantidad</th><th>Unidad</th><th>Lote</th></tr>";
while($reg=fetch($qry))
{
  $art = $reg->articulo;
  $nom = $reg->nombre;
  $can = $reg->cantidad;
  $uni = $reg->unidadAlmacen;
  $lot = $reg->lote;

  echo "<tr bgcolor='#ffffff'>";
  echo "   <td>";
  echo "       <a href='elremman.php?numero=$numero&articulo=$art&cmd=dl'><img src='../img/basura.png' border=0></a>";
  echo "   </td>";
  echo "   <td>$nom</td>";
  echo "   <td>$can</td>";
  echo "   <td align=center>$uni</td>";
  echo "   <td align=center>$lot</td>";
  echo "</tr>";

}
echo "</table>";

?>

