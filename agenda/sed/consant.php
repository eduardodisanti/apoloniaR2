<html>
<head>
</head>
<BODY>

<p><center>
<?php

echo "HOLA"; 
$link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
    mysql_select_db("apolonia");


    // **** mirar si se puede anotar ****
    $FechaHoy=Date("Y-m-d");

    $query=mysql_query("select Fecha,Medico,Medicos.Nombre as ElMedico from Horarios,Medicos where Paciente=$ci and Fecha > '$FechaHoy' and Medicos.Numero = Horarios.Medico");
    if(!empty($query))
      {

        while($rowi=mysql_fetch_object($query))
         {
               echo "Tiene una cita para el día <b>$rowi->Fecha</b> con $rowi->ElMedico<br>";
         }

      }
    mysql_close();
?>
</center>
</p>

</html>
