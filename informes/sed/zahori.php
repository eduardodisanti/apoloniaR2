<?php
require_once("DB.php");

session_start();

$dsn =   "mysql://apolonia:virgen@elias/apolonia";
$conn = DB::connect($dsn);
$conn->setFetchMode(DB_FETCHMODE_OBJECT);

if(empty($fdesde))
    $fdesde="2005-06-01";
if(empty($fhasta))
    $fhasta=date("2005-08-31");

echo "<center><h3>Trabajos enviados a Zahori entre $fdesde y $fhasta que no han sido entregados por Zahori</h3></center>";

// ** ver todos los meta trabajos entre fechas **

$query = " select Paciente, Nombre, MetaTrabajos.descripcion, Fecha, Episodios.Procedimiento from MetaTrabajos, Episodios, Pacientes, MetaTrabProc where Episodios.Paciente = Pacientes.Cedula and MetaTrabajos.id = MetaTrabProc.Meta and MetaTrabProc.Procedimiento = Episodios.Procedimiento and Fecha >='$fdesde' and Fecha <= '$fhasta' group by Paciente order by Fecha, Paciente";

$hand1 = $conn->query($query);
echo mysql_error();

echo "<table border=0 bgcolor='#000000'>";
echo "<tr bgcolor='#cccccc''><th colspan=2>Paciente</th><th>Trabajo</th><th>Fecha pedido</th><th>Vencimiento</th></tr>";

$cant = 0;
$fechaAnt='';
while($principal = $hand1->fetchRow())
{
   $fecha = $principal->Fecha;
   $vence = $fecha + 14;

   $vence = date("Y-m-d", strtotime("+14 day ".$fecha));

   $pac = $principal->Paciente;
   $proc= $principal->Procedimiento;

  $pendiente = TRUE;

// Si no esta en el parahacer entonces esta terminado

   $phq = "select Paciente, Meta from ParaHacer, MetaTrabProc where Paciente=$pac and MetaTrabProc.Procedimiento = ParaHacer.Procedimiento and ParaHacer.Procedimiento = $proc";

   $queryPHQ = $conn->query($phq);

   echo mysql_error();
   $regPHQ   = $queryPHQ->fetchRow();

   if(empty($regPHQ->Meta))
      $pendiente=FALSE;

// * ahora me fijo si por casualidad fue entregado por zahori y alguien no marco el trabajo muy  dificil pero por las dudas

    $phq = "select count(*) as cuenta from HistTrabSoc, MetaTrabProc, MetaTrabTrab  where Paciente=$pac and Episodio >= 5 and Episodio < 88 and MetaTrabProc.Meta = MetaTrabTrab.Meta and MetaTrabTrab.Trabajo = HistTrabSoc.Trabajo";

    $queryPHQ = $conn->query($phq);

    $entregados = $queryPHQ->cuenta;
    if($entregados > 0)
        $pendiente=FALSE;

// * Claro que si esta en proceso por otro laboratorio es que zahori no lo termino

   if(!$pendiente) // solo reviso si no esta pendiente pero por ahora lo dejo asi porque la evidencia es demasiado abrumadora contra zahori
     {
                        
     }

   if($pendiente)
     {
        if($fecha != $fechaANT)
	  {
	     if($color=='#ffffff')
	        $color='#ffffd0';
             else
	        $color='#ffffff';

	     $fechaANT=$fecha;
	  }
   	echo "<tr bgcolor='$color'>";
	echo "     <td>$pac</td>";
   	echo "     <td>$principal->Nombre</td>";
   	echo "     <td>$principal->descripcion</td>";
   	echo "     <td>$fecha</td>";
   	echo "     <td>$vence</td>";
   	echo "</tr>";

	// ** Muestro los episodios de la historia que estan asociados al proc
	$qhist = "select Fecha,Comentario,Usuarios.Usuario as nusuario from Episodios, Usuarios where Paciente=$pac and Fecha >= '$fdesde' and Fecha <= '2005-09-16' and Procedimiento = $proc and Episodios.usuario = Usuarios.funcionario order by Fecha";

        $queryQHIST = $conn->query($qhist); 
	while($regQHIST = $queryQHIST->fetchRow())
	  {
             echo "<tr bgcolor='#bbbccc'>";
	     echo "    <td align='right' colspan=1>";
	     echo          $regQHIST->Fecha;
	     echo "    </td>";
             echo "    <td colspan=2>";
	     echo          $regQHIST->Comentario;
	     echo "    </td>";
	     echo "    <td colspan=2>";
	     echo          $regQHIST->nusuario;
	     echo "    </td>";
	     echo "</tr>";
	  }
	$cant++;
     }
}
echo "</table>";
$conn->disconnect();

echo "<hr>Total de pendientes $cant";
?>
