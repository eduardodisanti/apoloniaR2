<?php

    include("../../functions/db.php");

     $db = conectar();


     $hoy = date("Y-m-d");

     $query = "select * from Procedimientos";
     $q = query($query);

     while($reg=fetch($q)) {

         $codigo   = $reg->Codigo;
	 $nombre   = $reg->Nombre;
	 $sesiones = $reg->Sesiones;
	 $especial = $reg->Especialidad;
	 $notas    = $reg->Notas;
         $basemucam= $reg->BaseMucam;
	 $cadencia = $reg->Cadencia;

	 if($reg->Activo=='S')
            $activo   = 'T';
	 else
	    $activo   = 'F';
	 $docific  = $reg->Dosificacion;

	 if($reg->Externo=='S')
	   $externo = 'T';
	 else
	   $externo  = 'F';

         $s = "insert into Procedimientos values($codigo, '$nombre', $sesiones, $especial, '$notas', $basemucam, $cadencia, '$activo', $docific, '$externo');";
	 echo $s."\n";
     }

     desconectar();
?>
