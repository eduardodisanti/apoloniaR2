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
</head>

<body bgcolor="#5265B1">
<center>
<Font size=8>Consulta de citas por medico</font><hr>
<form action="listamed.php" method="post">
<?
 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");

 if(empty($comando))
  {
    echo "<b>Paso 1</b>, identificar al medico ";
    echo "Medico : <input type=\"TEXT\" name=\"nmed\" value=\"\" length=8 maxlength=9>";
   echo "<br><br>\n";
   echo "<input type=\"hidden\" name=\"comando\" value=\"Paso2\">\n";
  }

if($comando=="Paso2")
  {
    
    echo "<hr>\n";
  
    $Xci=$ci;
    $codproc=strtok($proc,") ");
    $hoy=date("Ymd");
    
    $query=mysql_query("select Horarios.Fecha, Horarios.Turno, Horarios.Consultorio, Horarios.Hora, Horarios.Medico,Medicos.Nombre,Medicos.Numero as codmed, Horarios.Vino,Usuarios.usuario as Anoto, Horarios.Procedimiento as Proc 
                                   from Horarios,Medicos where Fecha >= '$hoy'        and
                                        Horarios.Paciente=$ci and Horarios.Activa='S' and 
                                        Horarios.Medico=Medicos.Numero and Medicos.Numero > 4 and Horarios.Funcionario = Usuarios.Funcionario  
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
    echo "   <td>Anoto</td>\n";
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
          $Numero=$rowi->Numero;
          $Anoto=$rowi->Anoto;
          $Proc =$rowi->Proc;

          if($Proc==693)
             $color='#FFFF00';
          echo "<tr bgcolor=$color>\n";
          echo "<td><font size=+1><b>$Fecha</b></font></td>";
          echo "   <td><b>$Hora</b></td>\n";
          echo "  <td><b>$Numero</b></td>\n";
          echo "   <td align=center>$Consultorio</td>\n";
          echo "   <td align=center>$Turno</td>\n";
          echo "   <td><b>$Medico</b></td>\n";
          echo "   <td><b>$Vino</b></td>\n";
          echo "   <td>$Anoto</td>\n";
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
   <br>
   <input type="submit" name="Consultar otro">
   <hr>
</form>
</body>
</html>
