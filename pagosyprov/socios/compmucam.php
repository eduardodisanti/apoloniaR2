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

   $fp=fopen("ftp://eduardo:VIRGEN@130.100.1.10/sistemas/cobranza/maestrod.txt","r");
   if(empty($fp))
      die("Error ftp");

   echo "<table border=1>";
   echo "<tr><th>Seguro</th><th>Cedula</th><th>Nombre</th><th>Marcado</th><th>Mucam</th><th>Seguro</th></tr>";
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
	   $frenuncia=strtok("|");

	   if(empty($frenuncia))
	      $frenuncia="0000-00-00";

           if(empty($atraso)) $atraso=0;
           if(empty($zona) || $zona < "0")
	       $zona=0;
           $end=$cedula;

	   $nombre = limpiar($nombre);
           $dom    = limpiar($dom);
           $tel    = limpiar($tel);

           $query = mysql_query("select * from Pacientes where Cedula=$cedula");
           $reg = mysql_fetch_object($query);
	   $positivamentePaga = $reg->PositivamentePaga;

           if(empty($positivamentePaga))
	       $positivamentePaga = $paga;

           $segq = "select * from Seguros where Numero=$seguro";
	   $segqry = mysql_query($segq);
           $segreg = mysql_fetch_object($segqry);

	   $segPaga = $segreg->Paga;

if(empty($segPaga))
   die($seguro."-".$segPaga);

	  if(empty($positivamentePaga))
	                 $positivamentePaga = $segPaga;
          if(empty($paga))
	     $paga = 'S';

           if($positivamentePaga != $segPaga && $paga != $segPaga)
	     { 
	        echo "<tr><td>$seguro<td>$cedula</td><td>$nombre</td><td>$positivamentePaga</td><td>$paga<td>$segPaga</td></td></tr>";
	        ++$cuenta;
	     }
           $begin=$cedula;
         }
    }

   echo "</table>";

   mysql_close($link);
?>
