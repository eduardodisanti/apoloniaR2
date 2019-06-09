<?php


$link=mysql_connect("elias","root","virgen");

   echo "Error : ".mysql_error()."\n";
   mysql_select_db("apolonia");

   $query="select * from Usuarios";
   $q = mysql_query($query);
   while($reg=mysql_fetch_object($q))
       {
          echo $reg->usuario;
	  $x = strtok($reg->usuario," ");
	  while($xx = strtok(" "))
	    $x=$x.".".$xx;

         mysql_query("update Usuarios set email='$x@cadi.com.uy' where usuario='$reg->usuario'");
	 echo "= $x\n";
       }


?>
