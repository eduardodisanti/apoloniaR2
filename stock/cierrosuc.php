<?php

function laburo() {

 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion ".mysql_error());
 mysql_select_db("apolonia");


 $mesant="2008-09-01";
 $qry = mysql_query("select codigo, destino, articulo,sum(Unidades) as cant from Movstock where Fecha >='$mesant' and Fecha <='2009-02-29' and destino !=0 and origen = 0 group by codigo, destino, articulo");

echo mysql_error();
//die("select codigo, destino, articulo,sum(Unidades) as cant from Movstock where Fecha >='$mesant' and Fecha <='2009-02-29' destino !=0 and origen = 0 group by codigo, destino, articulo");
   while($reg = mysql_fetch_object($qry))
    {
     
      $cod = $reg->codigo;
      $des = $reg->destino;
      $art = $reg->articulo;
      $can = $reg->cant;

      $hoy = Date("Y-m-d");
      $ahora = Date("H:i");

      if($cod==2) {
          echo $can."<br>";
         $q = "update stock set salidas = salidas + $can where almacen = $des and articulo = $art";
	 //$q1 = "insert into Movstock values($cod, $art, '$hoy', '$ahora', $des, $des, 'A', 0, $can, 'sistema', '')";
      }
      mysql_query($q);
    }

 mysql_close();

}

   laburo();
?>
