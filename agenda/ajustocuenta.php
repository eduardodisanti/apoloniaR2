<?php
 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");


 $q="select * from Horarios where Fecha > '2002-11-25'";
 $query=mysql_query($q);

 while($reg=mysql_fetch_object($query))
   {
      $fecha=$reg->Fecha;
      $turno=$reg->Turno;
      $consultorio=$reg->Consultorio;
      $Proc=$reg->Procedimiento;

      $qcp="select Cantidad from CuentaProc where fecha='$fecha' and consultorio='$consultorio' and turno=$turno and Procedimiento=$Proc";

      $querycp=mysql_query($qcp);
      $err=mysql_error();
      if(!empty($err))
         die("Err#1 $err en $qcp\n");

      $c=mysql_fetch_object($querycp);
      if(empty($c))
        {
           echo ".";
           mysql_query("insert into CuentaProc values('$fecha','$consultorio',$turno,$Proc,0)");
           $err=mysql_error();
           if(!empty($err))
               echo "Error 2 :$err\n";

           $Cant=0;
        } else
              $Cant=$c->Cantidad;

      $Cant=$Cant + 1;

      $ff=mysql_query("update CuentaProc set Cantidad=$Cant where fecha='$fecha' and consultorio ='$consultorio' and turno=$turno and Procedimiento=$Proc");
      $err=mysql_error();
      if(!empty($err))
         echo "Error $err\n";
   }
 mysql_close();
?>
