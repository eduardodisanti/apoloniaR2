<?php

    $query=mysql_query("select * from Faltas where Paciente=$ci");
    if(!empty($query))
       {
            $FechaHoy=date('Y-m-d');
            $rowi=mysql_fetch_object($query);
            if($rowi->SuspendidoHasta > '0000-00-00' and $rowi->EnFecha < $FechaHoy and $FechaHoy <= $rowi->SuspendidoHasta)
               {
                  $mensaje="<h3>Paciente suspendido en $rowi->EnFecha hasta $rowi->SuspendidoHasta hoy es $FechaHoy</h3>";
                  if($coinivelusuario >= 3)
                     echo "$mensaje";
                  else
                     die("$mensaje");
               }
       }
?>
