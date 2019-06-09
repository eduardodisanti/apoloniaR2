<?php 
function estaEnPlanLab($ci)
{
	$po=mysql_query("select * from PlanLabPac where Paciente=$ci");
	$reg=mysql_fetch_object($po);

         if(empty($reg))
	    return(false);
	 else
	    return(true);
}

function esMedicoDeLab($medico)
{
        $po=mysql_query("select * from Medicos where Numero=$medico and Especialidad=16");
        $reg=mysql_fetch_object($po);

        if(empty($reg))
             return(false);
        else
             return(true);
}

?>
