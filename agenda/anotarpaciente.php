<?php

    session_start();

   $coisucursal_ses=$_SESSION['coisucursal_ses'];
   $coifuncionario = $_SESSION['coifuncionario'];
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

<body bgcolor="#a4b6d4">
<center>
<table border=0 width=90%>
<tr>
<td>C.O.I Medica Uruguaya</td>
<td align=right><Font size=3>Agendar paciente</font></td>
</tr>
</table>
<hr>
<?php

function cartel_funcionario_0() {

  echo "<h3>ERROR</h3>";
  echo "<br>";
  echo "Se requiere que se autentique para anotar<br>";
  echo "<br>";
  echo "Este error puede producirse porque se ingreso a la historia clinica y se volvi� a agenda";
  echo "<br>";
  echo "<a href='../index.php'>Puse aqui para autenticarse</a>";
  echo "<br><h2>El paciente NO QUEDO ANOTADO</h2>";
  echo "<br>Datos : ";
  echo "Usuario de la sesion     : ".$_SESSION["coiusuario"];
  echo "Funcionario de la sesion : ".$_SESSION["coifuncionario"];
  echo "Funcionario cookie       : ".$coifuncionario;

  die("<br>Estamos solucionando este problema para que desaparezca el Usuario Revision - Gracias por su paciencia");

}

  include("../functions/paga.php");
  if(empty($coifuncionario))
        $coifuncionario=0;

 if($coifuncionario==0)
   cartel_funcionario_0();

 include("../functions/db.php");
 $link=conectar();
    // ************** miro que no este anotado **************

    $ci=$Cedula;

    include("mirarpaciente.php");

    $query=query("select * from Procedimientos where Codigo=$Proc");
    $rowi=query($query);
    echo "Procedimiento: <font size=+1>$Proc <b>$rowi->Nombre</b></font><hr>\n";
    $xproc=$rowi->Nombre;

    $query=query("select * from Horarios where Fecha='$Fecha' and Consultorio='$Consultorio' and Turno=$Turno and Hora='$Hora'"); 
    $err=mysql_error();
    if(!empty($err))
       die("<b>Error al intentar anotar PASO 1 avisar con este codigo de error : ".mysql_error()); 
    $rowi=mysql_fetch_object($query);
    if(empty($rowi))
     {
        die("<b>Error al intentar anotar avisar con este codigo de error $Hora : ".mysql_error());
     } 
    else
     {
        mysql_query("begin work");
        $paciente=$rowi->Paciente;
        $hora=$rowi->Hora;
    
        if(empty($lugar))
              $lugar=0;
 
        if($paciente==0 || $aut==1)
          { 
            // ************** ACA ANOTO **************
            
            if($aut==1) {
            
               $hh = strtok($Hora, ":");
               $mm = strtok(":");
               $ss = strtok(":");
               $mm += (15 * $lugar);
               if($mm > 60) {
                  $mm = $mm - 60;
                  $hh++;
               }
               $hora = $hh.":".$mm.":".$ss;
               $lugar = 200 + $lugar;
               $qq=mysql_query("insert into Horarios values('$Fecha', '$Consultorio', $Turno, '$hora', $nummed, $Cedula, 'N', 'S', $Proc, 'N', '$horainicio', $coifuncionario, $lugar)");
               
            }
            else
                $qq=mysql_query("update Horarios set Paciente=$Cedula, Procedimiento=$Proc,Vino='N',HoraCita='$horainicio',Funcionario=$coifuncionario,Numero=$lugar where Fecha='$Fecha' and Consultorio='$Consultorio' and Hora='$Hora' and Turno=$Turno");

            $error=mysql_error();
            if(!empty($error))
             {
               die("<br>No se pudo anotar paciente, error : <b>$error</b><br>");
             }
            // ************** Aca levanto la bandera de rx *************
              if($Proc==500)
                  { 
                     $qq=mysql_query("insert into rx values($Cedula,'$Fecha','N')"); 
                  }
            // ************** Aca grabo en faltas **********
                   $anio=strtok($Fecha,"-");
                   $mes=strtok("-");
                   $dia=strtok("-");

                   $mes=$mes + 1;
                   if($mes > 12)
                     {
                        $mes= 1;
                        $anio = $anio + 1;
                     }

            $qq=mysql_query("select * from Faltas where paciente=$Cedula");
            $reg=mysql_fetch_object($qq);
            if(!empty($reg))
             {
               $FechaHasta=$reg->SuspendidoHasta;
               $FechaHoy=date("Y-m-d");
               if($FechaHoy > $FechaHasta)
                {
                  $qq=mysql_query("delete from Faltas where paciente=$Cedula");
                  $qq=mysql_query("insert into Faltas values($Cedula,'$FechaHasta','$Fecha','AN')");
                }  
             } 
          else
            {
                $FechaHasta="$anio-$mes-$dia";

                $qq=mysql_query("insert into Faltas values($Cedula,'$FechaHasta','$Fecha','AN')");
                 
            	$error=mysql_error();
            	if(!empty($error))
              	{
              	    echo "<br>Advertencia : No se pudo actualizar la tabla de faltas, por <b>$error</b> el paciente quedo anotado<br>";
              	}
            }
            // ************* ACA GRABO LA CUENTA DE PROCEDIMIENTOS *************             

            $qq=mysql_query("select * from CuentaProc where fecha='$Fecha' and consultorio='$Consultorio' and turno=$Turno and Procedimiento=$Proc");
            $rowi=mysql_fetch_object($qq);
            if(empty($rowi))
              {
                  mysql_query("insert into CuentaProc values('$Fecha', '$Consultorio',$Turno, $Proc, 1)");
                  $error=mysql_error();
                       if(!empty($error))
                          {
                           echo "<br>No se pudo actualizar la cantidad de procedimientos por $error";  
                          }
                            else  
                                   echo "<br>Creada correctamente la cuenta de procedimientos<br>";
              }
                else
                    {
                       $numero=$rowi->Cantidad + 1;
                       $ff=mysql_query("update CuentaProc set Cantidad=$numero where fecha='$Fecha' and consultorio='$Consultorio' and turno=$Turno and Procedimiento=$Proc");
                       $error=mysql_error();
                       if(!empty($error))
                          {
                           echo "<br>No se pudo actualizar la cantidad de procedimientos por $error";   
                          }
                            else  
                                echo "<br>Actualizada correctamente la cuenta de procedimientos<br>";
                    }
          }
           else
               {
	         die("<font color=\"FBCFBC\" size=+2>Error,</font>No se pudo anotar el paciente porque se ha ocupado su lugar, pulse <a href=\"mostrarconsulta.php?cmd=anotar&Fecha=$Fecha&Turno=$Turno&Consultorio=$Consultorio&Medico=$Medico&Cedula=$Cedula\">aqui</a> para elegir otra hora"); 
               }
	       
	// ** Cargo en la deuda del socio si no esta ** //

	$ff=mysql_query("select * from Procedimientos where Codigo=$Proc");
	$reg=mysql_fetch_object($ff);
	$Ordenes = $reg->Ordenes;
        $Taller  = $reg->ImporteTaller;
	$TipoOrden = $reg->TipoOrden;
	$fechaHoy=Date("Y-m-d");
	//$horaAhora=Date("H:i:s");
        $horaAhora = microtime();

        if(paga($ci))
            $ff=mysql_query("insert into Deudas values($ci, $Proc, $pieza, $Ordenes, $Taller)");
        mysql_query("commit");
     }

