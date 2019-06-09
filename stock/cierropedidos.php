<?php

function laburo() {

 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion ".mysql_error());
 mysql_select_db("apolonia");

 $anio = Date("Y");
 $mes  = Date("m");
 $dia = 1;
 $mes--;
 if($mes < 1) {
     $mes = 12;
     $anio--;
 }

 $mesant=$anio."-".$mes."-".$dia;
 $qry = mysql_query("select codigo, destino, articulo,sum(Unidades) as cant from Movstock where Fecha >='$mesant' and destino !=0 and origen = 0 group by codigo, destino, articulo");

die($query);
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
