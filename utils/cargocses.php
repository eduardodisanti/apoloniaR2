<?php

   $link=mysql_connect("elias","root","virgen") or die("Error, la base de datos no acepto la coneccion");

   mysql_select_db("apolonia"); 

    $aadesde = Date("Y");
    $mmdesde = Date("m") - 4;
    $dddesde = Date("d");

    if($mmdesde < 1)
     {
        $mmdesde = 12 + $mmdesde;
        $aadesde = $aadesde - 1;
     }

     $mmhasta = Date("m");
     $aahasta = Date("Y");

     $fdesde = "$aadesde-$mmdesde-$dddesde";
     $fhasta = "$aahasta-$mmhasta-$dddesde";

mysql_query("delete from CSesiones");

   $query = "select Paciente,Procedimiento,Pieza, count(*) as cuenta from Episodios where Fecha >='$fdesde' and Fecha<='$fhasta' group by Paciente,Procedimiento,Pieza";
   $q=mysql_query($query); 
   $err = mysql_error();
   if(!empty($err))
       die("Mori = $err");

   echo "$query - q es $q\n";
//   echo mysql_fetch_object($q);

   while($rowi=mysql_fetch_object($q))
    {  
        $Paciente=$rowi->Paciente;
        $Procedimiento=$rowi->Procedimiento;
        $Pieza=$rowi->Pieza;
        $cuenta=$rowi->cuenta;           

        mysql_query("insert into CSesiones values ($Paciente,$Procedimiento,$cuenta,0,'A',0,$Pieza)");
        $err = mysql_error();
        if(!empty($err))
          die("$err diente es $Pieza xxx es $xxx");
    }
   mysql_close($link);
?>
