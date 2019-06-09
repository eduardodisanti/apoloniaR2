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
</head>

<body bgcolor="#5265B1">
<center>
<Font size=8>Anotar un paciente</font><hr>
<form action="anotar.php" method="post">
<?
 require("../apolonia.inc");
 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");
if($cmd=="anotar")
  {

    $ci=$Cedula;
    include("mirarpaciente.php"); 
    $query=mysql_query("select * from Procedimientos where Codigo=$Proc");
    $rowi=mysql_fetch_object($query);
    echo "Procedimiento : <font size=+1>$Proc <b>$rowi->Nombre</b></font><hr>\n";
    echo "<b>Paso 4</b>, Elegir el lugar del paciente<hr>";

    $query=mysql_query("select Horarios.Fecha, Horarios.Turno, Horarios.Consultorio, Horarios.Hora, Horarios.Medico,Medicos.Nombre,Horarios.Paciente from Horarios,Medicos where Fecha = '$Fecha' and Horarios.Activa='S' and Horarios.Medico=Medicos.Numero and Horarios.Turno=$Turno and Horarios.Consultorio='$Consultorio' order by Horarios.Fecha,Horarios.Turno,Horarios.Hora,Horarios.Medico") or
          die("Error en horarios : ".mysql_error());

    $inicio=0;
    echo "<table border=1 width=80%>\n";
    echo "<tr align=center bgcolor=\"#FFFFFF\">";
    echo "   <td>Fecha</td>\n";
    echo "   <td>Hora aprox</td>\n";
    echo "   <td>Hora</td>\n";
    echo "   <td>Consultorio</td>\n";
    echo "   <td>Turno</td>\n";
    echo "   <td>Medico</td>\n";
    echo "</tr>\n";

    $color="#ACCCCC";
    $numeros=mysql_num_rows($query);
    $franja1 = ($numeros / $franjas);
    $lugar=0;

    while($rowi=mysql_fetch_object($query))
      {
          $Fecha=$rowi->Fecha;
          $Turno=$rowi->Turno;
          $Consultorio=$rowi->Consultorio;
          $Hora=$rowi->Hora;
          $medico=$rowi->Medico;

          if($inicio==0)
               $inicio=$Hora;
          if($lugar==$franja1)
               $inicio=$Hora;

          $horaLugar=$inicio;
  // ******************************** ACA MUESTRO LA HORA ************************
  // ******
  // ****** Primero veo voy al calendario para saber que dia es

          $q1=mysql_query("select * from Calendario where Fecha='$Fecha');
          if(!empty($q1))
               {
                   $rq1=mysql_fetch_object($q1);
                   $ddls=$rq1->DiaDeLaSemana;
                   // ****** Ahora le pregunto al molde cual es la duracion de la consulta
                   $q1=mysql_query("select * from Molde where DiaDesde=$ddls and DiaHasta=$ddls and Turno=$Turno   and Consultorio='$Consultorio'");
                   $rq1=mysql_fetch_object($q1);
                   $xLugares=$rq1->Lugares;
                   $xHora=$rq1->Hora;
                   $xDuracion=$rq1->Duracion * 60;
           	   $hhInicio=strtok($xHora,":");
                   $mmInicio=strtok(":");
                   $mmAux=$mmInicio + $xDuracion;
                   $agHoras=mmAux % 60;
                   $hhInico = $hhInico + $agHoras;
                   $HoraFranja2 = "$hhInicio:$mmInicio";
               }
  
          if($lugar==$franja1)
                $inicio=$Hora;
          else
               {
                   $inicio=$HoraFranja2;
               }


          $lugar=$lugar + 1;
          $Medico=$rowi->Nombre;
          $pacanot=$rowi->Paciente;
          echo "<tr bgcolor=$color>\n";
          if(empty($volver))
               $volver=0;

          if($pacanot==0)
              {
                echo "   <td bgcolor=\"#FFFFFF\"><a href=\"anotarpaciente.php?Fecha=$Fecha&Turno=$Turno&Consultorio=$Consultorio&Hora=$Hora&Proc=$Proc&Cedula=$Cedula&horainicio=$inicio&Medico=$Medico\"><font size=+1><b>$Fecha</b></font></a></td>\n";
                $fz=3;
              }
          else
              {
                echo "   <td><font size=1><i>$Fecha</i></font></a></td>\n";
                $fz=1;
              }
          echo "   <td><font size=$fz>$Hora</font></td>\n";
          echo "   <td><b><font size=$fz>$inicio</font></b></td>\n";
          echo "   <td align=center><font size=$fz>$Consultorio</font></td>\n";
          echo "   <td align=center><font size=$fz>$Turno</font></td>\n";
          echo "   <td><b><font size=$fz>$Medico</font></b></td>\n";
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
   <input type="submit" name="boton" value="Cancelar">
</form>
<hr>
</body>
</html>
