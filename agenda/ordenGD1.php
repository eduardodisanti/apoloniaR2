<?php

   $orden="";
   
   $anio=strtok($fecha,"-");
   $mes=strtok("-");
   $dia=strtok("-");
   $fechaLinda="$dia  $mes  $anio";

   $hora     = strtok($hora,":");
   $minutos  = strtok(":");
   $horalinda= "$hora $minutos";
      

   header ("Content-type: image/png");
   $img_handle = ImageCreate (400, 500) or die ("ERROR! AVISAR no se puede crear imagen de la orden");
   $back_color = ImageColorAllocate ($img_handle, 255, 255, 255);
   $txt_color = ImageColorAllocate ($img_handle, 0, 0, 0);

   $ajusteH = 30;
   $ajusteV = 200;

   $angulo = 90;
   $font   = 31;
   $font1  = 12;

   $xCabecera  = 31 + $ajusteH;
   $yCabecera  =  1 + $ajusteV;

   $xMatricula = 31 + $ajusteH; 
   $yMatricula = 51 + $ajusteV;

  $xSeguro    = 240 + $ajusteH; 
  $ySeguro    =  51 + $ajusteV;

  $xNombre    =  31 + $ajusteH; 
  $yNombre    =  70 + $ajusteV;

  $xFecha     =  11 + $ajusteH; 
  $yFecha     =  110 + $ajusteV;

  $xHora      = 170 + $ajusteH; 
  $yHora      = 110 + $ajusteV;

  $xNumero    = 240 + $ajusteH; 
  $yNumero    = 110 + $ajusteV;

  $xMedico    =  41 + $ajusteH; 
  $yMedico    = 130 + $ajusteV;

  $xConsultorio = 320 + $ajusteH; 
  $yConsultorio = 130 + $ajusteV;

  $xPie         = 16 + $ajusteH;
  $yPie         = 160 + $ajusteV;

  $xAdv         = 16 + $ajusteH;
  $yAdv1        = 190 + $ajusteV;

  $yAdv2        = 205 + $ajusteV;

  $yAdv3        = 220 + $ajusteV;

  $yAdv4        = 235 + $ajusteV;

  $cabecera = "C.A.D.I    Tarjeta de Cita";
  $pie = "Telefono : 487-0525 int. 419";
  $advertencia1 = "Usted puede cancelar su hora hasta";
  $advertencia2 = "15 minutos antes de la hora de cita";
  $advertencia3 = "de lo contrario no podra ser anotado";
  $advertencia4 = "nuevamente por 30 dias."; 

  if(empty($ced))
     {
        $ced=4444448;
	$seguro=44;
	$nombrePaciente="SOCIO DE PRUEBA **";
	$fechaLinda="44/44/4444";
	$horaLinda="88:88:88";
	$numero="4488";
	$medico="MEDICO DE PRUEBA**";
        $consultorio="44";
     }

  $medico = substr($medico,0, 20);

  $medico = "Medico : ".$medico;
  $ced    = "Cedula : ".$ced;
  $seguro = "Seguro : ".$seguro;
  $fechaLinda = "Fecha : ".$fechaLinda;
  $horaLinda  = "Hora : ".$horalinda;
  $numero = "Numero : ".$numero;

 imagecopy($img_handle, imagecreatefrompng('../img/logo.png'), 160, 220, 0, 0, 138, 135);

  ImageString ($img_handle, $font, $xCabecera,   $yCabecera,    $cabecera, $txt_color);
  ImageString ($img_handle, $font, $xMatricula,  $yMatricula, 	$ced,      $txt_color);
  ImageString ($img_handle, $font, $xSeguro,  $ySeguro, 	$seguro,   $txt_color);
  ImageString ($img_handle, $font, $xNombre,  $yNombre, 	$nombrePaciente, $txt_color);
  ImageString ($img_handle, $font, $xFecha,  $yFecha, 		$fechaLinda,  $txt_color);
  ImageString ($img_handle, $font, $xHora,  $yHora, 		$horalinda,   $txt_color);
  ImageString ($img_handle, $font, $xNumero,  $yNumero, 	$numero, $txt_color);
  ImageString ($img_handle, $font, $xMedico,  $yMedico, 	$medico, $txt_color);
  ImageString ($img_handle, $font, $xConsultorio,  $yConsultorio, $consultorio, $txt_color);
  ImageString ($img_handle, $font1, $xPie,  $yPie, $pie, $txt_color);
  ImageString ($img_handle, $font1, $xAdv,  $yAdv1, $advertencia1, $txt_color);
  ImageString ($img_handle, $font1, $xAdv,  $yAdv2, $advertencia2, $txt_color);
  ImageString ($img_handle, $font1, $xAdv,  $yAdv3, $advertencia3, $txt_color);
  ImageString ($img_handle, $font1, $xAdv,  $yAdv4, $advertencia4, $txt_color);


  $rotate = imagerotate($img_handle, $angulo, 0);
  ImagePng ($rotate);
  //ImagePng ($img_handle);
?>

