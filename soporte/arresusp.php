<?php
 $link=mysql_connect("127.0.0.1","root","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");


 $q=mysql_query("select * from Faltas");
 while($rowi=mysql_fetch_object($q))
   {
     $enfecha=$rowi->EnFecha;
     $pac=$rowi->paciente;

     $anio=strtok($enfecha,"-");
     $mes=strtok("-");
     $dia=strtok("-");

     $mes=$mes + 1;
     if($mes > 12)
       {
              $mes= 1;
              $anio = $anio + 1;
       }

     $susp="$anio-$mes-$dia";
     mysql_query("update Faltas set SuspendidoHasta='$susp' where paciente=$pac") or die("error ".mysql_query());
   }
 mysql_close();
?>
