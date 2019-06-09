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

<body bgcolor="#cccccc">
<center>
<Font size=8>Asignaci&oacute;n de urgencias</font><hr>
<?

function laburo($mes)
{
 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");

 $qry = "select DiaDesde, Turno, Hora, Doctor, Nombre, ModeloUrgencia from Molde, Medicos where Molde.Doctor = Medicos.Numero and (ModeloUrgencia = $mes or ModeloUrgencia = 3) order by DiaDesde, Turno";
    echo "<table border=1 width=80%>\n";
    echo "<tr align=center bgcolor=\"#FFFFFF\">";
    echo "   <th>Dia</th>\n";
    echo "   <th>Comienzo</th>\n";
    echo "   <th>Medico</th>\n";
    echo "</tr>\n";

    $query = mysql_query($qry);
    $ant = "";
    $color= "#FFFFFF";

    while($reg=mysql_fetch_object($query))
      {
          $dia = $reg->DiaDesde;
	  $nom = $reg->Nombre;
	  $con = $reg->Hora;
	  $mod = $reg->ModeloUrgencia;

          $colco = $color;
          if($dia != $ant)
	     {
                 $ant = $dia;
		 if($color=="#FFFFFF")
	              $color = "#CCCCCC";
		 else
		     {
		      $color = "#FFFFFF";
		     }
	     }

          if($mod == 1)
	      $mu="Meses impares";
          else
              if($mod == 2)
                   $mu = "Meses pares";
              else
                 {
                    $mu = "Todos los meses";
                    $colco = "#FF0000";
                 }

          echo "<tr bgcolor='$color'>\n";
	  echo "  <td>$dia</td>\n";
	  echo "  <td>$con</td>\n";
	  echo "  <td>$nom</td>\n";
          echo "</tr>\n";
       }
    echo "</table>\n";

   mysql_close();
}

  echo "<CENTER>Meses Impares</CENTER>";
  laburo(1);
  echo "<CENTER>Meses Pares</CENTER>";
  laburo(2);
?>
   <br>
   Enviar a impresora <input type="checkbox" name="imprimir">
   <input type="submit" name="comando" value="Paso2">
   <hr>
</form>
</body>
</html>
