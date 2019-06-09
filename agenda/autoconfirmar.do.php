<head>
<script>
   function hacerSubmit() {
   	
   	boton=document.getElementById('boton');
   	boton.click();
   }
</script>
</head>
<body>

<table border=0 width='99%'>
<tr>
	<td width='128px'><img src='../img/logo.png' width=64></td>
	<td align='center'><font size='5'>Confirmacion de asistencia</font><br><font size='6' color='#ff0000'</font></td>
	<td width='160px' valign='middle' align='right'>
	<!-- Start JavaScript Clock Code --><div id="js_clock"><script language="javascript">function js_clock(){var clock_time = new Date();var clock_hours = clock_time.getHours();var clock_minutes = clock_time.getMinutes();var clock_seconds = clock_time.getSeconds();var clock_suffix = "AM";if (clock_hours > 11){clock_suffix = "PM";clock_hours = clock_hours - 12;}if (clock_hours == 0){clock_hours = 12;}if (clock_hours < 10){clock_hours = "0" + clock_hours;}if (clock_minutes < 10){clock_minutes = "0" + clock_minutes;}if (clock_seconds < 10){clock_seconds = "0" + clock_seconds;}var clock_div = document.getElementById('js_clock');clock_div.innerHTML = "<font size=5>"+clock_hours + ":" + clock_minutes + ":" + clock_seconds + " " +"</font>"+ clock_suffix;setTimeout("js_clock()", 1000);}js_clock();</script></div><!-- End JavaScript Clock Code -->
	</td>
</tr>
</table>
<?php

include("../functions/db.php");

function yaSeConfirmo($fecha, $horaCita, $nommed, $consultorio, $ok) {

     echo "<center><table border=0 width=99%>";
     echo "<tr>";
     echo "       <td colspan=2>";
     echo "       <font size='6'>Usted <font color='#ff0000'>$esta</font> para hoy a las </font>";
     echo "       <font size='6' color='#ff0000'>$horaCita</font>";
     echo "   </td>";
     echo "</tr>";
     echo "<tr>";
     echo "   <td>";
     echo "       <font size='6'>Con el Dr/a </font>";
     echo "   </td>";
     echo "   <td>";
     echo "       <font size='6'><b>$nommed</b></font>";
     echo "   </td>";
     echo "</tr>";
     echo "<tr>";
     echo "   <td>";
     echo "       <font size='6'>En el consultorio </font>";
     echo "   </td>";
     echo "   <td>";
     echo "       <font size='8' color='#ff0000'>$consultorio</font>";
     echo "   </td>";
     echo "</tr>";
     echo "</table>";

      echo "<br><center>";
      echo "<table border=0 bgcolor='#1111FF'>";
      echo "<tr><td><font size=7 color='#ffff00'>Usted ser&aacute; llamado por su nombre, sirvase esperar</font></td></tr>";
      echo "</table></center>";
}


function dadoDeBaja($cedula, $nombre) {

      echo "<br><center>";
      echo "<table border=0 bgcolor='#FF0000'>";
      echo "<tr><td><font size=7 color='#ffff00'>$cedula - $nombre</font></td></tr>";
      echo "<tr><td><font size=7 color='#ffff00'>Segun nuestros registros usted ha sido dado de baja, no puede confirmarse</font></td></tr>";
     echo "</table></center>";

}

function noEstaAnotado() {

      echo "<br><center>";
      echo "<table border=0 bgcolor='#1111FF'>";
      echo "<tr><td><font size=7 color='#ffff00'>Usted no esta anotado o digito mal su cedula</font></td></tr>";
      echo "</table></center>";

}

function mostrarAnotacion($fecha, $horaCita, $nommed, $suplente, $consultorio, $ok) {


   if($ok)
     $esta = "<b>esta confirmado</b>";
     else
         $esta = "<b>estaba anotado</b>";
         
   echo "<center><table border=0 width=99%>";
   echo "<tr>";
   echo "	<td colspan=2>";
   echo "       <font size='6'>Usted <font color='#ff0000'>$esta</font> para hoy a las </font>";
   echo "       <font size='6' color='#ff0000'>$horaCita</font>";
   echo "   </td>";
   echo "</tr>";
   echo "<tr>";
   echo "   <td>";
   echo "       <font size='6'>Con el Dr/a </font>";
   echo "   </td>";
   echo "   <td>";
   echo "       <font size='6'><b>$nommed</b></font>";
   echo "   </td>"; 
   echo "</tr>";
   echo "<tr>";
   echo "   <td>";
   echo "       <font size='6'>En el consultorio </font>";
   echo "   </td>";
   echo "   <td>";
   echo "       <font size='8' color='#ff0000'>$consultorio</font>";
   echo "   </td>"; 
   if(!empty($suplente)) {
          echo "   <td>";
          echo "       <font size='6'>Suplente: <b>$suplente</b></font>";
          echo "   </td>";
   }

   echo "</tr>";
   echo "</table>";
   
   if($ok)
      {
      	   echo "<br><center>";
      	   echo "<table border=0 bgcolor='#1111FF'>";
      	   echo "<tr><td><font size=7 color='#ffff00'>Usted ser&aacute; llamado por su nombre, sirvase esperar</font></td></tr>";
      	   echo "</table></center>";
      } 
}

