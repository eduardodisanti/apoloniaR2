<?php
   session_start();

function cartel_funcionario_0() {

  echo "<h3>ERROR</h3>";
  echo "<br>";
  echo "Se requiere que se autentique para anotar<br>";
  echo "<br>";
  echo "Este error puede producirse porque se ingreso a la historia clinica y se volvi� a agenda";
  echo "<br>";
  echo "<br><h2>DEBE INGRESAR NUEVAMENTE </h2>";
  echo "<br>Datos : ";
  echo "Usuario de la sesion     : ".$_SESSION["coiusuario"];
  echo "Funcionario de la sesion : ".$_SESSION["coifuncionario"];
  echo "Funcionario cookie       : ".$coifuncionario;

  die("<br>Estamos solucionando este problema para que desaparezca el Usuario Revision - Gracias por su paciencia");

  }

  $usuariocheck = $_SESSION['coifuncionario'];
  if(empty($usuariocheck)) {

            cartel_funcionario_0();
  }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

  <meta http-equiv="CONTENT-TYPE" content="text/html; charset=iso-8859-1">
  <title></title>

<style type="text/css">
     A:link  {color:#9A3D3F}
     A:visited {color:#9A3D3F}
     A:hover {color: #C44487}

     BODY{font-family: 'Lucida Sans',serif}
</style>
<!-- <script src="/agenda/popupanotar.js">
</script> -->

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

<script language="javascript" src="cal2.js">
</script>
<script language="javascript" src="cal_conf2.js"></script>

</script>
<?php include("menu/menu1h.html"); ?>
</head>

<?php
    echo "<body bgcolor=\"#a4b6d4\">";
    /* include("menu/menu1b.html");  
     include("menu/barra1b.html"); */
?>
<center>
<?php
     $coisucursal_ses=$_SESSION['coisucursal_ses'];

     $coiusuario = $_SESSION['coiusuario'];
     $coiclave   = $_SESSION['coiclave'];
?>

<Font size=4>
<?php 
      if($aut==1)
        echo "Autorizar un paciente en ";
      else
        echo "Anotar un paciente en ";
	echo $coisucursal_ses; 
?>
</font>
<form name="anotar" action="anotar.php" method="post">
<?php

 function cargarMedicos($filtromed) {

 echo "<select name='filtromedico'>\n";
 $q = "select * from Medicos where Activo='S' order by Nombre";
 $qry = query($q);
 echo "<option value='0'>---Todos---<option>";
 while($reg=fetch($qry)) {

    if($filtromed==$reg->Numero)
       $sel="selected"; 
    else
       $sel="";

    echo "<option value='$reg->Numero' $sel>$reg->Nombre ($filtromed)</option>\n";
 }
 echo "</select>";
 }

 function cargarEspecialidades() {

 }
 if(empty($coiusuario) || $coiusuario=="0")
   {
     die("<center><br>Debe estar identificado para poder anotar<br><a href=\"logon.php\">Pulse aqui para identificarse</a>\n<center>");
   }

 include("../functions/db.php");
 include("../functions/ortfija.php");

 include("../class/medico.phpm");

 include("../functions/anota.phpf");
 $link=conectar();

 $hoy=date("Ymd");
     $xhoy=date("Y-m-d");
 include("usuario.php");
 $usr = new usuario($coiusuario,$coiclave);

 if($usr->nivel < 3)
    {
      die("<center><br>No tiene autorizacion para ejecutar este comando<br><a href=\"index.php\">Pulse aqui para volver</a>\n<center>");

    }

 if(empty($comando))
  {
    echo "<b>Paso 1</b>, identificar al socio ";
    echo "Cedula : <input type=\"TEXT\" name=\"ci\" value=\"\" length=8 maxlength=9>";
   echo "<input type=\"hidden\" name=\"comando\" value=\"Paso2\">\n";
   echo "<input type=\"hidden\" name=\"aut\" value=\"$aut\">\n";
  }

if($comando=="Paso2")
  {
    include("mirarpaciente.php");
/*     echo "<a href=\"javascript:showMe();\">Mostrar cuenta corriente</a> ";
    echo "<a href=\"javascript:hideMe();\">Ocultar cuenta corriente</a>"; 
    echo "<hr>\n";
*/

 $suspendido="N";
 $query=mysql_query("select * from Faltas where Paciente=$ci");
  if(!empty($query))
   {
       $FechaHoy=date('Y-m-d');
       $rowi=mysql_fetch_object($query);
       if($rowi->SuspendidoHasta > '0000-00-00' && $rowi->EnFecha < $FechaHoy && $FechaHoy <= $rowi->SuspendidoHasta)
         {
           $suspendido="S";
           $query = mysql_query("select Vino from Horarios where Paciente=$ci and Fecha='$rowi->EnFecha'");
           $rvino = mysql_fetch_object($query);

           $vino = $rvino->Vino;

           if($vino=="S")
              $suspendido="N";
           else
              $suspendido="S";
         }
           else
               $suspendido="N";
  }

     if($suspendido=="S")
       die("<H2><font color='#ff0000'>Paciente suspendido, no puede anotar</font></H2>");
     

    // **** mirar si se puede anotar ****
    $FechaHoy=Date("Y-m-d");

    $query=mysql_query("select Fecha,Medico,Medicos.Nombre as ElMedico from Horarios,Medicos where Paciente=$ci and Fecha > '$FechaHoy' and Medicos.Numero = Horarios.Medico");
    if(!empty($query))
      {
        while($rowi=mysql_fetch_object($query))
         {
           echo "Tiene una cita para el dia <b>$rowi->Fecha</b> con $rowi->ElMedico<br>";
         }
      }  
// ** ver laboratorio 

  $query = mysql_query("select Vence from TrabSoc where Paciente=$ci and Vence >='$xhoy' order by Vence limit 1");
  $rowi = mysql_fetch_object($query);
  $vence = $rowi->Vence;

  if(!empty($vence))
    echo "<b><font color='#0000FF''>Tiene un trabajo de laboratorio para el dia $vence</font></b><br>";

  // ***** Mirar proxima vez **** 
    $query=mysql_query("select Procedimiento, Pieza,Nombre,Comentario from ParaHacer, Procedimientos where Paciente=$ci and Procedimiento=Codigo");
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
                $Ncom =$rowi->Comentario;
                //echo "<i>Proximo procedimiento:</i> <b>$Nproc</b><br>\n";
              }
            else
                 echo "No tiene marcados procedimientos posteriores<br>\n";
        }

      $medico_actual = medico_que_lo_atiende($ci);

/*    $coment=mysql_query("select * from Comentarios where Paciente=$ci");
    $regcom=mysql_fetch_object($coment);
    $comentario=$regcom->Comantario;

    echo "<table border=3><tr><td align=center bgcolor=\"#FFFFFF\">Comentarios para Recepcion y Att. Telefonica</td></tr>";
    echo "<tr><td bgcolor=\"#CCCCCC\"><font color=\"#FFFFFF\" size=4><pre>(<b>$comentario</b>)</pre></font></td></tr>";
    echo "</table>";
*/
    echo "<b>Paso 2 </b>";
    echo "Elegir un procedimiento <a href='../historias/pase.php?paciente=$ci' target='_pases'>Pases</a>";
    echo " <a href='anotar.php?ci=$ci&comando=Paso2'>Recargar<img src='../img/reload.png' border=0 align=middle></a>Se atiende con $medico_actual->nombre"; 


    $query=mysql_query("select * from ProximaVez where Paciente=$ci");
    $reg = mysql_fetch_object($query);
    $pprox = $reg->procedimiento;
    $pPieza= $reg->numero;

    echo "<select size=8 name=\"proc\" style=\"width:500\"\n>";
    $query=mysql_query("select Nombre, Codigo, Pieza, PiezaHasta, Especialidad, comentario from Procedimientos, ParaHacer where Paciente=$ci and Procedimiento = Codigo order by Nombre,Pieza") or 
          die("Error en procedimientos : ".mysql_error());
    $cosasParaHacer=0;
    while($rowi=mysql_fetch_object($query))
      {
          ++$cosasParaHacer;
          $Nombre=$rowi->Nombre;
          $Codigo=$rowi->Codigo;
	  $Pieza =$rowi->Pieza;
	  $PiezaHasta =$rowi->PiezaHasta;
	  $comentadio = $rowi->comentario;
          if($pprox==$Codigo && $Pieza==$pPieza)
	      {
	         $selected="selected";
		 $comsel  ="<== Este es el proximo procedimiento";
	      }
	 else
	      {
	        $selected="";
		$comsel  ="";
	      }
	      
           echo "<OPTION $selected value=\"$Codigo)$Pieza\">$Nombre en pieza $Pieza a $PiezaHasta ($comentadio) $comsel</OPTION>\n";
       }

    if($cosasParaHacer==0)
       $selected = "selected";

           echo "<OPTION $selected value=\"1)999\">Revision</OPTION>\n";
    echo "</select><hr>\n";
    echo "<input type=\"hidden\" name=\"comando\" value=\"Paso3\">\n";
    echo "<input type=\"hidden\" name=\"ci\" value=\"$ci\">\n";
    echo "<input type=\"hidden\" name=\"xpac\" value=\"$xpac\">\n";
    echo "<input type=\"hidden\" name=\"boton\" value=\"$nada\">\n";
    echo "<input type=\"hidden\" name=\"medico_preferido\" value=\"$medico_actual->numero\">\n";
    echo "<input type=\"hidden\" name=\"aut\" value=\"$aut\">\n";
}

if($comando=="Paso3")
  {
      
    if(!empty($telefono))
        mysql_query("update Pacientes set Telefono='$telefono' where Cedula=$ci");
    $Xci=$ci;

    $codproc=strtok($proc,")");
    $pieza=strtok(")");

    // ***************** Aca me fijo la deuda, si tiene deuda para procedimientos anteriores o piezas diferentes, fuiste.
    $laquery="select sum(ordenes) as ordenes, sum(taller) as taller from Deudas where Paciente=$ci and Pieza!=$pieza group by Paciente";

    $ff = mysql_query($laquery);
    $reg = mysql_fetch_object($ff);
    $deudaOrdenes = $reg->ordenes;
    $deudaTaller  = $reg->taller;

    if(empty($deudaOrdenes))
       $deudaOrdenes=0;
    if(empty($deudaTaller))
       $deudaTaller=0;

    $hoy=date("Ymd");
    $xhoy=date("Y-m-d");
    
    $ff=mysql_query("select Nombre,Especialidad from Procedimientos where Codigo=$codproc");
    $reg=mysql_fetch_object($ff);
    $xxproc = $reg->Nombre;
    $esp    = $reg->Especialidad;

    if($esp==12)
       {
         if(!estaEnPlanOrto($ci)) 
	   die("<center><h3>No esta en el plan de ortodoncia fija, no puede continuar</center>");
       }
    
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
           if($boton=="Ver")
              {
                  $fechahasta=$fechadesde;
             /*     $anioHOY=strtok($fechadesde,"-");
                  $mesHOY=strtok("-");
                  $diaHOY=strtok("-");
                  $fechadesde=$anioHOY."-".$mesHOY."-".$diaHOY;
              */
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
    
    echo "Procedimiento : <b>$codproc)$xxproc</b> en pieza <b>$pieza</b><hr>\n";

    if($deudaTaller != 0 || $deudaOrdenes != 0)
     {
        echo "<b>Este paciente debe $deudaOrdenes ordenes y $deudaTaller ordenes de taller </b>".
	     "<a href='../ctacte/verdeuda.php?paciente=$ci' target='_blank'>Ver</a>".
	     "<br>";
     }

    echo "<b>Paso 3</b>, Elegir la hora y el medico ($filtromedico)";
    $xproc="Procedimiento : $proc)$xxproc en pieza $pieza<hr>\n";
    echo "<input type=\"hidden\" name=\"comando\" value=\"Paso3\">\n";
    echo "<input type=\"hidden\" name=\"xpac\" value=\"$xpac\">\n";
    echo "<input type=\"hidden\" name=\"codproc\" value=\"$codproc\">\n";
    echo "<input type=\"hidden\" name=\"proc\" value=\"$proc\">\n";
    echo "<input type=\"hidden\" name=\"pieza\" value=\"$pieza\">\n";
    echo "<input type=\"hidden\" name=\"xproc\" value=\"$xproc\">\n";
    echo "<input type=\"hidden\" name=\"fechahasta\" value=\"$fechahasta\">\n"; 
 #   echo "<input type=\"hidden\" name=\"fechadesde\" value=\"$fechadesde\">\n";
    echo "<input type=\"hidden\" name=\"ci\" value=\"$ci\">\n";
    echo "<input type=\"hidden\" name=\"orden\" value=\"$orden\">\n";
    echo "<input type=\"hidden\" name=\"aut\" value=\"$aut\">\n";

    if(empty($orden))
        $orden=2;
    if($orden==1)
       $order="Horarios.Fecha,Horarios.Turno,Horarios.Hora,Medicos.Nombre";
    else
      if($orden==2)
         $order="Medicos.Nombre, Horarios.Fecha,Horarios.Turno,Horarios.Hora";
      else
           $order="especialidad, Medicos.Nombre, Horarios.Fecha,Horarios.Turno,Horarios.Hora";

if($aut!=1)
   $limiteAut=" and Horarios.Paciente = 0 ";
else
   $limiteAut=" ";

$filtro="";
if($filtromedico!='---Todos---' && !empty($filtromedico))
   $filtro = " and Medicos.Numero = $filtromedico ";

if(!empty($filtroesp))
   $filtro.= "and Medicos.especialidad = $filtroesp ";

    $laquery="select Horarios.Fecha, Horarios.Turno, Horarios.Consultorio, Consultorios.Sucursal, Horarios.Hora, Horarios.Medico, Medicos.Nombre,Medicos.Numero as codmed, Especialidades.Nombre as Especialidad, Medicos.especialidad as medesp from Horarios,Medicos,Consultorios,Especialidades where Horarios.Fecha >= '$fechadesde' and Horarios.Fecha <= '$fechahasta' and Medicos.especialidad = Especialidades.Codigo and 
Horarios.Activa='S' and Horarios.Medico=Medicos.Numero $limiteAut and Horarios.Consultorio = Consultorios.Codigo $filtro group by Horarios.Fecha, Horarios.Turno, Horarios.Consultorio,Horarios.Medico order by $order";
   $query=mysql_query($laquery)
 or           die("Error en horarios : "
.mysql_error()." $query orden es $laquery, fechadesde es $fechadesde $fechahasta");

// echo "<div id=\"scroll\" style=\"height=350px;overflow:scroll\">";
    echo "<input type=\"text\" name=\"fechadesde\" value=\"$fechadesde\" size=10><a href=\"javascript:showCal('Calendar1')\">-!-</a> y $fechahasta en $coisucursal_ses";
echo "<br>Filtrar medicos";
cargarMedicos($filtromedico);
cargarEspecialidades();

echo "&nbsp;&nbsp;<input type=\"checkbox\" name=\"vertodo\" value=\"$vertodo\">Ver otras sucursales <input type=\"submit\" name=\"boton\" value=\"Ver\">\n";
    
    echo "<table border=1 width=95%>\n";
    echo "<tr align=center bgcolor=\"#FFFFFF\">";
    echo "   <td>";
    echo "      <a href=\"anotar.php?comando=Paso3&fechahasta=$fechahasta&fechadesde=$fechadesde&ci=$ci&orden=1&xpac=$xpac&boton=nada&proc=$proc&aut=$aut\">Fecha</a>";
    echo "   </td>\n";
    echo "   <td>Hora</td>\n";
    echo "   <td>Consultorio</td>\n";
    echo "   <td>Turno</td>\n";
    echo "   <td>";
    echo "      <a href=\"anotar.php?comando=Paso3&fechahasta=$fechahasta&fechadesde=$fechadesde&ci=$ci&orden=2&xpac=$xpac&boton=nada&proc=$proc&pieza=$pieza&tipocmd=$tipocmd&aut=$aut\">Medico</a>";
    echo "</td>\n";
    echo "   <td>";
    echo "      <a href=\"anotar.php?comando=Paso3&fechahasta=$fechahasta&fechadesde=$fechadesde&ci=$ci&orden=3&xpac=$xpac&boton=nada&proc=$proc&pieza=$pieza&tipocmd=$tipocmd&aut=$aut\">Especialidad</a>";
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
//          $mm=$mm - 15;
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
if(empty($coisucursal_ses))
    $coisucursal_ses="";
if(($Sucursal!=$coisucursal_ses && $coisucursal_ses!="") && $coisucursal_ses!="TELEFONOS" && !$vertodo)
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
         if(!empty($regsup) && $regsup->Suplente != 82) {
                $SUPLENTE=" / ".$regsup->Nombre;  
                $colorMedico='#ff4444';
         } else
                $colorMedico=$color;
         if($codmed==117) 
	          $color="#ffa500";
         echo "<tr bgcolor=$color>\n";
          if($cantidad >= $limite || $regsup->Suplente == 98)
                echo "<td><font size=+0>$xdiasemana<b>$Fecha</b></font></td>";
          else
                echo "   <td><a href=\"mostrarconsulta.php?Fecha=$Fecha&Turno=$Turno&Consultorio=$Consultorio&Turno=$Turno&Medico=$codmed&Proc=$codproc&Cedula=$Xci&cmd=anotar&pieza=$pieza&Xpac=$xpac&aut=$aut\">$xdiasemana<font size=+0><b>$Fecha</b></font></a></td>\n";
          echo "   <td><b>$xHora</b></td>\n";
          echo "   <td align=center>$Consultorio($Sucursal)</td>\n";
          echo "   <td align=center>$Turno</td>\n";
          echo "   <td bgcolor='$colorMedico'><b>$Medico <font color=\"\#333333\" size=+1>$SUPLENTE</font></b></td>\n";
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

   desconectar();
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
<hr>
</form>
</body>
</html>
