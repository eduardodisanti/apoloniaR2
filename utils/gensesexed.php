<?php

function seatendioestasemana($paciente, $hoy)
{

   $fhasta = $hoy;
   $fdesde = date('Y-m-d',mktime(0, 0, 0, date("m"), date("d")-7,  date("Y")));

   $q = "select count(*) as cant from Episodios where Paciente=$paciente and Fecha >='$fdesde' and Fecha <='$fhasta'";

$qry = mysql_query($q);
   $reg = mysql_fetch_object($qry);
   $cant = $reg->cant;

   return($cant > 0);
}


     $link=mysql_connect("elias","root","virgen");
     $db = mysql_select_db("apolonia");

      $query = mysql_query("select Paciente, Diente, Medico, CSesiones.Sesiones as hechas, Extras, Procedimientos.Sesiones as acordadas, Procedimiento from CSesiones, Procedimientos where Procedimiento = Codigo");

      $err=mysql_error();
      if(!empty($err))
        die($err);

      $hoy=date("Y-m-d");

      while($reg=mysql_fetch_object($query))
        {
	  $pac   = $reg->Paciente;
	  $pieza = $reg->Diente;
	  $medico = $reg->Medico;
	  $hechas = $reg->hechas;
	  $acord  = $reg->acordadas;
	  $proc   = $reg->Procedimiento;

          if(seatendioestasemana($pac, $hoy))
	     $ok = true;
	 else
	     $ok = false;

          if($hechas > $acord && $acord > 0 && $ok)
	     {
	      $q = "insert into Auditoria values($pac, '$hoy', 2, $pieza, 0,'')";
	      mysql_query($q);
	      $err = mysql_error();
	      if(!empty($err))
	         echo "$err\n";
             }
        }
      mysql_close();
?>
