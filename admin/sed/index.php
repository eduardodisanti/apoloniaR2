<?php
    setcookie("volver","0");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

  <meta http-equiv="CONTENT-TYPE" content="text/html; charset=iso-8859-1">
  <title>
 <?php
      $dia = date("d-m-Y");
      $hora = date("H:i");
      echo "$coisucursal Fecha: $dia - $hora";
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
      include("menu/menu1h.html");
?>
</head>

<body bgcolor="#8493AE">
<?php
    include("menu/menu1b.html");
    include("menu/barra1b.html");
?>

<center>
</center>
<center>
<table border="1" width="100%" height="100%" style="background:url(coi.jpg) no-repeat center">
<tr>
<td valign="top">
	<?php
	     if(empty($contenido))
	       $contenido="admin.php";
	     echo "<iframe src=\"$contenido\" name=\"contenido\" width='100%' height=500px scrollbars=auto></iframe>";
	?>
</td>
</tr>
</table>
</center>
</body>
</html>
