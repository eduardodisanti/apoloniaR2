<?php 

function tipoContrato($tipo) 
{
   switch($tipo)
     {
         case 1 :
           $laorden="I";
         break;
         case 2 :
           $laorden="M";
         break;
         case 3 :
           $laorden="R";
         break;
     } 
   return($laorden);
}

function deudaOrtFija($ci) 
{
   $deuda=0;
   $of = mysql_query("select TipoMov, TipoOrden, sum(ImporteOrdenes) as suma from CuentaCorriente where Paciente=$ci group by TipoMov, TipoOrden");

   while($reg=mysql_fetch_object($of))
     {
         $tipo = $reg->TipoMov;
	 $orden= $reg->TipoOrden;

         if($orden == "I" ||
	    $orden == "M" ||
	    $orden == "Q" || 
	    $orden == "R")
	   {
         	if($tipo == "D" || $tipo == "1") 
           		$cuenta = $cuenta + $reg->suma;
	 	else
	   		$cuenta = $cuenta - $reg->suma;
	    }
     } 

   return($cuenta);
}

function estaEnPlanOrto($ci)
{

	$po=mysql_query("select * from PlanOrtodoncia where Paciente=$ci");
	$reg=mysql_fetch_object($po);

         if(empty($reg))
	    $esta = false;
	 else
	    $esta = true;

        $po=mysql_query("select * from AltasPO where Paciente=$ci");
        $reg=mysql_fetch_object($po);

	if(empty($reg))
	   $esAlta = false;
	else
	   $esAlta = true;

   return($esta || $esAlta);
}

function esMedicoDeOrtFija($medico)
{
        $po=mysql_query("select * from Medicos where Numero=$medico and Especialidad=12");
        $reg=mysql_fetch_object($po);

        if(empty($reg))
	     return(false);
        else
             return(true);
}
?>
