<?php
require_once("class/Mateo.phpm");
session_start();
$m = $_SESSION['mateo'];
$tema = $m->getTema();

require("../functions/db.php");
$link=conectar();

//query($query);


if(empty($orden))
   $orden='nombre';
   
echo "<body bgcolor='#ffffff'>";
$query = "select almacen, articulo, cantidad, nombre, unidadAlmacen, saldo, enviados, fecha, lote from pedidos, articulos where almacen= $id and articulos.id = articulo and enviados > 0 order by $orden";
$qry = query($query);

$qq = "select * from almacenes where id=$id";
$qqry=query($qq);

$qreg = fetch($qqry);
$para = $qreg->nombre;

echo "<table width='99%' bgcolor='#000000' cellspacing='1'>";
if($cmd=="enviar")
  {
  	
  	 $q = "select valor from numeradores where id='transferencias'";
	 $qq = query($q);
	 $reg = fetch($qq);

	 $numero = $reg->valor + 1;
	 query("update numeradores set valor=$numero where id='transferencias'");
     $hoy = Date("d-m-Y");
     echo "<tr bgcolor='#FFFFFF'>";
     echo "	<th colspan=2 align='left'><img src='logos/cadi.jpg' width=64></th>";
     echo "	<th colspan = 2>Remito interno para : <i>$para</i></th>";
     echo "	<th colspan = 1>$hoy Numero: $numero</th>";
     echo "</tr>";
  }
echo "<tr bgcolor='#cccccc'><th>&nbsp;</th>";
echo "<th>";
echo "     <a href='enviarremito.php?id=$id&orden=nombre'>Articulo</a>";
echo "</th><th>Enviando</th><th>Unidad</th><th>";
echo "     <a href='enviarremito.php?id=$id&orden=fecha desc,nombre'>Enviado</a>";
echo "</th></tr>";

while($reg=fetch($qry))
{
  $art = $reg->articulo;
  $nom = $reg->nombre;
  $can = $reg->cantidad;
  $uni = $reg->unidadAlmacen;
  $sal = $reg->saldo;
  $fec = $reg->fecha;
  $env = $reg->enviados;
  $lot = $reg->lote;
  $saldo=$reg->saldo;
  
  if($fec=='0000-00-00')
     $fec="";
  
  $eps = "elpedidocentral.php?id=$id&articulo=$art&cmd=ud";
  echo "<tr bgcolor='#ffffff'>";
  echo "   <td>";
  echo "       &nbsp;&nbsp;";
  echo "   </td>";
  echo "   <td>$nom</td>";
  echo "<td align=center>";

  echo "$env";

  echo "</td>";
  
  echo "   <td align=center>";
  echo "$uni";
  echo "   </td>";
  echo "   <td align=center>$fec</td>";
  echo "</tr>";
}
echo "</table>";

if($cmd=="imprimir")
   echo "<script languaje='javascript'>window.print();</script>";
   
if($cmd=="enviar") {
	
	$q = "select controlado from almacenes where id=$id";
	$qry = query($q);
	$reg = fetch($qry);
	
	$almacenControlado = $reg->controlado;
	
	$hoy = date("Y-m-d");
	$ahora=date("H:i");
	
    $q = "insert into remitosInt values($numero, 0, $id, '$hoy')";
	query($q);
	
    $q = "select * from pedidos where almacen=$id and enviados != 0";
	$qry = query($q);
	
	while($reg=fetch($qry)) 
	{
	   $alm       = $reg->almacen;
	   $art       = $reg->articulo;
       $env       = $reg->enviados;
       $remanente = $reg->saldo - $env;
	   $saldo     = $reg->saldo - $env;
	   $lote      = $reg->lote;

       $q1 = "insert into Movstock values(2,$art,'$hoy','$ahora',0,$id,'T',$numero,$env,'$m->usuario','$lote')";
       query($q1);
     
       $q3 = "insert into stock values(0, $art, 0,0,0)";
       query($q3);

       $q5 = "update stock set salidas = salidas + $env where almacen=0 and
           articulo=$art";
       query($q5);

       if($controlado == "N") { 

           $q4 = "insert into stock values($id, $art, 0,0,0)";
           query($q4);

           $q6 = "update stock set entradas=entradas + $env where almacen=$id and articulo=$art";
           query($q6);
	   } else {
	   	
	   	         $q8 = "insert into transito values($id, $art, '$hoy', $env, 0, '$lot', $numero)";
			 query($q8);
	     }
	
       if($remanente==0)
  	      $q2 = "delete from pedidos where almacen=$id and articulo=$art and lote = '$lote'";
  	   else
   	      $q2 = "update pedidos set enviados = 0, saldo = $saldo where almacen=$id and articulo=$art and lote = '$lote'";
       query($q2);
       
       if(!empty($lote)) {
          $q7 = "update lotes set cantidad = cantidad - $env where id='$lote' and articulo=$art";
          query($q7);
       }
      
       echo "<script languaje='javascript'>window.print();</script>";
       //die("$q1<br>$q2<br>$q3<br>$q4<br>$q5<br>$q6<br>$q7<br>");
	}
}

?>

