<?php

    include("../../functions/db.php");

     $db = conectar();


     $hoy = date("Y-m-d");

     $query = "select * from Episodios where Fecha = '$hoy'";
     $q = query($query);

     while($reg=fetch($q)) {

         $paciente = $reg->Paciente;
	 $fecha    = $reg->Fecha;
	 $pieza    = $reg->Pieza;
	 $hora     = $reg->Hora;
	 $proced   = $reg->Procedimiento;
         $informe  = $reg->Comentario;
	 $usuario  = $reg->usuario;
        
         $tipo = 1;
         if($proced == 693)
	   $tipo = 2;


         $qq = "select Externo from Medicos, Usuarios where funcionario = $usuario and Numero = medico";

	 $tqq = query($qq);
	 $treg= fetch($tqq);

	 $externo = $treg->Externo;
	 if(!empty($externo)) {
	   echo "$qq ($medico $externo)\n";

         $s = "insert into Episodios values($paciente, '$fecha', $pieza, '$hora', $proced, '$informe', $usuario, $tipo);";
	 echo $s."\n";
	 }
     }

     desconectar();
?>