$programa="ordencentral.php"; // ordenlocal1.php

//$programa="orden.php";
if($coisucursal_ses=="PIEDRAS")
   $programa="ordeninternet.php";
else
   if($coisucursal_ses=="COLON")
      $programa="ordeninternet.php";
   else
      if($coisucursal_ses=="TEJA")
        $programa="ordeninternet.php";
      else 
          if($coisucursal_ses=="SOLYMAR") 
              $programa="ordeninternet.php";
           else 
             if($coisucursal_ses=="MALVIN") 
                 $programa="ordeninternet.php";
                 
if($coisucursal_ses!="TELEFONOS")
{
   echo "<script>\n";
   echo "       window.open(\"$programa?ced=$Cedula&proc=$proc&xproc=$xproc&nombrePaciente=$nombrePaciente&fecha=$Fecha&hora=$horainicio&medico=$Medico&lugar=$lugar&consultorio=$Consultorio&seguro=$seguro\");\n";
   echo "</script>";
}
/* if($coisucursal_ses!="TELEFONOS" || $coisucursal_ses=="CENTRAL")
  {
   echo "<script> var sino=confirm(\"Desea imprimir ? $programa $nombrePaciente\");\n";
   echo "         if(sino)\n";
   echo "           {\n";
   echo "                  window.open(\"$programa?ced=$Cedula&proc=$proc&xproc=$xproc&nombrePaciente=$nombrePaciente&fecha=$Fecha&hora=$horainicio&medico=$Medico&lugar=$lugar&consultorio=$Consultorio&seguro=$seguro\");\n";
   echo "           }\n";
   echo "</script>\n";
  }
*/
// ******************* aca muestra una lista de anotaciones ************* //
    $hoy=$Fecha;
    $query=mysql_query("select Horarios.Fecha, Horarios.Turno, Horarios.Consultorio, Horarios.Hora, Horarios.Medico,Medicos.Nombre,Medicos.Numero as codmed, Horarios.Vino, Horarios.HoraCita,Procedimientos.Nombre as Proc
               from  Horarios,Medicos,Procedimientos 
               where Fecha >= '$hoy' and
                     Horarios.Paciente=$Cedula and Horarios.Activa='S'     and 
                     Procedimientos.Codigo = Horarios.Procedimiento        and
                     Horarios.Medico       = Medicos.Numero  
               order by Horarios.Fecha,Horarios.Turno,Horarios.Hora,Horarios.Medico") or           
                    die("Error en horarios : ".mysql_error());

    echo "<table border=1 width=80%>\n";
    echo "<tr align=center bgcolor=\"#FFFFFF\">";
    echo "   <td>Fecha</td>\n";
    echo "   <td>Hora</td>\n";
    echo "   <td>Consultorio</td>\n";
    echo "   <td>Turno</td>\n";
    echo "   <td>Medico</td>\n";
    echo "   <td>Procedimiento</td>\n";
    echo "   <td>Vino</td>\n";
    echo "</tr>\n";
    $color="#ACCCCC";
    while($rowi=mysql_fetch_object($query))
      {
          $Fecha=$rowi->Fecha;
          $Turno=$rowi->Turno;
          $Consultorio=$rowi->Consultorio;
          $Hora=$rowi->HoraCita;
          $Medico=$rowi->Nombre;
          $codmed=$rowi->codmed;
          $Vino=$rowi->Vino;
          $NombProc=$rowi->Proc;

          echo "<tr bgcolor=$color>\n";
          echo "<td><font size=+1><b>$Fecha</b></font></td>";
          echo "   <td><b>$Hora</b></td>\n";
          echo "   <td align=center>$Consultorio</td>\n";
          echo "   <td align=center>$Turno</td>\n";
          echo "   <td><b>$Medico</b></td>\n";
          echo "   <td><b>$NombProc</b></td>\n";
          echo "   <td><b>$Vino</b></td>\n";
          if($color=="#ACCCCC")
              $color="#BAAAAA";
          else
             $color="#ACCCCC";
          echo "</tr>\n";
       }
    echo "</table>\n";
mysql_close(); 

?>
</form>
<hr>
</body>
</html>
