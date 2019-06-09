<?php

    session_start();
    setcookie("volver","0");

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
    <?php
         if($coisucursal_ses=="CENTRAL")
               $SUCURSAL="Casa Central 8 de Octubre 2492";
         else
               if($coisucursal_ses=="PIEDRAS")
                         $SUCURSAL="Las Piedras";
               else
                    if($coisucursal_ses=="COLON")
                             $SUCURSAL="Colon";
                    else
                        if($coisucursal_ses=="TEJA")
                             $SUCURSAL="Teja";
			else
			      if($coisucursal_ses=="SOLYMAR")
			         $SUCURSAL="Solymar";
                               else
                                 $SUCURSAL="Todas";
    echo "<td height='12px' valign='top'>";
    echo " <form action='index.php' method=POST>\n";
    echo "  Usted esta en <font size=+0>Sucursal: <b>$SUCURSAL</b></font>";
    require_once("../functions/db.php");
    $link=conectar();

    echo "&nbsp;&nbsp;<select name='sucursal'>\n";
    $query=query("select Sucursal from Consultorios group by Sucursal");
    while($reg=fetch($query))
      {
        if($reg->Sucursal==$coisucursal_ses)
	  $sel="SELECTED";
	else
	  $sel="";

         echo "<option value='$reg->Sucursal' $sel>$reg->Sucursal</a>\n";
      }
    echo "</select>";
    echo "<input type='submit' value='Cambiar' name='comando'> su ip: ". $_SERVER["REMOTE_ADDR"];
    echo "</form>";
    echo "</td>";
    desconectar();
    ?> 
</tr>
<tr>
<td valign="top">
<div id=index style='position:relative;left:0;top:-50'>
	<?php
	     if(empty($contenido))
	       $contenido="laboratorio.php";
	     echo "<iframe src=\"$contenido\" name=\"contenido\" width='99%' height=440px border=0></iframe>";
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
