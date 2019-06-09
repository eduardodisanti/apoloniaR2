<?php

$link=mysql_connect("elias","root","virgen");

   mysql_select_db("apolonia");

   $query="select * from FactLab where Fecha <='2007-10-25'";
   $q = mysql_query($query);

   while($reg=mysql_fetch_object($q))
       {

          $lab = $reg->Laboratorio;
	  $ser = $reg->Serie; 
	  $fac = $reg->Numero;
	  $fec = $reg->Fecha;

          if($fec > '2007-10-25')
	     die("Horror");
	  $q1 = mysql_query("select * from RecFact where SerieFact='$ser' and LabRecibo=$lab and NumeroFact=$fac");

          $reg1 = mysql_fetch_object($q1);
	  $filas = mysql_num_rows($q1);

          if($filas==0) { 
	     $query = "insert into RecFact values('@', $lab, 9999, '$ser', $fac)";
	     mysql_query($query);
	  }
       }

?>
