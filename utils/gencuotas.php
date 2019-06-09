<?php

 $link=mysql_connect("elias","root","virgen") or die("Error, la base de dato
s no acepto la coneccion");
 mysql_select_db("apolonia");

/* *************************************************
   ** Primero genero todas las cuotas de ort.fija **
   ************************************************* */

   $q = mysql_query("select Paciente, Contrato from PlanOrtodoncia");
   echo "Hoy es ".Date("Y-m-d")."\n";
   while($reg = mysql_fetch_object($q))
    {
       $pac = $reg->Paciente;
       $con = $reg->Contrato;

       $hoy=Date("Y-m-d");
       $ahora=Date("U");
       $laorden="M";
       switch($con)
       {
           case 1:
                 $laorden="I";
                 break;
           case 2:
                 $laorden="M";
                 break;
           case 3:
                 $laorden="R";
                 break;
        }
       $qi = "insert into CuentaCorriente values($pac,'$hoy','$ahora',0,0,'D',1,'$laorden','N')";
       mysql_query($qi);
       $err = mysql_error();
       if(!empty($err))
         echo $err."\n";
    }

  mysql_close();
?>
