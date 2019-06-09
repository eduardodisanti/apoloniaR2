<?php

 $link=mysql_connect("elias","root","virgen") or die("Error, la base de dato
s no acepto la coneccion");
 mysql_select_db("apolonia");

 $q = mysql_query("select * from pedidos");

   while($reg = mysql_fetch_object($q))
    {
      $almacen   = $reg->almacen;
      $articulo  = $reg->articulo;
      $cantidad  = $reg->cantidad;
      $saldo     = $reg->saldo;
      $firma     = $reg->firma;

      mysql_query("insert into tmppedidos values($almacen, $articulo, $cantidad, $saldo, '$firma')");

      echo mysql_error()."\n";
    }

 mysql_close();
?>
