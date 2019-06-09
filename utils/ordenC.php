<?php

   header ("Content-type: image/png");
   $img_handle = ImageCreate (400, 250) or die ("Cannot Create image");
   $back_color = ImageColorAllocate ($img_handle, 192, 192, 192);
   $txt_color = ImageColorAllocate ($img_handle, 0, 0, 0);

   $angulo = 90;
   $font   = 31;

   $xMatricula = 91; 
   $yMatricula =  1;

  $xSeguro    = 320; 
  $ySeguro    =   1;

  $xNombre    =  91; 
  $yNombre    =  20;

  $xFecha     =  71; 
  $yFecha     =  60;

  $xHora      = 191; 
  $yHora      =  60;

  $xNumero    = 320; 
  $yNumero    =  60;

  $xMedico    =  91; 
  $yMedico    =  80;

  $xConsultorio = 330; 
  $yConsultorio =  80;

  if(empty($ci))
     {
        $ci=4444448;
	$seguro=44;
	$nombre="Guyunusa Carlevaro";
	$fecha="44/44/4444";
	$hora="88:88:88";
	$numero="4488";
	$medico="Daniela Mangarelli";
        $consultorio="44";
     }
  ImageString ($img_handle, $font, $xMatricula,  $yMatricula, 	$ci,     $txt_color);
  ImageString ($img_handle, $font, $xSeguro,  $ySeguro, 	$seguro, $txt_color);
  ImageString ($img_handle, $font, $xNombre,  $yNombre, 	$nombre, $txt_color);
  ImageString ($img_handle, $font, $xFecha,  $yFecha, 		$fecha,  $txt_color);
  ImageString ($img_handle, $font, $xHora,  $yHora, 		$hora,   $txt_color);
  ImageString ($img_handle, $font, $xNumero,  $yNumero, 	$numero, $txt_color);
  ImageString ($img_handle, $font, $xMedico,  $yMedico, 	$medico, $txt_color);
  ImageString ($img_handle, $font, $xConsultorio,  $yConsultorio, $consultorio, $txt_color);

  $rotate = imagerotate($img_handle, $angulo, 0);
  ImagePng ($rotate);
?>
