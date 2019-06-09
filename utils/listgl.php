<?php

   $query="select * from ";

$link=mysql_connect("elias","root","virgen") or die("Error, la base de datos no acepto la coneccion");

   mysql_select_db("apolonia");

   $cant=0;
   $q = mysql_query($query);
   while($reg=mysql_fetch_object($q))
      {
          $fecha = $reg->Fecha;
	  $vence = $reg->Vence;
	  $pac = $reg->Paciente;
	  $trab= $reg->Trabajo;
	  $pieza=$reg->Pieza;

	  $vence = date("Y-m-d", strtotime("+14 day ".$fecha));

	  mysql_query(" update TrabSoc set Vence='$vence' where Paciente = $pac and Trabajo=$trab and Pieza=$pieza");
     }
   
   mysql_close();
?>
