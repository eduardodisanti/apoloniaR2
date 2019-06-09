<html>
<head>
</head>
<body>
<table border=1 width=740>
<tr>
   <td align="center"><img src="../img/logo.jpg" width=96></td>
   <td align="center"><h2>Presupuesto</h2></td>
   <td align="center">
      <table border=0 width="100%" bgcolor="#000000">
         <tr bgcolor="#ffffff"><td align="center">HT-EDP-01</td></tr>
         <tr bgcolor="#ffffff"><td align="center">Versi&oacute;n 2</td></tr>
	 <tr bgcolor="#ffffff"><td align="center">&nbsp;&nbsp;</td></tr>
      </table>
   </td>
</tr>
<tr><td colspan=3>&nbsp;&nbsp;</td></tr>
<?php
 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
  mysql_select_db("apolonia");

  $q="select * from Pacientes where Cedula=$pac";
  $qry=mysql_query($q);
  if(empty($qry))
    {
       $nombre="No existe";
    }
      else
         {
	    $reg=mysql_fetch_object($qry);
	    $nombre = $reg->Nombre;
	    $seguro = $reg->Seguro;
	 }

  echo "<tr><td>Nombre</td><td>$nombre</td><td align='right'>C.I. $pac</td></tr>";
  $hoy=Date("d-M-Y");

  echo "<tr><td>Seguro: $seguro</td><td colspan=2 align='right'>Fecha: $hoy</td></tr>";
  echo "</table>";

  echo "<table border=1 width=740>";
  echo "<tr>";
  echo "  <th>Tratamiento</th>";
  echo "  <th>Cant.Ord.</th>";
  echo "  <th>Valor Ord.</th>";
  echo "  <th>Lab. Cant</th>";
  echo "  <th>Lab. Valor</th>";
  echo "  <th>Total prestaci&oacute;n</th>";
  echo "</tr>";

  $valorT = 110;
  $q = "select Valor from Ordenes where id='T'";
  $qry = mysql_query($q);
  $reg = mysql_fetch_object($qry);
  $valorT = $reg->Valor + 0;

    $guita = valorT;

    $valorI = 110;
    $q = "select Valor from Ordenes where id='A'";
    $qry = mysql_query($q);
    $reg = mysql_fetch_object($qry);
    $valorI = $reg->Valor + 0;

    $guita = $guita + $valorI;

       echo "<tr><td>Orden de ingreso</td>";
       echo " <td align=right>1</td>";
       echo " <td align=right>";
       echo number_format($valorI, 2);
       echo "</td>";
       echo " <td align=right>&nbsp;</td>";
       echo " <td align=right>&nbsp;</td>";
       echo " <td align=right>";
       echo number_format($valorI, 2);
       echo "</td>";
       echo "</tr>";


  $q="select Pieza, Procedimiento, Procedimientos.Nombre, Procedimientos.Ordenes, Procedimientos.TipoOrden, Procedimientos.ImporteTaller, BaseMucam from ParaHacer, Procedimientos where ParaHacer.Paciente=$pac and ParaHacer.Procedimiento = Procedimientos.Codigo order by Pieza, Procedimiento";

  $qry = mysql_query($q);

  while($reg=mysql_fetch_object($qry))
    { 

       $basemucam = $reg->BaseMucam;

       $q = "select * from Ordenes where codigoExterno = $basemucam"; 
       $valqry = mysql_query($q);
       $regval = mysql_fetch_object($valqry);

       $pieza  = $reg->Pieza + 0;
       $nombre = $reg->Nombre;
       $valor  = $regval->Valor + 0;
       $cantor = $reg->Ordenes + 0;
       $taller = $reg->ImporteTaller + 0;

       if($cantor==0)
          $valor = 0;
       if($taller == 0)
          $xvalorT = 0;
       else
          $xvalorT = $valorT;

       $total = $cantor * $valor + $taller * $valorT;

       $guita = $guita + $total;

       $xtotal = sprintf("%5.2f",total); 

       echo "<tr><td>En pieza $pieza $nombre</td>";
       echo " <td align=right>$cantor</td>";
       echo " <td align=right>";
       echo number_format($valor, 2);
       echo "</td>";
       echo " <td align=right>$taller</td>";
       echo " <td align=right>";
       echo number_format($xvalorT, 2);
       echo "</td>";
       echo " <td align=right>";
       echo number_format($total, 2);
       echo "</td>";
       echo "</tr>";
    }
  echo "<tr>";
  echo "<tr><td align='right' colspan=5>Total</td>";
  echo " <td align=right>";
  echo number_format($guita, 2);
  echo "</td>";
  echo "</tr>";

  echo "  <td colspan=6>";
  echo "  <b>PRESUPUESTO SUJETO A VARIACIONES(SEG&Uacute;N PRECIO DE LAS ORDENES)</b><br><br>";
  echo "<font size='1'>APARATOS REMOVIBLES.<br>";
  echo "Si por incumplimiento del paciente a sus citas, la prestaci&oacute;n realizada por el CADI no puede ser modificada ni adaptada, el paciente deber&aacute; hacerse cargo de los gastos incurridos por CADI.<br>";
  echo "El paciente deber&aacute; abonar el aparato por segunda vez cuando se trate de perdida, rotura y/o modificaci&oacute;n.<br>";
  echo "SE CONSIDERA RESPONSABILIDAD DEL PACIENTE EL CUMPLIMIENTO DE LAS CITAS ACORDADAS<br><br>";
  echo "NO SE COLOCA NINGUNA PRESTACI&Oacute;N SIN HABER SIDO SALDADO EL COSTO TOTAL DEL TRABAJO</font><br>";
  echo "<font size=2><b>EL PRESENTE PRESUPUESTO ESTA SUJETO A MODIFICACIONES POR VARIACIONES EN EL TRATAMIENTO</b></font>"; 
  echo "  </td>";
  echo "</tr>";
  echo "</table>";
  mysql_close();
?>
</table>
<script languaje='jacascript'> window.print(); </script>
</body>
</html>

