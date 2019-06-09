<?php

   $query="select Paciente from Deudas, Pacientes, Seguros where Deudas.Paciente=Cedula and Pacientes.Seguro=Numero and Seguros.Paga='N'";

$link=mysql_connect("127.0.0.1","root","virgen") or die("Error, la base de datos no acepto la coneccion");

   mysql_select_db("apolonia");

   $q = mysql_query($query);
   while($reg=mysql_fetch_object($q))
      {
          $Paciente=$reg->Paciente;
	  mysql_query("delete from Deudas where Paciente=$Paciente");
      }

   mysql_close();
?>
