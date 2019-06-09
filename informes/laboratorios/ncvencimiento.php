<?php

require("../../functions/db.php");

function date_diff($date2, $date1)
  {
      $s = strtotime($date2) - strtotime($date1);
      $d = intval($s/86400);
      return($d);
  }

echo "<center><h4>No conformidades POR VENCIMIENTO de $lab entre $f1 y $f2</h4></center><hr>";
 
  $link=conectar();

  echo "<table border='0' bgcolor='#000000'>";
  echo "<tr bgcolor='#fcfcfc'><th>Paciente</th><th>Trabajo</th><th>Pedido</th><th>Vencimiento</th></tr>";
  $ncvencimiento = 0;
  $ncretrabajos  = 0;
  $query = "select Paciente, Trabajo, Fecha, Episodio, HistTrabSoc.Laboratorio, Trabajos.descripcion as desctra from HistTrabSoc, Trabajos where Fecha >='$f1' and Fecha <='$f2' and HistTrabSoc.Laboratorio=$lab and Episodio = 3 and Trabajos.id = HistTrabSoc.Trabajo order by Paciente, Fecha";

  $q1 = query($query);
  while($q1reg = fetch($q1)) // ** para todos los trabajos
    {
      $pac  = $q1reg->Paciente;
      $trab = $q1reg->Trabajo;
      $fecha= $q1reg->Fecha;
      $epi  = $q1reg->Episodio;
      $lab  = $q1reg->Laboratorio;
      $ntra = $q1reg->desctra;

      $tiempo = 15;
      $vence = date("Y-m-d", strtotime("+$tiempo day ".$fecha));

    if($vence < $f2)
    {

      $query = "select * from HistTrabSoc where Paciente=$pac and Trabajo=$trab and Fecha >= '$fecha' and Fecha <= '$vence' and Episodio=5 and Laboratorio=$lab";

      $q2 = query($query);
      $q2reg = fetch($q2);
      $npac = $q2reg->Paciente;
      if(empty($npac))
        {
	   $q3 = query("select * from Pacientes where Cedula=$pac");
	   $q3reg = fetch($q3);
	   $npac = $q3reg->Nombre;
	   echo "<tr bgcolor='#ffffff'><td>$pac <b>$npac</b></td><td>$trab) $ntra</td><td>$fecha</td><td>$vence</td></tr>";
           $ncvencimiento++;
	}
     }
    }
     echo "</table>";
?>

