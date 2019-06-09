<?php
 if(empty($coiusuario) || $coiusuario=="0")
   {
     die("<center><br>Debe estar identificado para poder anotar<br><a href=\"logon.php\">Pulse aqui para identificarse</a>\n<center>");
   }
 include("../class/usuario.php");


   $xfecha1=$aa1.$mm1.$dd1;
   $xfecha2=$aa2.$mm2.$dd2;

   $dia=0;
   $generar=false;

  $link=mysql_connect("elias","apolonia","virgen") or
                         die("Error, no se puede abrir la base de datos".mysql_error());
  $db=mysql_select_db("apolonia");
 $usr = new usuario($coiusuario,$coiclave);

 if($usr->nivel < 9)
    {
      die("<center><br>No tiene autorizaci� para ejecutar este comando<br><a href=\"index1.php\">Pulse aqui para volver</a>\n<center>");

    }

  $q="select * from Molde where Doctor >= $med1 and Doctor <= $med2 and Consultorio >= '$cons1' and Consultorio <= '$cons2'";
  $query=mysql_query($q);
  echo "select * from Molde where Doctor >= $med1 and Doctor <= $med2 and Consultorio >= '$cons1' and Consultorio <= '$cons2'".
 ".:".mysql_error();

  while($rowi=mysql_fetch_object($query))
    { 
       echo ".";
       $dia_desde = $rowi->DiaDesde;
       $dia_hasta = $rowi->DiaDesde;
       $doctor    = $rowi->Doctor;
       $turno     = $rowi->Turno;
       $consultorio=$rowi->Consultorio;
       $lugares    =$rowi->Lugares;
       $hora       =$rowi->Hora;
       $HoraFin    =$rowi->HoraFin;

       $medico=$doctor;
       if($turno>=$turno1      && $turno<=$turno2      &&
          $consultorio>=$cons1 && $consultorio<=$cons2 &&
          $medico>=$med1       && $medico<=$med2)
         {
             $qcale=mysql_query("select * from Calendario where DiaDeLaSemana >= $dia_desde and DiaDeLaSemana <= $dia_hasta and Fecha >= '$xfecha1' and Fecha <= '$xfecha2'");

             while($rowcale=mysql_fetch_object($qcale))
                 {
                     $feriado=$rowcale->Feriado;
                     $fecha  =$rowcale->Fecha;
                     $dia    =$rowcale->DiaDeLaSemana; 
                     $ojimetro=mysql_query("select count(*) as cuenta from Horarios where Fecha='$fecha' and Turno=$turno and Consultorio='$consultorio' and Medico=$doctor");
                     if(empty($ojimetro))
                        $cuentita=0;
                     else 
                       {
                            $xoji=mysql_fetch_object($ojimetro);
                            $cuentita=$xoji->cuenta;
                       }                          
		     echo "<br>Cuenta es $cuentita lugares es $lugares<br>";
                     if($feriado=="N" && $cuentita < $lugares)
                       {
                         echo "Generando : <b>$fecha ($dia_desde) $doctor</b> select * from Horarios where Fecha='$fecha' and Consultorio='$consultorio' and Turno=$turno and Medico=$doctor<br>\n";
                         $qryhorarios=mysql("select * from Horarios where Fecha='$fecha' and Consultorio='$consultorio' and Turno=$turno and Medico=$doctor");
                         if(!empty($qryhorarios))
                               $nuevo=false; 
                         else
                               $nuevo=true;

//                       $segmento=round(($HoraFin * 60) / $lugares);
                         $segmento=round(($HoraFin) / $lugares);
                         $hh = strtok($hora,":");
                         $mm = strtok(":");
                         $mm = $mm + $cuentita * $segmento;
                         for($i=$cuentita;$i<$lugares;$i++)
                            {
                              if($nuevo)
                               { 
                                 echo "Fecha es $fecha Consultorio=$consultorio Turno=$turno Hora=$hora, HoraFin es $HoraFin lugares=$lugares<br>";
                                 if($mm >= 60)
                                   {
                                       $cociente = round($mm / 60);
                                       $resto    = $mm % 60;
                                       $hh = $hh + $cociente;
                                       $mm = $resto;
                                   } 
                                 $xhora=$hh.":".$mm.":"."00";
                                 $act="insert into Horarios values('$fecha','$consultorio',$turno,'$xhora',$doctor,0,'N','S',0,'N','',0,0)";
                                 echo "$act<br>";
                                 if(!empty($act))
                                   {
                                      $result=mysql_query($act);
                                      $error=mysql_error();
                                      if(!empty($error))
                                        echo "<b>Error en horarios lugar $i :</b> $error<br>Clave:$fecha,$consultorio,$turno,$xhora segmento=$segmento HoraFin=$HoraFin<br>";
                                      $mm = $mm + $segmento;
                                   }
                               }
                            }
                       }
                 }
         }
    }
echo "<hr>Fin";
?>
