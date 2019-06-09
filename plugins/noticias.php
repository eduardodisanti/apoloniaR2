<?php
   $fp=fopen("news/noticias.html","r");

   $mensaje="";
   while($x=fgets($fp))
    {
       $mensaje=$mensaje." - ".$x;
    }   

   fclose($fp);

   echo "<marquee>$mensaje</mensaje>";
?>
