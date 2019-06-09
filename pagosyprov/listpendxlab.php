<?php

     if(empty($FECHADESDE))
          $FECHADESDE=Date("Y-m-d");
     if(empty($FECHAHASTA))
        $FECHAHASTA = Date("Y-m-d");

     echo "<center><h5>Listado de trabajos pendientes</h5></center><hr>";

     $link=mysql_connect("elias","apolonia","virgen");
     $db = mysql_select_db("apolonia");


     if(empty($lab))
             $lab = 22;

     $q="select Fecha, Trabajos.descripcion as descripcion from TrabSoc, Trabajos where Entregado < 8 and TrabSoc.Laboratorio = $lab and TrabSoc.Laboratorio = Trabajos.id";

     $query=mysql_query($q);
     mysql_error();

     echo $q;
     echo "<table border=0 bgcolor='#000000' width='95%'>";
     echo "<tr bgcolor='#cccccc'>";
     echo "	<th>Fecha inicio</th><th colspan=2>Trabajo</th>";
     echo "</tr>";
     while($reg=mysql_fetch_object($query))
      {
          $fecha=$reg->Fecha;
          $nom=$reg->descripcion;
          
      }
     echo "</table>";
     mysql_close($link);
?>
<hr>
<center>
<table border=0 bgcolor='#000000' cellspacing='5' cellpadding='5'>
<tr>
<td>
	<a href='javascript:window.print()'><font color='#ffffff'>Imprimir</font></a>
</td>
<td>
	<a href='javascript:window.close()'><font color='#ffffff'>Cerrar</font></a>
</td>
</tr>
</table>
</center>
