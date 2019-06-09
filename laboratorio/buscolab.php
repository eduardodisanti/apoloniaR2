<?php

    // ** Primero, si tiene un metatrabajo con laboratorio asignado, lo respeto

    $Estado=-1;
    $MetaEstado=0;
    $metaq = "select Meta from MetaTrabTrab where Trabajo=$trab";
    $qmetaq=mysql_query($metaq);

    $regQMetaq = mysql_fetch_object($qmetaq);
    $MetaTrabajo=$regQMetaq->Meta;

    if(!empty($MetaTrabajo))
       {
          $metaq = "select Estado, Laboratorio, descripcion from MetaTrabSoc, Laboratorios where Paciente=$pac and MetaTrab=$MetaTrabajo and id=Laboratorio";

    	  $qmetaq=mysql_query($metaq);
          $regQMetaq = mysql_fetch_object($qmetaq);
          $MetaEstado=$regQMetaq->Estado;
       }

    if(empty($MetaEstado) || $MetaEstado==0)
       $MetaEstado=-1;

    if($MetaEstado!=-1)
      {
          $NOMBRELAB = $regQMetaq->descripcion;
          $LAB       = $regQMetaq->Laboratorio;
      }
else
  {
    $diaHoy = Date("w");
	// ** Segundo, busco un laboratorio con cupo que haga este trabajo **/

    // Primero obtengo los laboratorios y su cupos

   if($diaHoy==6)
     $limite = " and TrabLab.Laboratorio != 7 and TrabLab.Laboratorio !=9 ";

   $qlab = "select TrabLab.Laboratorio as labo, TrabLab.Trabajo as trab, TrabLab.Cupo as tcupo, Trabajos.descripcion ntrab, Laboratorios.descripcion as nomlab, Laboratorios.Cupo as cupo from TrabLab, Trabajos, Laboratorios where 
            TrabLab.Laboratorio = Laboratorios.id and
	    TrabLab.Trabajo     = Trabajos.id     and
	    TrabLab.Trabajo     = $trab           
	    $limite
	    order by Laboratorios.categoria";

   $queryLab = mysql_query($qlab);
   $error = mysql_error();
   if(!empty($error))
      {
         die("1) Avisar, error : <br>$error<br>No puede asignar el trabajo<br>Grave: No se puede encontrar un laboratorio con cupo<br>");
      }
    $encontre=FALSE;

    $maxTrab    = 999999;
    $este_labo  = 0;
    $este_nlab  = 0;
    $este_nomlab="";
    $este_trab  = 0;
    $este_cant  = 0;
    while($labreg = mysql_fetch_object($queryLab))
      {
        $labo = $labreg->labo;
	$trab = $labreg->trab;
	$cupo = $labreg->cupo;
	$nlab = $labreg->labo;
	$nomla= $labreg->nomlab;
	$ntrab= $labreg->ntrab;
 
        $qcupo = "select count(*) as cant from TrabSoc where Fecha='$hoy' and Laboratorio = $labo group by Laboratorio, Fecha";
	$qqcupo = mysql_query($qcupo);
        $error = mysql_error();	
	$rcupo  = mysql_fetch_object($qqcupo);
	$cant = $rcupo->cant;

      //  echo "cupo=$cupo cant=$cant<br>";
	if($cant < $cupo)    // ** Este tiene lugar veo si ya tiene un trabajo
	  {
	     if($este_labo == 0)
	       {
	         $este_labo   = $labo;
		 $este_nomlab = $nomla;
	       }
	     $encontre=TRUE;
	     $qCantHecho = "select count(*) as hechos from TrabSoc where Fecha='$hoy' and Laboratorio=$labo and Trabajo = $trab";
	     $qryCantHecho = mysql_query($qCantHecho);
	     $regCantHecho = mysql_fetch_object($qryCantHecho);
             $hechos = $regCantHecho->hechos;
//	     printf("Mirando $nlab, hechos : $hechos mt:$maxTrab este_labo = $este_labo");
	     if($hechos < $maxTrab)
	       {
	         $este_labo   = $nlab;
		 $este_nomlab = $nomla;
		 $maxTrab     = $hechos;
//		 echo "Entre $este_labo*";
	       }
	  }
      }

    $LAB       = $este_labo;
    $NOMBRELAB = $este_nomlab;

    if(!$encontre)
      {
         die("Avisar, GRAVE: <b>No puede asignar el trabajo</b><br> No se puede encontrar un laboratorio con cupo que haga este trabajo<br>$error");
      }
 }     
?>
