<?php

session_start();
		$_SESSION['coifuncionario']=$usr->funcionario;
		$_SESSION['coinivelusuario']=$usr->nivel;
		$_SESSION['coisucursal']=$sucursal;
		$_SESSION['coimedico']=$usr->medico;
		$_SESSION['coiusuario']=$usuario;
		$_SESSION['coiclave']=$clave;
                $_SESSION['coisucursal_ses']=$sucursal;

                setcookie("coifuncionario",$usr->funcionario);    
                setcookie("coinivelusuario",$usr->nivel);
                setcookie("coisucursal", $sucursal);
                setcookie("coimedico",$usr->medico);
?>
<html>
<head>

  <meta http-equiv="CONTENT-TYPE" content="text/html; charset=iso-8859-1">
  <title>Salir del sistema mateo</title>

  <meta name="GENERATOR" content="StarOffice/5.2 (Win32)">

<style type="text/css">
     A:link  {color:#9A3D3F}
     A:visited {color:#9A3D3F}
     A:hover {color: #C44487}

     BODY{font-family: 'Lucida Sans',serif}
</style>
</head>
<body>
<center>Usted se ha desconectado del sistema<br>
<a href='#' onclick='window.close()'>Pulse aqui para cerrar esta ventana</a>
</body>
</html>
