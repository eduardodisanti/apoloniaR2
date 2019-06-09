<?
   $link=mysql_connect("127.0.0.1","root","virgen") or die("Error, la base de datos no acepto la coneccion");

   $db = mysql_select_db("apolonia"); 

   $fechahoy = Date("Y-m-d");
   $yy = strtok($fechahoy,"-");
   $mm = strtok("-");
   $dd = strtok("-");
   $dd = $dd - 1;
   if($dd < 1)
     {
         $mm = $mm - 1;
         if($mm < 1)
           {
             $mm = 12;
             $yy = $yy - 1;
           }
         if($mm == 1  || $mm == 3 || $mm == 5 || $mm == 7 || $mm == 8 || $mm == 10  || $mm == 12)
            $dd = 31;
         else
             if($mm==2)
                $dd=28;
             else
                 $dd=30;
     }

   $fechaayer = "$yy-$mm-$dd";
   $q = mysql_query("select * from Horarios where Fecha = '$fechaayer' and Procedimiento=500 and Vino='N' and Paciente != 0");
   while($reg=mysql_fetch_object($q))
     {
        $pac = $reg->Paciente;
        $dq = "update Horarios set Procedimiento=0, Paciente=0 where Paciente=$pac and Fecha >= '$fechahoy'\n";
        $hora=strtotime("now");
        $insertp = "insert into Episodios values($pac,'$fechahoy',0,2,'$hora','Falta a RX'";
        mysql_query($insertp);
        //mysql_query($dq);
     }

   mysql_close($link);
?>
