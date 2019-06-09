<?php

$link=mysql_connect("elias","root","virgen");

   mysql_select_db("apolonia");

   $query="select nombre, unidadCompra, factorAlmacen as Almacen, factorExpedicion as expedicion, vence as Critico from articulos order by nombre";
   $q = mysql_query($query);
   echo "<table border=1>";
   echo "<tr>";
   echo "<td>Articulo</td><td>Unidad de compra</td><td>Unidad almacen</td><td>Unidad expedicion</td><td>Es critico</td>";
   echo "</tr>";
   while($reg=mysql_fetch_object($q))
       {
          echo "<tr>";
          echo "<td>$reg->nombre</td>";
	  echo "<td>$reg->unidadCompra</td>";
	  echo "<td>$reg->Almacen</td>";
	  echo "<td>$reg->expedicion</td>";
	  echo "<td>$reg->Critico</td>";
       }

  echo "</tr>";

?>
