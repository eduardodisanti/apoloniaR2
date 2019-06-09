<?php


$link=mysql_connect("elias","root","virgen");

   mysql_select_db("apolonia");


    $q = "select * from Trabajos where Activo='S'";

    $qry = mysql_query($q);
    while($reg = mysql_fetch_object($qry))
      {

           $tr = $reg->id;
           $qq = mysql_query("select * from ProcTrab where Trabajo=$tr");

	   $qqr = mysql_fetch_object($qq);
	   $t = $qqr->Trabajo;

           if(empty($t))
	      echo "$reg->id) $reg->descripcion\n";
      }
?>
