<?php

    session_start();

    $coisucursal_ses=$_SESSION['coisucursal_ses'];


 function obtengo_turno($hora) {
 
    $turno = 0;

    if($hora >='07:00:00' && $hora <'13:00:00')
       $turno = 11;
    else
       if($hora >='13:00:00' and $hora <'16:30:00')
          $turno = 31;
       else
          if($hora >='16:30:00' && $hora <'19:30:00')
             $turno = 41;
          else
             if($hora >='19:30:00')
               $turno = 51;
     
     return($turno);
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
     $resto   = date("m") % 2;

     if($resto == 1)
        $modelo = 1;
     else
        $modelo = 2;
     if(strlen($hhAhora) < 2)
        $hhAhora = "0".$hhAhora;

      $hoy   = Date("Y-m-d");
      $diahoy = Date("N");
      $ahora = "$hhAhora:$mmAhora:00";
     
      $turno = obtengo_turno($ahora);
      $turnoLimite = $turno + 9;

      $query = "select * from Medicos where Especialidad != 9 and Especialidad != 2 and Especialidad != 10 and Activo='S'";
      $requery = mysql_query($query);

      $query = "select medico from TablaUrgencias where sucursal = '$coisucursal' order by tiempo";
      $qry = mysql_query($query);

      $encontre = false;
      while(!$encontre && $rreg = mysql_fetch_object($requery)) {

              $medicoPool = $rreg->Numero;
              $reg = mysql_fetch_object($qry);
	      $medico = $reg->medico;
	      if(empty($medico))
	           $medico=$medicoPool;

              if($medico == $medicoPool) {
	          // Veo si esta atendiendo 

	           $qquery = "select Medico, Consultorio, count(*) as cuenta from Horarios where Fecha='$hoy' and Medico=$medico and Turno>=$turno and Turno < $turnoLimite group by Medico";

                   $qqry = mysql_query($qquery);

		   $qreg = mysql_fetch_object($qqry);
		   $med = $qreg->Medico;
		   $maxCons = $qreg->Consultorio;
		   $max = $qreg->cuenta;
		   if(!empty($med))
		     $encontre = true; 
	      }
      }

    }
      if(empty($medico))
          $medico = 0;

      if(empty($coiFuncionario))
         $coiFuncionario=0;

      $max = 99 + $max + 1;
      $query="insert into Horarios values('$hoy', '$maxCons',$turno,'$ahora', $med, $Cedula, 'N','S',693,'S','$ahora',$usr->funcionario, $max)";
      mysql_query($query);

     $timestamp = time();
     // echo $query;
      $query = "insert into TablaUrgencias values($medico,'$coisucursal','$hoy', $timestamp)";
      mysql_query($query);
      $query = "update TablaUrgencias set ultima='$hoy', tiempo=$timestamp where medico=$medico and sucursal='$coisucursal'";
      mysql_query($query);
      
      die($query);
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
