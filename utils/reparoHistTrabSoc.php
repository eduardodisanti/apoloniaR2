<?php


$link=mysql_connect("elias","root","virgen") or die("Error, la base de datos no acepto la coneccion");

   mysql_select_db("apolonia");

   $query="select * from HistTrabSoc where Episodio=3 and Fecha >='2006-10-26'";
   $q = mysql_query($query);
   while($reg=mysql_fetch_object($q))
    {
       $pac = $reg->Paciente;
       $tra = $reg->Trabajo;
       $fec = $reg->Fecha;
       $pie = $reg->Pieza;
       $epi = $reg->Episodio;
       $lab = $reg->Laboratorio;
       $ven = $reg->Vence;

       $query = "select * from TrabSoc where Paciente=$pac and Trabajo = $tra and Pieza=$pie";
       $q1 = mysql_query($query);
       $regq1 = mysql_fetch_object($q1);
       $qpac = $regq1->Paciente;
       if(empty($qpac))
         {
	   $qi = "insert into HistTrabSoc values($pac, $tra, '$ven', $pie, 8, $lab, '$ven')"; 
	   echo $qi."\n";
	   mysql_query($qi);
	 }
    }

   mysql_close();
?>
