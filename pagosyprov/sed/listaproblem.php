<?
 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");

  $fecha1 = "2004-08-01";
  $fecha2 = "2004-09-31";

 $q = "select Fecha,Consultorio,Turno,Medico from Horarios where Fecha >= '$fecha1' and Fecha <= '$fecha2' group by Fecha,Consultorio,Turno order by Fecha,Consultorio,Turno";

  $medico_ant = 0;
  $fecha_ant = "";
  $consultorio_ant = "";
  $turno_ant = 0;
  $cuenta = 0;

 $query = mysql_query($q);
 while($reg=mysql_fetch_object($query))
   {
      $medico = $reg->Medico;
      $consultorio = $reg->Consultorio;
      $turno = $reg->Turno;
      $fecha = $reg->Fecha;

      if(
        ($turno  != $turno_ant)  ||
        ($consultorio != $consultorio_ant) || 
        ($fecha  != $fecha_ant))
         { 
            if($cuenta > 1)
              {
                 echo "Error:|$medico_ant|$consultorio_ant|$fecha_ant|$turno_ant|\n";
              }   
	    $cuenta = 1;
    	    $medico_ant = $medico;
	    $fecha_ant = $fecha;
	    $consultorio_ant = $consultorio;
	    $turno_ant = $turno;
         }
          else $cuenta++;
   } 
 mysql_close();
?>
