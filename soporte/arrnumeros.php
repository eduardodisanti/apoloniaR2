<?
   $link=mysql_connect("127.0.0.1","root","virgen") or die("Error, la base de datos no acepto la coneccion");

   mysql_select_db("apolonia"); 

   $Fecha_ant="";
   $Turno_ant=0;
   $Consultorio_ant="";
   $lugar=0;
   $query="select * from Horarios where Fecha >= '2004-02-24' order by  Fecha,Consultorio,Turno,Hora";
   $q=mysql_query($query) or die("Error ".mysql_error());
   while($rowi=mysql_fetch_object($q))
    {        
        $Fecha=$rowi->Fecha;
        $Turno=$rowi->Turno;
        $Consultorio=$rowi->Consultorio;
        $Hora=$rowi->Hora;
        $medico=$rowi->Medico;           

        if($Fecha!=$Fecha_ant              ||
           $Turno!=$Turno_ant              ||
           $Consultorio!=$Consultorio_ant)
           {
              $lugar=0;
              $Fecha_ant = $Fecha;
              $Turno_ant = $Turno;
              $Consultorio_ant = $Consultorio;
           } 
       $lugar=$lugar + 1;       
       mysql_query("update Horarios set Numero=$lugar where Fecha='$Fecha' and Consultorio='$Consultorio' and Turno=$Turno and Hora='$Hora'");
       $err=mysql_error();
       if(!empty($err))
         die($err);
    }
   mysql_close($link);
?>
