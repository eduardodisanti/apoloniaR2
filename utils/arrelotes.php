<?php

    include("../functions/db.php");

     $db = conectar();

     $dudosos = 0;
     $fd = fopen("vencimientos.csv","r");
     while($reg = fgets($fd)) {

     $nombre = strtok($reg, "|");
     $vence  = strtok("|");
     $lote   = strtok("|");
     $cant   = strtok("|");
     $suc    = strtok("|");

     $query = "select id, nombre from articulos where nombre like '%$nombre%'";
     $q = query($query);

     $renglones = 0;
     while($reg=fetch($q)) {

           $id = $reg->id;
	   $desc  = $reg->nombre;

           ++$renglones;
     }
       if($renglones >= 1) {
         if($lote=="-")
	   $lote=$vence;

         //echo $desc."\n";
         $qin = "insert into lotes values('$lote', '$vence', $id, $cant)";
         query($qin);
         $err = mysql_error();

         if(!empty($err)) {
             echo "Error : ".$qin."-".$err."\n";
         }
       } 
         if($rengolnes==0)
	    $nombre."\n";
       //echo "$qin\n";

       if($renglones > 1) {
         echo $desc."\n";
	 $dudosos++;
       }
  }
  desconectar();

  echo "\n DUDOSOS : $dudosos\n";
?>
