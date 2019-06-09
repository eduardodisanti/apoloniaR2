<?
   $link=mysql_connect("127.0.0.1","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");

   mysql_select_db("apolonia"); 
           $codigo = 0 + $xcodigo;

           switch ($codigo)
            {
               case 33001: $tipord="A"; break;
               case 33002: $tipord="B"; break;
               case 33003: $tipord="C"; break;
               case 33004: $tipord="D"; break;
               case 33005: $tipord="E"; break;
               case 33007: $tipord="F"; break;
               case 33009: $tipord="G"; break;
               case 33014: $tipord="H"; break;
            }
           $procedimiento=0;
           if($estado=="c")
                $tipomov="H";
            else
                $tipomov="D";
           $importe = $monto / 100;
           $q = mysql_query("insert into CuentaCorriente values($matricula,'$fecha','$hora',$procedimiento,'$tipomov',$importe,'$tipord','N')");
           $err=mysql_error();
              if(!empty($err))
                      echo "$err $hora\n";
    }

   mysql_close($link);
?>
