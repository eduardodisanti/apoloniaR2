<?php

    $link=mysql_connect("elias","apolonia","virgen");
    $db=mysql_select_db("apolonia");

    $f1="$aa1-$mm1-$dd1";
    $f2="$aa2-$mm2-$dd2";
    $tquery="select * from Horarios where Medico=$medfalta and Fecha >= '$f1' and Fecha <= '$f2' and Turno >= $turno1 and Turno <= $turno2 and Consultorio='$consultorio' group by Fecha,Consultorio,Turno";

    $query=mysql_query($tquery);
    $error=mysql_error();
    if(!empty($error))
       {
          die("Error $error <br> la consulta fue $tquery"); 
       }

    echo "<table border=1>"; 
    echo "<tr><td>Fecha</td><td>Consultorio</td><td>Turno</td><td>Suple</td></tr>";
    while($reg=mysql_fetch_object($query))
       {
               $fecha=$reg->Fecha;
               $consultorio=$reg->Consultorio;
               $turno=$reg->Turno;

               $q2 = mysql_query("select Suplente, Nombre from Suplentes, Medicos where Fecha='$fecha' and Consultorio='$consultorio' and Turno=$turno and Suplente=Numero");
               $q2r = mysql_fetch_object($q2);
               $suplente = $q2r->Suplente;
               $nombre = $q2r->Nombre;
               if(empty($suplente)) {
                    //$q2 = mysql_query("delete from Suplentes where Fecha='$fecha' and Consultorio='$consultorio' and Turno=$turno");
                    $qins="insert into Suplentes values('$fecha','$consultorio',$turno,$medsuple)";
                    $q2=mysql_query($qins);
                    $error=mysql_error();
                    if(!empty($error))
                      {
                         $msg="ERR! $error";
                      }
                    else $msg="Ok";
               }
                 else
                     {
                        $msg="Atencion, existe suplente $suplente, $nombre";
			$q2 = mysql_query("delete from Suplentes where Fecha='$fecha' and Consultorio='$consultorio' and Turno=$turno");
		        $qins="insert into Suplentes values('$fecha','$consultorio',$turno,$medsuple)";
		        $q2=mysql_query($qins);
                     }
              echo "<tr><td>$fecha</td><td>$consultorio</td><td>$turno</td><td>$medsuple $msg</td></tr>";
       }
?>     
