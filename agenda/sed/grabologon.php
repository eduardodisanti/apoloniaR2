<?php
   function grabo_logoff($usuario)
    {
      $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
       mysql_select_db("apolonia");
        $hoy=date("Y-m-d");
        $query="select * from Marquitas where Funcionario=$usuario and Fecha='$hoy' order by Hora";

        $hora=date("H:i").":00";
        $result=mysql_query($query);
        $reg=mysql_fetch_object($result);
        $entrada = $reg->Entrada;
        $salida = $reg->Salida;
        if(empty($entrada))
         {
          echo "<h3>Atencion, el dia <b>$hoy</b> no tiene entrada <b> se registro su salida a la hora $hora</b></h3><br>";
         }
        else
          {
           echo "<h3>Adios, su salida hoy fue $hora, y su entrada $entrada</h3>";
          }
       mysql_query("insert into Marquitas values ($usuario,'$hora','$hoy')");
       mysql_close();
 
    }
   function grabo_login($usuario)
     {
        $hoy=date("Y-m-d");
        $query="select * from Marquitas where Funcionario=$usuario and Fecha='$hoy' order by Hora";

        $hora=date("H:i").":00";
        $result=mysql_query($query);
        $reg=mysql_fetch_object($result);
        $entrada = $reg->Entrada;
        if(empty($entrada))
         {
          mysql_query("insert into Marquitas values ($usuario,'$hora','$hoy')");
          echo "<h3>Registrado el primer ingreso del dia <b>$hoy</b> a la hora <b>$hora</b></h3><br>";
         }
        else
          {
            echo "<h3>Bienvenido nuevamente, su entrada de hoy fue $entrada</h3>";
          }

     }
?>
