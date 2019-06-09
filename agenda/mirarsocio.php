<?
   $ced=$ci;

   $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");

   mysql_select_db("apolonia"); 
   $query=mysql_query("select * from Pacientes where Cedula=$ced") or 
     die("(mirarpaciente.php) Error en bd, falla debido a ".mysql_error());

   $error = mysql_error();
   $rowi=mysql_fetch_object($query);
   if(empty($rowi))
     {
       echo "<font color=\"#fbffff\"><b>El paciente no existe #$error</b></font>";
       if($volver!="2")
           die("Pulse <a href=\"/agenda/index.php\">aqui</a> para volver");
       else
           die("Pulse <a href=\"/agenda/index.php\">aqui</a> para volver");
     }
   $seguro=$rowi->Seguro;
   $paga=$rowi->Paga;
   $telefono=$rowi->Telefono;
   $domicilio=$rowi->Domicilio;
   $habilit=$rowi->Habilitado;
   $Paga=$rowi->Paga;

  $qseguros=mysql_query("select Nombre,Paga from Seguros where Numero=$seguro");
  $seguros=mysql_fetch_object($qseguros);
  if(empty($seguros))
      $Paga='S';
  else
    {
      $Paga=$seguros->Paga; 
 //     if($paga!=$Paga)      // ** esto lo hago para saber si renuncio al serv.
 //        $Paga=$paga;
    }
   if($habilit=='N')
     {
       echo "<font color=\"#fbffff\"><b>El paciente fue dado de baja</b></font>";
       if($volver!="2")
           die("Pulse <a href=\"/agenda/index.php\">aqui</a> para volver");
       else
           die("Pulse <a href=\"/agenda/index.php\">aqui</a> para volver");
     }

   echo "<font color=\"#fbffff\">$ced,<b>$rowi->Nombre</b> Seguro(<i><b>$rowi->Seguro</b></i>)</font>";
   if($Paga=="S")
      echo "   <table border=5 bgcolor=\"#CCCCCC\"><tr><td><font size=+2 color=\"#FFFFFF\"><b>debe abonar</b> </font></td></tr></table>";

   echo "<a href=\"./historias/mostrarepisodioconnombre.php?paciente=$ci\" target=\"_blank\">Ver historia</a><br>";
   echo "Telefono : <b>$telefono</b> - Domicilio : <b>$domicilio</b><br>";
   $xpac="$ced,<b>$rowi->Nombre</b> Seguro(<i><b>$rowi->Seguro</b></i>)";

   $trancar="NO";
   include("versuspendido.php");
?>
