<?php

   $query="select * from Horarios where Fecha >='2009-05-01'";

$link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");

   mysql_select_db("apolonia");

   $cant=0;
   $q = mysql_query($query);
   while($reg=mysql_fetch_object($q))
      {
          $fecha = $reg->Fecha;
          $cons  = $reg->Consultorio;
	  $turno= $reg->Turno;

          $qcal = mysql_query("select DiaDeLaSemana from Calendario where Fecha='$fecha'");
	  $regcal = mysql_fetch_object($qcal);
          $dia = $regcal->DiaDeLaSemana;

          $qmol = mysql_query("select Hora from Molde where DiaDesde = $dia and Turno = $turno and Consultorio = '$cons'");
         
	  $regmol = mysql_fetch_object($qmol);
          $hora = $regmol->Hora;

	  mysql_query("update Horarios set HoraCita='$hora' where Fecha='$fecha' and Consultorio='$cons' and Turno=$turno");
     }
   
   mysql_close();
?>
