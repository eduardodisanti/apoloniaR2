<?php


$link=mysql_connect("elias","root","virgen");

   mysql_select_db("apolonia");

   if(empty($seguro))
        $seguro = 253;

  if(empty($garpa))
    $garpa='S';

   $query="select * from Pacientes where Paga='$garpa' and Seguro=$seguro and Habilitado='S' order by Cedula";
   $q = mysql_query($query);

   echo "<table border=1>";
          echo "<tr>";
          echo "<th>Seguro</th>";
          echo "<th>Cedula</th>";
          echo "<th>Nombre</th>";
          echo "</tr>";

   while($reg=mysql_fetch_object($q))
       {
          echo "<tr>";
          echo "<td>$reg->Seguro</td>";
          echo "<td>$reg->Cedula</td>";
          echo "<td>$reg->Nombre</td>";
          echo "</tr>";
       }
  echo "</table>";
?>
