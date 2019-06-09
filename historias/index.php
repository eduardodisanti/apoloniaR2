<?php
    session_start();
    setcookie("volver","0");
    $_SESSION['coimedico']=0;
    if($comando=="Cambiar")
       {
               $_SESSION['coisucursal_ses']=$sucursal;
       }

       $coisucursal_ses=$_SESSION['coisucursal_ses'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

  <meta http-equiv="CONTENT-TYPE" content="text/html; charset=iso-8859-1">
  <title>
 <?php
      $dia = date("d-m-Y");
      $hora = date("H:i");

      echo "$coisucursal_ses Fecha: $dia - $hora";
 ?>
 </title>
</script>

<style type="text/css">
     A:link  {color:#9A3D3F}
     A:visited {color:#9A3D3F}
     A:hover {color: #C44487}

     BODY{font-family: 'Lucida Sanss',serif}
</style>
<?php 
      include("menu/menu3h.html");
?>
</head>

<body bgcolor="#8493AE">
<?php
    include("menu/menu3b.php");
    include("menu/barra1b.html");
?>

<center>
</center>
<center>
<table border="0" width="100%" height="100%" style="background:url(coi.jpg) no-repeat center">
<tr>
<td valign="top">
<div id=index style='position:relative;left:0;top:-50'>
	<?php
	     if(empty($contenido))
	       $contenido="listaconf.php";
	     echo "<iframe src=\"$contenido\" width='99%' height=440px border=0 name='contenido'></iframe>";

	?>
</div>
</td>
</tr>
<tr><td>
<?php
   include("menu/estado.php");
?>
</table>
</center>
<script>
if (parseInt(navigator.appVersion)>3)
top.resizeTo(1020,700);
</script>
</body>
</html>
