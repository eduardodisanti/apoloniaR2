<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

  <meta http-equiv="CONTENT-TYPE" content="text/html; charset=iso-8859-1">
<?php
     if(!empty($nmed))
       {
          echo "<meta http-equiv=\"refresh\" content=\"60\" url=\"listarev.php?nmed=$nmed\">\n";
       }
?>
  <title>Lista de asistencia</title>

<style type="text/css">
     A:link  {color:#9A3D3F}
     A:visited {color:#9A3D3F}
     A:hover {color: #C44487}

     BODY{font-family: 'Arial',serif}
</style>

</head>

<body bgcolor="#dfffff">
<center>
<Font size=5>Consulta de pacientes para atender</font><hr>
<form action="listarev.php" method="post">
<?php

 function mostrar_lista_altas($fecha, $medico)
  {
    $hora = 0;
    $fecha = date("Y-m-d");
       $q = mysql_query("select Paciente,Fecha,Hora, Pacientes.Nombre as Nombre from Altas,Pacientes where Fecha = '$fecha' and Hora >= '$hora' and validada='N' and Altas.Paciente = Pacientes.Cedula");

       echo "<table border=0 bgcolor='#000000' width='80%'>";
       echo "<tr bgcolor='#990000'><td colspan='5' align='center'><font color='#ffffff'> Altas del dia para validar </font></td></tr>\n";
       echo "<tr bgcolor='#FCFCFC'><td>Fecha</td><td>Hora</td><td colspan=2>Paciente</td><td>Validar</td></tr>\n";
       while($reg=mysql_fetch_object($q))
        {
          $Hora  = $reg->Hora;
          $Fecha = $reg->Fecha;
          $Pac   = $reg->Paciente;
          $Nombre= $reg->Nombre;

          echo "<tr bgcolor='#FFFFFF'>\n";
          echo "<td>$Fecha</td>";
          echo "   <td>$Hora</td>\n";
          echo "   <td align=center>$Pac</td>\n";
          echo "   <td>$Nombre</td>\n";
          echo "   <td>\n";
          echo "   (<a href='#' onclick='supervisar($Pac,\"O\",$medico, \"$Fecha\")'>Si</a>) (<a href='#' onclick='supervisar($Pac,\"R\",$medico,\"$Fecha\")'>No</a>)";
          echo "   </td>\n";
          echo "</tr>";
        } 
     echo "</table>";
  }

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
         echo "<tr><td>$cod</td><td><a href=\"listarev.php?comando=Paso2&nmed=$cod\" target='_historia'>$nom</a></td></tr>";
      } 
    echo "</table>";
   echo "<br><br>\n";
  }
if($accion=="G")
  {
     mysql_query("insert into Asistencia values($medico,'$fecha',$turno,$numero,$paciente)");
     $nmed=$medico; 
  }
if($comando=="Paso2")
  {
    echo "<input type=\"hidden\" name=\"nmed\" value=\"$nmed\">\n";
    $query=mysql_query("select * from Medicos where Numero=$nmed");
    $reg=mysql_fetch_object($query);
    echo "Medico : <b>$reg->Nombre</b> ($nmed)"."    <a href='listarev.php?comando=Paso2&nmed=$nmed'><img src='../img/reload.png' border=0>Actualizar</a>";
    echo "<hr>";


    $Xci=$ci;
    $codproc=strtok($proc,") ");
    $hoy=date("Ymd");

    if(empty($fechahasta))
       $fechahasta=$hoy;

    $query=mysql_query("select Horarios.Fecha, Horarios.Turno, Horarios.Consultorio, Horarios.HoraCita, Horarios.Medico,Medicos.Nombre,Medicos.Numero as codmed, Horarios.Vino,Horarios.Numero, Procedimientos.Nombre as Proc,Horarios.Paciente, Pacientes.Nombre as Pac,Pacientes.Telefono,Usuarios.usuario as Anoto from Medicos,Horarios,Procedimientos,Pacientes, Usuarios where 
                                        Horarios.Fecha='$hoy'        and
                                        Horarios.Medico=$nmed and Horarios.Activa='S' and
                                        Procedimientos.Codigo = Horarios.Procedimiento and 
                                        Pacientes.Cedula      = Horarios.Paciente and 
                                        Horarios.Medico=Medicos.Numero and Medicos.Numero > 0 and
                                        Horarios.Paciente != 0 and 
                                        Horarios.Funcionario = Usuarios.funcionario 
                                        order by Horarios.Fecha,Horarios.Turno,Horarios.Hora,Horarios.Medico") or           
                       die("Error en horarios : ".mysql_error());

    echo "<table border=0 width=100%>\n";
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
    echo "   <td>Llamado</td>\n";
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
          $Vino=$rowi->Vino;
          $NombProc=$rowi->Proc;
          $Pac=$rowi->Pac;
          $Tel=$rowi->Telefono;
          $Cedula=$rowi->Paciente;
          $Anoto=$rowi->Anoto;

          $nnxq = "select * from Asistencia where Medico=$codmed and Fecha='$Fecha'and Turno=$Turno and Numero=$Numero and Paciente = $Cedula";
          $nnq=mysql_query($nnxq);
          $nnreg=mysql_fetch_object($nnq);
          if(!empty($nnreg))
            $llamado="S";
          else
            $llamado="N";

          if($Vino=="S")
             $font="size=4";
          else
             $font="size=3";
          if($llamado=="N" && $Vino=="N")
            $font="$font $color=\"#ff0000\"";
          else
            $font="$font $color=\"#ffffff\"";

          echo "<tr bgcolor=$color>\n";
          echo "<td>$Fecha</td>";
          echo "   <td>$Hora</td>\n";
          echo "   <td>$Numero</td>\n";
          echo "   <td align=center>$Consultorio</td>\n";
          echo "   <td align=center>$Turno</td>\n";
          echo "   <td><font $font>$NombProc</font></td>\n";
          echo "   <td><font $font>$Cedula <a href=\"hojarevision.php?paciente=$Cedula&comando=revision&medico=$codmed\">$Pac</a></font></td>\n";
          echo "   <td>$Tel</td>\n";
          echo "   <td>$Vino</td>\n";
          echo "   <td>$Anoto</td>\n";
          echo "   <td>";
          if($llamado=="N" && $Vino=="S")
            echo "<a href=\"listarev.php?comando=Paso2&accion=G&fecha=$Fecha&medico=$codmed&turno=$Turno&numero=$Numero&paciente=$Cedula\">Atendido</a>"; 
          else
            if($llamado=="S" && $Vino=="S")
                echo "Ya atendido"; 
            else
                echo "No vino";
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
   <input type="submit" name="comando" value="Paso2" >
   <hr>
</form>
</body>
</html>
