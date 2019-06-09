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

     BODY{font-family: 'Arial',serif}
</style>
</head>

<body bgcolor="#dfffff">
<center>
<Font size=5>Consulta de citas por medico</font><hr>
<form action="listamedico.php" method="post">
<?
 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");

 if(empty($comando))
  {
    echo "<b>Paso 1</b>, identificar al medico ";
    $q="select * from Medicos where Activo='S' order by Nombre";
    $query=mysql_query($q);
    echo "<center><table border=0 width=90% bgcolor=\"#cddddd\">";
    while($reg=mysql_fetch_object($query))
      {
         $cod=$reg->Numero;
         $nom=$reg->Nombre;
         echo "<tr><td>$cod</td><td><a href=\"listamedico.php?comando=Paso2&nmed=$cod\">$nom</a></td></tr>";
      } 
    echo "</table>";
   echo "<br><br>\n";
  }

if($comando=="Paso2")
  {
    echo "<input type=\"hidden\" name=\"nmed\" value=\"$nmed\">\n";
    $query=mysql_query("select * from Medicos where Numero=$nmed");
    $reg=mysql_fetch_object($query);
    echo "Medico : <b>$reg->Nombre</b>"; 
    echo "<hr>";
    $Xci=$ci;
    $codproc=strtok($proc,") ");
    if(empty($fechadesde))
       $hoy=date("Ymd");
    else
       $hoy=$fechadesde;

    if(empty($fechahasta))
       $fechahasta=$hoy;

    $query=mysql_query("select Horarios.Fecha, Horarios.Turno, Horarios.Consultorio, Horarios.HoraCita, Horarios.Medico,Medicos.Nombre,Medicos.Numero as codmed, Horarios.Vino,Procedimientos.Nombre as Proc,Pacientes.Nombre as Pac,Paciente from Medicos,Horarios,Procedimientos,Pacientes where 
                                        Horarios.Fecha>='$hoy'        and
                                        Horarios.Fecha<='$fechahasta' and
                                        Horarios.Medico=$nmed and Horarios.Activa='S' and
                                        Procedimientos.Codigo = Horarios.Procedimiento and 
                                        Pacientes.Cedula      = Horarios.Paciente and 
                                        Horarios.Medico=Medicos.Numero and Medicos.Numero > 0 and
                                        Horarios.Paciente != 0
                                        order by Horarios.Fecha,Horarios.Turno,Horarios.Hora,Horarios.Medico") or           
                       die("Error en horarios : ".mysql_error());

    echo "<table border=0 width=95%>\n";
    echo "<tr align=center bgcolor=\"#FFFFFF\">";
    echo "   <td>Fecha</td>\n";
    echo "   <td>Hora</td>\n";
    echo "   <td>Consultorio</td>\n";
    echo "   <td>Turno</td>\n";
    echo "   <td>Paciente</td>\n";
    echo "   <td>Vino</td>\n";
    echo "   <td>&nbsp;&nbsp;</td>\n";
    echo "</tr>\n";
    $color="#ACCCCC";
    while($rowi=mysql_fetch_object($query))
      {
          $Fecha=$rowi->Fecha;
          $Turno=$rowi->Turno;
          $Consultorio=$rowi->Consultorio;
          $Hora=$rowi->HoraCita;
          $codmed=$rowi->codmed;
          $Vino=$rowi->Vino;
          $NombProc=$rowi->Proc;
          $Pac=$rowi->Pac;
          $Cedula=$rowi->Paciente;

          echo "<form action=\"reasignar.php\" method=post>\n";
          echo "<input type=\"hidden\" name=\"fecha\" value=\"$Fecha\">\n";
          echo "<input type=\"hidden\" name=\"consultorio\" value=\"Consultorio\">\n";
          echo "<input type=\"hidden\" name=\"turno\" value=\"$Turno\">\n";
          echo "<input type=\"hidden\" name=\"hora\" value=\"$Hora\">\n";
          echo "<input type=\"hidden\" name=\"cedula\" value=\"$Cedula\">\n";

          echo "<tr bgcolor=$color>\n";
          echo "<td>$Fecha</td>";
          echo "   <td>$Hora</td>\n";
          echo "   <td align=center>$Consultorio</td>\n";
          echo "   <td align=center>$Turno</td>\n";
          echo "   <td>$Cedula $Pac</td>\n";
          echo "   <td>$Vino</td>\n";
          echo "   <td><input type=\"submit\" name=\"comando\" value=\"Reasignar\"></td>\n";
          if($color=="#ACCCCC")
              $color="#BAAAAA";
          else
             $color="#ACCCCC";
          echo "</tr>\n";
          echo "</form>\n";
       }
    echo "</table>\n";
  }
    if(empty($fechahasta))
        $fechahasta=date('Y-m-d');
    echo "Fecha desde: <input type=\"text\" name=\"fechadesde\" value=\"$hoy\" size=10> Fecha hasta:  <input type=\"text\" name=\"fechahasta\" value=\"$fechahasta\" size=10><br>";

mysql_close();
?>
   <br>
   <input type="submit" name="comando" value="Paso2" >
   <hr>
</form>
</body>
</html>
