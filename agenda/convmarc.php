<?
   $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");

   mysql_select_db("apolonia"); 

   $q = mysql_query("select * from Marcas");
   while($reg=mysql_fetch_object($q))
     {
         $fecha = $reg->Fecha;
         $fun   = $reg->Funcionario;
         $ent   = $reg->Entrada;
         $sal   = $reg->Salida;

         mysql_query("insert into Marquitas values($fun,'$ent','$fecha')");
         $err = mysql_error();
         if(!empty($err))
              echo $err."\n";
         mysql_query("insert into Marquitas values($fun,'$sal','$fecha')");
         $err = mysql_error();
         if(!empty($err))
              echo $err."\n";
     }
   mysql_close($link);
?>
