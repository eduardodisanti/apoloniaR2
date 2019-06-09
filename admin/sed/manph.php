<?php
  $db=mysql_connect("localhost","apolonia","virgen");
  mysql_select_db("apolonia");

if(empty($anterior))
    $anterior=0;

if($comando=="borrar")
   borrar($pac, $pieza, $proc);

if($comando=="buscar")
  {
  $anterior = $pac - 1;
  }

   $query = "select Paciente, Cedula, Pacientes.Nombre as nom from ParaHacer,Pacientes,Seguros where Paciente > $anterior and Paciente = Cedula and Seguros.Numero = Pacientes.Seguro and Seguros.Paga = 'S' limit 1";

//  $query="select Seguro,Cedula, Pacientes.Nombre as nom, Seguros.Nombre as segn, Seguros.Paga as Paga from Pacientes,Seguros where Cedula > $anterior and Seguros.Paga = 'S' and Numero = Pacientes.Seguro order by Cedula limit 1";
  $q = mysql_query($query);

  echo mysql_error();
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
  echo "<form action='manph.php' method='post'>";
  echo "Buscar cedula : <input type='text' name='pac' value='$anterior' size=9> <input type='submit' name='comando' value='buscar'>";
  echo "</form>";
  echo " <a href='../historias/conshist.php?paciente=$ced' target='_blank'>Ver historia </a>";
  echo "<b>$ced</b> $nom (Seg.:$seg) <a href='manph.php?anterior=$ced'>Siguiente</a><hr>";

echo "<table border=0 width=90%>";
echo "<tr>";
echo "<td width='35%'>";
  echo "<table border=0 bgcolor='#000000'>";
  echo "<tr bgcolor='#cccccc'><th>Procedimiento</th><th>Pieza</th><th>&nbsp;&nbsp;</th></tr>";
    while($rr = mysql_fetch_object($qq))
    {
     $nproc = $rr->Nombre;
     $pieza = $rr->Pieza;
     $trasa = $ced - 1;
     $proc  = $rr->Procedimiento;

     echo "<tr bgcolor='#ffffff'><td>$nproc</td><td>$pieza</td><td><a href='manph.php?anterior=$trasa&comando=borrar&pac=$ced&pieza=$pieza&proc=$proc'>Borrar</a></td></tr>";	
    }
   echo "</table>";
echo "</td>";
echo "<td>";
   echo " <iframe src='../ctacte/viscta.php?ced=$ced' width='100%'></iframe>";
echo "</td>";
echo "</tr>";
echo "</table>";
}

mysql_close();

function borrar($pac, $pieza, $proc)
{
  $bq = "delete from ParaHacer where Paciente=$pac and Pieza = $pieza and Procedimiento = $proc"; 
  mysql_query($bq);
  $err = mysql_error();
  if(empty($err))
     echo "Borrado correctamente<br>";
  else
     echo "Error borrando, anotar $error<br>";
}

?>
