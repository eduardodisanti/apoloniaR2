<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="CONTENT-TYPE" content="text/html; charset=iso-8859-1">
  <title>Confirmar</title>

  <meta name="GENERATOR" content="Quanta+">

<style type="text/css">
     A:link  {color:#9A3D3F}
     A:visited {color:#9A3D3F}
     A:hover {color: #C44487}

     BODY{font-family: 'Lucida Sans',serif}
</style>
<script language="JavaScript">
   function chequearPago()
    {
/*       if(document.conf.pago.checked)
         {
	    return(true);
	 } else 
	         {
		     alert('No es posible confirmar la hora si el paciente no ha abonado sus ordenes\nSi el paciente efectivamente ha abonado marque el casillero correspondiente');
		     return(false);
		 }
		  */

       return(true);
    }
</script>
</head>

<body bgcolor="#a4b6d4">
<center>
<Font size=5>Confirmar un paciente</font><hr>
<?
 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");
 include("usuario.php");

 $usr = new usuario($coiusuario,$coiclave);

 if($usr->nivel < 3)
    {
      die("<center><br>No tiene autorización para ejecutar este comando<br><a href=\"javascript:window.back()\">Pulse aqui para volver</a>\n<center>");
    }

 if(empty($comando))
  {
    echo "<form action='confirmar.php'>\n";
    echo "<b>Paso 1</b>, identificar al socio ";
    echo "Cedula : <input type=\"TEXT\" name=\"ci\" value=\"\" length=8 maxlength=9>";
   echo "<br><br>\n";
   echo "<input type=\"submit\" name=\"comando\" value=\"Paso2\">\n";
   echo "</form>";
  }

if($comando=="Paso2")
  {
    $trancar="NO";
   $ced=$ci;
   $query=mysql_query("select * from Pacientes where Cedula=$ced") or 
     die("(mirarpaciente.php) Error en bd, falla debido a ".mysql_error()." La cedula es : $ced");
   $error=mysql_error();
   $rowi=mysql_fetch_object($query);

   if(empty($rowi))
     {
       echo "<font color=\"#fbffff\"><b>El paciente no existe #$error</b></font>";
       if($volver!="2")
           die("Pulse <a href=\"/agenda/index.php\">aqui</a> para volver");
       else
           die("Pulse <a href=\"/agenda/index.php\">aqui</a> para volver");
     }
   $seguro=$rowi->Seguro;
   $paga=$rowi->Paga;
   $telefono=$rowi->Telefono;
   $domicilio=$rowi->Domicilio;
   $habilit=$rowi->Habilitado;
   $Paga=$rowi->Paga;

  $qseguros=mysql_query("select Nombre,Paga from Seguros where Numero=$seguro");
  $seguros=mysql_fetch_object($qseguros);
  if(empty($seguros))
      $Paga='S';
  else
    {
      $Paga=$seguros->Paga; 
 //     if($paga!=$Paga)      // ** esto lo hago para saber si renuncio al serv.
 //        $Paga=$paga;
    }
   if($habilit=='N')
     {
       echo "<font color=\"#A9E4FF\"><b>El paciente fue dado de baja</b></font>";
       die("Pulse <a href=\"/agenda/index.php\">aqui</a> para volver");
     }
      echo "   <table border=0>";
      echo "   <tr>";
      echo "       <td><font color=\"#fbffff\">Cedula $ced</font></td>";
      echo "       <td><font color=\"#fbffff\"><b>$rowi->Nombre</b></font></td>";
      echo "       <td><font color=\"#fbffff\">Seguro: $rowi->Seguro</font></td>";
      echo "   </tr>";
      echo "   <tr>";
      echo "       <td>Telefono : <b>$telefono</b></td><td>Domicilio : <b>$domicilio</b></td>";

   if($Paga=="S")
      echo "       <td bgcolor=\"#aa0a0a\"><font size=+0 color=\"#FFFFFF\"><b>debe
 abonar</b> </font></td>";
      echo "   </tr>";
      echo "</table>";

   $xpac="$ced,<b>$rowi->Nombre</b> Seguro(<i><b>$rowi->Seguro</b></i>)";

   $trancar="NO";

    $suspendido="N";
    $query=mysql_query("select * from Faltas where Paciente=$ci");
    if(!empty($query))
       {
            $FechaHoy=date('Y-m-d');
            $rowi=mysql_fetch_object($query);
            if($rowi->SuspendidoHasta > '0000-00-00' and $rowi->EnFecha < $FechaHoy and $FechaHoy <= $rowi->SuspendidoHasta)
               {
                $suspendido="S";
               }
             else
                $suspendido="N";
       }
    echo "<hr>\n";
   
    $fechaHoy=date("Y-m-d"); 
    //include("../ctacte/ctacte.php");
    echo "<br><b>Paso 2</b>, Anotaciones del socio $ci para el <b>$fechaHoy</b> ".date("D"); 

 $query=mysql_query("select Horarios.Fecha,Horarios.Hora,Horarios.Medico,Medicos.Nombre,Horarios.Consultorio,Horarios.Turno,Horarios.Numero, Horarios.HoraCita, Horarios.Procedimiento,Procedimientos.Nombre as NombreP,Procedimientos.TipoOrden,Procedimientos.Ordenes,Procedimientos.ImporteTaller, Ordenes.escripcion as descord, Ordenes.valor 
	from 
                     Horarios,Medicos,Procedimientos,Ordenes
	where 
                     Horarios.Paciente = $ci and 
                     Horarios.Vino='N' and 
                     Horarios.Fecha = '$fechaHoy' and 
                     Horarios.Medico = Medicos.Numero and 
		     Procedimientos.TipoOrden = Ordenes.id and 
                     Horarios.Procedimiento = Procedimientos.Codigo
	order by
                     Horarios.Fecha,Horarios.Consultorio,Horarios.Turno,Horarios.Hora") or
             die("Error en Horarios : ".mysql_error());

    echo "<table border=1 width=90% bgcolor=\"#bccccc\">";
    echo "<tr bgcolor=\"aaaaaa\" align=middle><td>Hora</td><td>Medico</td><td>Nombre del Medico</td><td>Consultorio</td><td>Turno</td><td>Procedimiento</td><td>Numero</td></tr>";
    while($rowi=mysql_fetch_object($query))
      {
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
	 
        echo "<tr>\n";
	$horaactual=date("H:i").":00";
	$hhlim=strtok($horaCita,":");
	$mmlim=strtok(":");
	$mmlim=$mmlim + 30;
	if($mmlim >= 60)
	 {
	   $hhlim=$hhlim + 1;
	   $mmlim= $mmlim - 60;
	 } 
	$horalimite=sprintf("%02d:%02d:00",$hhlim,$mmlim);
	echo "<hr>Hora limite: $horalimite / Hora actual : $horaactual<hr>";
         
	$nombreDiaHoy=date("D");
/*	if($horaactual > $horalimite && $nombreDiaHoy!="Sat")
	   echo "   <td><font size=+1>$horaCita <b>FUERA DE HORA</b></font>";
	else */
	echo "   <td><b><font color='#B03530'>$hora</font></b></td>";
	echo "   <td>$medico</td><td>$nommed</td><td>$consultorio</td><td>$turno</td><td>$nproc</td><td>$numero</td>\n";
	echo "</tr>";
	echo "<tr bgcolor='#EBEBEB'>";
	echo "<form action='confirmar.php' name='conf' onsubmit='return chequearPago()'>\n";
	echo "  <td colspan=4>Debe entregar \n";
	echo "	<b>$ordenes</b>\n";
	echo "  ordenes de <b>$importeord</b> ($escripcion) ";
	echo " y <b> $taller </b>ordenes de taller</td>\n";
	echo " <td colspan=2>";
	//echo "   <input type='checkbox' name='pago' value='$estanlasordenes'>";
	echo "   Ordenes entregadas";
	echo "  <input type='text' name='cantord' value='$ordenes' size=2>\n";
	echo "   Ordenes de taller";
	echo "  <input type='text' name='taller'  value='$taller' size=3>\n";
	echo " </td>";
	echo "  <input type='hidden' name='ci'          value='$ci'>\n";
	echo "  <input type='hidden' name='xpac'        value='$xpac'>\n";
	echo "  <input type='hidden' name='comando'     value='Paso3'>\n";
	echo "  <input type='hidden' name='hora'        value='$hora'>\n";
	echo "  <input type='hidden' name='fecha'       value='$fecha'>\n";
	echo "  <input type='hidden' name='consultorio' value='$consultorio'>\n";
	echo "  <input type='hidden' name='turno'       value='$turno'>\n";
	echo "  <input type='hidden' name='tipord'      value='$tipoOrden'>\n";
	echo "  <input type='hidden' name='proc'        value='$proc'>\n";
        if($horaactual > $horalimite && $nombreDiaHoy!="Sat")
	    echo "   <td><font size=+1>$horaCita <b>FUERA DE HORA</b></font>";
        else
	{
	  echo "<td>";
	  echo "   <input type='submit' name='cmdconfirmar' value='Confirmar'>";
	  echo "</td>";
	}
	echo "</form>\n";
	echo "</tr>\n";
      }

    echo "</table><hr>\n";
    echo "<input type=\"hidden\" name=\"ci\" value=\"$ci\">\n";
    echo "<input type=\"hidden\" name=\"xpac\" value=\"$xpac\">\n";
  }

if($comando=="Paso3")
  {
           $rows = 1;
           $query=mysql_query("update Horarios set Vino='S' where Paciente=$ci and Fecha='$fecha' and Consultorio='$consultorio' and Turno=$turno");
           $rows=@mysql_num_rows($query);
           if($rows < 1)
              {
                echo "<h2>ATENCION REVISAR QUE ESTE CONFIRMADA Y AVISAR EN CASO CONTRARIO</h2>"; 
                echo "update Horarios set Vino='S' where Paciente=$ci and Fecha='$fecha' and Consultorio='$consultorio' and Turno=$turno";
              }
           $error=mysql_error();
           if(!empty($error))
            {
              die("<br>No se pudo confirmar paciente, error : <b>$error</b><br>");
            }
           echo "<br>Confirmado correctamente ($rows)<br>";

         if($suspendido=="N")
          {
           $query=mysql_query("delete from Faltas where paciente=$ci");
           $error=mysql_error();
           if(!empty($error))
              {
                  die("<br>No se pudo eliminar de la tabla de faltas : <b>$error</b><br>");
              }
           echo "Actualizada tabla de faltas";
          } 
	  
	  // ** grabo en cuenta corriente
	  
	  echo "<br>Importe de ordenes $cantord - $taller - $tipord<br>";
	  $pieza = 0;
	  if($cantord > 0)
	    {
	  	$q = mysql_query("insert into CuentaCorriente values($ci,'$fecha','$hora', $pieza, $proc,'H', $cantord,'$tipord','S ')");
	    }
	  if($taller > 0)
	    {
	  	$q = mysql_query("insert into CuentaCorriente values($ci,'$fecha','$hora', 999, $proc,'H', $cantord,'H','S ')");
	    }
	  
	  // ** actualizo el repositorio de ordenes, si no existe lo creo
	  $fechaAAMM = substr($fecha,0,7);
	  $query = mysql_query("select * from tablord where paciente=$ci and fecha='$fechaAAMM' and TipoOrden='$tipord'");
	  if(mysql_num_rows($query) < 1)
	     $query = mysql_query("insert into tablord values($ci,'$fechaAAMM','$tipord', 0,0)");
	  // ** actualizo el repositorio de ordenes de laboratorio, si no existe lo creo
	  $query = mysql_query("select * from tablord where paciente=$ci and TipoOrden='H' and fecha='$fechaAAMM'");
	  if(mysql_num_rows($query) < 1)
	     $query = mysql_query("insert into tablord values($ci,'$fechaAAMM','H', 0,0)");

	  $query = mysql_query("update tablord set debe=debe+$cantord where paciente=$ci and TipoOrden='$tipord' and fecha='$fechaAAMM'");
	  
	  $query = mysql_query("update tablord set debe=debe+$taller where paciente=$ci and TipoOrden='H' and fecha='$fechaAAMM'");

          $query = mysql_query("update Deudas set ordenes = ordenes - $cantord, taller=taller - $taller where Paciente=$ci and Procedimiento=$proc and Pieza=$pieza"); 
  }

mysql_close();
?>
<hr>
</form>
</body>
</html>

