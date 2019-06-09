<?php
require_once("DB.php");

session_start();

$dsn =   "mysql://apolonia:virgen@elias/apolonia";
$conn = DB::connect($dsn);
$conn->setFetchMode(DB_FETCHMODE_OBJECT);

if(empty($fdesde))
    $fdesde="2005-01-01";
if(empty($fhasta))
    $fhasta=date("Y-m-d");

$queryP = "select distinct Paciente from Horarios, Consultorios where Fecha >= '$fdesde' and Fecha <= '$fhasta' and Sucursal='CENTRAL' and Paciente !=0";
$q = $conn->query($queryP);

$nomigraron = 0;

while($principal=$q->fetchRow())  // *** mientras hayan pacientes
{

     $pac = $principal->Paciente;

     $query1 = "select Sucursal, count(Paciente) as cant from Horarios, Consultorios where Paciente=$pac and Fecha >= '1997-01-01' and Fecha <= '$fhasta' and Consultorios.Codigo = Horarios.Consultorio group by Sucursal";

     $central  = 0;
     $sucursal = 0;

     $q1 = $conn->query($query1);
     while($qcent = $q1->fetchRow())
       {
         $suc = $qcent->Sucursal;
	 $can = $qcent->cant;

	 if($suc=="CENTRAL")
	    ++$central;
	 else
	    ++$sucursal;

	 if($central<=1)
              $migraron[$suc]++;
	 if($sucursal==0)
	    $nomigraron++;
	 if($central >= $sucursal)
	    $hibridosCentral[$suc]++;
	 if($central < $sucursal)
	    $hibridosSucursal[$suc]++;
       }
}

echo "Per&iacute;odo $fdesde y $fhasta<br>\n";
echo "<table border=1 width='90%'>\n";
echo "<tr><th colspan=2>Pacientes que migraron completamente</th></tr>\n";
echo "<tr><th>A sucursal</th><th>Cantidad</th></tr>\n";
reset( $migraron );
while( list( $suc, $cant ) = each( $migraron ) ) 
{
  if($suc != "CENTRAL")
    echo "<tr><td>$suc</td><td>$cant</td></tr>\n";
}
echo "<tr><td colspan=2>&nbsp;</td></tr>\n";
echo "<tr><th colspan=2>Pacientes que migraron pero se atienden mayormente en central</th></tr>\n";

reset( $hibridosCentral);
while( list( $suc, $cant ) = each( $hibridosCentral ) )
{
  if($suc != "CENTRAL")
      echo "<tr><td>$suc</td><td>$cant</td></tr>\n";
}

echo "<tr><td colspan=2>&nbsp;</td></tr>\n";
echo "<tr><th colspan=2>Pacientes que migraron pero se atienden mayormente en sucursales</th></tr>\n";

reset( $hibridosSucursal);
while( list( $suc, $cant ) = each( $hibridosSucursal ) )
{
  if($suc != "CENTRAL")
        echo "<tr><td>$suc</td><td>$cant</td></tr>\n";
}
echo "</table>\n";
?>
