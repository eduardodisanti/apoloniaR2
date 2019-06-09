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
</head>

<body bgcolor="#5265B1">
<center>
<Font size=8></font><hr>
<form action="borrfal.php" method="post">
<?
 if(empty($coiusuario) || $coiusuario=="0")
   {
     die("<center><br>Debe estar identificado para poder anotar<br><a href=\"logon.php\">Pulse aqui para identificarse</a>\n<center>");
   }
 include("usuario.php");

 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");
 $usr = new usuario($coiusuario,$coiclave);

 if($usr->nivel < 5)
    {
      die("<center><br>No tiene autorización para ejecutar este comando<br><a href=\"index.php\">Pulse aqui para volver</a>\n<center>");

    }
 if(empty($comando) || $comando=="Otro Paciente")
  {
    echo "<center><h1>Borrar pacientes</h1></center>\n";
    echo "<b>Paso 1</b>, identificar al socio ";
    echo "Cedula : <input type=\"TEXT\" name=\"ci\" value=\"\" length=8 maxlength=9>";
   echo "<br><br>\n";
   echo "<input type=\"hidden\" name=\"comando\" value=\"Paso2\">\n";
  }

if($comando=="Paso2")
  {

   $ced=$ci;
   $query=mysql_query("select * from Pacientes where Cedula=$ced") or 
     die("(mirarpaciente.php) Error en bd, falla debido a ".mysql_error());

   $rowi=mysql_fetch_object($query);

   if(empty($rowi))
     {
       echo "<font color=\"#fbffff\"><b>El paciente no existe</b></font>";
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
     }

   echo "<font color=\"#fbffff\">$ced,<b>$rowi->Nombre</b> Seguro(<i><b>$rowi->Seguro</b></i>)</font>";

   echo "<a href=\"./historias/mostrarepisodioconnombre.php?paciente=$ci\" target=\"_blank\">Ver historia</a><br>";
   echo "Telefono : <b>$telefono</b> - Domicilio : <b>$domicilio</b><br>";
   $xpac="$ced,<b>$rowi->Nombre</b> Seguro(<i><b>$rowi->Seguro</b></i>)";

   $trancar="NO";
    echo "<hr>\n";
  
    $Xci=$ci;
    $codproc=strtok($proc,") ");
    $hoy=date("Ymd");
    
    $query=mysql_query("select * from Faltas where paciente=$ci") or
                       die("Error en Faltas : ".mysql_error());

    echo "<table border=1 width=50%>\n";
    echo "<tr align=center bgcolor=\"#FFFFFF\">";
    echo "   <td>En fecha</td>\n";
    echo "   <td>Suspendido hasta</td>\n";
    echo "   <td>Tipo</td>\n";
    echo "</tr>\n";
    $color="#ACCCCC";
    while($rowi=mysql_fetch_object($query))
      {
          $Fecha=$rowi->EnFecha;
          $Tipo=$rowi->Tipo;
          $Hasta=$rowi->SuspendidoHasta;

          echo "<tr bgcolor=$color>\n";
          echo "<td><font size=+1><b> Datos de la suspension\n";
          echo "   </b></font></td>";
          echo "   <td><b>$Fecha</b></td>\n";
          echo "   <td>$Hasta</td>\n";
          echo "   <td>$Tipo</td>\n";
          if($color=="#ACCCCC")
              $color="#BAAAAA";
          else
             $color="#ACCCCC";
          echo "</tr>\n";
       }
    echo "</table>\n";
 echo "<input type=\"hidden\" name=\"ci\" value=\"$ci\">\n";
 echo "<br><input type=\"submit\" name=\"comando\" value=\"Borrar\">\n";
  }

if($comando=="Borrar")
  {
    $borrados="delete from Faltas where paciente=$ci";
    mysql_query($borrados);
    $err=mysql_error();
    if(!empty($err))
       printf("No se pudo borrar la falta en $borrados por $err<br>");
    
  echo "Falta borrada<br>";
  echo "<br><input type=\"submit\" name=\"comando\" value=\"Otro paciente\">\n";

  }

mysql_close();
?>
   <hr>
</form>
</body>
</html>
