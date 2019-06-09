<?php

   session_start();
   $coisucursal_ses=$_SESSION['coisucursal_ses'];

   if(empty($pac))
     {
       echo "<form name='elpac'>";
       echo "<table border=0>";
       echo "<tr>";
       echo "     <td>";
       echo "         Paciente";
       echo "     </td>";
       echo "     <td>";
       echo "          <input type='text' size=8 name='pac'>";
       echo "     </td>";
       echo "</tr>";
       echo "<tr>";
       echo "     <td>";
       echo "         Diente";
       echo "     </td>";
       echo "     <td>";
       echo "          <input type='text' size=3 name='diente'> (777=Superior, 888=Inferior, 999=Toda la boca)";
       echo "     </td>";
       echo "</tr>";
       echo "<tr>";
       echo "     <td colspan=2 align='center'>";
       echo "          <input type='submit' name='Enviar' value='Enviar'>";
       echo "     </td>";
       echo "</tr>";
       echo "</table>";
       echo "</form>";

     } else
           laburo($pac, $cmd, $trab, $diente, $nuevoestado);

function laburo($pac, $cmd, $trab, $diente, $nuevoestado)
{
   $db=mysql_connect("130.100.201.1","apolonia","virgen");
   mysql_select_db("apolonia");
 
   $pacq = "select * from Pacientes where Cedula=$pac";
   $r  = mysql_query($pacq);
   $rg = mysql_fetch_object($r);
   $nombrePac = $rg->Nombre;

   $LAB = 0;
   $NOMBRELAB='ERROR';
   $hoy=Date("Y-m-d");
   if($cmd=="agregar")
      {
         if($coisucursal_ses=="CENTRAL")
	      $elestado=3;
	 else
          $elestado=1;

          // ** Hook para ver si tiene colocado un trabajo en ese diente

          // ** Hook para obtener el laboratorio **
	 
          $r = mysql_query("select * from TrabSoc where Paciente=$pac and Trabajo=$trab and Fecha='$hoy'");
	  $rg=mysql_fetch_object($r);
	  $repeticiones = $rg->Repeticiones;
	  $labito = $rg->Laboratorio;
	  $pieza  = $rg->Diente;

	  if(empty($repeticiones))
	    {
             include("buscolab.bak.php");
             $r=mysql_query("insert into TrabSoc values($pac,$trab,'$hoy',$elestado,0,'$coisucursal_ses', $LAB)");
	     $r=mysql_query("insert into HistTrabSoc values($pac,$trab,'$hoy',$elestado, $LAB)");
	     $r=mysql_query("insert into MetaTrabSoc values($pac,$MetaTrabajo,'$hoy',$elestado,$LAB,'$coisucursal_ses')");
	     echo "<script languaje=''>alert('Laboratorio elegido $LAB - $NOMBRELAB')</script>";
	    } else
	      {
	        $repeticiones = $repeticiones+1;
		$r=mysql_query("update TrabSoc set Repeticiones=$repeticiones , Entregado=3 where Paciente=$pac and Trabajo=$trab and Entregado=7");
		$r=mysql_query("insert into HistTrabSoc values($pac,$trab,'$hoy',88, $labito, $diente)");
	      }
	  echo "<script languaje='javascript'>alert('Trabajo registrado');</script>\n";
      } else
          if($cmd=="borrar")
	    {
		$r=mysql_query("delete from TrabSoc where Paciente=$pac and Trabajo=$trab");
		$r=mysql_query("insert into HistTrabSoc values($pac,$trab,'$hoy',0, $idlab, $diente)");
//		$r=mysql_query("delete from MetaTrabSoc where Paciente=$pac and Meta=$MetaTrabajo, $diente");

		// Aca tengo que borrar del MetaTrabSoc
	    }  else
          	if($cmd=="colocar")
		   {
		     $r=mysql_query("delete from TrabSoc where Paciente=$pac and Trabajo=$trab and Entregado=7, $diente");
		     $r=mysql_query("insert into HistTrabSoc values($pac,$trab,'$hoy',8, $idlab, $diente)");
	           }
		     else
                      if($cmd=="avanza")
		       {
		        $r=mysql_query("update TrabSoc set Entregado = $nuevoestado where Paciente=$pac and Trabajo=$trab");
		        $r=mysql_query("insert into HistTrabSoc values($pac,$trab,'$hoy',$nuevoestado, $idlab, $diente)");
		       }
		       else
		        if($cmd=="retrabajo")
		         {
		          //$r=mysql_query("update TrabSoc set Entregado = 3 where Paciente=$pac and Trabajo=$trab");
		          $r=mysql_query("insert into HistTrabSoc values($pac,$trab,'$hoy',88, $idlab)");
                         }


   echo "<center>";
   echo "Trabajos enviados a laboratorio para <b>$nombrePac en $diente</b>";
   echo "<table border=0 width=99% bgcolor='#000000'>\n";
   echo "<tr valign=\"top\"  bgcolor='#cccccc'>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "    Asignados<br>";
   $hoy=date("Y-m-d");

   if($coisucursal_ses=="CENTRAL")
      $estadio=3;
   else
      $estadio=1;

   $q="select Trabajo, Trabajos.descripcion as nomTrab, Entregado, Laboratorios.descripcion as nomlab, Laboratorios.id as idlab, EstadosTrabajo.Descripcion as estate from TrabSoc,Trabajos, Laboratorios, EstadosTrabajo where paciente=$pac and Trabajo = Trabajos.id and TrabSoc.Laboratorio = Laboratorios.id and Entregado = EstadosTrabajo.Codigo order by Trabajos.descripcion";

   $result=mysql_query($q);
   echo mysql_error();
   echo "     <table border=0 bgcolor=\"#000000\" width='100%'>";
   while($reg=mysql_fetch_object($result))
     {
 	echo "	  <tr bgcolor=\"#ffffff\">\n";
	echo "	    <td>";
	$cod=$reg->Trabajo;
	$trab=$reg->nomTrab;
	$estado=$reg->Entregado;
	$nomlab=$reg->nomlab;
	$idlab =$reg->idlab;
	$pieza =$reg->Pieza;
	$estate=$reg->estate;

	if($estado==3 && $coisucursal_ses=="CENTRAL")
	   $estadio=1;
	else
	   $estadio=$estado;

	if(!empty($cod))
	  {
	   echo "$trab";
	  }
	else
	   echo "&nbsp";
	echo "	    </td>\n";
	echo "	    <td width=22px>\n";
	if($estadio==1)
	   {
	     echo "	<a href='asignarTrab.php?pac=$pac&cmd=borrar&trab=$cod&idlab=$idlab&diente=$pieza' title='Anular este pedido'>";
	     echo "   	   <img src='../img/basura.png' border=0>";
	     echo "	</a>";
	   }
	echo "	    </td>\n";
	echo "      <td width=22px>\n";
	if($estado==7)
	  {
	     echo "		<a href='asignarTrab.php?pac=$pac&cmd=retrabajo&trab=$cod&idlab=$idlab&diente=$pieza' title='Retrabajo, tiene problemas no pasa a la siguiente etapa'>";
	     echo "		<img src='../img/critico.png' border=0>";
	     echo "		</a>";
	  }
	echo "	    </td>\n";
	echo "	    <td width=22px>\n";
	if($estado != 8 && $estado != 9)
	  {
	     $nuevoestado = $estado + 1;
	     echo "	<a href='asignarTrab.php?pac=$pac&cmd=avanza&trab=$cod&idlab=$idlab&diente=$pieza&nuevoestado=$nuevoestado' title='Siguiente etapa'>";
	     echo "		<img src='../img/ok24.png' border=0>";
	     echo "	</a>";
	  }
	echo "	    </td>\n";
	echo "	  </tr>\n";
	echo "   <tr>\n";
	echo "   <tr>\n";
        echo "     <td colspan=4 bgcolor='#cccccc' align='center'>";
        echo "        $estate";
        echo "     </td\n";
        echo "   </tr\n";
	echo "     <td colspan=4 bgcolor='#aaaaaa' align='center'>";
	echo "        $nomlab";
	echo "     </td\n";
	echo "   </tr\n";
	
     }
   echo "	</table>\n";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "    Disponibles<br>";
   echo "	<table bgcolor=\"#000000\" cellspacing=1  width='100%'>\n";
   $result=mysql_query("select id, descripcion from Trabajos order by descripcion");
   while($reg=mysql_fetch_object($result))
      {
	echo "  <tr bgcolor=\"#ffffff\">\n";
	echo "	    <td>";   
        $cod=$reg->id;
	$nom=$reg->descripcion;
	$tie=$reg->Tiempo;
	echo "<a href='asignarTrab.php?pac=$pac&cmd=agregar&trab=$cod'&diente=$pieza>$nom</a>";
      }
	echo "	    </td>";   
	echo "	  </tr>\n";
	echo "    </table>\n";      
   echo "</td>";   
   echo "</tr>";
   echo "</table>";
   mysql_close();
}
?>
