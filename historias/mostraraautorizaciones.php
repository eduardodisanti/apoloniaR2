<?php
require_once("../functions/fechahora.php");
require_once("../functions/db.php");

conectar();

$hoy = Date("Y-m-d");
  
   $q = "select Fecha, Turno, count(*) as cantidad from Horarios where  Medico = $medico and Fecha > '$hoy' and Numero >= 200 and Numero <=299 group by Fecha, Turno order by Fecha, Turno";

   $query = query($q);

   echo "<table border=0 width=95% bgcolor='#000000'>";
   echo "<tr><th colspan=3  bgcolor='#fcfcfc'>Autorizaciones</th></tr>";
   echo "<tr>";
   echo "<th bgcolor='#fcfcfc'>Fecha</th><th bgcolor='#fcfcfc'>Turno</th><th bgcolor='#fcfcfc'>Cantidad</th>";
   echo "</tr>\n";
   $count = 0;
   while($reg = fetch($query))
   {
     $fecha = $reg->Fecha;
     $turno = $reg->Turno;
     $cant  = $reg->cantidad;

     if($count==0)
       $color="#ffffff";
     else
       $color="#cccccc";

     echo "<tr><td bgcolor='$color'>$fecha</td><td bgcolor='$color'>$turno</td><td bgcolor='$color'>$cant</td></tr>";
     $count++;
     if($count==2)
        $count=0;
   }
   echo "</table>";
desconectar();
?>