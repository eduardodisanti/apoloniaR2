<?php

  require("functions/db.php");
  require("functions/imap.php");
  require("functions/quota.php");
  include("class/usuario.php");
  include("plugins/log.php");

session_start();

if($situacion!="yalogeado")
{
 $link=conectar();
 $error=mysql_error();
 if(!empty($error))
       die("Error en select db: $error<br>");

        if(!empty($usuario))
         {
            setcookie("coiusuario", $usuario);
            setcookie("coiclave",   $clave);

            $usr = new usuario($usuario,$clave, true);
            if($usr->nivel>0)
             {
		$_SESSION['coifuncionario']=$usr->funcionario;
		$_SESSION['coinivelusuario']=$usr->nivel;
		$_SESSION['coisucursal']=$sucursal;
		$_SESSION['coimedico']=$usr->medico;
		$_SESSION['coimedico_ses']=$usr->medico;
		$_SESSION['coiusuario']=$usuario;
		$_SESSION['coiclave']=$clave;
        $_SESSION['coisucursal_ses']=$sucursal;
        $_SESSION['email_ses']=$usr->email;

        $_SESSION['almacen_coi_ses']=cargarAlmacen($sucursal);

                setcookie("coifuncionario",$usr->funcionario);    
                setcookie("coinivelusuario",$usr->nivel);
                setcookie("coisucursal", $sucursal);
                setcookie("coimedico",$usr->medico);
		escribir_log($usr->usuario, "Ingreso al sistema");
             }
                else {
		      escribir_log($usr->usuario, "Ingreso fallido");
                      die("<h2>Nombre de usuario o clave incorrecto<br><a href=\"logoncentral.php\">Pulse aqui para volver</a>");
		}
         }
  desconectar();
}
?>
<html>
<head>

  <meta http-equiv="CONTENT-TYPE" content="text/html; charset=iso-8859-1">
  <title></title>

  <meta name="GENERATOR" content="Smultron">

