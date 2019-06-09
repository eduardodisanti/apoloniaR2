<?php


$link=mysql_connect("elias","root","virgen");

   echo "Error : ".mysql_error()."\n";
   mysql_select_db("apolonia");

   $query="select Cedula, Telefono from Pacientes where Telefono > ' '";
   $q = mysql_query($query);
   while($reg=mysql_fetch_object($q))
       {
          echo "$reg->Cedula|$reg->Telefono\n";
       }

?>
