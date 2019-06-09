<?php


$link=mysql_connect("elias","root","virgen") or die("Error, la base de datos no acepto la coneccion");

   mysql_select_db("apolonia");

/*   $query="select * from Horarios group by Paciente order by Fecha";
   $q = mysql_query($query);
   while($reg=mysql_fetch_object($q))
       {
          $pac = $reg->Paciente;
          $fec = $reg->Fecha;
            
          mysql_query("update Diagnosticos set Fecha='$fec' where Paciente=$pac");
       }
*/
   $query="select * from Episodios group by Paciente, Pieza order by Fecha";
   $q = mysql_query($query);
   while($reg=mysql_fetch_object($q))
       {
          $pac = $reg->Paciente;
          $pie = $reg->Pieza;
          $proc = $reg->Procedimiento;
            
          mysql_query("update Diagnosticos set Diagnostico=$roc where Paciente=$pac and Pieza=$pie");
       }    
   mysql_close();
?>
