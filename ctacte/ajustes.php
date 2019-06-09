<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2//EN">
<html>
<head>

  <meta http-equiv="CONTENT-TYPE" content="text/html; charset=iso-8859-1">
  <title>Ajustes de Cuenta Corriente</title>

<style type="text/css">
     A:link  {color:#9A3D3F}
     A:visited {color:#9A3D3F}
     A:hover {color: #C44487}

     BODY{font-family: 'Lucida Sans',serif}
</style>
</head>

<body bgcolor="#a4b6d4">
<center>
<Font size=5>Ajustes de cuenta corriente</font><hr>
<?php
 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");
 include("../class/usuario.php");

 $usr = new usuario($coiusuario,$coiclave, 0);

 if($usr->nivel < 3)
    {
      die("<center><br>No tiene autorizaci&oacute;n para ejecutar este comando<br><a href=\"index1.php\">Pulse aqui para volver</a>\n<center>");

    }

 if(empty($comando))
  {
    echo "<form action='ajustes.php'>";
    echo "<b>Paso 1</b>, identificar al socio ";
    echo "Cedula : <input type=\"TEXT\" name=\"ci\" value=\"\" length=8 maxlength=9>";
    echo "<br><br>\n";
    echo "<input type=\"submit\" name=\"comando\" value=\"Paso2\">\n";
    echo "</form>";
  }

if($comando=='dl')
  {
    $q = mysql_query("delete from CuentaCorriente where Paciente=$paciente and Fecha='$fecha' and Hora='$hora'");
    $comando="Paso2";
    $ci=$paciente;

    $tx = "update Deudas set Ordenes = Ordenes - $importe, taller = Taller - $taller  where Paciente=$ci and Procedimiento = $procedimiento and Pieza=$pieza)";
    $q = mysql_query($tx);
  }
  
if($comando=='Ajustar')
  {
    $hora=date("U");
    $tx= "insert into CuentaCorriente values($ci, '$fecha', '$hora', 999,0,'$tipo',$importe,'$orden','N')";
    $q = mysql_query($tx);

    $tipoord=$orden;
    $tipmov=$tipo;
    $comando="Paso2";

    $tx = "update Deudas set Ordenes = Ordenes - $importe, taller = Taller - $taller  where Paciente=$ci and Procedimiento = $procedimiento and Pieza=$pieza)";
    $q = mysql_query($tx);

  }

  
if($comando=="Paso2")
  {
   echo "<form action=\"ajustes.php\" method=\"post\">\n";  	
   $ced=$ci;
   $query=mysql_query("select * from Pacientes where Cedula=$ced") or 
         die("(mirarpaciente.php) Error en bd, falla debido a ".mysql_error());
   $error=mysql_error();
   $rowi=mysql_fetch_object($query);

   if(empty($rowi))
     {
       echo "<font color=\"#fbffff\"><b>El paciente no existe #$error</b></font>";
       if($volver!="2")
           die("Pulse <a href=\"/agenda/index1.php\">aqui</a> para volver");
     }
   $seguro=$rowi->Seguro;
   $paga=$rowi->Paga;
   $telefono=$rowi->Telefono;
   $domicilio=$rowi->Domicilio;
   $habilit=$rowi->Habilitado;
   $Paga=$rowi->Paga;

     echo "   <table border=0>";
     echo "   <tr>";
     echo "       <td><font color=\"#fbffff\">Cedula $ced</font></td>";
     echo "       <td><font color=\"#fbffff\"><b>$rowi->Nombre</b></font></td>";
     echo "       <td><font color=\"#fbffff\">Seguro: $rowi->Seguro</font></td>";
     echo "   </tr>";
     echo "   <tr>";
     echo "       <td>Telefono : <b>$telefono</b></td><td>Domicilio : <b>$domicilio</b></td>";
     echo "</table>";
     
    echo "<table border=1>";
    echo "<tr>";
    echo "	<td>Fecha del ajuste</td><td><input type='text' name='fecha' value='$fecha' size=10></td>";
//    echo "</tr>";
//    echo "<tr>";
    if($tipmov=='1')
      {
        $sel1="selected";
        $sel2="";
      }
    else
      {
      	$sel1="";
        $sel2="selected";
      }
    echo "	<td>Tipo de ajuste</td>";
    echo "  <td>";
    echo "		<select name='tipo' size=2>\n";
    echo "          <option value='1' $sel1>Debito</option>\n";
    echo "          <option value='2' $sel2>Cr&eacute;dito</option>\n";    
    echo "      </select>\n";
    echo "  </td>";
    echo "</tr>";    
    echo "<tr>";
    echo "	<td>Cant. de ordenes</td>";
    echo "	<td align=right><input type='text' name='importe' value='$importe' size=5></td>";
    echo "	<td>Concepto</td>";    
    echo "  <td>";
    echo "		<select name='orden'>\n";
    $q=mysql_query("select * from Ordenes order by escripcion");
    while($reg=mysql_fetch_object($q))
      {
      	 $id=$reg->id;
      	 $desc=$reg->escripcion;
      	 $val=$reg->Valor;
      	 
      	 if($tipoord==$id)
      	     $sel="selected";
      	 else
      	     $sel="";
      	 echo "          <option value='$id' $sel>$desc - \$$val</option>";
      }
    echo "      </select>\n";
    echo "  </td>";
    echo "</tr>";
    echo "<tr>";
    echo "  <td colspan=4 align='center'>";
    echo "		<input type='submit' name='comando' value='Ajustar'>";
    echo "  </td>";
    echo "</tr>";
    echo "</table>";     
    echo "<input type='hidden' name='ci' value='$ced'>";
    echo "</form>";

    $query=mysql_query("select Fecha,Hora,TipoMov,ImporteOrdenes,TipoOrden,escripcion as Descripcion,Valor from CuentaCorriente,Ordenes where Paciente=$ced and id=TipoOrden order by Fecha,Hora desc limit 100");

     echo "<table boder=0 bgcolor='#000000' width='500px'>";
     echo "<tr bgcolor='#cccccc'>";
     echo "	<td align='center'>Fecha</td>";
     echo "	<td align='center'>Concepto</td>";
     echo "	<td align='center'>Orden</td>";
     echo "	<td align='center'>Debe</td>";
     echo "	<td align='center'>Haber</td>";
     echo "	<td align='center'>&nbsp;</td>";
     echo "</tr>\n";

     while($reg=mysql_fetch_object($query))
       { 
         $fecha=$reg->Fecha;
         $hora = $reg->Hora;
         $tipmov=$reg->TipoMov;
	 	 $proc=$reg->Procedimiento;
         $impo=$reg->ImporteOrdenes;
         $tipord=$reg->TipoOrden;
         $xtipord="$reg->Descripcion ($reg->Valor) $reg->TipoOrden";
         echo "<tr bgcolor='#ffffff'>"; 
         echo "	<td>$fecha</td>";
	 if($proc==0)
	    {
	    	switch($tipmov)
	    	    {
	    	    	  case "1":
	    	    	             $concepto="Ajuste de Debito";
	    	    	  		break;
	    	    	  case "2":
	    	    	             $concepto="Ajuste de Credito";
	    	    	  		break;
	    	    	  case "3":
	    	    	             $concepto="Pago";
	    	    	  		break;	    	    	  		
	    	    }
	    }
	 else
	     {
        	$qq=mysql_query("select Nombre, Ordenes, ImporteTaller from Procedimientos where Codigo=$proc");
			$rr=mysql_fetch_object($qq);
			$concepto=$rr->Nombre;
	     }
	 echo "	<td>$concepto</td>";
         echo "	<td align='center'>$tipord</td>";
	 if($tipmov=="D" || $tipmov=="1")
	   {
	        $xdebe=sprintf("%4.2f",$impo);
		$xhaber="";
	   } else
	          {
			$xhaber=sprintf("%4.2f",$impo);
			$xdebe="";
		  }
	echo "	<td align='right'>$xdebe</td>";
	echo "	<td align='right'>$xhaber</td>";
	echo "	<td align='center'>";
	if($tipmov==1 || $tipmov==2)
	    echo "<a href='ajustes.php?comando=dl&fecha=$fecha&hora=$hora&paciente=$ced&tipoord=$tipord&importe=$impo&tipmov=$tipmov'><img src='../img/cancel.png' border=0></a></td>";
	echo "</tr>\n";
       }
              
    echo "</table>\n";
  }

if($comando=="Paso3")
  {
  }

mysql_close();
?>
   <hr>
   <font size=+1><a href="ajustes.php?cmd=">Otro paciente</a></font>
</body>
</html>
