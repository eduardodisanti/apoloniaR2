<?php

 $anioNuevo = 2009;
 $mesNuevo = 1;

$link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");

   mysql_select_db("apolonia");

   $query="select * from histprec where anio=2008 and mes=12 and tipo=1";
   $q = mysql_query($query);
   while($reg=mysql_fetch_object($q))
    {

        $tipo = $reg->tipo;
	$proveedor = $reg->proveedor;
        $anio = $reg->anio;
	$mes = $reg->mes;
	$articulo = $reg->articulo;
	$precio = $reg->precio;
	$impuesto = $reg->impuestos;

	$qq = "insert into histprec values($tipo, $proveedor, $anioNuevo, $mesNuevo, $articulo, $precio, $impuesto)";
    
        echo $qq."\n";
	mysql_query($qq);
    }

   mysql_close();
?>
