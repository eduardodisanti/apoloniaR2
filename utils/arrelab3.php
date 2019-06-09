<?php

   $query="select * from HistTrabSoc where Episodio=3 or Episodio=5 order by Paciente,Trabajo,Fecha";

$link=mysql_connect("127.0.0.1","root","virgen") or die("Error, la base de datos no acepto la coneccion");

   mysql_select_db("apolonia");

   $cant=0;
   $q = mysql_query($query);
   while($reg=mysql_fetch_object($q))
      {
          $pac = $reg->Paciente;
	  $tra = $reg->Trabajo;
	  $fec = $reg->Fecha;
	  $lab = $reg->Laboratorio;
	  $epi = $reg->Episodio;

	  echo "$pac - $tra -$fec - $lab - $epi\n";
     }
   
   mysql_close();
?>
