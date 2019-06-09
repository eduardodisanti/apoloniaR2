<?php 
function paga($ci)
{
	$po=mysql_query("select Seguros.Paga from Seguros,Pacientes where Cedula=$ci and Seguro=Numero");
	$reg=mysql_fetch_object($po);

	echo "select Seguro.Paga from Seguros,Pacientes where Cedula=$ci and Seguro=Numero";
	echo mysql_error();

        $paga = $reg->Paga;
        if(empty($paga))
	    $paga='S';

        return($paga);
}
?>
