<?php

function date_diff($date2, $date1)
  {
      $s = strtotime($date2) - strtotime($date1);
      $d = intval($s/86400);
      return($d);
  }
if(empty($cmd))
  $cmd=bajar;

require("../functions/db.php");
$link=conectar();

 
    $hoy = Date("Y-m-d");
     if(empty($FECHADESDE))
          $FECHADESDE='2006-11-26';
     if(empty($FECHAHASTA))
        $FECHAHASTA = '2006-12-25';

if($FECHADESDE < '2006-11-26')
   $FECHADESDE = '2006-11-26';

$hoy = Date("Y-m-d");
    
$query = "select Fecha,Serie,Numero,Trabajo,Paciente,Pieza, Trabajos.descripcion, Pacientes.Nombre from FactLab, Pacientes, Trabajos where Fecha >='$FECHADESDE' and Fecha <='$FECHAHASTA' and Pacientes.Cedula = Paciente and Trabajos.id = Trabajo order by Pacientes.Nombre";

$q = query($query);
echo mysql_error();
$total = 0;

while($reg = fetch($q))
 {
    $fecha = $reg->Fecha;
    $serie = $reg->Serie;
    $numero= $reg->Numero;
    $trab  = $reg->Trabajo;
    $pac   = $reg->Paciente;
    $pieza = $reg->Pieza;
    $nomb  = $reg->Nombre;
    $ntrab = $reg->descripcion;
   
    $query = "select Episodio from HistTrabSoc where Paciente=$pac and Trabajo=$trab and Fecha >='$fecha' and Pieza = $pieza and Episodio = 8";

    $qq  = query($query);
    $regq= fetch($qq);

    $episodio = $regq->Episodio;

    $listar = false;

    $cq = query("select * from Horarios where Paciente = $pac and Fecha >='$fecha' and Fecha <='$hoy' and Vino='S'");
    $rcq = fetch($cq);
    $cita = $rcq->Fecha;

    if(empty($episodio) && !empty($cita))
       $listar = true;

    if($listar) {

            $comentario = "Sr/a Medico tratante, hemos detectado que en esta historia clinica figuran trabajos pendientes de laboratorio\nAgradecemos marque como colocado o como etapa terminada aquellos que corresponda.\nAtentamente, por directorio de CADI, Guyunusa Carlevaro";
          $ex = "insert into Episodios values($pac,'$hoy',999,2,'00:00:00','$comentario',49)";
          query($ex);
//	  die($ex."\n");
    }   
 }
?>
