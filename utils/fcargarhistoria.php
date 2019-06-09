<?php

   $link=mysql_connect("127.0.0.1","root","virgen") or die("Error, la base de datos no acepto la coneccion");

   mysql_select_db("apolonia"); 
   $begin=0;
   $end=0;

   $fp=fopen("ftp://eduardo:VIRGEN@130.100.1.10/sistemas/despacho/histo.txt","r");
   while(!feof($fp))
    {
       $reg=fgets($fp,65536);
       if(!empty($reg))
         {
           $cedula=strtok($reg,"|");
           $seguro=strtok("|");
           $baja=strtok("|");
           $zona=strtok("|");
	   if($zona=="")
	         $zona=0;

           $query=mysql_query("insert into HistoriaBajas values($cedula,$seguro,'$baja',$zona)");
           $err=mysql_error();
         }
    }

   mysql_close($link);
?>
