<script languaje="javascript">

function abrir(fecha, consultorio, turno)
  {
     var url;
     
     url="listaurgencias.php?fecha="+fecha+"&consultorio="+consultorio+"&turno="+turno;
     url=url+"&comando=Cambiar";
     
     window.open(url,"Turno","width=500,height=450,resizable,scrollbars");
  }
</script>
<?php

 require("../functions/db.php");
 
 $link=conectar();

 if(empty($comando)) {

   $fecha = Date("Y-m-d");
   $aaaa = strtok($fecha, "-");
   $mm   = strtok("-");
   $dd   = strtok("-");
   $comando='Crear';
 }
   else  if($comando=='Crear')
            {
	        $sql = "insert into ListaUrgencias values('$aaaa-$mm-$dd', '$consultorio', $turno, $medico)";
		query($sql);
	    }
	      else if($comando=='Cambiar') 
	           {
                      $aaaa = strtok($fecha, "-");
		      $mm   = strtok("-");
		      $dd   = strtok("-");
		      $comando = "Actualizar";
		   }
		     else if($comando=='Actualizar')
		           {
                             $sql = "update ListaUrgencias set Medico = $medico where Fecha='$aaaa-$mm-$dd' and Consultorio='$consultorio' and Horario=$turno";

		             query($sql);
                             $comando='Crear';
			     $fecha='$aaaa-$mm-$dd';
			   }
  
 $fecha1 = "$aaaa-$mm-1";
 $fecha2 = "$aaaa-$mm-31";

 mostrar_mes($fecha1, $fecha2, $comando, $dd, $mm, $aaaa, $cons, $turno);

 desconectar();
 
 function mostrar_mes($fd,$fh, $comando, $dd, $mm, $aaaa, $cons, $turno)
  {
      $r=1;
      $dia_ant=null;

      echo "<center>";
      echo "<form action='listaurgencias.php' method='post'>";
      echo "DD <input type='text' size='2' name='dd' value='$dd'> ";
      echo "MM <input type='text' size='2' name='mm' value='$mm'>";
      echo "AAAA <input type='text' size='4' name='aaaa' value='$aaaa'>";
      echo "Consultorio <input type='text' size='5' name='consultorio' value='$cons'>";
      echo "Turno <input type='text' size='2' name='turno' value='$turno'> ";
      echo "Medico ";
      ponerListaMedicosEnUnCombo($medico);
      echo "<input type='submit' name='comando' value='$comando'>";
      echo "</form>";
      echo "</center>\n";   
      echo "<table border=0 bgcolor='#000000' cellpadding='0' cellspacing='1'>\n";
      echo "<tr bgcolor='#cccccc'><th>Fecha</th><th width='50px'>Consultorio</th><th width='50px'  align='center'>Turno</th><th width='50px' align='center'>Medico</th></tr>\n";
      
      $sql="select Fecha, Consultorio, Horario, Medico, Nombre from ListaUrgencias, Medicos where Medicos.Numero = ListaUrgencias.Medico and Fecha >='$fd' and Fecha <='$fh' order by Fecha, Horario, Consultorio";
      $q = query($sql);
      echo mysql_error();
      while($reg = fetch($q))
         {
	    $fecha = $reg->Fecha;
	    $cons  = $reg->Consultorio;
	    $turno = $reg->Horario;
	    $medico= $reg->Medico;
	    $nmed  = $reg->Nombre;
	    
	    if($r==0)
	      {
	       $color="#CFCFCF";
	       $r=1;
	      }
	    else
	       {
	         $color="#FFFFFF";
	         $r=0;
	       }
	    echo "<tr bgcolor='$color'><td><b>$fecha</b></td><td align='center'>$cons</td><td>$turno</td><td><a href='listaurgencias.php?fecha=$fecha&cons=$cons&turno=$turno&medico=$medico&nmed=$nmed&comando=Cambiar'>$medico</a></td><td>$nmed</td></tr>\n";
	 }
      echo "</table>\n";
  }

  function ponerListaMedicosEnUnCombo($elmed) {

      $qry = query("select Numero, Nombre from Medicos where Activo='S' order by Nombre");
    
      echo "<select name='medico'>";
      while($reg=fetch($qry))
        {
	   $codigo = $reg->Numero;
	   $nombre = $reg->Nombre;
	   if($elmed == $codigo)
	     $sel="selected";
	   else
	     $sel="";
	   echo "<option value='$codigo' $sel>$nombre</option>";
	} 
      echo "</select>";

  }
?>
