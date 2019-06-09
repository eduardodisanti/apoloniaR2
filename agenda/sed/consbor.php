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

<body bgcolor="#cccccc">
<center>
<Font size=8>Historia de anulaciones de citas</font><hr>
<form action="consbor.php" method="post">
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
  
    $Xci=$ci;
    $codproc=strtok($proc,") ");
    if(empty($fecha))
      $hoy=date("Ymd");
    else
      $hoy=$fecha;
 
    $query=mysql_query("select Borrados.Paciente,Borrados.Fecha,Borrados.Turno, Borrados.EnFecha,Borrados.Consultorio, Usuarios.usuario as funcionario
                      from Borrados, Usuarios
                      where 
                               Borrados.Paciente=$ci and
                               Borrados.Fecha >= '$hoy' and
                               Usuarios.funcionario = Borrados.Funcionario
                          order by Borrados.EnFecha") or
                       die("Error en horarios : ".mysql_error());

    echo "<table border=1 width=80%>\n";
    echo "<tr align=center bgcolor=\"#FFFFFF\">";
    echo "   <td>Anotado para</td>\n";
    echo "   <td>Consultorio</td>\n";
    echo "   <td>Turno</td>\n";
    echo "   <td>Medico</td>\n";
    echo "   <td>Se borro en</td>\n";
    echo "   <td>Borrado por</td>\n";
    echo "   <td>Anotado por</td>\n";

    echo "</tr>\n";
    $color="#ACCCCC";
    while($rowi=mysql_fetch_object($query))
       {
          $Fecha=$rowi->Fecha;
          $Turno=$rowi->Turno;
          $Consultorio=$rowi->Consultorio;
          $EnFecha=$rowi->EnFecha;

          $quaux="select Medicos.Nombre, Usuarios.usuario as anotadopor from Horarios,Medicos,Usuarios where Fecha='$Fecha' and Consultorio='$Consultorio' and Turno=$Turno and Horarios.Medico = Medicos.Numero and Usuarios.funcionario = Horarios.Funcionario";
          $qq=mysql_query($quaux); 
          $auxrowi=mysql_fetch_object($qq);
          $Medico=$auxrowi->Nombre;
	  $funcionario=$rowi->funcionario;
          $anotadopor=$auxrowi->anotadopor;

          echo "<tr bgcolor=$color>\n";
          echo "<td><font size=+1><b>$Fecha</b></font></td>";
          echo "   <td align=center>$Consultorio</td>\n";
          echo "   <td align=center>$Turno</td>\n";
          echo "   <td><b>$Medico</b></td>\n";
          echo "   <td><b>$EnFecha</b></td>\n";
	  echo "   <td><b>$funcionario</b></td>\n";
	  echo "   <td><b>$anotadopor</b></td>\n";
          if($color=="#ACCCCC")
              $color="#BAAAAA";
          else
             $color="#ACCCCC";
          echo "</tr>\n";
       }
    echo "</table>\n";
  }

mysql_close();
echo "Fecha desde: <input type=\"text\" name=\"fecha\" value=\"$hoy\" size=10><br>";

?>
   <br>
   <input type="submit" name="comando" value="Paso2">
   <hr>
</form>
</body>
</html>
