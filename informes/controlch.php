<?php
     $link=mysql_connect("elias","apolonia","virgen");
     $db = mysql_select_db("apolonia");

   $q="select Paciente, Nombre, Fecha, count(*) as cuenta, Consultorio from Horarios, Pacientes where Fecha >= '$fechadesde' and Fecha <= '$fechahasta' and Vino='S' and Paciente != 0 and Paciente = Cedula and Consultorio >= '$cons1' and Consultorio <= '$cons2' group by Paciente,Consultorio, Fecha";

   echo "<table border=1 cellspacing='1' width=100%>\n";
   echo "<tr><th>Cons</th><th>pac</th><th>nombre</th><th>asistencias</th><th>episodios</th></tr>\n";

   $query=mysql_query($q);
   $error = mysql_error();
   if(!empty($error))
     die($error);

   $mal = 0;

   while($reg=mysql_fetch_object($query))
    {
       $cuenta = $reg->cuenta;
       $pac    = $reg->Paciente;
       $fecha  = $reg->Fecha;
       $nombre = $reg->Nombre;
       $cons   = $reg->Consultorio;

       $qq = "select count(*) as cuenta from Episodios where Fecha = '$fecha' and Paciente=$pac"; 

       $query2 = mysql_query($qq);
       $reg2 = mysql_fetch_object($query2);
       $episodios = $reg2->cuenta;

       if(empty($episodios))
           $episodios = 0; 
       if($episodios < $cuenta)
         {
          if(!empty($desglose))
             echo "<tr bgcolor='#cccccc'><td>$cons</td><td>$pac</td><td>$nombre</td><td>$cuenta</td><td>$episodios</td></tr>\n";
             $epiq="select Fecha, Procedimientos.Nombre as pn, Medicos.Nombre as mn from Horarios,Procedimientos,Medicos where Paciente=$pac and Horarios.Medico = Medicos.Numero and Fecha ='$fecha' and Procedimiento=Codigo";
             $qepi=mysql_query($epiq);
             while($regep=mysql_fetch_object($qepi))
               {
                   $efe=$regep->Fecha;
                   $eno=$regep->pn;
                   $eme=$regep->mn;
                   echo "<tr><td>$efe</td><td>$eme</td><td colspan=3>$eno</td></tr>"; 
               }
          $mal++;
         }
    }

    echo "</table>\n";
    echo "<hr>Total de incongruencias : $mal";
      mysql_close();
?>
<hr>
<button onclick="javascript:history.back()">Volver</button>


