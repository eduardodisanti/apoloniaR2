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
   $img_handle = ImageCreate (400, 250) or die ("ERROR! AVISAR no se puede crear imagen de la orden");
   $back_color = ImageColorAllocate ($img_handle, 192, 192, 192);
   $txt_color = ImageColorAllocate ($img_handle, 0, 0, 0);

   $ajusteH = 30;
   $ajusteV = 0;

   $angulo = 90;
   $font   = 31;

   $xMatricula = 31 + $ajusteH; 
   $yMatricula =  1 + $ajusteV;

  $xSeguro    = 320 + $ajusteH; 
  $ySeguro    =   1 + $ajusteV;

  $xNombre    =  31 + $ajusteH; 
  $yNombre    =  20 + $ajusteV;

  $xFecha     =  11 + $ajusteH; 
  $yFecha     =  60 + $ajusteV;

  $xHora      = 170 + $ajusteH; 
  $yHora      =  60 + $ajusteV;

  $xNumero    = 320; 
  $yNumero    =  60;

  $xMedico    =  41 + $ajusteH; 
  $yMedico    =  80 + $ajusteV;

  $xConsultorio = 330 + $ajusteH; 
  $yConsultorio =  80 + $ajusteV;

  if(empty($ced))
     {
        $ced=4444448;
	$seguro=44;
	$nombrePaciente="SOCIO DE PRUEBA **";
	$fecha="44/44/4444";
	$hora="88:88:88";
	$numero="4488";
	$medico="MEDICO DE PRUEBA**";
        $consultorio="44";
     }

  $medico = substr($medico,0, 20);
  ImageString ($img_handle, $font, $xMatricula,  $yMatricula, 	$ced,     $txt_color);
  ImageString ($img_handle, $font, $xSeguro,  $ySeguro, 	$seguro, $txt_color);
  ImageString ($img_handle, $font, $xNombre,  $yNombre, 	$nombrePaciente, $txt_color);
  ImageString ($img_handle, $font, $xFecha,  $yFecha, 		$fechaLinda,  $txt_color);
  ImageString ($img_handle, $font, $xHora,  $yHora, 		$horalinda,   $txt_color);
  ImageString ($img_handle, $font, $xNumero,  $yNumero, 	$numero, $txt_color);
  ImageString ($img_handle, $font, $xMedico,  $yMedico, 	$medico, $txt_color);
  ImageString ($img_handle, $font, $xConsultorio,  $yConsultorio, $consultorio, $txt_color);

  //$rotate = imagerotate($img_handle, $angulo, 0);
  //ImagePng ($rotate);
  ImagePng ($img_handle);
?>
?>
<script>
window.print();
//window.close();
</script>

