<?php
   $link=mysql_connect("127.0.0.1","root","virgen") or die("Error, la base de datos no acepto la coneccion");

   mysql_select_db("apolonia"); 
   $fp=fopen("ftp://eduardo:VIRGEN@130.100.1.10/sistemas/cajas/histcoi.dat","r");
   while(!feof($fp))
    {
       $reg=fgets($fp,65536);
       if(!empty($reg))
         {
           $fecha=substr($reg,0,8);
           $hora =substr($reg,8,8);
           $matricula=substr($reg,16,7);
           $monto=substr($reg,23,8);
           $estado=substr($reg,31,1);
           $origen=substr($reg,32,3);
           $xcodigo=substr($reg,35,16);
	   $cajero=0;

           $codigo = 0 + $xcodigo;
           switch ($codigo)
            {
               case 33001: $tipord="A"; break;
               case 33002: $tipord="B"; break;
               case 33003: $tipord="E"; break;
               case 33004: $tipord="C"; break;
               case 33005: $tipord="D"; break;
               case 33007: $tipord="G"; break;
               case 33009: $tipord="I"; break;
               case 33010: $tipord="J"; break;
               case 33011: $tipord="K"; break;
               case 33012: $tipord="L"; break;
               case 33113: $tipord="M"; break;
               case 33013: $tipord="N"; break;
               case 33015: $tipord="3"; break;
               case 33016: $tipord="5"; break;
               case 33017: $tipord="R"; break;
               case 33018: $tipord="S"; break;
               case 33019: $tipord="U"; break;
               case 33020: $tipord="V"; break;
               case 33021: $tipord="W"; break;
               case 33022: $tipord="X"; break;

               case 33014: $tipord="T"; break;
            }
           if($estado=="c")
                $tipomov="H";
            else
                $tipomov="D";
           $importe = $monto / 100;

           $existe = 0;
	   $qqqe = "select * from OrdSoc where Fecha='$fecha' and Hora='$hora' and Paciente=$matricula and TipoOrden='$tipord' and Confirmada='N'";
           $qe = mysql_query($qqqe);

           mysql_num_rows($qe);

	   if($rows==0)
	     {
              $q = mysql_query("insert into OrdSoc values($matricula,'$tipord', '$fecha','$hora', $cajero,  0, 'S', 'N')");
	     }
	   else
	     {
	      $q = mysql_query("update OrdSoc set Confirmada='S' where Fecha='$fecha' and Hora = '$hora' and Paciente=$matricula and TipoOrden='$tipord'");
             }
           $error = mysql_error();
	   if(!empty($error))
	         echo $error."\n";
        }
    }

   mysql_close($link);

?>

