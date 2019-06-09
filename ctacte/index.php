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
    <?php
         if($coisucursal=="CENTRAL")
               $SUCURSAL="Casa Central 8 de Octubre 2492";
         else
               if($coisucursal=="PIEDRAS")
                         $SUCURSAL="Las Piedras";
               else
                    if($coisucursal=="COLON")
                             $SUCURSAL="Colon";
                    else
                        if($coisucursal=="TEJA")
                             $SUCURSAL="Teja";
                    else
                             $SUCURSAL="Todas";
    echo "<td height='16px'><font size=+0>Sucursal: <b>$SUCURSAL</b></font></td>";
    ?> 
</tr>
<tr>
<td valign="top">
	<?php
	     if(empty($contenido))
	       $contenido="cuentas.php";
	     echo "<iframe name='contenido' src=\"$contenido\" width='100%' height=550px></iframe>";
	?>
</td>
</tr>
</table>
</center>
</body>
</html>
