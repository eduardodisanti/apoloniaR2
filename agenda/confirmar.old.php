<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

  <meta http-equiv="CONTENT-TYPE" content="text/html; charset=iso-8859-1">
  <title></title>

  <meta name="GENERATOR" content="StarOffice/5.2 (Win32)">

<style type="text/css">
     A:link  {color:#9A3D3F}
     A:visited {color:#9A3D3F}
     A:hover {color: #C44487}

     BODY{font-family: 'Lucida Sans',serif}
</style>
<script language="JavaScript1.2">

// Script Source: CodeLifter.com
// Copyright 2003
// Do not remove this header

isIE=document.all;
isNN=!document.all&&document.getElementById;
isN4=document.layers;
isHot=false;

function ddInit(e){
  topDog=isIE ? "BODY" : "HTML";
  whichDog=isIE ? document.all.theLayer : document.getElementById("theLayer");
  hotDog=isIE ? event.srcElement : e.target;
  while (hotDog.id!="titleBar"&&hotDog.tagName!=topDog){
    hotDog=isIE ? hotDog.parentElement : hotDog.parentNode;
  }
  if (hotDog.id=="titleBar"){
    offsetx=isIE ? event.clientX : e.clientX;
    offsety=isIE ? event.clientY : e.clientY;
    nowX=parseInt(whichDog.style.left);
    nowY=parseInt(whichDog.style.top);
    ddEnabled=true;
    document.onmousemove=dd;
  }
}

function dd(e){
  if (!ddEnabled) return;
  whichDog.style.left=isIE ? nowX+event.clientX-offsetx : nowX+e.clientX-offsetx;
  whichDog.style.top=isIE ? nowY+event.clientY-offsety : nowY+e.clientY-offsety;
  return false;
}

function ddN4(whatDog){
  if (!isN4) return;
  N4=eval(whatDog);
  N4.captureEvents(Event.MOUSEDOWN|Event.MOUSEUP);
  N4.onmousedown=function(e){
    N4.captureEvents(Event.MOUSEMOVE);
    N4x=e.x;
    N4y=e.y;
  }
  N4.onmousemove=function(e){
    if (isHot){
      N4.moveBy(e.x-N4x,e.y-N4y);
      return false;
    }
  }
  N4.onmouseup=function(){
    N4.releaseEvents(Event.MOUSEMOVE);
  }
}

function hideMe(){
  if (isIE||isNN) whichDog.style.visibility="hidden";
  else if (isN4) document.theLayer.visibility="hide";
}

function showMe(){
  if (isIE||isNN) whichDog.style.visibility="visible";
  else if (isN4) document.theLayer.visibility="show";
}

document.onmousedown=ddInit;
document.onmouseup=Function("ddEnabled=false");

</script>

</head>

<body bgcolor="#a4b6d4">
<center>
<Font size=5>Confirmar un paciente</font><hr>
<form action="confirmar.php" method="post">
<?
 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");
 include("usuario.php");

 $usr = new usuario($coiusuario,$coiclave);

 if($usr->nivel < 3)
    {
      die("<center><br>No tiene autorización para ejecutar este comando<br><a href=\"index.php\">Pulse aqui para volver</a>\n<center>");

    }

 if(empty($comando))
  {
    echo "<b>Paso 1</b>, identificar al socio ";
    echo "Cedula : <input type=\"TEXT\" name=\"ci\" value=\"\" length=8 maxlength=9>";
   echo "<br><br>\n";
   echo "<input type=\"hidden\" name=\"comando\" value=\"Paso2\">\n";
  }

if($comando=="Paso2")
  {
    $trancar="NO";
//    include("mirarpaciente.php");
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
       echo "<font color=\"#fbffff\"><b>El paciente fue dado de baja</b></font>";
       if($volver!="2")
           die("Pulse <a href=\"/agenda/index.php\">aqui</a> para volver");
       else
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
    include("../ctacte/ctacte.php");
    echo "<br><b>Paso 2</b>, Anotaciones del socio $ci para el <b>$fechaHoy</b> ".date("D"); 

 $query=mysql_query("select Horarios.Fecha,Horarios.Hora,Horarios.Medico,Medicos.Nombre,Horarios.Consultorio,Horarios.Turno,Horarios.Numero, Horarios.HoraCita, Horarios.Procedimiento,Procedimientos.Nombre as NombreP,Procedimientos.Ordenes,Procedimientos.ImporteTaller from 
                     Horarios,Medicos,Procedimientos where 
                     Horarios.Paciente = $ci and 
                     Horarios.Vino='N' and 
                     Horarios.Fecha = '$fechaHoy' and 
                     Horarios.Medico = Medicos.Numero and 
                     Horarios.Procedimiento = Procedimientos.Codigo order by
                     Horarios.Fecha,Horarios.Consultorio,Horarios.Turno,Horarios.Hora") or
             die("Error en Horarios : ".mysql_error());

    echo "<table border=1 width=90% bgcolor=\"#bccccc\">";
    echo "<tr bgcolor=\"aaaaaa\" align=middle><td>Hora</td><td>Medico</td><td>Nombre del Medico</td><td>Consultorio</td><td>Turno</td><td>Procedimiento</td><td>Numero</td><td>Ordenes</td><td>Taller</td></tr>";
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
         //$horalimite="zzzzzz";
         $nombreDiaHoy=date("D");
         if($horaactual > $horalimite && $nombreDiaHoy!="Sat")
              echo "   <td><font size=+1>$horaCita <b>FUERA DE HORA</b></font>";
         else 
              echo "   <td><a href=\"confirmar.php?ci=$ci&xpac=$xpac&comando=Paso3&hora=$hora&fecha=$fecha&consultorio=$consultorio&turno=$turno\"><font size=+1>$hora</font></a></td>";
         echo "   <td>$medico</td><td>$nommed</td><td>$consultorio</td><td>$turno</td><td>$nproc</td><td>$numero</td><td align=right>$ordenes</td><td align=right>$taller</td>\n";
         echo "</tr>\n"; 
      }

    echo "</table><hr>\n";
    echo "<input type=\"hidden\" name=\"ci\" value=\"$ci\">\n";
    echo "<input type=\"hidden\" name=\"xpac\" value=\"$xpac\">\n";
  }

if($comando=="Paso3")
  {
           $query=mysql_query("update Horarios set Vino='S' where Paciente=$ci and Fecha='$fecha' and Consultorio='$consultorio' and Turno=$turno");
           $rows=mysql_num_rows($query);
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
           echo "Confirmado correctamente ($rows)<br>";

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
  }

mysql_close();
?>
   <input type="submit" name="boton" value="Siguiente">
<hr>
</form>
</body>
</html>
