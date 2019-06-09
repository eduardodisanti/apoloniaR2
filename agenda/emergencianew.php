<?php

    session_start();

    $coisucursal_ses=$_SESSION['coisucursal_ses'];

function devolver_consultorio_con_menos_urgencias($fecha, $desde, $hasta, $sucursal) {


// *** Primero obtengo todos los consultorios
        $q = "select Consultorio from Horarios, Medicos, Consultorios
                     where
                           Fecha='$fecha' and
                           HoraCita >='$desde' and
                           HoraCita <='$hasta' and
                           Consultorios.Codigo = Horarios.Consultorio and
                           Consultorios.Sucursal = '$sucursal' and
                           Medicos.Numero = Horarios.Medico and
                           Medicos.especialidad != 2  and
                           Medicos.especialidad != 5  and
                           Medicos.especialidad != 9 and
                           Medicos.especialidad != 10
                    group by Consultorio
             ";

      $elegido = "1";
      $menor   = 999;
      $query = mysql_query($q);

      while($reg = mysql_fetch_object($query))
        {
           $consultorio = $reg->Consultorio;
           $q1 = "select count(*) as Cantidad from Horarios 
                         where 
                             Fecha='$fecha' and
                             HoraCita >='$desde' and
                             HoraCita <='$hasta' and 
                             Consultorio='$consultorio' and 
                             Procedimiento = 693
                 ";
          $query1 = mysql_query($q1);
          $reg1 = mysql_fetch_object($query1);
          $tempCant = $reg1->Cantidad;

          if(empty($tempCant))
            $tempCant = 0;
          if($tempCant < $menor)
           {
               $elegido = $consultorio;
               $menor = $tempCant;
           }
        } 

      return($elegido);
}

 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");

 include("usuario.php");
 $usr = new usuario($coiusuario,$coiclave);

 if($usr->nivel < 3)
    {
      die("<center><br>No tiene autorizaci&oacute;n para ejecutar este comando<br><a href=\"index.php\">Pulse aqui para volver</a>\n<center>");

    }


 if($comando=="Borrar")
   {
     $act=mysql_query("delete from Emergencias where Paciente=$Cedula and Fecha='$Fecha'") or die("Error ".mysql_error()." borrando Emergencia");
   }

