<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2//EN">
<html>
<head>

  <meta http-equiv="CONTENT-TYPE" content="text/html; charset=iso-8859-1">
  <title></title>

  <meta name="GENERATOR" content="Quanta+ (Linux)">

<style type="text/css">
     A:link  {color:#9A3D3F}
     A:visited {color:#9A3D3F}
     A:hover {color: #C44487}

     BODY{font-family: 'Arial',serif}
</style>
</head>

<body bgcolor="#dfffff">
<center>
<Font size=5>Consulta que requieren trabajos de laboratorio </font><hr>
<form action="venctrabxmed.php" method="post">
<?
 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");

 if(empty($comando))
  {
    echo "<b>Paso 1</b>, elegir turno fecha y sucursal<hr>";
    echo "Turno : ";
    echo "<select name='turno'>";
    echo    "<option name='1'>1 Matutino</option>";
    echo    "<option name='2'>2 Matutino</option>";
    echo    "<option name='3'>3 Tarde</option>";
    echo    "<option name='4'>4 Tarde</option>";
    echo    "<option name='5'>5 Noche</option>";
    echo    "<option name='5'>6 Noche</option>";
    echo "</select>";
    echo "<br>Fecha desde ";
    echo "<input type='text' name='fechadesde' size=10><br>";
    echo "Fecha hasta ";
    echo "<input type='text' name='fechahasta' size=10><br>";

    $query="select Sucursal from Consultorios group by Sucursal order by Sucursal";
    $qry = mysql_query($query);

    echo "Sucursal   <select name='sucursal'>";
    while($reg=mysql_fetch_object($qry))
      {
         if($reg->Sucursal=="$coisucursal_ses")
             $sel="SELECTED";
         else
             $sel="";
         echo "<option value='$reg->Sucursal' $sel>$reg->Sucursal</option>"; 
      }
    echo "</select>";

    echo "<hr>";
    echo "<input type='submit' name='comando' value='Listar'>";
  }

if($comando=="Listar")
  {
    if(empty($fechadesde))
       $hoy=date("Ymd");
    else
       $hoy=$fechadesde;

    if(empty($fechahasta))
       $fechahasta=$hoy;

     $turno1 = $turno * 10;
     $turno2 = $turno1 + 9;

     $medicoAnt=0;
     $fechaAnt="";

    $q="select Horarios.Fecha, Horarios.Turno, Horarios.Consultorio, Consultorios.Sucursal, Horarios.HoraCita, Medicos.Nombre as NombreMedico, Horarios.Medico as codmed, Procedimientos.Nombre as proc, Horarios.Paciente, Pacientes.Nombre as Pac from Horarios, Medicos, Procedimientos, Pacientes, Consultorios where
                       Horarios.Fecha >='$hoy'		and
		       Horarios.Fecha <='$fechahasta'   and
		       Horarios.Turno >= $turno1        and
		       Horarios.Turno <= $turno2        and
		       Horarios.Medico = Medicos.Numero and
		       Horarios.Paciente != 0           and
		       Horarios.Paciente = Pacientes.Cedula and 
		       Consultorios.Sucursal = '$sucursal'  and
		       Horarios.Consultorio  = Consultorios.Codigo and 
		       Procedimientos.Codigo = Horarios.Procedimiento and
		       Medicos.especialidad != 10 and
		       Medicos.especialidad != 9  and
		       Medicos.especialidad != 2   

		       order by Horarios.Fecha, Horarios.Medico, Horarios.Turno, Horarios.Hora";

    $query = mysql_query($q)
        or die("Error en consulta ".mysql_error());

    echo "<table border=0 width=100%>\n";
    echo "<tr align=center bgcolor=\"#FFFFFF\">";
    echo "   <td>Hora</td>\n";
    echo "   <td>Cons</td>\n";
    echo "   <td>Turno</td>\n";
    echo "   <td>Paciente</td>\n";
    echo "   <td>Procedimiento</td>\n";
    echo "   <td>Trabajo</td>\n";
    echo "</tr>\n";

    $color="#ACCCCC";
    while($rowi=mysql_fetch_object($query))
      {
          $Fecha=$rowi->Fecha;
          $Turno=$rowi->Turno;
          $Consultorio=$rowi->Consultorio;
          $Hora=$rowi->HoraCita;
          $Numero=$rowi->Numero;
          $codmed=$rowi->codmed;
          $NombProc=$rowi->proc;
	  $NombreMedico=$rowi->NombreMedico;
          $Pac=$rowi->Pac;
          $Cedula=$rowi->Paciente;
	  $estado = $rowi->estado;

        $q2 = "select Trabajos.descripcion, EstadosTrabajo.Descripcion as estado from Trabajos, TrabSoc, EstadosTrabajo where TrabSoc.Paciente = $Cedula and Trabajos.id = TrabSoc.Trabajo and TrabSoc.Entregado = EstadosTrabajo.Codigo group by Trabajos.descripcion";
	$query2 = mysql_query($q2);

	$num = mysql_num_rows($query2);
	if($num > 0)
	 {
          if($Fecha!=$fechaAnt)
	    {
	      $fechaAnt=$Fecha;
              echo "<tr bgcolor='#ffffff'>";
              echo "    <td colspan=7 align='left'>";
              echo "       <font size=+1>$Fecha</font>";
              echo "    </td>";
              echo "</tr>";
	    }

          if($codmed!=$medicoAnt)
	    {
	      echo "<tr bgcolor='#ffffff'>";
	      echo "    <td colspan=7 align='center'>";
	      echo "       <font size=+1>$codmed $NombreMedico</font>";
	      echo "    </td>";
	      echo "</tr>";
	      $medicoAnt=$codmed;
	    }
          echo "<tr bgcolor=$color>\n";
          echo "   <td>$Hora</td>\n";
          echo "   <td align=center>$Consultorio</td>\n";
          echo "   <td align=center>$Turno</td>\n";
          echo "   <td>$Cedula $Pac</td>\n";
          echo "   <td>$NombProc</td>\n";
	  echo "   <td>";

             $i=0;
	     while($reg2 = mysql_fetch_object($query2))
	       {
	           $i++;
	           $trab = $reg2->descripcion;
		   $estado = $reg2->estado;
		   echo "$i)$trab (<i>$estado</i>)<br>";
	       }
	  echo "   </td>";
          if($color=="#ACCCCC")
              $color="#BAAAAA";
          else
             $color="#ACCCCC";
          echo "</tr>\n";
        }
       }
    echo "</table>\n";
  }

mysql_close();
?>
<a href="#" onclick="window.print()">Imprimir</a>
</form>
</body>
</html>
