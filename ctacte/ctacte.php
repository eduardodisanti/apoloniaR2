<!-- BEGIN FLOATING LAYER CODE //-->
<div id="theLayer" style="position:absolute;width:400px;left:30;top:10;visibility:visible">
<table border="0" width="400" bgcolor="#424242" cellspacing="0" cellpadding="5">
<tr>
<td width="100%">
  <table border="0" width="100%" cellspacing="0" cellpadding="0" height="36">
  <tr>
  <td id="titleBar" style="cursor:move" width="100%">
  <ilayer width="100%" onSelectStart="return false">
  <layer width="100%" onMouseover="isHot=true;if (isN4) ddN4(theLayer)" onMouseout="isHot=false">
  <font face="Arial" color="#FFFFFF">Cuenta Corriente del socio</font>
  </layer>
  </ilayer>
  </td>
  <td style="cursor:hand" valign="top">
  <a href="#" onClick="hideMe();return false"><font color=#ffffff size=2 face=arial  style="text-decoration:none">X</font></a>
  </td>
  </tr>
  <tr>
  <td width="100%" bgcolor="#FFFFFF" style="padding:4px" colspan="2">
<!-- PLACE YOUR CONTENT HERE //-->
<?php
    $query=mysql_query("select * from CuentaCorriente where Paciente=$ced order by Fecha,Hora desc limit 15");

     echo "<table boder=0 bgcolor='#000000' width='100%'>";
     echo "<tr bgcolor='#cccccc'>";
     echo "<td align='center'>Fecha</td>";
     echo "<td align='center'>Hora</td>";
     echo "<td align='center'>Orden</td>";
     echo "<td align='center'>Cantidad</td>";
     echo "</tr>\n";
     while($reg=mysql_fetch_object($query))
       { 
         $fecha=$reg->Fecha;
         $hora = $reg->Hora;
         $tipmov=$reg->TipoMov;
         $impo=$reg->ImporteOrdenes;
         $tipord=$reg->TipoOrden;
         echo "<tr bgcolor='#ffffff'>"; 
         echo "<td>$fecha</td>";
         echo "<td>$hora</td>";
         echo "<td>Orden tipo $tipord</td>";
         echo "<td>$impo</td>";
         echo "</tr>\n";
       }
    echo "</table>\n";
?>
<!-- END OF CONTENT AREA //-->                                                      </td>                                                                             </tr>                                                                             </table>                                                                        </td>
</tr>
</table>
</div>
