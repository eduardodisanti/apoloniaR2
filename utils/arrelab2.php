<?php

   $query="select * from HistTrabSoc where Laboratorio=5 and Fecha >= '2005-09-09' and Fecha <= '2005-10-06'";

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

         $query = "select * from HistTrabSoc where Paciente = $pac and Trabajo=$tra and Laboratorio=5 and Fecha >= '2005-09-09' and Episodio=5";

	 $laqq = mysql_query($query);

         $regqq = mysql_fetch_object($laqq);
	 $pacqq = $regqq->Paciente;

	 if(empty($pacqq))
	  {
	    mysql_query("delete HistTrabSoc values($pac, $tra, '$fec', 5, 5)");
	  }
	 $err = mysql_error();
	 if(!empty($err))
	     $err."\n";
     }
   
   mysql_close();
?>
