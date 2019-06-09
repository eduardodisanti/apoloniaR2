<?php
 $link=mysql_connect("elias","root","virgen") or die("Error, la base de dato
 s no acepto la coneccion");
  mysql_select_db("apolonia");

    $q = "select Fecha, Consultorio, Turno from Horarios, Medicos where Medicos.Numero = Medico and Medicos.especialidad = 6 and Fecha >='2006-11-01' and Fecha <='2006-11-31' and Paciente=0";

    $qry = mysql_query($q);
    
    while($reg=mysql_fetch_object($qry)) {
    	
    	$fecha = $reg->Fecha;
    	$cons  = $reg->Consultorio;
    	$turno = $reg->Turno;
    	
//    	die("delete from Horarios where Fecha='$fecha' and Consultorio='$cons' and Turno=$turno and Paciente=0");
    	mysql_query("delete from Horarios where Fecha='$fecha' and Consultorio='$cons' and Turno=$turno and Paciente=0");
    	
    }
