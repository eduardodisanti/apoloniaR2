<?php

function limpiar($a)
{
  $ok = $a;

  return($ok); 
}
 
   $link=mysql_connect("127.0.0.1","root","virgen") or die("Error, la base de datos no acepto la coneccion");

   mysql_select_db("apolonia"); 
   $begin=0;
   $end=0;

   $fp=fopen("/srv/tmp/maestrod.txt","r");
   while(!feof($fp))
    {
       $reg=fgets($fp,65536);
       if(!empty($reg))
         {
           $cedula=strtok($reg,"|");
           $seguro=strtok("|");
           $nombre=strtok("|");

	   limpiar($nombre);
           $sexo=strtok("|");
           $tel=strtok("|");
           $dom=strtok("|");
           $paga=strtok("|");
           $atraso=strtok("|");
           $zona=strtok("|"); 
           //echo "$cedula,$nombre\n";
           if(empty($paga))  $paga='S';
           if(empty($atraso)) $atraso=0;

           $end=$cedula;
           mysql_query("update Pacientes set Habilitado='N' where Cedula > $begin and Cedula < $end");

           $comi=strtok($nombre,"'");
           $fini=strtok("'");
           $nombre=$comi."-".$fini;

           $comi=strtok($dom,"'");
           $fini=strtok("'");
           $dom=$comi."-".$fini;

           $query=mysql_query("delete from Pacientes where Cedula=$cedula");

           $query=mysql_query("insert into Pacientes values($cedula,$seguro,'$nombre','$sexo','$tel','$dom','$paga',$atraso,'S',$zona)");
           $err=mysql_error();
     /*      if(!empty($err))
              echo("\n".$err." en ".$qq."\n"); */
           $begin=$cedula;
         }
    }

   mysql_query("update Pacientes set Paga='N' where Seguro=36 or Seguro=37");
   mysql_close($link);
?>
