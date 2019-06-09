<?php

   $query="select Cedula, FechaIng from Pacientes where Habilitado='N'";

$link=mysql_connect("127.0.0.1","root","virgen") or die("Error, la base de datos no acepto la coneccion");

   mysql_select_db("apolonia");

   $cant=0;
   $q = mysql_query($query);
   while($reg=mysql_fetch_object($q))
      {
          $cedula=$reg->Cedula;
	  $fing  =$reg->FechaIng;

	  $query = "select Fecha from HistoriaBajas where Paciente=$cedula and Fecha >= '$fecha1' order by Fecha limit 1";
	  $qs = mysql_query($query);
	  $xreg = mysql_fetch_object($qs);

	  $fecha = $xreg->Fecha;
	  if($fecha > "0000-00-00" && !empty($fecha))
	    {
	       ++$cant;
               $updat=mysql_query("update Pacientes set FechaIng='$fecha' where Cedula=$cedula"); 
	    }
      }

   mysql_close();
?>
