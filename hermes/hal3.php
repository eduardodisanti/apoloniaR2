<?php

function responder($firma, $respeustas) {
  if($respuestas>0)
      $nuevos="S";
  else
      $nuevos="N";

  echo "$firma|$nuevos|$respuestas\n";
}

   include('../script/sets.php');
   include('../script/db.php');   
   $link=abrir_db();

   if(empty($cliente))
      $cliente = 111;

   $q = "select incidente, referencia, quien, incidentes.firma as lafirma from tickets, incidentes where incidentes.cliente=$cliente and incidentes.id = tickets.incidente and (validado='N' or resuelto='N') group by incidente order by tickets.fecha, tickets.hora desc";
   $query=query($q);

   $error=mysql_error();
   if(!empty($error))
      echo "$q<br>".$error;
   else
      {
         $incidente_ant=0;
         $respuestas=0;
         while($reg = fetch_object($query))
           {
	       $firma     = $reg->lafirma;
               $incidente = $reg->incidente;
	       if($firma != $firma_ant) {

	             responder($firma_ant, $respuestas);
		     $respuestas = 0;
	       }

               if($incidente_ant!=$incidente)
                  {
                        $incidente_ant = $incidente;
                        $quien     = $reg->quien;
                        if($quien == "T")
                          $respuestas++;
                  }
               $asunto    = $reg->referencia;
           }
      }

  responder($firma, $respuestas);
  cerrar_db();

?>
