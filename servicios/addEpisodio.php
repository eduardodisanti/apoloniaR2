<?php

include("functions/db.php");

session_start();

conectar();


$paciente    = $pac;
$pieza1      = $diente1;
$pieza2      = $diente2;
$procedimiento = $proc;
$comentario  = $coment;
$usuario     = $usr;
$fecha       = date("Y-m-d");
$hora		 = date("H:i");
$finalizado  = $terminado;


// Determino en que estado lo deja

$q = "select loDeja from Procedimientos where Codigo=$procedimiento";
$qry = query($q);
    
$err = mysql_error();
    
$reg=fetch($qry);
$loDeja = $reg->loDeja;
    
if($pieza1 < $pieza2)
  {
       $pieza3 = $pieza1;
       $pieza1 = $pieza2;
       $pieza2 = $pieza3;
  }
  
for($pieza = $diente1; $pieza <= $diente2; $pieza++) {

	$q = "insert into Episodios values($paciente, '$fecha', $pieza, $procedimiento, '$hora', '$comentario', $usuario)";
	query($q);
    $err.= mysql_error();
    
    if(($pieza==$diente1 || $pieza==$diente2) && $loDeja==5) {
       $estado = 2;
    }
    else
       if($lodDeja==5) {
          		$estado=1;
       }
        else          
            $estado = $loDeja;
     
    if($estado==5 || $estado==6)
      $estado=1;
     
    if($finalizado!="S" and $procedimiento==620)
       $estado = 4;

    $q = "insert into piezasPaciente values($paciente, $pieza, $estado)";
	query($q);

	$q = "update piezasPaciente set estado=$estado where paciente=$paciente and pieza=$pieza";
	query($q);
	$e = mysql_error();
	if(!empty($e))
    	   $err.= "\naddEpisodios.do-".$err.$e.$q;
    	
 $q = "insert into actosmedicos values($usuario, '$fecha', '$hora', $paciente, 'E','N')";
 query($q);
 $err.=mysql_error();

 if($finalizado=="S") {

    // Aqui pongo como colocado si existe un trabajo de laboratorio

    // Primero obtengo los trabajos que tengo que buscar

    $q = "select * from ProcTrab where Procedimiento = $procedimiento";

    $qry = query($q);

    while($reg=fetch($qry)) {


         $trab = $reg->Trabajo;

         $q = "select * from TrabSoc where Paciente=$paciente and Pieza=$pieza and Entregado=7 and trabajo=$trab";
         $qts = query($q);

         while($qtreg=fetch($qts)) {

             $suc = $qtreg->Sucursal;
             $lab = $qtreg->Laboratorio;
             $salida=$qtreg->Salida;
	     $fecha=$qtreg->Fecha;
             $vence=$qtreg->Vence;
             
             query("update TrabSoc set Entregado=8 where Paciente=$paciente and Pieza=$pieza and Entregado=7 and trabajo=$trab");
             $err.=mysql_error();
             query("insert into HistTrabSoc values($paciente, $trab, '$fecha', $pieza, 8, $lab, '$vence')");
             $err.=mysql_error();
         }
    }
 }

}

desconectar();

if(empty($err))
   $ret = "ACK";
   else
      $ret = "NAK+".$err;
//echo "ACK";
	echo $ret;
?>