<style type="text/css">
     A:link  {color:#9A3D3F}
     A:visited {color:#9A3D3F}
     A:hover {color: #C44487}

     BODY{font-family: 'Lucida Sans',serif}
</style>
</head>

<body bgcolor="#6A98C9">
<center>
<form action="logoncentral.php" method="post">
<table border=0 width=30%>
<?php

$secusr = $_SESSION['coiusuario'];
$ip=@$REMOTE_ADDR;
$xip = substr($ip, 0, 6);

 $link=conectar();

       if(empty($usuario))
          $usuario="";
       $usr = new usuario($_SESSION['coiusuario'],$_SESSION['coiclave'], true);
$secusr = $usr->usuario;
$ip=@$REMOTE_ADDR;
$xip = substr($ip, 0, 6);
if(!estaautorizado($xip, $secusr)) {
	die("<h2>No autorizado a ingresar fuera de VPN ($ip) ($secusr)</h2>");
}

if($xip != "172.16" && $xip != "10.100" &&
   $secusr != "di santi eduardo"   &&
   $secusr != "carlevaro guyunusa" &&
   $secusr != "queiro beatriz" &&
   $secusr != "directores")
	      die("<h2>No autorizado a ingresar fuera de VPN ($ip) ($secusr)</h2>");
       if($usr->nivel!=-1)
         {
	    $usuariomail = strtok($usr->email, "@");
	    $dominio     = strtok("@");
            if($dominio=="cadi.com.uy")
	           $mbox = autenticar_imap($usr->email, $coiclave);
	        else
	          $mbox = "";    
	    if(!empty($mbox) || $mbox != "")
	        $mensajes = imap_mensajes_pendientes($mbox)." mensajes";
            else
	        $mensajes = "(No es posible ver sus mensajes pendientes en $usuariomail@$dominio)";

            if($usr->email > " ")
               $quota = calcularQuotaUsada($usr->email);
            else
               $quota = 0;

            echo "Bienvenido/a ($usr->funcionario) <b>$usr->usuario</b> su cargo es $usr->cargo<br>";
            echo "Su nivel de usuario es <b>$usr->nivel</b>, su correo es $usr->email<br>";
	    	echo "<font size='+1'>Usted tiene <b>$mensajes</b> sin leer</font><br>";
	    	echo "<font size='+1'>Usted esta utilizando el <b>$quota %</b> de su cuota de disco </font><br>";
            echo "<hr>\n";

            if($usr->email > " ")
	        $quota = calcularQuotaUsada($usr->email);
            else
	        $quota = 0;

	    if($quota > $MAXCUOTA)
	       {
	           alertarSobreQuota($quota, $MAXCUOTA);
	       }
	 
	    $roles = $usr->rol;
	    $largoRoles = strlen($roles);

	    echo "<table border=0 width=60% bgcolor='#000000' cellspacing=1>\n";
	    echo "<tr bgcolor='#cccccc'>";
	    echo "<td colspan=2 align='center'>Menu de $usr->usuario en <i>$coisucursal</i> ($ip)</td>";
	    echo "</tr>\n";
	    for($i=0;$i<$largoRoles;$i++)
	     {
	     
	       echo "<tr bgcolor='#ffffff'>";
	       $rol = substr($roles,$i,1);
	       switch ($rol)
	       {
	           case '1' : 
				$icono="agenda.png";
				$sistema="agenda";
				$nombre="Agenda de horarios";
			break;
			
	        case '2' : 
				$icono="historias.png";
				$sistema="historias";
				$nombre="Historias Cl&iacute;nicas";
			break;

	           case '3' : 
				$icono="stock.png";
				$sistema="stock";
				$nombre="Sistema de stock";
			break;

	           case '4' : 
				$icono="informes.png";
				$sistema="informes";
				$nombre="Informes generales";
			break;

	           case '5' : 
				$icono="personal.png";
				$sistema="personal";
				$nombre="Sistema de personal";
			break;

	           case '6' : 
				$icono="tiempos.png";
				$sistema="laboratorio";
				$nombre="Sistema de laboratorio";
			break;

                   case '7' :
		                $icono="today.png";
			        $sistema="ctacte";
			        $nombre="Sistema de Cuenta Corriente";
			break;

                   case '8' :
		                $icono="personal.png";
			        $sistema="provlab";
			        $nombre="Proveedor de Laboratorio";
                        break;

		  case 'A' :
		                $icono="lista.png";
			        $sistema="pagosyprov";
			        $nombre="Pagos y Proveedores";
			 break;


	           case '9' : 
				$icono="configure.png";
				$sistema="admin";
				$nombre="Administracion del sistema";
			break;

                case 'P' :
		                $icono="historias.png";
		                $sistema="historias4P";
		                $nombre="Odontologia Medica Uruguaya";
		        break;

	       }
		if($usr->rol==1)
		   $programa="historias/index.php";
		else
		   if($usr->rol==3)
	               $programa="stock/index.php";
		   else
	              $programa="agenda/index.php";

	              
		echo "  <td align='center'>";
			echo "  	<a href='$sistema/index.php'><img src='img/$icono' border=0></a>";
			echo "  </td>";
			echo "  <td>";
			echo "  	<a href='$sistema/index.php'>$nombre</a>";
			echo "  </td>";

		echo "</tr>\n";
	   }  
	    echo "<tr bgcolor='#F4F3E7'>";
	    echo "   <td align='center'>";
	    echo "	<a href='usr/datos.php'><img src='img/clave.png' border=0></a>";
	    echo "   </td>";
	    echo "   <td>";
	    echo "	<a href=\"usr/datos.php\">Cambiar su clave</a><br>";
	    echo "   </td>";
	    echo "</tr>\n";
	    echo "<tr bgcolor='#EBEBEB'>";
	    echo "   <td align='center'>";
	    echo "	<a href='desconectar.php'><img src='img/exit.png' border=0></a>";
	    echo "   </td>";
	    echo "   <td>";
	    echo "	<a href=\"desconectar.php\">Cerrar la sesion</a><br>";
	    echo "   </td>";
	    echo "</tr>\n";	    
	    echo "</table>\n";
          
       } else
              die("<h2>Nombre de usuario o clave incorrecto<br><a href='#' onclick='window.close()'>Cerrar esta ventana</a>"); 
     desconectar();

     function cargarAlmacen($sucursal) {

         $resp = 0;

         $query = "select almacen from Consultorios where Sucursal='$sucursal'";

         $qry = query($query);

         $reg = fetch($qry);

         return($reg->almacen);
     }
     
     function estaautorizado($xip, $secusr) {
     
     	// PRIMERO VEO LAS IPS AUTORIZADAS SIN RESTRICCIONES
     	$encontreip = false;
     	$encontreusr = true;
     	$fp = fopen("acl/ips.acl","r");
     	
     	$i=0;
     	
     	while($s = fgets($fp) && !encontreip) {
     		
     		if($xips == $s) 
     		   $encontreip = true;
       	}

     	fclose($fp);
     	
     	// SI NO ESTOY ACCEDIENDO DESDE UNA IP AUTORIZADA 
     	if(!encontreip) {
	     	$fp = fopen("acl/usuarios.acl","r");
     	
    	 	$encontreusr = false;
     	
     		while($s = fgets($fp) && !encontre) {
     		
     			if($secusr == $s) 
     		   	   $encontreusr = true;     		
     		}
         	fclose($fp);
     	} else
             $encontreusr = true;
              	      
     	return($encontreusr);
     }
?>
   <br>
   <hr>
</form>
</body>
</html>
