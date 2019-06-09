<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2//EN">
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

<body bgcolor="#cccccc">
<center>
<Font size=8>Consulta de citas por fecha</font><hr>
<form action="listafech.php" method="post">
<?
 $link=mysql_connect("elias","root","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");

 if(empty($comando))
  {
    $hoy=date("Ymd");
    echo "<b>Paso 1</b>, Ingrese las fechas  <br>";
   echo "<input type=\"hidden\" name=\"comando\" value=\"Paso2\">\n";
  }

if($comando=="Paso2")
  {
    echo "<input type=\"hidden\" name=\"fecha1\" value=\"$fecha1\" length=8 maxlength=8>";
    echo "<input type=\"hidden\" name=\"fecha2\" value=\"$fecha2\" length=8 maxlength=8>";


    echo "<hr>\n";
  
    $Xci=$ci;
    $codproc=strtok($proc,") ");
    if(empty($fecha1))
      $fecha1=date("Ymd");

   if(empty($fecha2))
      $fecha2=date("Ymd");

  echo $alfabetico;
  switch ($alfabetico)
   {
    case "alfa" :
           $orden="Pacientes.Nombre, Horarios.Fecha,Horarios.Turno,Horarios.Hora,Horarios.Medico";
           break;
    case "medi" :
           $orden="Horarios.Medico, Horarios.Fecha, Horarios.Turno, Horarios.Hora";
           break;
    case "fech" :
           $orden="Horarios.Fecha, Horarios.Turno, Horarios.Hora, $Horarios.Medico";
           break;
   } 

 if($medico==0)
  {
      $med1 = 0;
      $med2 = 999999;
  }
    else
      {
           $med1 = $medico;
           $med2 = $medico;
      }

    $query=mysql_query("select Horarios.Fecha,Horarios.Paciente, Pacientes.Nombre as npac, Pacientes.Telefono as Telefono,  Horarios.Turno, Horarios.Consultorio, Horarios.Hora, Horarios.Medico,Medicos.Nombre,Medicos.Numero as codmed, Horarios.HoraCita,Procedimientos.Nombre as Proc, Horarios.Numero, Horarios.Vino  
                                   from Horarios,Medicos,Procedimientos,Pacientes where Fecha >= '$fecha1'        and Fecha <= '$fecha2' and 
Horarios.Medico >= $med1 and Horarios.Medico <= $med2 and 
                                        Horarios.Paciente=Pacientes.Cedula and Horarios.Activa='S' and 
                                        Procedimientos.Codigo = Horarios.Procedimiento and
                                        Horarios.Medico=Medicos.Numero   
                                        order by $orden") or
                       die("Error en horarios : ".mysql_error());

    echo "<table border=1 width=80%>\n";
    echo "<tr align=center bgcolor=\"#FFFFFF\">";
    echo "   <td>Cedula</td>\n";
    echo "   <td>Nombre</td>\n";
    echo "   <td>Telefono</td>\n";
    echo "   <td>Hora</td>\n";
    echo "   <td>Numero</td>\n";
    echo "   <td>Consultorio</td>\n";
    echo "   <td>Turno</td>\n";
    echo "   <td>Medico</td>\n";
    echo "   <td>Procedimiento</td>\n";
    echo "   <td>Fecha</td>\n";
    echo "   <td>Vino</td>\n";
    echo "</tr>\n";
    $color="#ACCCCC";
    while($rowi=mysql_fetch_object($query))
      {
          $Cedula=$rowi->Paciente;
          $npac=$rowi->npac;
          $Telefono=$rowi->Telefono;
          $Turno=$rowi->Turno;
          $Numero=$rowi->Numero;
          $Consultorio=$rowi->Consultorio;
          $Hora=$rowi->HoraCita;
          $Medico=$rowi->Nombre;
          $codmed=$rowi->codmed;
          $Vino=$rowi->Vino;
          $NombProc=$rowi->Proc;
          $Fecha=$rowi->Fecha;

          if($Cedula !=0 || !empty($listarTodos))
           {
          	echo "<tr bgcolor=$color>\n"; 
          	echo "   <td>$Cedula</td>\n";
          	echo "<td><b>$npac</b></td>";
          	echo "   <td>$Telefono</td>\n";
          	echo "   <td><b>$Hora</b></td>\n";
          	echo "   <td align=center>$Numero</td>\n";
          	echo "   <td align=center>$Consultorio</td>\n";
          	echo "   <td align=center>$Turno</td>\n";
          	echo "   <td>$Medico</td>\n";
          	echo "   <td>$NombProc</td>\n";
                echo "   <td>$Fecha</td>\n";
          	echo "   <td>$Vino</td>\n";
          	if($color=="#ACCCCC")
              		$color="#BAAAAA";
          	else
             		$color="#ACCCCC";
            }
          echo "</tr>\n";
       }
    echo "</table>\n";
  }

echo "Fecha desde: <input type=\"text\" name=\"fecha1\" value=\"$fecha1\" size=10><br>";
echo "Fecha hasta: <input type=\"text\" name=\"fecha2\" value=\"$fecha2\" size=10><br><br>";
echo "Listar todos <input type=\"checkbox\" name=\"listarTodos\"><br>";
echo "Orden      : <select name=\"alfabetico\">\n";
echo "<option value=\"alfa\">Alfabetico</a>\n";
echo "<option value=\"fech\">Fecha</a>\n";
echo "<option value=\"medi\">Medico</a>\n";
echo "</select><br>\n";

echo "Medico : ";
echo "<select name=\"medico\">\n";
echo "<option value=\"0\">Todos</a>\n";
$qry=mysql_query("select * from Medicos order by Nombre");
while($rowi=mysql_fetch_object($qry))
{
   $cod = $rowi->Numero;
   $nom = $rowi->Nombre;
   echo "<option value=\"$cod\">$nom</a>\n"; 
}

echo "</select><br>\n";

mysql_close();
?>
   <br>
   <input type="submit" name="comando" value="Paso2">
   <hr>
<?php
 if($volver=="2")
   echo "<font size=+2><a href=\"index2.php\">Menu principal</a></font>";
 else
 if($volver=="3")
   echo "<font size=+2><a href=\"/historias/index1.php\">Menu principal</a></font>";
 else
   echo "<font size=+2><a href=\"index1.php\">Menu principal</a></font>";

?>

</form>
</body>
</html>
