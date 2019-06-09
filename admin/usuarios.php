<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

  <meta http-equiv="CONTENT-TYPE" content="text/html; charset=iso-8859-1">
  <title></title>

  <meta name="GENERATOR" content="Smultron OS/X">

<style type="text/css">
     A:link  {color:#9A3D3F}
     A:visited {color:#9A3D3F}
     A:hover {color: #C44487}

     BODY{font-family: 'Lucida Sans',serif}
</style>
</head>

<body bgcolor="#dfffff">
<center>
<Font size=+1>Mantenimiento de usuarios</font><hr>
<?php
 if(empty($coiusuario) || $coiusuario=="0")
   {
     die("<center><br>Debe estar identificado para poder anotar<br><a href=\"logon.php\">Pulse aqui para identificarse</a>\n<center>");
   }
 include("../class/usuario.php");

 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");
 $usr = new usuario($coiusuario,$coiclave, true);

 if($usr->nivel < 9)
    {
      die("<center><br>No tiene autorizacion para ejecutar este comando<br><a href=\"index1.php\">Pulse aqui para volver</a>\n<center>");

    }

 if($comando=="Agregar")
   {
     if(empty($rol))
        $rol='0';

     $q="insert into Usuarios values('$usuario','$clave','$email',$funcionario,'$cargo',$nivel,$medico,'$rol')";
     mysql_query($q);
 
     $datos = array('cliente'=>'111',               'usuario'=>$usuario,               'clave'=>$clave,               'email'=>$email,
               'cmd'=>'mod');                  $d = http_build_query($datos);      $u = "hermes.kcreativa.com/script/ua.php?$d";
     $h=fopen("http://$u", "r");
     
     // ***** crear el usuario en el servidor local
     $s = system("sudo /srv/www/apoloniaR2/os/nuevousuario.sh $usuario $clave");
   }

 if($comando=="Bloquear")
   {
     $q="update Usuarios set clave='$clave',email='$email',usuario='$usuario',cargo='$cargo',nivel=0 where funcionario=$funcionario";
     mysql_query($q);
   }

 if($comando=="Actualizar")
   {
     $q="update Usuarios set clave='$clave',email='$email',usuario='$usuario',cargo='$cargo',nivel=$nivel,medico=$medico,rol='$rol' where funcionario=$funcionario";
     mysql_query($q);
     
     // ** cambio la clave en el hermes
     
     $datos = array('cliente'=>111,               'usuario'=>$usuario,               'clave'=>$clave,               'email'=>$email,
               'cmd'=>'mod');                  $d = http_build_query($datos);      $u = "hermes.kcreativa.com/script/ua.php?$d";
     $h=fopen("http://$u", "r");
   }

echo "<b>Lista de usuarios</b>";
    $q="select * from Usuarios order by usuario";
    $query=mysql_query($q);
    echo "<center><table border=0 width=80% bgcolor=\"#cddddd\">";
    echo "<tr><th>Num</th><th>Usuario</th><th>Clave</th><th>email</th><th>Cargo</th><th>Nivel</th><th>Medico</th><th>Rol</th>\n";
    while($reg=mysql_fetch_object($query))
      {
         $funcionario=$reg->funcionario;
         $usuario=$reg->usuario;
         $clave=$reg->clave;
         $email=$reg->email;
         $cargo=$reg->cargo;
         $nivel=$reg->nivel;
         $medico=$reg->medico;
	 $rol=$reg->rol;

         echo "<form action=\"usuarios.php\" method=post>\n";
         echo "<tr>\n";
echo "<input type=\"hidden\" name=\"funcionario\" value=\"$funcionario\">\n";
echo "<td><b>$funcionario</b></td>";
echo "<td>*<input type=input name=\"usuario\" value=\"$usuario\" size=12></td>";
echo "<td><input type=password name=\"clave\" value=\"$clave\" size=8></td>";
echo "<td><input type=input name=\"email\" value=\"$email\" size=20></td>";
echo "<td><input type=input name=\"cargo\" value=\"$cargo\" size=20></td>";
echo "<td><input type=input name=\"nivel\" value=\"$nivel\" size=1 maxlenght=1></td>";
echo "<td><input type=input name=\"medico\" value=\"$medico\" size=4></td>";
echo "<td><input type=input name=\"rol\" value=\"$rol\" size=6>";
echo "</td>";
echo "<td><input type=SUBMIT name=\"comando\" value=\"Actualizar\"></td>";
echo "<td><input type=SUBMIT name=\"comando\" value=\"Bloquear\"></td>";
         echo "</tr>\n";
         echo "</form>\n";
      }
echo "<form action=\"usuarios.php\" method=post>\n";
echo "<td><input type=input name=\"funcionario\" value=\"\" size=5></td>";
echo "<td><input type=input name=\"usuario\" value=\"\" size=12></td>";
echo "<td><input type=password name=\"clave\" value=\"\" size=8></td>";
echo "<td><input type=input name=\"email\" value=\"\" size=24></td>";
echo "<td><input type=input name=\"cargo\" value=\"\" size=24></td>";
echo "<td><input type=input name=\"nivel\" value=\"3\" size=1 maxlenght=1></td>";
echo "<td><input type=input name=\"medico\" value=\"0\" size=4></td>";
echo "<td><input type=input name=\"rol\" value=\"1\" size=6 maxlenght=6></td>";
echo "<td colspan=2><input type=SUBMIT name=\"comando\" value=\"Agregar\"></td>";
echo "</form>\n"; 
    echo "</table>";
   echo "<hr>\n";
?>

</body>
</html>