function fueraDeHora($horaActual, $horaLimite) {
	
      	   echo "<br><center>";
      	   echo "<table border=0 bgcolor='#FF1111'>";
      	   echo "<tr><td><font size=6 color='#ffff00'>Lo sentimos pero no es posible confirmarlo</b></font></td></tr>";
      	   echo "<tr><td><font size=6 color='#ffffff'>Usted ha llegado <b>fuera de hora</b></font></td></tr>";
      	   echo "<tr><td><font size=6 color='#ffffff'>La hora limite era <b>$horaLimite</b></font></td></tr>";
      	   echo "<tr><td><font size=6 color='#ffffff'>La hora actual es  <b>$horaActual</b></font></td></tr>";
      	   echo "</table>";
      	   echo "</center><br>"; 
}

function confirmo($paciente, $consultorio, $turno, $fecha) 
{
           $rows = 1;
           $query=query("update Horarios set Vino='S' where Paciente=$paciente and Fecha='$fecha'");
	   //and Consultorio='$consultorio' and Turno=$turno");
           $rows=@mysql_num_rows($query);
           if($rows < 1)
              {
                echo "<h2>ATENCION REVISAR QUE ESTE CONFIRMADA Y AVISAR EN CASO CONTRARIO</h2>"; 
              }
           $error=mysql_error();
           if(!empty($error))
            {
              die("<br>No se pudo confirmar paciente, error : <b>$error</b><br>");
            }

	   if($rows > 1)
               echo "<br>Usted ha sido confirmado para todas las consultas de hoy ($rows)<br>";

         if($suspendido=="N")
          {
           $query=mysql_query("delete from Faltas where paciente=$paciente");
           $error=mysql_error();
          }  

      $hoy =  date("Y-m-d");
      $ahora= date("H:i:s");
      $query = mysql_query("insert into timing values('$hoy', '$ahora', $ci, '00:00:00')");

}


  conectar();
  
 
 $query = "select Nombre, Habilitado from Pacientes where Cedula=$ci";
 $q = query($query);
 echo mysql_error();
 $reg = fetch($q);

 $habilitado = $reg->Habilitado;
 $nombre     = $reg->Nombre;

if($habilitado=='N')
    dadoDeBaja($ci, $nombre);
 else {

 $fechaHoy = Date("Y-m-d");
 $query = "select Horarios.Fecha,Horarios.Hora,Horarios.Medico,Medicos.Nombre,Horarios.Consultorio,Horarios.Turno,Horarios.Numero, Horarios.HoraCita, Horarios.Procedimiento,Procedimientos.Nombre as NombreP,Procedimientos.TipoOrden,Procedimientos.Ordenes,Procedimientos.ImporteTaller, Ordenes.escripcion as descord, Ordenes.valor, Medicos.especialidad, Vino
	from 
                     Horarios,Medicos,Procedimientos,Ordenes
	where 
                     Horarios.Paciente = $ci and 
                     Horarios.Fecha = '$fechaHoy' and 
                     Horarios.Medico = Medicos.Numero and 
		    	     Procedimientos.TipoOrden = Ordenes.id and 
                     Horarios.Procedimiento = Procedimientos.Codigo
	order by
                     Horarios.Fecha,Horarios.Consultorio,Horarios.Turno,Horarios.Hora limit 1";

  $q = query($query);
  
  $rowi=fetch($q);
 
      $vino=$rowi->Vino;
      $hora=$rowi->Hora;
      $horaCita=$rowi->HoraCita;
      $fecha=$rowi->Fecha;
      $medico=$rowi->Medico;
      $nommed=$rowi->Nombre;
      $consultorio=$rowi->Consultorio;
      $turno=$rowi->Turno;
      $proc=$rowi->Procedimiento;
      $nproc=$rowi->NombreP;
      $ordenes=$rowi->Ordenes;
      $taller=$rowi->ImporteTaller;
      $numero=$rowi->Numero;
	 $tipoOrden=$rowi->TipoOrden;
	 $escripcion=$rowi->descord;
	 $importeord=$rowi->valor;
	 $especialidad=$rowi->especialidad;

	$horaactual=date("H:i").":00";
	$hhlim=strtok($horaCita,":");
	$mmlim=strtok(":");
	$mmlim=$mmlim + 30;
	if($mmlim >= 60)
	 {
	   $hhlim=$hhlim + 1;
	   $mmlim= $mmlim - 60;
	 } 


   if($vino=='N') {
	$horalimite=sprintf("%02d:%02d:00",$hhlim,$mmlim);
	if($horaactual > $horalimite) {
	
	    fueraDeHora($horaactual, $horalimite);
	    $ok = false;
	}	else
	            $ok = true;
	
	// *** Consulta de suplentes

       $q = "select Suplente, Nombre from Suplentes, Medicos where Fecha='$fecha', Consultorio='$consultorio', Turno=$Turno and Suplente = Numero";

       $querySuplente = mysql_query($q);
       $regSuplente = mysql_fetch_object($querySuplente);

       $sup = $regSuplente->NombreSuplente;

	mostrarAnotacion($fecha, $horaCita, $nommed, $sup, $consultorio, $ok);
	if($ok)
    	    confirmo($ci, $consultorio, $turno, $fecha);
   }
     else
        if($vino=='S') {

         yaSeConfirmo($fecha, $horaCita, $nommed, $consultorio, $ok); 
	} 
	  else {
	           noEstaAnotado();
	  }

}
    desconectar();


   echo "<br>";
   echo "<form action='autoconfirmar.php' method='post'>";
   echo "<center><font size='6'>Pulse la tecla <b>Enter</b> por favor</font></center>";
   echo "<input type='submit' value='Pulse Enter' id='boton'>";
   echo "</form>";
   
   echo "<script>";
   echo "   boton=document.getElementById('boton');";
   echo "	boton.focus();";
   echo "	setInterval('hacerSubmit()',15000);";
   echo "</script>";
?>
