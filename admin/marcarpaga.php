<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2//EN">
<html>
<head>

  <meta http-equiv="CONTENT-TYPE" content="text/html; charset=iso-8859-1">
  <title>Marcar pago o no pago del paciente</title>

<style type="text/css">
     A:link  {color:#9A3D3F}
     A:visited {color:#9A3D3F}
     A:hover {color: #C44487}

     BODY{font-family: 'Lucida Sans',serif}
</style>
</head>

<body bgcolor="#a4b6d4">
<center>
<Font size=5>Marcar debe abonar de Pacientes</font><hr>
<?php
 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");
 include("../class/usuario.php");

 $usr = new usuario($coiusuario,$coiclave);

 if($usr->nivel < 9)
    {
      die("<center><br>No tiene autorizaci&oacute;n para ejecutar este comando<br><a href=\"index1.php\">Pulse aqui para volver</a>\n<center>");
    }

 if(empty($comando))
  {
    echo "<form action='marcarpaga.php'>";
    echo "Identificar al socio ";
    echo "Cedula : <input type=\"TEXT\" name=\"ci\" value=\"\" length=8 maxlength=9>";
    echo "<br><br>\n";
    echo "<input type=\"submit\" name=\"comando\" value=\"Paga\">\n &nbsp;&nbsp;";
    echo "<input type=\"submit\" name=\"comando\" value=\"No Paga\">\n";
    echo "</form>";
  }

if($comando=="Paga")
  {
    $tx= "update Pacientes set PositivamentePaga='S' where Cedula=$ci";
    $q = mysql_query($tx);
  }

if($comando=="No Paga")
  {
    $tx = "update Pacientes set PositivamentePaga='N' where Cedula=$ci";
    $q = mysql_query($tx);    
  }
  
if(!empty($comando))
  {
   $ced=$ci;
   $query=mysql_query("select * from Pacientes where Cedula=$ced") or 
         die("(mirarpaciente.php) Error en bd, falla debido a ".mysql_error());
   $error=mysql_error();
   $rowi=mysql_fetch_object($query);

   if(empty($rowi))
     {
       echo "<font color=\"#fbffff\"><b>El paciente no existe #$error</b></font>";
       die("Pulse <a href=\"/agenda/marcarpaga.php\">aqui</a> para volver");
     }
   $seguro   = $rowi->Seguro;
   $paga     = $rowi->Paga;
   $telefono = $rowi->Telefono;
   $domicilio= $rowi->Domicilio;
   $habilit  = $rowi->Habilitado;
   $Paga     = $rowi->PositivamentePaga;
   $nombre   = $rowi->Nombre;

   echo "<li>$nombre</li>";
    echo "<li>Seguro      : $seguro</li>";
    echo "<li>Paga        : $paga</li>";
    echo "<li>Telefono    : $telefono</li>";
    echo "<li>Domicilio   : $domicilio</li>";
    echo "<li>De alta     : $habilit</li>";
    echo "<li>Siempre paga: $Paga</li>";
   echo "</li>";
  }

mysql_close();
?>
   <hr>
   <font size=+1><a href="marcarpaga.php?cmd=">Otro paciente</a></font>
</body>
</html>
