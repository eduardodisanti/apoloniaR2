<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2//EN">
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
</head>

<body bgcolor="#dfffff">
<center>
<Font size=8>Cambiar su clave</font><hr>
<?php
 if(empty($coiusuario) || $coiusuario=="0")
   {
     die("<center><br>Debe estar identificado para poder anotar<br><a href=\"logon.php\">Pulse aqui para identificarse</a>\n<center>");
   }
 include("../class/usuario.php");
 include("../functions/db.php");

 $link=conectar();
 $usr = new usuario($coiusuario,$coiclave, truev);

 if($comando=="Actualizar")
   {
     $q="update Usuarios set clave='$clave' where funcionario=$funcionario";
     query($q);
     
     // cambio la clave del hermes
     $email = $usr->email;
     
     $datos = array('cliente'=>'111',               'usuario'=>$coiusuario,               'clave'=>$clave,               'email'=>$email,
               'cmd'=>'mod');                  $d = http_build_query($datos);      $u = "hermes.kcreativa.com/script/ua.php?$d";
     $h=fopen("http://$u", "r");

   $cmd="chpasswd " . $coiusuario . ":" . $clave;
      exec($cmd,$output,$status);
      die( $ouput."-".$status);
   }

    echo "<b>Cambiar su clave</b>";
    $q="select * from Usuarios where usuario='$coiusuario'";
    $query=query($q);
    echo "<center><table border=0 width=90% bgcolor=\"#cddddd\">";
    echo "<tr><th>Num</th><th>Usuario</th><th>Clave</th><th>email</th><th>Cargo</th><th>Nivel</th>\n";
    while($reg=fetch($query))
      {
         $funcionario=$reg->funcionario;
         $usuario=$reg->usuario;
         $clave=$reg->clave;
         $email=$reg->email;
         $cargo=$reg->cargo;
         $nivel=$reg->nivel;
         echo "<form action=\"datos.php\" method=post>\n";
         echo "<tr>\n";
echo "<input type=\"hidden\" name=\"funcionario\" value=\"$funcionario\">\n";
echo "<td><b>$funcionario</b></td>";
echo "<td>$usuario</td>";
echo "<td><input type=password name=\"clave\" value=\"$clave\" size=8></td>";
echo "<td>$email</td>";
echo "<td>$cargo</td>";
echo "<td>$nivel</td>";
echo "<td><input type=SUBMIT name=\"comando\" value=\"Actualizar\"></td>";
         echo "</tr>\n";
         echo "</form>\n";
      }
echo "</form>\n"; 
    echo "</table>";
   echo "<br><br>\n";

   echo "<font size=+2><a href=\"javascript:history.back()\">Volver</a></font>";
?>

</body>
</html>
