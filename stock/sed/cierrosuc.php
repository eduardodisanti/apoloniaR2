<?php

function laburo() {

 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");

 $qry = mysql_query("select codigo, destino, articulo,sum(Unidades) as cant from Movstock where Fecha >='2008-09-01' and Fecha <='2008-09-31' and destino !=0 group by codigo, destino, articulo");

   while($reg = mysql_fetch_object($qry))
    {
     
      $cod = $reg->codigo;
      $des = $reg->destino;
      $art = $reg->articulo;
      $can = $reg->cant;

      $hoy = Date("Y-m-d");
      $ahora = Date("H:i");

      if($cod==2) {
         $q = "update stock set salidas = salidas + $can where almacen = $des and articulo = $art"; 
	 $q1 = "insert into Movstock values($cod, $art, '$hoy', '$ahora', $des, $des, 'A', 0, $can, 'sistema', '')";
      }
      else {
         $q = "update stock set salidas = salidas - $can where almacen = $des and articulo = $art";
	 $q1 = "insert into Movstock values($cod, $art, '$hoy', '$ahora', $des, $des, 'A', 0, $can, 'sistema', '')";
      }
      mysql_query($q);
    }

 mysql_close();

}

   laburo();
?>
