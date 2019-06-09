<?php
function date_diff($date2, $date1)
  {
      $s = strtotime($date2) - strtotime($date1);
      $d = intval($s/86400);
      return($d);
  }
if(empty($cmd))
  $cmd=bajar;

require("../functions/db.php");
$link=conectar();


$bocas = 0;
$cantproc = 0;

$query="select distinct(Paciente), Fecha from Episodios where Procedimiento=681 or Procedimiento = 682 or Procedimiento=690 order by Fecha";
$q = query($query);

echo mysql_error();

while($reg = fetch($q))
{
   $pac         = $reg->Paciente;
   $fechaHasta  = $reg->Fecha;

   $pacant=$pac;
   $query = "select * from Episodios where Paciente = $pac and Fecha<='$fechaHasta'";

   $qproc = query($query);

   $error = mysql_error();
   if(!empty($error))
      die($error);
   while($regproc = fetch($qproc))
      {
         $proc = $regproc->Procedimiento;

	 if($proc == 688 ||
	    $proc == 202 ||
	    $proc == 150 ||
	    $proc == 203 ||
	    $proc == 630 ||
	    $proc == 687 ||
	    $proc == 204 ||
	    $proc == 205 ||
	    $proc == 207 ||
	    $proc == 673 ||
	    $proc == 208 ||
	    $proc == 151 ||
	    $proc == 152 ||
	    $proc == 674 ||
	    $proc == 718 ||
	    $proc == 101 ||
	    $proc == 5005 ||
	    $proc == 5002 ||
	    $proc == 5003 ||
	    $proc == 210 ||
	    $proc == 153 ||
	    $proc == 211 || 
	    $proc == 717 ||
	    $proc == 716 ||
	    $proc == 671 ||
	    $proc == 104 ||
	    $proc == 672 ||
	    $proc == 105 ||
	    $proc == 102 ||
	    $proc == 103 ||
	    $proc == 689 ||
	    $proc == 685 ||
	    $proc == 107 ||
	    $proc == 106 ||
	    $proc == 212 ||
	    $proc == 213 ||
	    $proc == 686 ||
	    $proc == 108 ||
            $proc == 218 ||
	    $proc == 217)
	      {
	        if($pacant!=$pacact)
		 {
	            $bocas++;
                    $pacact=$regproc->Paciente;
		    $pacant = $pacact;
		 }
		$cantproc++;
		$x = $procs[$proc];
		if(empty($x))
		  $procs[$proc]=0;

		$procs[$proc]++;
	      }
      }
}


echo "<center><h4>Promedio de altas con procedimientos que requierern laboratorio</h4></center><hr>";
$query="select distinct(Paciente), Fecha from Episodios where Procedimiento=681 or Procedimiento = 682 or Procedimiento=690 order by Fecha";

echo "Pacientes que requirieron laboratorios      : <b>$bocas</b>\n";
echo "Procedimientos que requirieron laboratorios : <b>$cantproc</b>\n";
echo "<table>";
echo "<tr bgcolor='#cccccc'>";
echo "  <th colspan=2>Paciente</th>";
echo "  <th>Procedimiento</th>";
echo "  <th>Cantidad</th>";
echo "</tr>\n";

for($i=0;$i<10000;$i++)
 {
      if(!empty($procs[$i]))
         {
	    $query = "select * from Procedimientos where Codigo=$i";
	    $npr = query($query);
	    $nreg = fetch($npr);
	    $nombre = $nreg->Nombre;
	    echo "<tr><td>$nombre</td><td align=right>$procs[$i]</td></tr>";
	 }
 }
echo "</table>";

?>

<center><a href='javascript:window.print()'>Imprimir</a></center>
