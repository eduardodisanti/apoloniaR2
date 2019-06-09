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
<Font size=8>Consulta de citas por paciente</font><hr>
<form action="listapac.php" method="post">
<?
 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");

 if(empty($comando))
  {
    $hoy=date("Ymd");
    echo "<b>Paso 1</b>, identificar al socio ";
    echo "Cedula : <input type=\"TEXT\" name=\"ci\" value=\"\" length=8 maxlength=9>";
   echo "<br><br>\n";
   echo "<input type=\"hidden\" name=\"comando\" value=\"Paso2\">\n";
  }

if($comando=="Paso2")
  {
    echo "<input type=\"hidden\" name=\"ci\" value=\"$ci\" length=8 maxlength=9>";
    include("mirarpaciente.php");
    echo "<hr>\n";

   $prn=$prn.sprintf("Paciente : $prnxpac\n");
   $prn=$prn."------------------------------------------------------------------------------\n";
  
    $Xci=$ci;
    $codproc=strtok($proc,") ");
    if(empty($fecha))
      $hoy=date("Ymd");
    else
      $hoy=$fecha;
   
    $query=mysql_query("select Horarios.Fecha, Horarios.Turno, Horarios.Consultorio, Horarios.Hora, Horarios.Medico,Medicos.Nombre,Medicos.Numero as codmed, Horarios.Vino, Horarios.HoraCita,Procedimientos.Nombre as Proc, Horarios.Numero 
                                   from Horarios,Medicos,Procedimientos where Fecha >= '$hoy'        and
                                        Horarios.Paciente=$ci and Horarios.Activa='S' and 
                                        Procedimientos.Codigo = Horarios.Procedimiento and
                                        Horarios.Medico=Medicos.Numero  
                                        order by Horarios.Fecha,Horarios.Turno,Horarios.Hora,Horarios.Medico") or           
                       die("Error en horarios : ".mysql_error());

    echo "<table border=1 width=80%>\n";
    echo "<tr align=center bgcolor=\"#FFFFFF\">";
    echo "   <td>Fecha $fecha</td>\n";
    echo "   <td>Hora</td>\n";
    echo "   <td>Numero</td>\n";
    echo "   <td>Consultorio</td>\n";
    echo "   <td>Turno</td>\n";
    echo "   <td>Medico</td>\n";
    echo "   <td>Procedimiento</td>\n";
    echo "   <td>Vino</td>\n";
    echo "</tr>\n";
    $color="#ACCCCC";

    $prn=$prn.sprintf("%10s %8s %3s %5s %3s %40s %48s\n\n", "Fecha", "Hora", "Nro", "Cons", "Turno", "Medico", "Procedimiento");

    while($rowi=mysql_fetch_object($query))
      {
          $Fecha=$rowi->Fecha;
          $Turno=$rowi->Turno;
          $Numero=$rowi->Numero;
          $Consultorio=$rowi->Consultorio;
          $Hora=$rowi->HoraCita;
          $Medico=$rowi->Nombre;
          $codmed=$rowi->codmed;
          $Vino=$rowi->Vino;
          $NombProc=$rowi->Proc;

          echo "<tr bgcolor=$color>\n";
          echo "<td><font size=+1><b>$Fecha</b></font></td>";
          echo "   <td><b>$Hora</b></td>\n";
          echo "   <td align=center>$Numero</td>\n";
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
          $prn=$prn.sprintf("%10s %8s %3d %5s %3d %40s %33s\n", $Fecha, $Hora, $Numero, $Consultorio, $Turno, $Medico, $NombProc);
       }
    echo "</table>\n";
//    $prn=$prn.sprintf("%c%c",18,12);
    if(!empty($imprimir))
        {
           $name="$ci.prn";
           $file = fopen("tmp/$name","w");
           fputs($file, $prn);
           fclose($file);

           exec("lpr -l -P lp1 tmp/$name");
           unlink("tmp/$name");
        }
  }

mysql_close();
echo "Fecha desde: <input type=\"text\" name=\"fecha\" value=\"$hoy\" size=10><br>";

?>
   <br>
   Enviar a impresora <input type="checkbox" name="imprimir">
   <input type="submit" name="comando" value="Paso2">
   <hr>
</form>
</body>
</html>
