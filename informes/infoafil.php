<?php
     $link=mysql_connect("elias","apolonia","virgen");
     $db = mysql_select_db("apolonia");

     $fecha1 = "1998-12-01";
     $fecha2 = date("Y-m-d");

    for($a=1997;$a < 2020;$a++)
       {
          $altas[$a] =0;
	  $reafil[$a]=0;
       }

    $cuenta = 0;
     $qpacientes = mysql_query("select Cedula, FechaIng from Pacientes where Habilitado='S' and FechaIng >= '$fecha1'");

     while($reg = mysql_fetch_object($qpacientes))
       {
          $fing  = $reg->FechaIng;
          $cedula= $reg->Cedula;
	  $anio = strtok($fing,"-");

          if(($cuenta % 1000) == 0)
	    {
	     $seg1 = Date("s");
	     echo $cuenta." : $seg1 segs\n";
	    }

	     ++$cuenta;

 // ******** verifico si estaba de baja y se afilio *******

	  $qbaja = mysql_query("select Fecha from HistoriaBajas where Paciente=$cedula and Fecha <='$fecha1' limit 1");
	  $breg = mysql_fetch_object($qbaja);
	  $Fecha = $breg->Fecha;

          if(empty($Fecha))
	    $bajas = 0;
	  else 
	     $bajas = 1;

          $qbaja = mysql_query("select Fecha from HistoriaBajas where Paciente=$cedula and Fecha >= '$fecha1' order by Fecha limit 1");

          $breg=mysql_fetch_object($qbaja);
          if(!empty($breg->Fecha))
	     $anio= strtok($breg->Fecha, "-");

          if($bajas==0) // Nunca estuvo de baja 
	    {
	       $altas[$anio]++;
	    } else
	         {
		   $reafil[$anio]++; 
		 }
       }

     mysql_close();

 arsort($altas);
 reset($altas);
 arsort($reafil);
 reset($reafil);

    echo "\nSocios nuevos\n";
     foreach($altas as $anio => $cant) {
        if($cant > 0)
          print "$anio: => $cant.\n";
	}

	    echo "\nReafiliaciones\n";
	     foreach($reafil as $anio => $cant) {
	       if($cant > 0)
	           print "$anio: => $cant.\n";
	        }
?>
<hr>
<button onclick="javascript:history.back()">Volver</button>


