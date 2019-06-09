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
<Font size=8>Orden de asignacion de urgencias</font><hr>
<?

function laburo($mes)
{
 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");

    $qry = "select sucursal, medico, Nombre, ultima from TablaUrgencias, Medicos where medico = Medicos.Numero order by Sucursal, tiempo asc, ultima asc, Numero, Nombre";
    echo "<table border=1 width=80%>\n";
    echo "<tr align=center bgcolor=\"#FFFFFF\">";
    echo "   <th>Sucursal</th>\n";
    echo "   <th>Medico</th>\n";
    echo "   <th>Ultima asignacion</th>\n";
    echo "</tr>\n";

    $query = mysql_query($qry);
    $ant = "";
    $color= "#FFFFFF";

    while($reg=mysql_fetch_object($query))
      {
          $suc = $reg->sucursal;
	  $nom = $reg->Nombre;
	  $ult = $reg->ultima;
	  $med = $reg->medico;

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

          echo "<tr bgcolor='$color'>\n";
	  echo "  <td>$suc</td>\n";
	  echo "  <td>$nom ($med)</td>\n";
	  echo "  <td>$ult</td>\n";
          echo "</tr>\n";
       }
    echo "</table>\n";

   mysql_close();
}

  laburo(1);
?>
   <br>
   <input type="submit" name="comando" value="Imprimir" OnClick='window.print()'>
   <hr>
</form>
</body>
</html>
