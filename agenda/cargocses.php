<?php
   $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");

   mysql_select_db("apolonia"); 

   $query = "select Paciente,Procedimiento,Pieza, count(*) as cuenta from Episodios group by Paciente,Procedimiento,Pieza";
   $q=mysql_query($query); 
   $err = mysql_error();
   if(!empty($err))
       die("Mori = $err");

   echo "$query - q es $q\n";
   $rowi = mysql_fetch_object($q);

   while($rowi=mysql_fetch_object($q))
    {  
        $Paciente=$rowi->Paciente;
        $Procedimiento=$rowi->Procedimiento;
        $Pieza=$rowi->Pieza;
        $cuenta=$rowi->cuenta;           

	echo "insert into CSesiones values ($Paciente,$Procedimiento,$cuenta,0,'A',0,$Pieza)\n";

        mysql_query("insert into CSesiones values ($Paciente,$Procedimiento,$cuenta,0,'A',0,$Pieza)");
        $err = mysql_error();
        if(!empty($err))
          die("$err diente es $Pieza xxx es $xxx");
    }
   mysql_close($link);
?>
