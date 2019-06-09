<?php

function cierro_precios() {

  $anio = Date("Y");
  $mes  = Date("m");
$mes = 1;

 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");

// Primero paso todos los trabajos de laboratorio.
 $qry = mysql_query("delete from histprec where anio=$anio and mes = $mes");
 
 $qry = mysql_query("select Trabajos.id as Trabajo, Costo, Laboratorios.id as Laboratorio, valor from Trabajos, Laboratorios, TipoIva where TipoIva.id = Trabajos.TipoIva");

 echo mysql_error();


   while($reg = mysql_fetch_object($qry))
    {
      $trab = $reg->Trabajo;
      $tipo = 1; // Laboratorios
      $precio = $reg->Costo;
      $lab   = $reg->Laboratorio;
      $impuestos = $reg->valor;
      
      $q = "insert into histprec values($tipo, $lab, $anio, $mes, $trab, $precio, $impuestos)"; 
      mysql_query($q);
      echo mysql_error();
    }

die("end");
 $qry = mysql_query("select * from artprov");
 echo mysql_error();

   while($reg = mysql_fetch_object($qry))
    {
      
      $trab = $reg->articulo;
      $tipo = 2; // Stock
      $precio = $reg->precio;
      $prov   = $reg->proveedor;
      $tiva   = $reg->tipoiva;
      
      $q = "insert into histprec values($tipo, $prov, $anio, $mes, $trab, $precio, '$tiva')"; 

      mysql_query($q);
    }

// Luego paso todas los precios de proveedores
 mysql_close();

}


cierro_precios();

?>
