<?php


$link=mysql_connect("elias","root","virgen");

   echo "Error : ".mysql_error()."\n";
   mysql_select_db("apolonia");

   $query="select * from Usuarios";
   $q = mysql_query($query);
   while($reg=mysql_fetch_object($q))
       {
          echo $reg->usuario;
       }

?>
