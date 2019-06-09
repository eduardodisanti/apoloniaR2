<?php
  $db=mysql_connect("localhost","apolonia","virgen");
  mysql_select_db("apolonia");

if(empty($anterior))
    $anterior=0;

if($comando=="borrar")
   borrar($pac, $pieza, $proc);

  $query="select Seguro,Cedula, Pacientes.Nombre as nom, Seguros.Nombre as segn, Seguros.Paga as Paga from Pacientes,Seguros where Cedula > $anterior and Seguros.Paga = 'S' and Numero = Pacientes.Seguro order by Cedula limit 1";
  $q = mysql_query($query);
  $nr = mysql_num_rows($q);

 while($reg=mysql_fetch_object($q))
 {
     $seg = $reg->Seguro;
     $ced = $reg->Cedula;
     $nom = $reg->nom;
     $paga= $reg->Paga;

     $query="select Paciente,Pieza, Procedimiento, Nombre from ParaHacer, Procedimientos  where Paciente=$ced and Procedimiento = Codigo";

  $qq = mysql_query($query);
  $cuenta = mysql_num_rows($qq);
    echo "$ced $seg $nom <a href='manph.php?anterior=$ced'>Siguiente</a><hr>";
    while($rr = mysql_fetch_object($qq))
    {
     $nproc = $rr->Nombre;
     $pieza = $rr->Pieza;
     $trasa = $ced - 1;
     $proc  = $rr->Procedimiento;

     echo "$nproc en $pieza <a href='manph.php?anterior=$trasa&comando=borrar&pac=$ced&pieza=$pieza&proc=$proc'>Borrar</a><br>";	
 }
}

mysql_close();

function borrar($pac, $pieza, $proc)
{
  $bq = "delete from ParaHacer where Paciente=$pac and Pieza = $pieza and Procedimiento = $proc"; 
  //mysql_query($bq);
  echo "NO Borrado correctamente<br>";
}

?>
