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
<script src="/agenda/popupanotar.js">
</script>

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

<?php
      echo "<body bgcolor=\"#a4b6d4\">";
?>
<!-- BEGIN FLOATING LAYER CODE //-->
<div id="theLayer" style="position:absolute;width:250px;left:100;top:100;visibility:visible">
<table border="0" width="250" bgcolor="#424242" cellspacing="0" cellpadding="5">
<tr>
<td width="100%">
  <table border="0" width="100%" cellspacing="0" cellpadding="0" height="36">
  <tr>
  <td id="titleBar" style="cursor:move" width="100%">
  <ilayer width="100%" onSelectStart="return false">
  <layer width="100%" onMouseover="isHot=true;if (isN4) ddN4(theLayer)" onMouseout="isHot=false">
  <font face="Arial" color="#FFFFFF">Layer Title</font>
  </layer>
  </ilayer>
  </td>
  <td style="cursor:hand" valign="top">
  <a href="#" onClick="hideMe();return false"><font color=#ffffff size=2 face=arial  style="text-decoration:none">X</font></a>
  </td>
  </tr>
  <tr>
  <td width="100%" bgcolor="#FFFFFF" style="padding:4px" colspan="2">
<!-- PLACE YOUR CONTENT HERE //-->
This is where your content goes.<br>
It can be any html code or text.<br>
Remember to feed the reindeer.<br>
Avoid chewable giblet curtains.
<!-- END OF CONTENT AREA //-->
  </td>
  </tr>
  </table>
</td>
</tr>
</table>
</div>
<!-- END FLOATING LAYER CODE //-->

<center>
<Font size=8>Anotar un paciente</font><hr>
<form action="anotar.php" method="post">
<?
 if(empty($coiusuario) || $coiusuario=="0")
   {
     die("<center><br>Debe estar identificado para poder anotar<br><a href=\"logon.php\">Pulse aqui para identificarse</a>\n<center>");
   }

 $link=mysql_connect("127.0.0.1","root","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");

 include("usuario.php");
 $usr = new usuario($coiusuario,$coiclave);

 if($usr->nivel < 3)
    {
      die("<center><br>No tiene autorizaci�n para ejecutar este comando<br><a href=\"index1.php\">Pulse aqui para volver</a>\n<center>");

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
    include("mirarpaciente.php");
    echo "<hr>\n";

    // **** mirar si se puede anotar ****
    $FechaHoy=Date("Y-m-d");

    $query=mysql_query("select Fecha,Medico,Medicos.Nombre as ElMedico from Horarios,Medicos where Paciente=$ci and Fecha > '$FechaHoy' and Medicos.Numero = Horarios.Medico");
    if(!empty($query))
      {
        
        while($rowi=mysql_fetch_object($query))
         {
               echo "Tiene una cita para el d�a <b>$rowi->Fecha</b> con $rowi->ElMedico<br>";
         }

      }  

  // ***** Mirar proxima vez **** 
    $query=mysql_query("select Procedimiento, Pieza,Nombre from ParaHacer, Procedimientos where Paciente=$ci and Procedimiento=Codigo");
    $error=mysql_error();
    if(!empty($error))
        echo "<br>Error, no se pudo verificar procedimientos posteriores<br>\n";
    else
        {
            $rowi=mysql_fetch_object($query);
            if(!empty($rowi))
              {
                $Ncodproc=$rowi->Procedimiento;
                $Nproc=$rowi->Nombre;
                echo "<br><i>Proximo procedimiento:</i> <b>$Nproc</b><br>\n";
              }
            else
                 echo "No tiene marcados procedimientos posteriores<br>\n";
        }

    $coment=mysql_query("select * from Comentarios where Paciente=$ci");
    $regcom=mysql_fetch_object($coment);
    $comentario=$regcom->Comantario;

    echo "<table border=3><tr><td align=center bgcolor=\"#FFFFFF\">Comentarios para Recepcion y Att. Telefonica</td></tr>";
    echo "<tr><td bgcolor=\"#CCCCCC\"><font color=\"#FFFFFF\" size=4><pre>(<b>$comentario</b>)</pre></font></td></tr>";
    echo "</table>";
    echo "<br><b>Paso 2</b>, Elegir un procedimiento "; 
    echo "<br><select size=20 name=\"proc\" style=\"width:400\"\n>";
    $query=mysql_query("select * from Procedimientos order by Nombre") or 
          die("Error en procedimientos : ".mysql_error());
    while($rowi=mysql_fetch_object($query))
      {
          $Nombre=$rowi->Nombre;
          $Codigo=$rowi->Codigo;
          if($Ncodproc==$Codigo)
              echo "<OPTION selected>$Codigo) $Nombre</OPTION>\n";
          else
              echo "<OPTION>$Codigo) $Nombre</OPTION>\n";
       }

    echo "</select><hr>\n";
    echo "<input type=\"hidden\" name=\"comando\" value=\"Paso3\">\n";
    echo "<input type=\"hidden\" name=\"ci\" value=\"$ci\">\n";
    echo "<input type=\"hidden\" name=\"xpac\" value=\"$xpac\">\n";
    echo "<input type=\"hidden\" name=\"boton\" value=\"$nada\">\n";
  }

