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
    $prn=$prn.sprintf("Medico : $reg->Nombre\n");
    $prn=$prn."------------------------------------------------------------------------------\n";
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


    $query=mysql_query("select Horarios.Fecha, Horarios.Turno, Horarios.Consultorio, Horarios.HoraCita, Horarios.Medico,Medicos.Nombre,Medicos.Numero as codmed, Horarios.Vino,Horarios.Numero, Procedimientos.Nombre as Proc,Horarios.Paciente, Pacientes.Nombre as Pac,Pacientes.Telefono,Usuarios.usuario as Anoto, Horarios.Procedimiento as npr from Medicos,Horarios,Procedimientos,Pacientes, Usuarios where 
                                     Horarios.Fecha>='$hoy'        and
                                     Horarios.Fecha<='$fechahasta' and
                                     Horarios.Medico=$nmed and Horarios.Activa='S' and
                                     Procedimientos.Codigo = Horarios.Procedimiento and 
                                     Pacientes.Cedula      = Horarios.Paciente and 
                                     Horarios.Medico=Medicos.Numero and Medicos.Numero > 0 and
                                     Horarios.Funcionario = Usuarios.funcionario 
                                     order by Horarios.Fecha,Horarios.Turno,Horarios.Hora,Horarios.Medico") or           
                       die("Error en horarios : ".mysql_error());

    echo "<table border=0 width=95%>\n";
    echo "<tr align=center bgcolor=\"#FFFFFF\">";
    echo "   <td>Fecha</td>\n";
    echo "   <td>Hora</td>\n";
    echo "   <td>Numero</td>\n";
    echo "   <td>Consultorio</td>\n";
    echo "   <td>Turno</td>\n";
    echo "   <td>Procedimiento</td>\n";
    echo "   <td>Paciente</td>\n";
    echo "   <td>Telefono</td>\n";
    echo "   <td>Vino</td>\n";
    echo "   <td>Anoto</td>\n";
    echo "</tr>\n";

    $prn=$prn.sprintf("%10s %8s %3s %5s %3s %40s %48s %14s\n\n", "Fecha", "Hora", "Nro", "Cons", "Turno", "Procedimiento", "Paciente", "Telefono");

    $color="#ACCCCC";
    while($rowi=mysql_fetch_object($query))
      {
          $Fecha=$rowi->Fecha;
          $Turno=$rowi->Turno;
          $Consultorio=$rowi->Consultorio;
          $Hora=$rowi->HoraCita;
          $Numero=$rowi->Numero;
          $codmed=$rowi->codmed;
          $Vino=$rowi->Vino;
          $NombProc=$rowi->Proc;
          $Pac=$rowi->Pac;
          $Tel=$rowi->Telefono;
          $Cedula=$rowi->Paciente;
          $Anoto=$rowi->Anoto;
          $NPR = $rowi->npr;

          if($Cedula==0) {

	      $erasequery = "select * from Borrados where Fecha='$Fecha' and Turno='$Turno' and Consultorio='$Consultorio'";
	      $eq = mysql_query($erasequery);
	      $ereg = mysql_fetch_object($eq);
	      if(!empty($ereg->Paciente)) {
	       
	         $Pac = "(Paciente borrado)";
		 $Cedula = $ereg->Paciente;
		 $color="#00D000";
              }
	  }
	    
          if($NPR==693)
             $color='#FFCC00';
          echo "<tr bgcolor=$color>\n";
          echo "<td>$Fecha</td>";
          echo "   <td>$Hora</td>\n";
          echo "   <td>$Numero</td>\n";
          echo "   <td align=center>$Consultorio</td>\n";
          echo "   <td align=center>$Turno</td>\n";
          echo "   <td>$NombProc</td>\n";
          echo "   <td>$Cedula $Pac</td>\n";
          echo "   <td>$Tel</td>\n";
          echo "   <td>$Vino</td>\n";
          echo "   <td>$Anoto</td>\n";
          if($color=="#ACCCCC")
              $color="#BAAAAA";
          else
             $color="#ACCCCC";
          echo "</tr>\n";
          if(!empty($imprimir))
           {
              $prn=$prn.sprintf("%10s %8s %3d %5s %3d %40s %33s %14s\n", $Fecha, $Hora, $Numero, $Consultorio, $Turno, $NombProc, $Cedula.$Pac, $Tel);
           }
       }
    echo "</table>\n";
//    $prn=$prn.sprintf("%c%c",18,12);
    if(!empty($imprimir))
        {
           $name=$nmed;
    	   $file = fopen("tmp/$name.prn","w");
           fputs($file, $prn);
           fclose($file);
            
           exec("lpr -l -P lp1 tmp/$name.prn");
           unlink("tmp/$name.prn");
        }
  }
    if(empty($fechahasta))
        $fechahasta=date('Y-m-d');
    echo "Fecha desde: <input type=\"text\" name=\"fechadesde\" value=\"$hoy\" size=10> Fecha hasta:  <input type=\"text\" name=\"fechahasta\" value=\"$fechahasta\" size=10><br>";


mysql_close();
?>
   <br>
   <input type="submit" name="comando" value="Paso2" >&nbsp;&nbsp;
   Enviar a impresora <input type="checkbox" name="imprimir">
   <hr>
</form>
</body>
</html>
