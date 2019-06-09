<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

  <meta http-equiv="CONTENT-TYPE" content="text/html; charset=iso-8859-1">
  <title>Borrar Cita</title>

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

<body bgcolor="#5265B1">
<center>
<Font size=8></font><hr>
<form action="borrar.php" method="post">
<?
 if(empty($coiusuario) || $coiusuario=="0")
   {
     die("<center><br>Debe estar identificado para poder anotar<br><a href=\"logon.php\">Pulse aqui para identificarse</a>\n<center>");
   }
 include("usuario.php");

 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");
 $usr = new usuario($coiusuario,$coiclave);

 if($usr->nivel < 2)
    {
      die("<center><br>No tiene autorización para ejecutar este comando<br><a href=\"index.php\">Pulse aqui para volver</a>\n<center>");

    }

 if(empty($comando))
  {
    echo "<center><h1>Borrar pacientes</h1></center>\n";
    echo "<b>Paso 1</b>, identificar al socio ";
    echo "Cedula : <input type=\"TEXT\" name=\"ci\" value=\"\" length=8 maxlength=9>";
   echo "<br><br>\n";
   echo "<input type=\"hidden\" name=\"comando\" value=\"Paso2\">\n";
  }

if($comando=="Paso2")
  {
    $ignorarBaja='S';
    include("mirarpaciente.php");
    echo "<hr>\n";
  
    $Xci=$ci;
    $codproc=strtok($proc,") ");
    $hoy=date("Ymd");
    
    $query=mysql_query("select Horarios.Fecha, Horarios.Turno, Horarios.Consultorio, Horarios.Hora, Horarios.Medico,Medicos.Nombre,Medicos.Numero as codmed, Horarios.Vino,Horarios.Procedimiento,Horarios.Numero, HoraCita
                                   from Horarios,Medicos where Fecha >= '$hoy'        and
                                        Horarios.Paciente=$ci and Horarios.Activa='S' and 
                                        Horarios.Medico=Medicos.Numero 
                                        order by Horarios.Fecha,Horarios.Turno,Horarios.Hora,Horarios.Medico") or           
                       die("Error en horarios : ".mysql_error());

    echo "<table border=1 width=50%>\n";
    echo "<tr align=center bgcolor=\"#FFFFFF\">";
    echo "   <td>Fecha</td>\n";
    echo "   <td>Hora</td>\n";
    echo "   <td>Numero</td>\n";
    echo "   <td>Consultorio</td>\n";
    echo "   <td>Turno</td>\n";
    echo "   <td>Medico</td>\n";
    echo "   <td>Vino</td>\n";
    echo "</tr>\n";
    $color="#ACCCCC";
    while($rowi=mysql_fetch_object($query))
      {
          $Fecha=$rowi->Fecha;
          $Turno=$rowi->Turno;
          $Consultorio=$rowi->Consultorio;
          $Hora=$rowi->Hora;
	  $HoraCita=$rowi->HoraCita;
          $Numero=$rowi->Numero;
          $Medico=$rowi->Nombre;
          $codmed=$rowi->codmed;
          $Vino=$rowi->Vino;
          $Proc=$rowi->Procedimiento;

          echo "<tr bgcolor=$color>\n";
          echo "<td><font size=+1><b>\n";
          if($Vino=='N')
               echo "   <a href=\"borrar.php?comando=borrar&Fecha=$Fecha&Turno=$Turno&Consultorio=$Consultorio&Hora=$Hora&ci=$ci&codmed=$codmed&lugar=$Numero\">$Fecha</a>";
          else
               echo "   $Fecha\n";

          echo "   </b></font></td>";
          echo "   <td><b>$HoraCita</b></td>\n";
          echo "   <td><b>$Numero</b></td>\n";
          echo "   <td align=center>$Consultorio</td>\n";
          echo "   <td align=center>$Turno</td>\n";
          echo "   <td><b>$Medico</b></td>\n";
          echo "   <td><b>$Vino</b></td>\n";
          if($color=="#ACCCCC")
              $color="#BAAAAA";
          else
             $color="#ACCCCC";
          echo "</tr>\n";
       }
    echo "</table>\n";
  }

if($comando=="borrar")
  {
    $hoy=date("Y-m-d");
    $query="update Horarios set Paciente=0, Vino='N' where Fecha='$Fecha' and Turno=$Turno and Consultorio='$Consultorio' and Paciente='$ci' and Hora='$Hora' and Medico=$codmed";
   
    if($lugar > 200 & $lugar < 300)
      {
         $query="delete from Horarios where Fecha='$Fecha' and Turno=$Turno and Consultorio='$Consultorio' and Paciente='$ci' and Hora='$Hora' and Medico=$codmed";
      } 
    mysql_query($query) or die("Error, no se pudo borrar la cita".mysql_error());
    $query="delete from Faltas where Paciente=$ci"; 
    mysql_query($query) or die("Error, no se pudo borrar la falta");
    echo "Borrado correctamente<br>";
    echo "Actualizada tabla de faltas<br>"; 
    $limit="update CuentaProc set Cantidad=Cantidad - 1 where fecha='$Fecha' and Turno=$Turno and Consultorio='$Consultorio' and Procedimiento='$Proc'";
    mysql_query($limit) or die("No se pudo actualizar la cuenta de procedimientos");
    echo "Actualizada la cuenta de procedimientos<br>";
    $borrados="insert into Borrados values($ci,'$Fecha','$Consultorio', $Turno,'$hoy',$coifuncionario)";
    mysql_query($borrados);
    $err=mysql_error();
    if(!empty($err))
       printf("No se pudo grabar en la historia de borrados  en $borrados<br>");
    
    echo "Actualizada la historia de borrados<br>";
  }

mysql_close();
?>
   <br>
   <input type="submit" name="Otro paciente">
   <hr>
</form>
</body>
</html>
