<?php

 echo "<title>Molde del dia:$dia en el turno $turno</title>\n";
 require("../functions/db.php");
 
 $link=conectar();

 if(empty($comando))
   $comando="turno";
   
 switch ($comando)
   {
      case "turno" :
             mostrar_turno($dia, $turno);
           break;
      case "medico" :
             mostrar_medico($dia, $turno, $consultorio);
           break;
      case "Eliminar" :
                borrar($dia, $turno, $consultorio);
		mostrar_turno($dia, $turno);
           break;   
      case "Actualizar" :
                actualizar($dia, $turno, $consultorio, $lugares,$hora,$medico,$tiempo, $mu);
		mostrar_turno($dia, $turno);
           break;   
      case "Nuevo" :
               nuevo();
           break;
      case "Agregar" :
                agregar($dia, $turno, $consultorio, $lugares,$hora,$medico,$tiempo, $mu);
		mostrar_turno($dia, $turno);
           break;   

   }
  desconectar();
 
 function mostrar_turno($dia, $turno)
  {
      echo "<center><h3>Lista del dia:$dia en el turno $turno</h3></center>\n";
      $r=1;
      $consAnt=null;
      
      echo "<table border=0 bgcolor='#000000' cellpadding='0' cellspacing='1' width='100%'>\n";
      echo "<tr bgcolor='#cccccc'><th>Consultorio</th><th width='50px'>Turno</th><th width='50px'  align='center'>Hora</th></tr>\n";
      
      $sql="select Consultorio,Doctor,Medicos.Nombre as nombre, Hora, ModeloUrgencia from Molde, Medicos where DiaDesde=$dia and Turno=$turno and Medicos.Numero=Doctor order by Consultorio, Turno, Hora, nombre";
      $q = query($sql);
      while($reg = fetch($q))
         {
	    $mu          = $reg->MoldeUrgencia;
	    $consultorio = $reg->Consultorio;
	    $hora  = $reg->Hora;
	    $doctor= $reg->Doctor;
	    $nombre= $reg->nombre;
	    if($consAnt!=$consultorio)
	      {
	        $diaAnt=$dia;
		$consAnt=$consultorio;
		$xcons=$consultorio;
	      } else $consultorio="&nbsp;&nbsp";
	       
	    
	    if($r==0)
	      {
	       $color="#77AF77";
	       $r=1;
	      }
	    else
	       {
	         $color="#77AAAA";
	         $r=0;
	       }
	    echo "<tr bgcolor='$color'><td><b>$xcons</b></td><td><a href='moldeturno.php?dia=$dia&turno=$turno&consultorio=$consultorio&comando=medico'>$nombre</a></td><td>$hora</td><td>$mu</td></tr>\n";
	 }
      echo "</table>\n";
      echo "<br><center><input type='Button' value='Cerrar' onclick='window.close()'></center>";
  }
  
  
 function mostrar_medico($dia, $turno, $consultorio)
  {
      echo "<center><h3>Lista del dia:$dia en el turno $turno</h3></center>\n";
      echo "<form action='moldeturno.php'>";
      
      $sql="select DiaDesde, Turno, Consultorio, Lugares, Hora, Doctor, HoraFin, Nombre, ModeloUrgencia from Molde, Medicos where DiaDesde=$dia and Turno=$turno and Consultorio='$consultorio' and Medicos.Numero=Doctor";
      $q = query($sql);
      $reg = fetch($q);
        $lugares = $reg->Lugares;
	$hora  = $reg->Hora;
	$doctor= $reg->Doctor;
	$tiempo= $reg->HoraFin;
	$consultorio = $reg->Consultorio;
	$nombre= $reg->Nombre;
	$mu    = $reg->ModeloUrgencia;

      echo "Modificar : Dia $dia, Consultorio: $consultorio, Turno: $turno<hr>";
      echo "<table border=0 bgcolor='#000000' cellpadding='0' cellspacing='1' width='100%'>\n";
      echo "<tr bgcolor='#cccccc'>";
      echo "<td>Lugares</td>";
      echo "<td><input type='text' name='lugares' value='$lugares' size=3  maxlength='3'></td>";
      echo "</tr>\n";
      
      echo "<tr bgcolor='#fffccc'>";
      echo "<td>Hora de inicio</td>";
      echo "<td><input type='text' name='hora' value='$hora' size=5 maxlength='5'></td>";
      echo "</tr>\n";
      
      echo "<tr bgcolor='#cccccc'>";
      echo "<td>Tiempo por paciente (min)</td>";
      echo "<td><input type='text' name='tiempo' value='$tiempo' size=4 maxlength='5'></td>";
      echo "</tr>\n";

      echo "<tr bgcolor='#cccccc'>";
      echo "<td>Medico</td>";
      echo "<td>";
      echo "<select name='medico'>";
      $q1 = query("select Numero,Nombre from Medicos where Activo='S' order by Nombre");
      while($rr1=fetch($q1))
        {
	   $med = $rr1->Numero;
	   $nom = $rr1->Nombre;
	   if($doctor==$med)
	      $sel="selected";
	   else
	      $sel="";
	   echo "<option value='$med' $sel>$nom</option>";
	}
      echo "</select>";
      echo "</td>";
      echo "</tr>\n";
      echo "<tr  bgcolor='#cccccc'>";
      echo "<td>Modelo urgencias</td>";
      echo "<td>";
      echo "<select name='mu'>";
      if($mu==0)
         $sel="selected"; 
      else
          $sel="";
      echo "	<option value='0' $sel>No hace urgencias</option>";
      if($mu==1)
         $sel="selected";
      else
         $sel="";
      echo "    <option value='1' $sel>Urgencias los meses impares</option>";
       if($mu==2)
         $sel="selected";
       else
         $sel="";
       echo "    <option value='2' $sel>Urgencias los meses pares</option>";
       if($mu==3)
         $sel="selected";
       else
         $sel="";
      echo "    <option value='3' $sel>Urgencias todos los meses</option>";

      echo "</select>";
      echo "</table>\n";
      echo "<input type='hidden' name='dia' value='$dia'>";
      echo "<input type='hidden' name='turno' value='$turno'>";
      echo "<input type='hidden' name='consultorio' value='$consultorio'>";
      echo "<br><center><input type='SUBMIT' name='comando' value='Actualizar' >&nbsp;&nbsp;";
      echo "<input type='Button' value='Cerrar' onclick='window.close()'>&nbsp;&nbsp;";
      echo "<input type='SUBMIT' name='comando' value='Eliminar' >";
      echo "</center>";
      echo "</form>";
  }

 function nuevo()
  {
      echo "<center><h3>Agregar un turno</h3></center>\n";
      echo "<form action='moldeturno.php'>";
      
      echo "<table border=0 bgcolor='#000000' cellpadding='0' cellspacing='1' width='100%'>\n";
      echo "<tr bgcolor='#cccccc'>";
      echo "<td>Dia</td>";
      echo "<td>";
      echo "<select name='dia'>";
      echo "<option value='1'>Lunes</option>";
      echo "<option value='2'>Martes</option>";
      echo "<option value='3'>Miercoles</option>";     
      echo "<option value='4'>Jueves</option>";
      echo "<option value='5'>Viernes</option>";
      echo "<option value='6'>Sabado</option>";
      echo "<option value='7'>Domingo</option>";
      echo "</select>";
      echo "</td>";
      echo "</tr>\n";
      
      echo "<tr bgcolor='#fffccc'>";
      echo "<td>Turno</td>";
      echo "<td><input type='text' name='turno' value='' size=3 maxlength='3'></td>";
      echo "</tr>\n";
      
      echo "<tr bgcolor='#cccccc'>";
      echo "<td>Consultorio</td>";
      
      echo "<td>";
      echo "<select name='consultorio'>";
      $q1 = query("select Codigo, Sucursal from Consultorios order by Sucursal, Codigo");
      while($rr1=fetch($q1))
        {
	   $cons = $rr1->Codigo;
	   $suc = $rr1->Sucursal;
	   echo "<option value='$cons'>$cons en $suc</option>";
	}
      echo "</select>";      
      echo "</td>";
      echo "</tr>\n";
      
      echo "<tr bgcolor='#fffccc'>";
      echo "<td>Lugares</td>";
      echo "<td><input type='text' name='lugares' value='' size=3  maxlength='3'></td>";
      echo "</tr>\n";
      
      echo "<tr bgcolor='#cccccc'>";
      echo "<td>Hora de inicio</td>";
      echo "<td><input type='text' name='hora' value='' size=5 maxlength='5'></td>";
      echo "</tr>\n";
      
      echo "<tr bgcolor='#fffccc'>";
      echo "<td>Minutos x pac</td>";
      echo "<td><input type='text' name='tiempo' value='' size=4 maxlength='5'></td>";
      echo "</tr>\n";

      echo "<tr bgcolor='#cccccc'>";
      echo "<td>Medico</td>";
      echo "<td>";
      echo "<select name='medico'>";
      $q1 = query("select Numero,Nombre from Medicos where Activo='S' order by Nombre");
      while($rr1=fetch($q1))
        {
	   $med = $rr1->Numero;
	   $nom = $rr1->Nombre;
	   echo "<option value='$med'>$nom</option>";
	}
      echo "</select>";
      echo "</td>";
      echo "</tr>\n";

      echo "</table>\n";
      echo "<br><center><input type='SUBMIT' name='comando' value='Agregar' >&nbsp;&nbsp;";
      echo "<input type='Button' value='Cerrar' onclick='window.close()'>&nbsp;&nbsp;";
      echo "</center>";
      echo "</form>";
  }

 function borrar($dia, $turno, $consultorio)
  {
	$sql="delete from Molde where DiaDesde=$dia and Turno=$turno and Consultorio='$consultorio'";
	$res=query($sql);
	
  }

 function actualizar($dia, $turno, $consultorio, $lugares,$hora,$medico,$tiempo, $mu)
  {

	$sql="update Molde set Lugares=$lugares, hora='$hora', Doctor=$medico, HoraFin=$tiempo, ModeloUrgencia=$mu where DiaDesde=$dia and Turno=$turno and Consultorio='$consultorio'";

	$res=query($sql);

	die(mysql_error());
  }
  
 function agregar($dia, $turno, $consultorio, $lugares,$hora,$medico,$tiempo, $mu)
  {
     if(empty($mu))
        $mu = 0;
	$sql="insert into Molde values($dia, $turno, '$consultorio', $lugares, '$hora', $medico, $tiempo, $mu)";
	$res=query($sql);
  }

?>
