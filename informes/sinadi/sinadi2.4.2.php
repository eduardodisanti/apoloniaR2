<?php
function date_diff($date2, $date1)
  {
      $s = strtotime($date2) - strtotime($date1);
      $d = intval($s/86400);
      return($d);
  }

   $hoy = Date("Y-m-d");
   $FECHADESDE='2009-02-01';
   $FECHAHASTA='2009-02-31';

    require("../../functions/db.php");
     if(empty($FECHADESDE))
          $FECHADESDE=$hoy;
     if(empty($FECHAHASTA))
        $FECHAHASTA = $hoy;
     $link=conectar();

   $q = "select FechaIng, fechaNacimiento, count(*) as Cuenta, Sexo from Horarios, Pacientes where Fecha >= '$FECHADESDE' and Fecha <='$FECHAHASTA' and Vino='S' and Paciente = Cedula and Procedimiento = 693 group by FechaIng";

   $query = query($q);

   while($reg=fetch($query)) {

      $f = $reg->FechaIng;
      $c = $reg->Cuenta;
      $s = $reg->Sexo;

      $edad = round(date_diff($hoy, $f)/365);

      if($edad > 100) $edad = 50;

      if($edad < 1) $edad = 0;
      if($edad >=1  && $edad <= 4)  $edad = 1;
      if($edad >=5  && $edad <= 14) $edad = 2;
      if($edad >=15 && $edad <= 19) $edad = 3;
      if($edad >=20 && $edad <= 44) $edad = 4;
      if($edad >=45 && $edad <= 64) $edad = 5;
      if($edad >=65 && $edad <= 74) $edad = 6;
      if($edad > 74) $edad = 7;

      if($s=='M')
         $hombres[$edad]+=$c;
      else
         $mujeres[$edad]+=$c;
   }

   echo "**** HOMBRES ****\n";
   for($i=0;$i<120;$i++)
     {
      if($hombres[$i]!=0 && !empty($hombres[$i]))
         echo $i.";".$hombres[$i]."\n";
     }

  echo "**** MUJERES ****\n";
   for($i=0;$i<120;$i++)
     {
       if($mujeres[$i]!=0 && !empty($mujeres[$i]))
       echo $i.";".$mujeres[$i]."\n";
     }

?>
