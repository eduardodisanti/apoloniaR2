<?php

    include("../functions/db.php");

     $db = conectar();

     query("update stock set Entradas=0, Salidas=0");

     $query = "select * from Movstock where Fecha>='2007-08-24' and Origen=0 and Origen=0";
     $q = query($query);

     while($reg=fetch($q)) {

           $codigo = $reg->Codigo;
           $art =  $reg->Articulo;
	   $unidades = $reg->Unidades;
	   $origen   = $reg->Origen;
	   $destino  = $reg->Destino;

	   if($codigo==1) {

                  $query = "update stock set Entradas=Entradas + $unidades where almacen=$origen and articulo=$art";
                  $query1 = "";
		  echo mysql_error()."\n";
	   } else
	            {
	             $query = "update stock set Entradas=Entradas + $unidades where almacen=$destino and articulo=$art";
	    	     $query1 = "update stock set Salidas=Salidas + $unidades where almacen=$origen and articulo=$art";
		    }
	    
           query($query);
	   if(!empty($query1)) {
	        query($query1);
	   }

     }

     desconectar();
?>
