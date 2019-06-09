<?php


$link=mysql_connect("elias","root","virgen");

   mysql_select_db("apolonia");

   $query="select * from Medicos";
   $q = mysql_query($query);
   while($reg=mysql_fetch_object($q))
       {
          mysql_query("insert into TablaUrgencias values($reg->Numero, 'CENTRAL', '2006-11-01')");
       }

?>
