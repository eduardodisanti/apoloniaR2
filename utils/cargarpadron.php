<?php

  function limpiar($cadena)
  {
     $limpia = "";
     $len = strlen($cadena);
     for($a=0;$a<=$len;$a++)
        {
         $x = substr($cadena, $a, 1);
         if($x=="'" || $x=="\"")
              $x=".";
         if($x < " ")
              $x=" ";
         if($x > "z")
              $x="-";

         $limpia=$limpia.$x;
         }

     return($limpia);
  }

   $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");

   mysql_select_db("apolonia"); 
   $begin=0;
   $end=0;
   $cuenta = 0;

   $fp=fopen("/home/mucam/maestrod.txt","r");
   if(empty($fp))
      die("Error ftp");

   while(!feof($fp))
    {
       $reg=fgets($fp,65536);
       if(!empty($reg))
         {
           $cedula=strtok($reg,"|");
           $seguro=strtok("|");
           $nombre=strtok("|");
           $sexo=strtok("|");
           $tel=strtok("|");
           $dom=strtok("|");
           $paga=strtok("|");
           $atraso=strtok("|");
           $zona=strtok("|"); 
	   $fing=strtok("|");
	   $fechanac=strtok("|");
	   $frenuncia=strtok("|");

           if(empty($fechanac))
	     $fechanac = "0000-00-00";
	   
	   if(empty($frenuncia))
	      $frenuncia="0000-00-00";

           if(empty($paga))  $paga='S';
           if(empty($atraso)) $atraso=0;
           if(empty($zona) || $zona < "0")
	       $zona=0;
           $end=$cedula;
           mysql_query("update Pacientes set Habilitado='N' where Cedula > $begin and Cedula < $end");

	   $nombre = limpiar($nombre);
           $dom    = limpiar($dom);
           $tel    = limpiar($tel);

           $query = mysql_query("select * from Pacientes where Cedula=$cedula");
           $reg = mysql_fetch_object($query);
	   $positivamentePaga = $reg->PositivamentePaga;
	   $viejoseguro = $reg->Seguro;

           if($seguro==59 && $viejoseguro==25)
	      $seguro = 25;

           if(empty($positivamentePaga))
	       $positivamentePaga = $paga;

           $query=mysql_query("delete from Pacientes where Cedula=$cedula");

           $query=mysql_query("insert into Pacientes values($cedula,$seguro,'$nombre','$sexo','$tel','$dom','$paga',$atraso,'S', $zona, '$fing', '$positivamentePaga', '$frenuncia', '$fechanac')");
           $err=mysql_error();

	      ++$cuenta;
           if(!empty($err))
              echo("\n".$err." en ".$qq."\n"); 
           $begin=$cedula;
         }
    }

   mysql_query("update Pacientes set Paga='N' where Seguro=36 or Seguro=37");
   mysql_close($link);
?>
