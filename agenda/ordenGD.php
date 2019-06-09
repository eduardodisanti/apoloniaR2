<?php

function tratar($s) {

  $s = str_replace("\n", " ",$s);
  $s = str_replace("\r", " ",$s);

  return($s);
}
   $orden="";
   
   $anio=strtok($fecha,"-");
   $mes=strtok("-");
   $dia=strtok("-");
   $fechaLinda="$dia/$mes/$anio";

   $hora     = strtok($hora,":");
   $minutos  = strtok(":");
   $horalinda= "$hora $minutos";
      

   header ("Content-type: image/png");
   $img_handle = ImageCreate (400, 500) or die ("ERROR! AVISAR no se puede crear imagen de la orden");
   $back_color = ImageColorAllocate ($img_handle, 255, 255, 255);
   $txt_color = ImageColorAllocate ($img_handle, 0, 0, 0);

   $ajusteH = 0;
   $ajusteV = 200;

   $angulo = 90;
   $font   = 26;
   $font1  = 10;
   $font2  = 2;

   $xCabecera  = 01 + $ajusteH;
   $yCabecera  =  1 + $ajusteV;

   $xMatricula = 01 + $ajusteH; 
   $yMatricula = 31 + $ajusteV;

  $xSeguro    = 230 + $ajusteH; 
  $ySeguro    =  31 + $ajusteV;

  $xNombre    =  01 + $ajusteH; 
  $yNombre    =  50 + $ajusteV;

  $xFecha     =  01 + $ajusteH; 
  $yFecha     =  70 + $ajusteV;

  $xHora      = 170 + $ajusteH; 
  $yHora      =  70 + $ajusteV;

  $xNumero    = 290 + $ajusteH; 
  $yNumero    =  70 + $ajusteV;

  $xMedico    =  01 + $ajusteH;
  $yMedico    =  90 + $ajusteV;

  $xConsultorio = 290 + $ajusteH;
  $yConsultorio =  90 + $ajusteV;

  $xPie         = 01 + $ajusteH;
  $yPie         = 120 + $ajusteV;

  $xAdv         = 01 + $ajusteH;
  $yAdv1        = 130 + $ajusteV;
  $yAdv2        = 145 + $ajusteV;
  $yAdv3        = 160 + $ajusteV;
  $yAdv4        = 175 + $ajusteV;
  $yAdv5	= 190 + $ajusteV;
  $yAdv6        = 205 + $ajusteV;
  $yAdv7        = 220 + $ajusteV;
  $yAdv8        = 235 + $ajusteV;
  $yAdv9        = 250 + $ajusteV;
  $yAdv10       = 265 + $ajusteV;
  $yAdv11       = 280 + $ajusteV;

  //$cabecera = "C.A.D.I    Tarjeta de Cita";
  /* $pie = "Informacion de interes : ";
  $advertencia1 = "Horario de URGENCIAS, lunes a viernes de 8 a 22 hrs";
  $advertencia2 = "y sabados de 8 a 19 hrs.";
  $advertencia3 = "El paciente debera presentarse con documento de ";
  $advertencia4 = "identidad y recibo vigente.";
  $advertencia5 = "Por anotaciones, cancelaciones y/o consultas en gral";
  $advertencia6 = "SERVICIO DE ATENCION TELEFONICA : 480 20 63";
  $advertencia7 = "Horario: Lun a Vie de 8 a 20 hrs, Sab de 8 a 13 hrs";
  $advertencia8 = "Usted puede cancelar su consulta hasta 15 minutos ";
  $advertencia9 = "antes de la hora de cita, de lo contrario no podra";
  $advertencia10= "ser anotado nuevamente por 30 dias"; 
  */
  
  $fp = fopen("../textos/textoorden.txt","r");

  $pie = tratar(fgets($fp));
  $advertencia1 = tratar(fgets($fp));
  $advertencia2 = tratar(fgets($fp));
  $advertencia3 = tratar(fgets($fp));
  $advertencia4 = tratar(fgets($fp));
  $advertencia5 = tratar(fgets($fp));
  $advertencia6 = tratar(fgets($fp));
  $advertencia7 = tratar(fgets($fp));
  $advertencia8 = tratar(fgets($fp));
  $advertencia9 = tratar(fgets($fp));
  $advertencia10= tratar(fgets($fp));
  //$advertencia11= tratar(fgets($fp));
  
  fclose($fp);


  if(empty($ced))
     {
        $ced=4444448;
	$seguro=44;
	$nombrePaciente="SOCIO DE PRUEBA **";
	$fechaLinda="44/44/4444";
	$horalinda="88:88";
	$numero="4488";
	$medico="MEDICO DE PRUEBA**";
        $consultorio="44";
     }

  $medico = substr($medico,0, 20);

  $medico = "Medico : ".$medico;
  $ced    = "Cedula : ".$ced;
  $seguro = "Seguro : ".$seguro;
  $fechaLinda = "Fecha : ".$fechaLinda;
  $horalinda  = "Hora : ".$horalinda;
  $numero = "Nro:".$numero;
  $consultorio="Cons:".$consultorio;

  imagecopy($img_handle, imagecreatefrompng('../img/cabecera1.png'), 20, 140, 0, 0, 350, 49);

  ImageString ($img_handle, $font, $xCabecera,   $yCabecera,    $cabecera, $txt_color);
  ImageString ($img_handle, $font, $xMatricula,  $yMatricula, 	$ced,      $txt_color);
  ImageString ($img_handle, $font, $xSeguro,  $ySeguro, 	$seguro,   $txt_color);
  ImageString ($img_handle, $font, $xNombre,  $yNombre, 	$nombrePaciente, $txt_color);
  ImageString ($img_handle, $font, $xFecha,  $yFecha, 		$fechaLinda,  $txt_color);
  ImageString ($img_handle, $font, $xHora,  $yHora, 		$horalinda,   $txt_color);
  ImageString ($img_handle, $font, $xNumero,  $yNumero, 	$numero, $txt_color);
  ImageString ($img_handle, $font, $xMedico,  $yMedico, 	$medico, $txt_color);
  ImageString ($img_handle, $font, $xConsultorio,  $yConsultorio, $consultorio, $txt_color);
  ImageString ($img_handle, $font2, $xPie,  $yPie, $pie, $txt_color);
  ImageString ($img_handle, $font2, $xAdv,  $yAdv1, $advertencia1, $txt_color);
  ImageString ($img_handle, $font2, $xAdv,  $yAdv2, $advertencia2, $txt_color);
  ImageString ($img_handle, $font2, $xAdv,  $yAdv3, $advertencia3, $txt_color);
  ImageString ($img_handle, $font2, $xAdv,  $yAdv4, $advertencia4, $txt_color);
  ImageString ($img_handle, $font2, $xAdv,  $yAdv5, $advertencia5, $txt_color);
  ImageString ($img_handle, $font2, $xAdv,  $yAdv6, $advertencia6, $txt_color);
  ImageString ($img_handle, $font2, $xAdv,  $yAdv7, $advertencia7, $txt_color);
  ImageString ($img_handle, $font2, $xAdv,  $yAdv8, $advertencia8, $txt_color);
  ImageString ($img_handle, $font2, $xAdv,  $yAdv9, $advertencia9, $txt_color);
  ImageString ($img_handle, $font2, $xAdv,  $yAdv10,$advertencia10, $txt_color);
  ImageString ($img_handle, $font2, $xAdv,  $yAdv11,$advertencia11, $txt_color);

  $rotate = imagerotate($img_handle, $angulo, 0);
  ImagePng ($rotate);
  //ImagePng ($img_handle);
?>

