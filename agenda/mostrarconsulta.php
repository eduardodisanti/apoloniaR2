<?php

   session_start();
   $coisucursal_ses=$_SESSION['coisucursal_ses'];

?>
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

<body bgcolor="#5265B1">
<center>
<Font size=8>
<?php
        if($aut==1)
	     echo "Autorizar un paciente";
	else
             echo "Anotar un paciente";
?>
</font><hr>
<form action="anotar.php" method="post">
<?
 include("../functions/ortfija.php");
 include("../functions/planlab.php");
 require("conf/apolonia.inc");
 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");
if($cmd=="anotar")
  {

    $ci=$Cedula;
    include("mirarpaciente.php");
    $query=mysql_query("select * from Procedimientos where Codigo=$Proc");
    $rowi=mysql_fetch_object($query);
    echo "Procedimiento : <font size=+1>$Proc <b>$rowi->Nombre</b></font><hr>\n";
    echo "<b>Paso 4</b>, Elegir el lugar del paciente<hr>";


    $estaOF  =estaEnPlanOrto($ci);
    $estaLab =estaEnPlanLab($ci);

    $query=mysql_query("select Horarios.Fecha, Horarios.Turno, Horarios.Consultorio, Horarios.Hora, Horarios.Medico,Medicos.Nombre,Horarios.Paciente,Medicos.Especialidad as esp from Horarios,Medicos where Fecha = '$Fecha' and Horarios.Activa='S' and Horarios.Medico=Medicos.Numero and Horarios.Turno=$Turno and Horarios.Consultorio='$Consultorio' order by Horarios.Fecha,Horarios.Turno,Horarios.Hora,Horarios.Medico") or
          die("Error en horarios : ".mysql_error());

    $inicio=0;
    echo "<table border=1 width=80%>\n";
    echo "<tr align=center bgcolor=\"#FFFFFF\">";
    echo "   <td>Fecha</td>\n";
    echo "   <td>Hora aprox</td>\n";
    echo "   <td>Hora</td>\n";
    echo "   <td>Numero</td>\n";
    echo "   <td>Consultorio</td>\n";
    echo "   <td>Turno</td>\n";
    echo "   <td>Medico</td>\n";
    echo "</tr>\n";

    $color="#ACCCCC";
    $numeros=mysql_num_rows($query);
    $franja1 = ($numeros / $franjas);
    $lugar=0;
    $HoraFranja1=0;

    $primero=1;
    $cuentaAutorizaciones=0;
    $goal = 3;
    
    while($rowi=mysql_fetch_object($query))
      {
          $Fecha=$rowi->Fecha;
          $Turno=$rowi->Turno;
          $Consultorio=$rowi->Consultorio;
          $Hora=$rowi->Hora;
          $medico=$rowi->Medico;
	  $esp=$rowi->esp;
	  $autorizar = $rowi->Autorizacion;
	  /*if($autorizar == "S" && rowi->Paciente != 0)
	    $cuentaAutorizaciones++;
*/
          $HoraOriginal=$Hora;

      if($Fecha > '2004-02-06')
       {
         $hh = strtok($Hora,":");
         $mm = strtok(":");
//         $mm = $mm - 15;
         if($mm < 0)
           {
             $mm = 60 - 15;
             $hh = $hh - 1;
           }
         if($hh < 0)
            $hh = 23;
         $mm=sprintf("%02d",$mm);
         $hg=sprintf("%02d",$hh);
         $Hora        = "$hh:$mm";
         if($primero==1)
          {
            $primero=0;
            $inicio=$Hora;
          }
         $HoraFranja1 = $inicio;
         $HoraFranja2 = $HoraFranja1;
       }

          if($inicio==0)
               $inicio=$HoraFranja1;

          if($lugar<$franja1)
		   $inicio=$HoraFranja1;
          else
                   $inicio=$HoraFranja2;

          $lugar=$lugar + 1;
          $Medico=$rowi->Nombre;
          $pacanot=$rowi->Paciente;
          echo "<tr bgcolor=$color>\n";
          if(empty($volver))
               $volver=0;

          if(!$estaOF && $esp==6)
	     $Medico=98;

	  //if(!$estaLab && $esp==16)
	  //   $Medico=98;
	     
          if($pacanot==0 && $Medico != 98)
              {
                echo "   <td bgcolor=\"#FFFFFF\"><a href=\"anotarpaciente.php?Fecha=$Fecha&Turno=$Turno&Consultorio=$Consultorio&Hora=$HoraOriginal&Proc=$Proc&Cedula=$Cedula&horainicio=$inicio&Medico=$Medico&lugar=$lugar&pieza=$pieza&aut=$aut\"><font size=+1><b>$Fecha</b></font></a></td>\n";
                $fz=3;
              }
          else
              {
                echo "   <td><font size=1><i>$Fecha</i></font></a></td>\n";
                $fz=1;
              }
          if($HoraFranja1=="0")
           {
               $inicio=$Hora;
               $adv=" Error en horarios consulte!";
           }
          else
               $adv="";
          echo "   <td><font size=$fz>$inicio</font></td>\n"; /* va $Hora */
          echo "   <td><b><font size=$fz>$inicio $adv</font></b></td>\n";
          echo "   <td><b><font size=$fz>$lugar</font></b></td>\n";
          echo "   <td align=center><font size=$fz>$Consultorio</font></td>\n";
          echo "   <td align=center><font size=$fz>$Turno</font></td>\n";
          echo "   <td><b><font size=$fz>$Medico</font></b></td>\n";
          if($color=="#ACCCCC")
              $color="#BAAAAA";
          else
             $color="#ACCCCC";
          echo "</tr>\n";
          
          if($lugar > 200 and $lugar < 300)
              $cuentaAutorizaciones++;
       }


    /*
             ********** HOOK PARA LOS AUTORIZADOS ***********
    */
   if($aut==1 && $cuentaAutorizaciones<=1) {
   
          $lugar++;
   		  echo "<tr bgcolor=$color>\n";
          if(empty($volver))
               $volver=0;

          if(!$estaOF && $esp==6)
	            $Medico=98;

          if($Medico != 98)
              {
                echo "   <td bgcolor=\"#FFFFFF\"><a href=\"anotarpaciente.php?Fecha=$Fecha&Turno=$Turno&Consultorio=$Consultorio&Hora=$HoraOriginal&Proc=$Proc&Cedula=$Cedula&horainicio=$inicio&Medico=$Medico&nummed=$medico&lugar=$lugar&pieza=$pieza&aut=$aut\"><font size=+1><b>$Fecha</b></font></a></td>\n";
                $fz=3;
              }

          if($HoraFranja1=="0")
           {
               $inicio=$Hora;
               $adv=" Error en horarios consulte!";
           }
          else
               $adv="";
          echo "   <td><font size=$fz>$inicio</font></td>\n"; /* va $Hora */
          echo "   <td><b><font size=$fz>$inicio $adv</font></b></td>\n";
          echo "   <td><b><font size=$fz>$lugar AUTORIZADO</font></b></td>\n";
          echo "   <td align=center><font size=$fz>$Consultorio</font></td>\n";
          echo "   <td align=center><font size=$fz>$Turno</font></td>\n";
          echo "   <td><b><font size=$fz>$Medico</font></b></td>\n";
          if($color=="#ACCCCC")
              $color="#BAAAAA";
          else
             $color="#ACCCCC";
          echo "</tr>\n";
   }
     
    echo "</table>\n";
  }

mysql_close();
?>
   <font size=+0><a href="index.php">Menu principal</a></font>   
</form>
<hr>
</body>
</html>
