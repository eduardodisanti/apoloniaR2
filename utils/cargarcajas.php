<?php
function date_diff($date2, $date1)
  {
      $s = strtotime($date2) - strtotime($date1);
      $d = intval($s/86400);
      return($d);
  }

  $link=mysql_connect("elias","root","virgen") or die("Error, la base de datos no acepto la coneccion");

   mysql_select_db("apolonia"); 
   $fp=fopen("ftp://cadi:CaDiMuCaM@130.100.1.10/sistemas/cajas/histcoi.dat","r");
   while(!feof($fp))
    {
       $hoy = date("Y-m-d");
       $reg=fgets($fp,65536);
       $fecha=substr($reg,0,8);
       $fechalim = date("Y-m-d", strtotime("-1 day ".$hoy));
       if(!empty($reg) && date_diff($fechalim, $fecha) < 1)
         {
           $fecha=substr($reg,0,8);
           $hora =substr($reg,8,8);
           $matricula=substr($reg,16,7);
           $monto=substr($reg,23,8);
           $estado=substr($reg,31,1);
           $origen=substr($reg,32,3);
           $xcodigo=substr($reg,35,16);

           $codigo = 0 + $xcodigo;
//     echo "$fecha - $hora - $matricula - $monto - $estado - $origen - $codigo\n";
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

           $q = mysql_query("select Fecha,Procedimiento,Pieza from CuentaCorriente where Paciente=$matricula and TipoOrden='$tipord' and EnProceso='S'");
           $reg=mysql_fetch_object($q);
           $procedimiento=$reg->Procedimiento;
           if(empty($procedimiento))
              $procedimiento = 0;

           $pieza=$reg->Pieza;
           if(empty($pieza))
               $pieza=999;

	   $qu="insert into CuentaCorriente values($matricula,'$fecha','$hora', $pieza, $procedimiento,'$tipomov', 1,'$tipord',' ')\n";

           echo $qu;
           //$q = mysql_query($qu);
           /* $err=mysql_error();
              if(!empty($err))
                      echo "$err $hora\n";
            */
         }
    }

   mysql_close($link);

?>

