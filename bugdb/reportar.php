<?php

   require_once("DB.php");
   require_once("class/bug.phpm");
   require_once("conf/bugdb.php");

   if(empty($paso))
      $paso=1;

   if($paso==3)
     {
	$dsn = "$db://$dbusr:$dbclave@$dbservidor/$dbname";
	$conn = DB::connect($dsn);
	$conn->setFetchMode(DB_FETCHMODE_OBJECT);

	  
          $bug = new Bug();
	  
	  $bug->setConn($conn);
	  
	  $hoy = Date("Y-m-d");
	  $ahora=Date("H:i:s");
	  $bug->setFecha($hoy);
	  $bug->setHora($ahora);
	  $bug->setUsuario($usuario);
	  $bug->setResumen($resumen);
	  $bug->setDescripcion($descripcion);
	  $bug->setArreglado("");
	  
	  $bug->almacenar();
     }
   $contenido = "reporte.".$paso.".phtml";
   include("templates/$contenido");
?>
