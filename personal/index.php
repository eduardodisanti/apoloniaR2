<?php
    setcookie("volver","2");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

  <meta http-equiv="CONTENT-TYPE" content="text/html; charset=iso-8859-1">
  <title></title>

  <meta name="GENERATOR" content="StarOffice/5.2 (Win32)">


<style type="text/css">
     A:link  {color:#9A3D3F}
     A:visited {color:#9A3D3F}
     A:hover {color: #C44487}

     BODY{font-family: 'Lucida Sans',serif}
</style>

<?php include("menu/menu1h.html"); ?>

</head>

<body bgcolor="#8493AE">
<?php
    include("menu/menu1b.html");
    include("menu/barra1b.html");
?>
<center>
<table border="1" width="100%" height="100%" style="background:url(coi.jpg) no-repeat center">
<tr>
   <td>
       <?php
              if(empty($contenido))
	        $contenido="../mensaje.html";
	
	      echo "<iframe src='$contenido' name='contenido' width='100%' height=550></iframe>";
        ?>
   </td>
</tr>
</center>
</body>
</html>
