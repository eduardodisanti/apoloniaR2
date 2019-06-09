<?php

   $query="select * from TrabSoc";

$link=mysql_connect("127.0.0.1","root","virgen") or die("Error, la base de datos no acepto la coneccion");

   mysql_select_db("apolonia");

   $cant=0;
   $q = mysql_query($query);
   while($reg=mysql_fetch_object($q))
      {
          $pac = $reg->Paciente;
	  $tra = $reg->Trabajo;
	  $fec = $reg->Fecha;
	  $lab = $reg->Laboratorio;

         $laq = "update HistTrabSoc set Laboratorio=$lab where Paciente=$pac and Fecha='$fec' and Trabajo=$tra";

	 $laqq = mysql_query($laq);
	 $err = mysql_error();

	 if(!empty($err))
	     $err."\n";
      }

   $query = "select Paciente, Trabajo, Fecha from HistTrabSoc where Laboratorio=0";
   $q = mysql_query($query);
   while($reg = mysql_fetch_object($q))
     {
         $pac = $reg->Paciente;
	 $tra = $reg->Trabajo;
	 $fec = $reg->Fecha;

         $qmeta = mysql_query("select Meta from MetaTrabTrab where Trabajo=$tra");
         $metareg = mysql_fetch_object($qmeta);
	 $meta = $metareg->Meta;

     if(!empty($meta))
      {
         $lameta = mysql_query("select Laboratorio from MetaTrabSoc where Paciente=$pac and MetaTrab=$meta");

         $err = mysql_error();
	 if(!empty($err))
	    die("Error : ".$err."\n"."select Laboratorio from MetaTrabSoc where Paciente=$pac and MetaTrab=$meta");

	 $qmetalab = mysql_fetch_object($lameta);

         $metalab=$qmetalab->Laboratorio;

	 if(empty($lameta))
             $metalab = 1;


         $updat = "update HistTrabSoc set Laboratorio = $metalab where Paciente=$pac and Fecha='$fec' and Trabajo=$tra";

	 $qupdat = mysql_query($updat);

      }
     }
   
   mysql_close();
?>
