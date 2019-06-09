<?php
function date_diff($date2, $date1)
  {
      $s = strtotime($date2) - strtotime($date1);
      $d = intval($s/86400);
      return($d);
  }

echo "<center><h2>Indicadores de tiempos promedio</h2></center><hr>";
if(empty($comando))
 {
     echo "<form action='tiempos.php' method=post>\n";
     echo "<center><table border = 0 width='60%'>\n";
     echo "<tr>";
     echo "   <td>Fecha desde (AAAA-MM-DD)</td>";
     echo "   <td><input type='text' width='10' name='FECHADESDE'></td>";
     echo "</tr>";
     echo "<tr>";
     echo "   <td>Fecha hasta (AAAA-MM-DD)</td>";
     echo "   <td><input type='text' width='10' name='FECHAHASTA'></td>";
     echo "</tr>";
     echo "<tr>";
     echo "   <td colspan=2><input type='submit' name='comando' value='Ejecutar!'></td>";
     echo "</tr>";
     echo "</table></center>\n";
     echo "</form>\n";
 }
else
 {
     if(empty($FECHADESDE))
          $FECHADESDE='2003-07-01';
     if(empty($FECHAHASTA))
        $FECHAHASTA = '2003-12-31';
     $link=mysql_connect("elias","root","virgen");
     $db = mysql_select_db("apolonia");

     $q1 = mysql_query("select count(Paciente) as Cuenta from Horarios where Paciente != 0 and Fecha >= '$FECHADESDE' and Fecha <= '$FECHAHASTA'");
     $reg = mysql_fetch_object($q1);
     $Consultas = $reg->Cuenta;
     echo "Numero de consultas hasta desde $FECHADESDE hasta $FECHAHASTA : <b>$Consultas</b><br>\n";

     $consultas = 0;
     $dias = 0;
     $espera = 0;
     $revs   = 0;
     $maximo = 0;
     $minimo = 9999999999;

    // ** Para cada sucursal ** //
$qsuc = "select Sucursal from Consultorios group by Sucursal";
$q9 = mysql_query($qsuc);
while($sucreg = mysql_fetch_object($q9))
 {

     $sucursal = $sucreg->Sucursal;

     $dias = 0;
     $consultas = 0;
     $espera = 0;
     $revs   = 0;
     $maximo = 0;
     $minimo = 9999999999;

     echo "<h2><center>$sucursal</center></h2>\n";
// ** Para cada paciente
     $q1 = mysql_query("select Paciente from Horarios,Consultorios where Paciente !=0 and Fecha >= '$FECHADESDE'  and Fecha <= '$FECHAHASTA' and Horarios.Consultorio = Consultorios.Codigo and Sucursal = '$sucursal' group by Paciente");
     while($reg=mysql_fetch_object($q1))
       {
           $pac = $reg->Paciente;

           // **** Saco la fecha de la ultima revision
//           $q2 = mysql_query("select Fecha from Horarios,Consultorios where Procedimiento = 1 and Paciente=$pac  and Fecha >= '$FECHADESDE' and Fecha <= '$FECHAHASTA' and Horarios.Consultorio = Consultorios.Codigo and Sucursal = '$sucursal' order by Fecha  desc");
           $q2 = mysql_query("select Fecha from Horarios where Procedimiento = 1 and Paciente=$pac  and Fecha >= '$FECHADESDE' and Fecha <= '$FECHAHASTA' order by Fecha  desc");
           $regq2 = mysql_fetch_object($q2);
           $fechaInicial = $regq2->Fecha;
           $primera = 1;
	   $norev   = 0;
	   // ******** en el caso de que esta fecha sea vacia este pac no tuvo revision en este periodo
	   // ******** por lo tanto la primer fecha sirve y no la de revision
	   if(empty($fechaInicial))
	    {
           	$q2 = mysql_query("select Fecha from Horarios,Consultorios where 	  Paciente=$pac  and Fecha >= '$FECHADESDE' and Fecha <= '$FECHAHASTA' and Horarios.Consultorio = Consultorios.Codigo and Sucursal = '$sucursal' order by Fecha  desc");
           	$regq2 = mysql_fetch_object($q2);
           	$fechaInicial = $regq2->Fecha;
		$primera=0;
		$norev=1;
	    } else
	       {   // ****** si es una revision tengo ge sumar 1 *****
	               $revs = $revs + 1;
	       }


           // **** Ahora miramos los proc posteriores y sacamos el prom
           $fecha1 = $fechaInicial;

           $difa = 0;
//echo "<hr>$pac";

           $q3 = mysql_query("select Fecha from Horarios, Consultorios where Paciente=$pac and Fecha > '$fechaInicial' and Fecha <= '$FECHAHASTA' and Horarios.Consultorio = Consultorios.Codigo and Sucursal = '$sucursal' order by Fecha");
           while(($regq3=mysql_fetch_object($q3)) && !empty($fecha1))
             {
                $fecha2 = $regq3->Fecha;
//		echo "Fecha2 es $fecha2<br>";
                if($primera==1)
                   {
                        $difa = date_diff($fecha2, $fechaInicial);
                        //$revs = $revs + 1;
                        $primera = 0;
                   }
                else
                {
//		if($norev==1)
//                   $difa = date_diff($fecha2, $fechaInicial);

//echo "difa $difa<br>";
                $ddias = date_diff($fecha2, $fecha1);
//echo "ddias $ddias<br>";
//echo "consultas es $consultas<br>";
                if($ddias<365)      //** Para el caso de gente que retomo
                   {
//   echo "entre<br>";
                      $dias = $dias + $ddias;
                      $consultas = $consultas + 1;
                      if($difa > $mayor)
                           $mayor = $difa;
                      if($difa < $minimo)
                           $minimo = $difa;
                      if($ddias > $mayor)
                           $mayor = $ddias;
                      if($ddias < $minimo)
                           $minimo = $ddias;

//echo "mayor = $mayor<br>";
//echo "minimo = $minimo<br>";
                   }
              }
             $fecha1 = $fecha2;
             }
	   if($norev==0)
              $espera = $espera + $difa;
       }

      if($consultas==0)
         $consultas = 1;
      $promedio = $dias / $consultas;
      if($revs==0)
         $revs=1;
      $espera = $espera / $revs;
      echo "El promedio de espera entre consultas es : <b>$promedio</b> dias calculados sobre <b>$consultas</b> casos<br>";
      echo "La espera promedio desde la revision hasta la primera consulta es : <b>$espera</b> dias, se consideraron <b>$revs</b><br>";
      echo "El paciente que espero mas tiempo lo hizo <b>$mayor</b> dias<br>\n";
      echo "El paciente que espero menos tiempo lo hizo <b>$minimo</b> dias<br>\n";
      echo "<hr>\n";
 }
}
?>
