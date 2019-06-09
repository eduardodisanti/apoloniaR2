<?php
require("../functions/db.php");

require_once("class/Mateo.phpm");

session_start();
$m = $_SESSION['mateo'];
$tema = $m->getTema();

echo "<script>\n";
echo "

     function recargar(laurl, laid, linea) {
     	
     	var id = document.getElementById(laid);
     	
     	lote = id.value;
     	
     	laurl = laurl+'&lotepasado='+lote+'&orden=nombre#'+linea;
     	
     	window.location.href=laurl;
     }
";
echo "</script>\n";
$link=conectar();
if($cmd=='ud')
         {  
			$hoy=date("Y-m-d");
			if(empty($accion)) {
				$query = "update pedidos set enviados = enviados + ($cantidad), fecha='$hoy', lote='$lote' where almacen=$id and articulo=$articulo and lote='$loteactual'";
				query($query);
			}
			if($accion=="del") {
			      $query = "delete from pedidos where almacen=$id and articulo=$articulo and lote = '$loteactual'";
			      query($query);
			}
			else 
			   if($accion=='split') {
					$query = "update pedidos set enviados = $cantidad, fecha='$hoy', lote='$lot' where almacen=$id and articulo=$articulo and lote = '$loteactual'";
					query($query);
					$cantidadNueva = $cantidad;
					$query = "insert into pedidos values ($id,$articulo,$cantidadNueva, $cantidadNueva,'$usuario', '$hoy', 0, '$lote')";
				    query($query);
			}
	    	//die($query);
	 }

if(empty($orden))
   $orden='nombre';
   
echo "<body bgcolor='#ffffff'>";
$query = "select almacen, articulo, cantidad, nombre, unidadAlmacen, saldo, enviados, fecha, lote, vence from pedidos, articulos where almacen= $id and articulos.id = articulo order by $orden";

$qry = query($query);
$linea=0;

echo "<table width='99%' bgcolor='#000000' cellspacing='1'>";
echo "<tr bgcolor='#cccccc'><th>&nbsp;</th>";
echo "<th>";
echo "     <a href='elpedidocentral.php?id=$id&orden=nombre'>Articulo</a>";
echo "</th><th width=200px>Lote";
echo "</th><th>Pedido</th><th>Saldo</th><th>Enviando</th><th>Unidad</th><th>";
echo "     <a href='elpedidocentral.php?id=$id&orden=fecha desc,nombre'>Enviado</a>";
echo "</th></tr>";
while($reg=fetch($qry))
{

  ++$linea;
  $art = $reg->articulo;
  $nom = $reg->nombre;
  $can = $reg->cantidad;
  $uni = $reg->unidadAlmacen;
  $sal = $reg->saldo;
  $fec = $reg->fecha;
  $env = $reg->enviados;
  $lot = $reg->lote;
  $vence = $reg->vence;
 
  $loteactual = $lot;
  $resto = $sal - $env;
  $restomenos1 = $env - 1;
  if($restomenos1<0)
     $restomenos1=0;
     
  if($fec=='0000-00-00')
     $fec="";
 
  $ahora = Date("m:i:s");
  $eps = "elpedidocentral.php?id=$id&articulo=$art&cmd=ud";
  //echo "<a name='$linea'></a>";
  echo "<tr bgcolor='#ffffff'>";
  echo "   <td>";
  echo "      <a name='$linea'></a><a href='$eps&accion=del'><img src='img/borrar16.png' border=0></a>&nbsp;&nbsp;";
  if($env != 0 && !empty($lot))
     echo "       <a href='$eps&cantidad=$resto&accion=split'><img src='img/editar16.png' border=0></a>";
  echo "   </td>";
  echo "   <td>$nom</td>";
  echo "   <td>";
    	$ellote = "";
  if($vence=='N')
    echo "&nbsp;&nbsp;";
  else {
  	//echo "   <input type='text' size=8 name='lot' value='$lot'>";
  	$lq  = "select * from lotes where articulo=$art and cantidad != 0 order by vence";
  	$lqq = query($lq);
  	 echo "\n<select name='lot' id='lote$art' onChange='recargar(\"$eps\", \"lote$art\", $linea)'>";
  	while($lreg = fetch($lqq)) {
  	    
  		$idlote = $lreg->id;
  		$fvlote = $lreg->vence;

  		if($lotepasado==$idlote) {
  	      $selected = "selected";
  	      $ellote = $lotepasado;
  		}
  	    else
  	      $selected="";
  		 echo "<option value='$idlote' $selected>$idlote - $fvlote</option>";
  		
  		//echo "<font size='0'><a href='$eps&lotepasado=$idlote#$linea'>$idlote - $fvlote</a><br></font>";
  		
  		if(empty($ellote))
  		   $ellote = $idlote;
    }
      echo "</select>\n";
  }
  echo "   </td>";
  echo "   <td align=right>$can</td><td align=right>$sal</td>";
  echo "<td align=center>";
  if($env > 0) {
      echo "   <a href='$eps&cantidad=-$env&ahora=$ahora&lote=$ellote&orden=$orden#$linea'><<</a>";  
      echo "   <a href='$eps&cantidad=-1&ahora=$ahora&lote=$ellote&orden=$orden#$linea'>[-]</a> ";
  }
  echo "$env";
  if($sal > 0) {
      echo "   <a href='$eps&cantidad=1&ahora=$ahora&lote=$ellote&loteactual=$loteactual&orden=$orden#$linea'>[+]</a>";
      echo "   <a href='$eps&cantidad=$sal&ahora=$ahora&lote=$ellote&loteactual=$loteactual&orden=$orden#$linea'>>></a>";
  }
  echo "</td>";
  
  echo "   <td align=center>";
  echo "$uni";
  echo "   </td>";
  echo "   <td align=center>$fec</td>";
  echo "</tr>";
}
echo "</table>";

?>

