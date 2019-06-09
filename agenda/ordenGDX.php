<?php

   $orden="";
   
   $anio=strtok($fecha,"-");
   $mes=strtok("-");
   $dia=strtok("-");
   $fechaLinda="$dia / $mes / $anio";

   $hora     = strtok($hora,":");
   $minutos  = strtok(":");
   $horalinda= "$hora $minutos";
      

   header ("Content-type: image/png");
   $img_handle = ImageCreate (500, 520) or die ("ERROR! AVISAR no se puede crear imagen de la orden");
   $back_color = ImageColorAllocate ($img_handle, 255, 255, 255);
   $txt_color = ImageColorAllocate ($img_handle, 0, 0, 0);

   $ajusteH = 50;
   $ajusteV = 200;

   $angulo = 90;
   $font   = 31;
   $font1  = 12;

   $xCabecera  = 25 + $ajusteH;
   $yCabecera  =  1 + $ajusteV;

   $xMatricula = 20 + $ajusteH; 
   $yMatricula = 61 + $ajusteV;

  $xSeguro    = 350 + $ajusteH; 
  $ySeguro    =  75 + $ajusteV;

  $xNombre    =  20 + $ajusteH; 
  $yNombre    =  90 + $ajusteV;

  $xFecha     =  30 + $ajusteH; 
  $yFecha     =  130 + $ajusteV;

  $xHora      = 190 + $ajusteH; 
  $yHora      = 130 + $ajusteV;

  $xNumero    = 390 + $ajusteH; 
  $yNumero    = 130 + $ajusteV;

  $xMedico    =  41 + $ajusteH; 
  $yMedico    = 160 + $ajusteV;

  $xConsultorio = 410 + $ajusteH; 
  $yConsultorio = 160 + $ajusteV;

  $xPie         = 16 + $ajusteH;
  $yPie         = 170 + $ajusteV;

  $xAdv         = 16 + $ajusteH;
  $yAdv1        = 200 + $ajusteV;

  $yAdv2        = 215 + $ajusteV;

  $yAdv3        = 230 + $ajusteV;

  $yAdv4        = 245 + $ajusteV;

  if(empty($ced))
     {
        $ced=4444448;
	$seguro=44;
	$nombrePaciente="SOCIO DE PRUEBA **";
	$fechaLinda="44 44 4444";
	$horalinda="88:88:88";
	$numero="4488";
	$medico="MEDICO DE PRUEBA**";
        $consultorio="44";
     }

  $medico = substr($medico,0, 20);

  $medico = $medico;
  $ced    = $ced;
  $seguro = $seguro;
  $fechaLinda = $fechaLinda;
  $horalinda  = $horalinda;
  $numero = $numero;

 imagecopy($img_handle, imagecreatefrompng('../img/ordenes1.png'), 105, 144, 0, 0, 400, 277);

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

