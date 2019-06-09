<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2//EN">
<html>
<head>

  <meta http-equiv="CONTENT-TYPE" content="text/html; charset=iso-8859-1">
  <title>Ajustes de Cuenta Corriente</title>

<style type="text/css">
     A:link  {color:#9A3D3F}
     A:visited {color:#9A3D3F}
     A:hover {color: #C44487}

     BODY{font-family: 'Lucida Sans',serif}
</style>
</head>

<body bgcolor="#a4b6d4">
<center>
<Font size=5>Vista de cuenta corriente</font><hr>
<?php
 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");
 include("../class/usuario.php");

 $usr = new usuario($coiusuario,$coiclave);

 if($usr->nivel < 3)
    {
      die("<center><br>No tiene autorizaci&oacute;n para ejecutar este comando<br><a href=\"index1.php\">Pulse aqui para volver</a>\n<center>");

    }

    $query=mysql_query("select Pieza, Procedimientos.Nombre as descProc, Deudas.ordenes as cantOrdenes, Deudas.taller as cantTaller from Deudas,Procedimientos where Paciente=$paciente and Codigo=Procedimiento order by Pieza, Procedimiento desc");

echo mysql_error();

     echo "<table boder=0 bgcolor='#000000' width='500px'>";
     echo "<tr bgcolor='#cccccc'>";
     echo "	<td align='center'>Pieza</td>";
     echo "	<td align='center'>Procedimiento</td>";
     echo "	<td align='center'>Ordenes</td>";
     echo "	<td align='center'>Taller</td>";
     echo "</tr>\n";

     $totalOrdenes = 0;
     $totalTaller  = 0;
     while($reg=mysql_fetch_object($query))
      { 
        $pieza=$reg->Pieza;
 	$proc=$reg->descProc;
        $ordenes=$reg->cantOrdenes;
	$taller=$reg->cantTaller;
        echo "<tr bgcolor='#ffffff'>"; 
         echo "	<td>$pieza</td>";
	 echo "	<td>$proc</td>";
	 $xord=sprintf("%4.2f",$ordenes);
	 $xtaller=sprintf("%4.2f",$taller);
	 echo "	<td align='right'>$xord</td>";
	 echo "	<td align='right'>$xtaller</td>";
	echo "</tr>\n";

	$totalOrdenes+=$ordenes;
	$totalTaller+=$taller;
      }
   
    echo "<tr bgcolor='#bbbbbb'>";
    echo " <td></td>";
    echo " <td align=right>Total</td>";
    $xord=sprintf("%4.2f",$totalOrdenes);
    $xtaller=sprintf("%4.2f",$totalTaller);
    echo " <td align='right'>$xord</td>";
    echo " <td align='right'>$xtaller</td>";
    echo "</tr>\n";

    echo "</table>\n";
mysql_close();
?>
   <hr>
</body>
</html>
