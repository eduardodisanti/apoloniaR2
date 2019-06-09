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
<Font size=5>Vista de cuenta corriente</font><hr>
<?php
 $link=mysql_connect("127.0.0.1","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");
 include("../class/usuario.php");

 $usr = new usuario($coiusuario,$coiclave);

 if($usr->nivel < 3)
    {
      die("<center><br>No tiene autorizaci&oacute;n para ejecutar este comando<br><a href=\"index1.php\">Pulse aqui para volver</a>\n<center>");

    }

    $query=mysql_query("select Fecha,Hora,TipoMov,ImporteOrdenes,TipoOrden,escripcion as Descripcion,Valor from CuentaCorriente,Ordenes where Paciente=$ced and id=TipoOrden order by Fecha,Hora desc");

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
        	$qq=mysql_query("select Nombre from Procedimientos where Codigo=$proc");
			$rr=mysql_fetch_object($qq);
			$concepto=$rr->Nombre;
	     }
	 echo "	<td>$concepto</td>";
         echo "	<td align='center'>$xtipord</td>";
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
	echo "</tr>\n";
       }
              
    echo "</table>\n";
mysql_close();
?>
   <hr>
</body>
</html>
