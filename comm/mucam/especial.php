<?php

    include("../../functions/db.php");

     $db = conectar();


     $hoy = date("Y-m-d");

     $query = "select * from Especialidades";
     $q = query($query);

     while($reg=fetch($q)) {

         $codigo = $reg->Codigo;
	 $nombre    = $reg->Nombre;

         $s = "insert into Especialidades values($codigo, '$nombre');";
	 echo $s."\n";
     }

     desconectar();
?>
