<?php

include("../functions/db.php");

function llenarProveedores($articulo) {

   echo "<td>";
   echo "<select id=$articulo>";
   $q = "select * from proveedores order by nombre";
   $qry = query($q);
   while($reg=fetch($qry)) {

     $id = $reg->id;
     $nombre=$reg->nombre;
     echo "<option value=$id>$nombre</option>";
   }

   echo "</select>";
   echo "</td>";
}

$link=conectar();

   query("delete from Proforma");
   $fecha = Date("Y-m-d");
   
   $mes = Date("m");
   $anio= Date("Y");
   
   $mes--;
   if($mes<1) {
   	
   	$mes = 1;
   	$anio--;
   }
   
   $diadesde=1;
   $diahasta=31;
   
   $f1="$anio-$mes-$diadesde";
   $f2="$anio-$mes-$diahasta";
   
   // **** este select es para comprar en base al gasto *****
   
   echo "<table border=0 bgcolor='#000000' width=80% cellpadding=1px>";
   echo "<tr bgcolor='#cccccc'><th>Articulo</th><th>Entradas</th><th>Salidas</th><th>Comprar</th><th>Proveedor</th></tr>";

   $q = "select Movstock.Codigo, Articulo as codart, nombre, sum(unidades) as cantidad from Movstock, articulos where Fecha >='$f1' and Fecha <= '$f2' and articulos.id = Movstock.articulo group by Movstock.Codigo, Articulo order by nombre, Movstock.Codigo";

   $qry = query($q);
   
   echo mysql_error();
   
   $aant = $ent = $sal = 0;
   
   while($reg = fetch($qry)) {
   	
   	  $codigo = $reg->codart;
   	  $art    = $reg->Articulo;
   	  $nombre = $reg->nombre;
   	  $cant   = $reg->cantidad;
   	 
	 if($aant==0) {

             $aant = $codigo;
	 }

   	  if($codigo==1)
   	     $ent+=$cant;
   	  else
   	     $sal+=$cant;
   	  
   	  if($aant!=$codigo) {
   	 
	    $qsal = "select (entradas - salidas) as saldo from stock where almacen=0 and articulo=$aant";
	    $qqsal = query($qsal);
	    //die($qsal);
	    $qreg = fetch($qqsal);
	    $sent = $qreg->saldo;

   	    $xent = number_format($sent);
   	    $xsal = number_format($sal);
   	    $comprar = $sal - $sent;
   	    $xcomp = number_format($comprar);
   	    if($comprar > 0) {
	    query("insert into Proforma values($aant, $comprar)");
	    $err=mysql_error();
	    if(!empty($err))
	       echo($err.$aant."<br>");

          echo "<tr bgcolor='#ffffff'><td>$nombre</td><td align=right>$xent</td><td align=right>$xsal</td><td align=right>$xcomp</td>";
	  llenarProveedores($aant);
	  echo "</tr>";
	  }
   	  	$ent = 0;
   	  	$sal = 0;
   	  	$aant = $codigo;
   	}
   }
   
   echo "</table>";
?>
