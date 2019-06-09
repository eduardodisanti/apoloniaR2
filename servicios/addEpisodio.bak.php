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
    $err = $err.$pieza."\n";

	$q = "insert into Episodios values($paciente, '$fecha', $pieza, $procedimiento, '$hora', '$comentario', $usuario)";
	query($q);
    $err = $err.$q."\n";
    
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
	$e=mysql_error();
	if(!empty($e))
    	    $err = $err.$e.$q;

    $q = "select * from ProcTrab where Procedimiento = $procedimiento"; 
    $qry = query($q);
    while($reg=fetch($qry)) {

         
    }

}

desconectar();

if(empty($err))
   $ret = "ACK";
   else
      $ret = "NAK+".$err;
echo "ACK";
	// echo $ret;
?>
