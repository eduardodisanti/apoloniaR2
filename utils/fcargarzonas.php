<?php

   $link=mysql_connect("127.0.0.1","root","virgen") or die("Error, la base de datos no acepto la coneccion");

   mysql_select_db("apolonia"); 
   $begin=0;
   $end=0;

   $fp=fopen("ftp://eduardo:VIRGEN@130.100.1.10/sistemas/cobranza/zonetas.txt","r");
   while(!feof($fp))
    {
       $reg=fgets($fp,65536);
       if(!empty($reg))
         {
           $cedula=strtok($reg,"|");
           $zona=strtok("|"); 
	   if(empty($zona))
	       $zona=0;
           mysql_query("update Pacientes set Zona=$zona where Habilitado='N' and Cedula = $cedula");
         }
    }

   mysql_close($link);
?>
