<?
   $link=mysql_connect("127.0.0.1","root","virgen") or die("Error, la base de datos no acepto la coneccion");

   mysql_select_db("apolonia"); 

   $Fecha_ant="";
   $Turno_ant=0;
   $Consultorio_ant="";
   $query="select * from Horarios where Fecha >= '2002-12-01' order by  Fecha,Consultorio,Turno,Hora";
   $q=mysql_query($query) or die("Error ".mysql_error());
   while($rowi=mysql_fetch_object($q))
    {        
        $Fecha=$rowi->Fecha;
        $Turno=$rowi->Turno;
        $Consultorio=$rowi->Consultorio;
        $Hora=$rowi->Hora;
        $medico=$rowi->Medico;           

        if($Fecha!=$Fecha_ant              ||
           $Turno!=$Turno_ant              ||
           $Consultorio!=$Consultorio_ant)
           {
              $lugar=0;
              $qnum="select count(*) numero from Horarios where 
                     Fecha = '$Fecha' and Horarios.Activa='S' and Horarios.Turno=$Turno and Horarios.Consultorio='$Consultorio'";
              $onum=mysql_query($qnum) or die("error : $qnum ".mysql_error());
              $rnum=mysql_fetch_object($onum);
              $numeros=$rnum->numero;
              $franja1 = ($numeros / 2);
              $Fecha_ant=$Fecha;
              $Turno_ant=$Turno;
              $Consultorio_ant=$Consultorio;
           }        

        $lugar=$lugar + 1;
        if($inicio==0)
               $inicio=$Hora;
        if($lugar==$franja1)
               $inicio=$Hora;

        if($Turno==1)
            {
               if($lugar<=$franja1)
                   $inicio="09:00:00";
               else
                   $inicio="10:30:00";

              if($medico==38)
                   $inicio="08:00:00";
              if($medico==8 && $lugar<=$franja1)
                  $inicio="09:15:00";
              else
                 if($medico==8 && $lugar > $franja1)
                    $inicio="10:45:00";

              if($medico==30)
                   $inicio="08:30:00";
            }

          if($Turno==2)
            {
               if($lugar<=$franja1)
                   $inicio="13:00:00";
               else
                   $inicio="14:30:00";
               if($medico==30)
                   $inicio="12:00:00";
              if($medico==8 && $lugar<=$franja1)
                  $inicio="13:00:00";
              else
                 if($medico==8 && $lugar > $franja1)
                    $inicio="14:00:00";

            }

          if($Turno==3)
            {
               if($lugar<=$franja1)
                   $inicio="16:30:00";
               else
                   $inicio="18:00:00";
            }

          if($Turno==4)
            {
               if($lugar<=$franja1 && $medico==9)
                   $inicio="19:00:00";
               else
                   if($lugar!=$franja1 && $medico==9)
                      $inicio="20:30:00";
                   else
                      if($lugar<=$franja1 && $medico!=9)
                          $inicio="19:30:00";
                      else
                         if($lugar!=$franja1 && $medico!=9)
                            $inicio="21:00:00";

            }

       mysql_query("update Horarios set HoraCita='$inicio' where Fecha='$Fecha' and Consultorio='$Consultorio' and Turno=$Turno and Hora='$Hora'");
       $err=mysql_error();
       if(!empty($err))
         die($err);
    }
   mysql_close($link);
?>
