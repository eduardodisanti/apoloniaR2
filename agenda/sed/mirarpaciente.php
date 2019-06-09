<script type="text/javascript">
 function actualizarFono(tel)
   {
         alert("El valor es : "+tel);
   }
</script>
<?php
 
   require_once("../functions/db.php");
   $ced=$ci;
//   $link=conectar();
   $query=query("select * from Pacientes where Cedula=$ced") or 
     die("(mirarpaciente.php) Error en bd, falla debido a ".mysql_error());
   $error=mysql_error();
   $rowi=fetch($query);

   if(empty($rowi))
     {
      echo "<font color=\"#fbffff\"><b>El paciente no existe $error</b></font>";
      die("Pulse <a href=\"javascript:history.back()\">aqui</a> para volver");
     }
   $seguro=$rowi->Seguro;
   $paga=$rowi->Paga;
   $telefono=$rowi->Telefono;
   $domicilio=$rowi->Domicilio;
   $habilit=$rowi->Habilitado;
   $Paga=$rowi->Paga;
   $nombrePaciente = $rowi->Nombre;
   $positivamentepaga = $rowi->PositivamentePaga;
   $fechaRenuncia = $rowi->fechaRenuncia;

  $qseguros=query("select Nombre,Paga, NuncaPaga, Ignorar from Seguros where Numero=$seguro");
  $seguros=fetch($qseguros);
  if(empty($seguros))
      $Paga="S";
  else
    {
      $Paga=$seguros->Paga; 
      $nuncapaga = $seguros->NuncaPaga;
      $ignorar   = $seguros->Ignorar;

      $renuncio="N";
      if($Paga=="N" && $paga=="S")      // ** esto lo hago para saber si renuncio al serv.
         {
	     $renuncio = "S";
	     $Paga="S";
	 }
     if($nuncapaga=="S" || $ignorar=="S")
           {
	      $Paga="N";
	      $paga = "N";
	      $renuncio="N";
	   }
     if($positivamentepaga=="S")
         $Paga="S";
	 $paga="S";
    }

   if($habilit=='N' && $ignorarBaja!='S')
     {
      echo "<font color=\"#fbfcfc\"><b>El paciente fue dado de baja</b></font>";
      die("Pulse <a href=\"javascript:history.back()\">aqui</a> para volver");
     }

      echo "   <table border=0>";
      echo "   <tr>";
      echo "     <td><font color=\"#000000\">Cedula $ced</font></td>";
      echo "     <td><font color=\"#000000\"><b>$rowi->Nombre</b></font></td>";
      echo "     <td><font color=\"#000000\">Seguro: $rowi->Seguro</font></td>";
      echo "   </tr>";
      echo "   <tr>";
      echo "     <td>Telefono : <b><input type=\"text\" name=\"telefono\" id=\"telefono\" value=\"$telefono\"></b>";
      echo "</td>";
      echo "<td>Domicilio : <b>$domicilio</b></td>";
      $xpac="$ced,<b>$rowi->Nombre</b> Seguro(<i><b>$rowi->Seguro</b></i>)";

   if($Paga=="S")
     {
      echo "       <td bgcolor=\"#aa0a0a\">";
      echo "       <font size=+0 color=\"#FFFFFF\"><b>debe abonar</b>";
      if($renuncio=="S") {
             $fecharenuncia = $rowi->fechaRenuncia;
             echo ":ATENCION <b>AMABLEMENTE</b> <br>COMUNICAR AL PACIENTE QUE SEGUN LA <br>INFORMACION QUE MUCAM<BR>BRINDA A NUESTRO SERVICIO USTED<br> DESDE LA FECHA  $fecharenuncia<BR>RENUNCIO A LA COBERTURA ODONTOLOGICA";
         }
      echo "       </font></td>";
      }
      echo "   </tr>";
      echo "</table>";

  // poner en la linea siguiente &comando=revision
   echo "<a href=\"../historias/mostrarepisodioconnombre.php?paciente=$ci\" target=\"_blank\">Ver historia</a><br>";

   $trancar="NO";
   include("versuspendido.php");
//   include("../ctacte/ctacte.php");
?>