if($comando=="Agregar")
{

     $encontre = "NO";

     $act=mysql_query("insert into Emergencias values($Cedula,'$Fecha',$usr->funcionario)") or die("Error ".mysql_error()." grabando Emergencia");
   if($coisucursal_ses=="CENTRAL")
    {

     $hhAhora = Date("H");
     $mmAhora = Date("i");
     $hhTope  = $hhAhora;
     $mmTope  = $mmAhora;

     $mmAhora += 15;
     if($mmAhora > 59)
        {
	  $hhAhora++;
	  $mmAhora = $mmAhora - 59;
	}

     $hoy   = Date("Y-m-d");
     $ahora = "$hhAhora:$mmAhora:00";
     $tope  = "$hhTope:$mmTope:00";
     // ******** Primero busco un medico con hora libre

     echo "<br>Buscando un candidato entre(1) $tope y $ahora";

     $q = "select Fecha, Hora, Consultorio, Turno, Hora, Medico, Nombre as nmed, Horarios.Numero from Horarios, Medicos, Consultorios where
                 Fecha = '$hoy' and 
		 Hora  >= '$ahora' and Hora <= '$tope' and
		 Paciente = 0 and
		 Medicos.Numero = Horarios.Medico and
		 Consultorios.Codigo = Horarios.Consultorio and 
		 Medicos.especialidad != 2  and 
                 Medicos.especialidad != 5  and 
                 Medicos.especialidad != 9  and 
                 Medicos.especialidad != 10 and 
		 Consultorios.Sucursal = '$coisucursal_ses' limit 1
          ";

     $query = mysql_query($q);
     $reg   = mysql_fetch_object($query);
     $fecha = $reg->Fecha;
     $medico= $reg->Medico;
     $hora  = $reg->Hora;
     $cons  = $reg->Consultorio;
     $turn  = $reg->Turno;
     $nmed  = $reg->nmed;
     $numero= $reg->Numero;

     if(!empty($nmed))
       {
           echo "Candidato : $nmed en el consultorio $cons";
           mysql_query("update Horarios set Paciente=$Cedula, Procedimiento=693, Vino='S' where Fecha='$fecha' and Hora='$hora' and Consultorio='$cons' and Turno='$turn'");
	   //mysql_query("insert into Asistencia values($medico, '$fecha', $turn, $numero, $Cedula)");
	   $encontre="SI";
       }
     else		// Nadie libre entonces busco pacientes que no vinieron
       {
         echo " ---- no encontrado<br>";
         $hhAhora = Date("H");
         $mmAhora = Date("i");

         $hoy   = Date("Y-m-d");
         $ahora = "$hhAhora:$mmAhora:00";

         $mmTope = $mmAhora - 30;
	 $hhTope = $hhAhora;
	 if($mmTope < 0)
	    {
	       $mmTope = 60 + $mmTope;
	       $hhTope = $hhTope - 1;
	    }
         $tope  = "$hhTope:$mmTope:00";

	 echo "<br>Buscando un candidato(2) entre $ahora y $tope";
         $q = "select distinct Medico, Fecha, Hora, Consultorio, Turno, Hora, Nombre as nmed from Horarios, Medicos, Consultorios where
                 Fecha = '$hoy' and
	         Hora  <= '$ahora' and Hora >= '$tope' and
	         Vino = 'N' and
                 Consultorios.Codigo = Horarios.Consultorio and
                 Consultorios.Sucursal = '$coisucursal_ses' and
	         Medicos.Numero = Horarios.Medico and 
                 Medicos.especialidad != 2  and
                 Medicos.especialidad != 5  and
                 Medicos.especialidad != 9  and
                 Medicos.especialidad != 10  
		 limit 1
	      ";
         $query = mysql_query($q);
         while($reg=mysql_fetch_object($query))
           {
         	$fecha = $reg->Fecha;
         	$hora  = $reg->Hora;
         	$cons  = $reg->Consultorio;
         	$turn  = $reg->Turno;
         	$hora  = $reg->Hora;
         	$nmed  = $reg->nmed;

                if(!empty($nmed)) // Encontre a alguien, veamos si no se fue ya
		  {
		    $mefijoq = "select Hora from Horarios where 
		               Fecha       = '$fecha' and
			       Hora        = '$hora'  and
			       Consultorio = '$cons'  and
			       Turno       = '$turn'
			    order by Hora desc";
                   $mq = mysql_query($mefijoq);
		   $mreg = mysql_fetch_object($mq);
		   $horaFin = $mreg->Hora;
	           if($ahora < $horaFin)
	            {
		      echo "Candidato : $nmed en el consultorio $cons<b>";
              	      mysql_query("update Horarios set Paciente=$Cedula, Procedimiento=693, Vino='S' where Fecha='$fecha' and Hora='$hora' and Consultorio='$cons' and Turno='$turn'");
		                 //mysql_query("insert into Asistencia values($medico, '$fecha', $turn, $numero, $Cedula)");
		      $encontre="SI";
		      break;
		    }
		   } // del encontre a alguien
            } // del while
        } // Nadie libre
   if($encontre=="NO")
    {
      echo " ----- no encontrado<br>";

      $rotado = devolver_consultorio_con_menos_urgencias($hoy, $tope, $ahora, $coisucursal_ses);

      echo "Sin candidatos, asignado al consultorio $rotado<br>";
      $medico = 0; 
      $requery = "select Medico, Turno from Horarios where Fecha='$hoy' and Hora >='$ahora' and Consultorio='$rotado' limit 1";
      $q = mysql_query($requery);
      $reg = mysql_fetch_object($q);
      $medico = $reg->Medico;
      $turno  = $reg->Turno;

      if(empty($medico))
          $medico = 0;

      if(empty($coiFuncionario))
         $coiFuncionario=0;

      $query="insert into Horarios values('$hoy', '$rotado',$turno,'$ahora', $medico, $Cedula, 'N','S',693,'S','$ahora',$usr->funcionario, 0)"; 
      mysql_query($query);
      //mysql_query("insert into Asistencia values($medico, '$hoy', $turno, 0, $Cedula)");
    }
 } // del if CENTRAL
}

 $fechahoy=date("Y-m-d");

 $query=mysql_query("select Emergencias.Paciente,Fecha,Pacientes.Nombre as pac from Emergencias, Pacientes where Emergencias.Paciente = Pacientes.Cedula and Fecha >= '$fechahoy' order by Fecha,Pacientes.Nombre") or die("Error ".mysql_error());

  echo "<table border=1 width=95%>\n";
  echo "<tr bgcolor=\"#fbfbfb\" align=center>\n";
  echo "  <td>Cedula</td>\n";
  echo "  <td>Nombre</td>\n";
  echo "  <td>Fecha</td>\n";
  echo "  <td>&nbsp;&nbsp;</td>\n";
  echo "</tr>\n";

       echo "<tr>\n";
       echo "<form action=\"emergencia.php\" method=\"post\">\n";
       echo "<td><input type=\"input\" value=\"\" name=\"Cedula\" size=9 maxlength=9></td>\n";
       echo "<td>&nbsp;&nbsp;</td>\n";
       echo "<td><input type=\"input\" value=\"$fechahoy\" name=\"Fecha\" size=11 maxlength=10></td>\n";
       echo "<td>&nbsp;&nbsp;</td>\n";
       echo "<td><input type=\"submit\" name=\"comando\" value=\"Agregar\">";
       echo "</td>\n";
       echo "</tr>\n";
      echo "</form>\n";
 
  while($rowi=mysql_fetch_object($query))
   {
    echo "<form action=\"emergencia.php\" method=\"post\">\n";

     echo "<input type=\"hidden\" value=\"$rowi->Paciente\" name=\"Cedula\">\n";
     echo "<input type=\"hidden\" value=\"$rowi->Fecha\" name=\"Fecha\">\n";
     echo "<tr>\n";
       echo "<td>$rowi->Paciente</td>\n";
       echo "<td>$rowi->pac</td>\n";
       echo "<td>$rowi->Fecha</td>\n";
       echo "<td>    <input type=\"submit\" name=\"comando\" value=\"Borrar\">";
       echo "</td>\n";
     echo "</tr>\n";
    echo "</form>\n";
   } 
  echo "</table>\n";
 mysql_close();
?>
<hr>