if($comando=="Paso3")
  {
    $Xci=$ci;
    $codproc=strtok($proc,") ");
    $hoy=date("Ymd");
    $xhoy=date("Y-m-d");
    
    if(empty($fechadesde))
         $fechadesde=$xhoy;

    if(empty($fechahasta))
       {
           $fechahasta=$xhoy;
       }
     if($boton=="Siguiente")
       {
         $fechadesde=$fechahasta;
         $anioHOY=strtok($fechahasta,"-");
         $mesHOY=strtok("-");
         $diaHOY=strtok("-");
         $diaHOY=$diaHOY+15;
         if($diaHOY>31)
          {
            $diaHOY=1;
            $mesHOY=$mesHOY + 1; 
          }
         if($mesHOY>12)
           {
             $mesHOY=1;
             $anioHOY=$anioHOY+1;
           }
         $fechahasta=$anioHOY."-".$mesHOY."-".$diaHOY;
      }
       else 
          if($boton!="nada")
           {
             $fechahasta=$fechadesde;
             $anioHOY=strtok($fechadesde,"-");
             $mesHOY=strtok("-");
             $diaHOY=strtok("-");
             $diaHOY=$diaHOY - 15;
             if($diaHOY<1)
               {
                 $diaHOY=30;
                 $mesHOY=$mesHOY - 1;
               }
             if($mesHOY<1)
               {
                 $mesHOY=12;
                 $anioHOY=$anioHOY - 1;
               }
             $fechadesde=$anioHOY."-".$mesHOY."-".$diaHOY;
           }
    echo $xpac."<br>";
    echo "Procedimiento : <b>$proc</b><hr>\n";
    echo "<b>Paso 3</b>, Elegir la hora y el medico";
    $xproc="Procedimiento : <b>$proc</b><hr>\n";
    echo "<input type=\"hidden\" name=\"comando\" value=\"Paso3\">\n";
    echo "<input type=\"hidden\" name=\"xpac\" value=\"$xpac\">\n";
    echo "<input type=\"hidden\" name=\"codproc\" value=\"$codproc\">\n";
    echo "<input type=\"hidden\" name=\"proc\" value=\"$proc\">\n";
    echo "<input type=\"hidden\" name=\"xproc\" value=\"$xproc\">\n";
    echo "<input type=\"hidden\" name=\"fechahasta\" value=\"$fechahasta\">\n"; 
    echo "<input type=\"hidden\" name=\"fechadesde\" value=\"$fechadesde\">\n";
    echo "<input type=\"hidden\" name=\"ci\" value=\"$ci\">\n";
    echo "<input type=\"hidden\" name=\"orden\" value=\"$orden\">\n";

    if(empty($orden))
        $orden=2;
    if($orden==1)
       $order="Horarios.Fecha,Horarios.Turno,Horarios.Hora,Medicos.Nombre";
    else
      if($orden==2)
         $order="Medicos.Nombre, Horarios.Fecha,Horarios.Turno,Horarios.Hora";
      else
           $order="especialidad, Medicos.Nombre, Horarios.Fecha,Horarios.Turno,Horarios.Hora";

    $laquery="select Horarios.Fecha, Horarios.Turno, Horarios.Consultorio, Consultorios.Sucursal, Horarios.Hora, Horarios.Medico, Medicos.Nombre,Medicos.Numero as codmed, Especialidades.Nombre as Especialidad from Horarios,Medicos,Consultorios,Especialidades where Horarios.Fecha >= '$fechadesde' and Horarios.Fecha <= '$fechahasta' and Medicos.especialidad = Especialidades.Codigo and 
Horarios.Activa='S' and Horarios.Medico=Medicos.Numero and Horarios.Paciente = 0 and Horarios.Consultorio = Consultorios.Codigo group by Horarios.Fecha, Horarios.Turno, Horarios.Consultorio,Horarios.Medico order by $order";
   $query=mysql_query($laquery)
 or           die("Error en horarios : "
.mysql_error()." $query orden es $order, fechadesde es $fechadesde $fechahasta");

// echo "<div id=\"scroll\" style=\"height=350px;overflow:scroll\">";
    echo "$fechadesde y $fechahasta en $coisucursal";
    echo "<table border=1 width=95%>\n";
    echo "<tr align=center bgcolor=\"#FFFFFF\">";
    echo "   <td>";
    echo "      <a href=\"anotar.php?comando=Paso3&fechahasta=$fechahasta&fechadesde=$fechadesde&ci=$ci&orden=1&xpac=$xpac&boton=nada&proc=$proc\">Fecha</a>";
    echo "   </td>\n";
    echo "   <td>Hora</td>\n";
    echo "   <td>Consultorio</td>\n";
    echo "   <td>Turno</td>\n";
    echo "   <td>";
    echo "      <a href=\"anotar.php?comando=Paso3&fechahasta=$fechahasta&fechadesde=$fechadesde&ci=$ci&orden=2&xpac=$xpac&boton=nada&proc=$proc\">Medico</a>";
    echo "</td>\n";
    echo "   <td>";
    echo "      <a href=\"anotar.php?comando=Paso3&fechahasta=$fechahasta&fechadesde=$fechadesde&ci=$ci&orden=3&xpac=$xpac&boton=nada&proc=$proc\">Especialidad</a>";
    echo "</td>\n";

    echo "</tr>\n";

    $color="#ACCCCC";
    while($rowi=mysql_fetch_object($query))
      {
          $Fecha=$rowi->Fecha;
          $Turno=$rowi->Turno;
          $Consultorio=$rowi->Consultorio;
          $Sucursal=$rowi->Sucursal;
          $Hora=$rowi->Hora;
          $Medico=$rowi->Nombre;
          $codmed=$rowi->codmed;
          $especialidad=$rowi->Especialidad;


          $qdia=mysql_query("select Hora from Horarios where Fecha='$Fecha' and Consultorio='$Consultorio' and Turno=$Turno order by Hora asc");
          $qdiareg=mysql_fetch_object($qdia);
          $xHora=$qdiareg->Hora;
          $hh=strtok($xHora,":");
          $mm=strtok(":");
          $mm=$mm - 15;
          if($mm < 0) 
             {
                $hh=$hh - 1;
                $mm = 60 + $mm;
             }
          $xHora=sprintf("%02d:%02d",$hh,$mm);
          $qdia=mysql_query("select DiaDeLaSemana from Calendario where Fecha='$Fecha'");
          $diareg=mysql_fetch_object($qdia);
          $diadelasemana=$diareg->DiaDeLaSemana;

          $xdiasemana="mirar";
          switch ($diadelasemana)
            {
                 case 1:
                       $xdiasemana="Lun";
                      break;
                case 2: 
                      $xdiasemana="Mar";
                      break;
                case 3:
                      $xdiasemana="Mie";
                      break;
                case 4:
                     $xdiasemana="Jue";
                     break;
                case 5:
                     $xdiasemana="Vie";
                     break;
                case 6:
                     $xdiasemana="Sab";
                     break;
                case 7:
                     $xdiasemana="Dom";
                     break;
            }

          // ***** Limito el consultorio *****/

$esSucursal=0;
if(empty($coisucursal))
    $coisucursal="";
if($Sucursal!=$coisucursal && $coisucursal!="")
  {
    $esSucursal=1;
  }
        // ************************************/

if($esSucursal==0)
  { 
/*   $qspaces=mysql_query("select count(Paciente) as lugares from Horarios where Fecha='$Fecha' and Turno=$Turno and Consultorio='$Consultorio' group by Fecha,Consultorio,Turno,Medico") or die(mysql_error());

   $rowspaces=mysql_fetch_object($qspaces);
   $lugares=$rowspaces->lugares;
   if($lugares <= 33)
     { 
*/
          $qlimit=mysql_query("select cantidad from Limitaciones where procedimiento=$codproc");
          $rowlimit=mysql_fetch_object($qlimit);
          if(empty($rowlimit))
            {
               $limite=999; 
            } else
                 $limite=$rowlimit->cantidad;

         $qlimit=mysql_query("select Cantidad from CuentaProc where fecha='$Fecha' and consultorio='$Consultorio' and turno=$Turno and Procedimiento=$codproc");
         $rowlimit=mysql_fetch_object($qlimit);
         if(empty($rowlimit))
                   $cantidad=0;
         else
                    $cantidad=$rowlimit->Cantidad;

         $mostrar=true;
         $splitTurno=sprintf("%02d",$Turno);
         $turnoMirar=substr($splitTurno,1,1);
         if($limite !=999 && $turnoMirar >= 4)
               $cantidad=9999;

         $SUPLENTE="";

         $veosup=mysql_query("select Fecha,Consultorio,Turno,Suplente,Nombre from Suplentes,Medicos where Fecha = '$Fecha'and Consultorio='$Consultorio' and Turno=$Turno and Numero=Suplente");
         $regsup=mysql_fetch_object($veosup);
         if(!empty($regsup))
                $SUPLENTE=" / ".$regsup->Nombre;  
         echo "<tr bgcolor=$color>\n";
          if($cantidad >= $limite)
                echo "<td><font size=+0>$xdiasemana<b>$Fecha</b></font></td>";
          else
                echo "   <td><a href=\"mostrarconsulta.php?Fecha=$Fecha&Turno=$Turno&Consultorio=$Consultorio&Turno=$Turno&Medico=$codmed&Proc=$codproc&Cedula=$Xci&cmd=anotar&Xpac=$xpac\">$xdiasemana<font size=+0><b>$Fecha</b></font></a></td>\n";
          echo "   <td><b>$xHora</b></td>\n";
          echo "   <td align=center>$Consultorio($Sucursal)</td>\n";
          echo "   <td align=center>$Turno</td>\n";
          echo "   <td><b>$Medico <font color=\"\#333333\" size=+1>$SUPLENTE</font></b></td>\n";
          echo "<td>$especialidad</td>";
          if($color=="#ACCCCC")
              $color="#BAAAAA";
          else
             $color="#ACCCCC";
          echo "</tr>\n";
       }
     /* } */
}
    echo "</table>\n";
//    echo "</div>\n";
    echo "<input type=\"Submit\" name=\"boton\" value=\"Anterior\" >";
  }

if($comando=="Anotar")
  {
     
  }

mysql_close();
   echo "<input type=\"submit\" name=\"boton\" value=\"Siguiente\">\n";

/* if(Comando=="Paso2")
  {
   echo "<script languaje=\"Javascript\">function abrir() {";
   echo "\n";
   echo "}\n";
   echo "</script>\n";
   echo "<input type=\"submit\" name=\"boton\" value=\"Siguiente\" onclick=\"abrir()\">\n";
  }
*/
?>
   <br>
   <hr>
   <font size=+2><a href="index1.php">Menu principal</a></font>
</form>
</body>
</html>
