<?php

    session_start();
?>

<html>
<head>
  <meta http-equiv="CONTENT-TYPE" content="text/html; charset=iso-8859-1">
  <title>Pase de cuarto piso</title>

<style type="text/css">
     A:link  {color:#9A3D3F}
     A:visited {color:#9A3D3F}
     A:hover {color: #C44487}

     BODY{font-family: 'Arial',serif}
</style>

</head>

<body bgcolor="#dfffff">
<center>
<Font size=5>Ingresar un pase</font><hr>
<form action="pase.php" method="post">
<?php

    $coiusario=$_SESSION['coiusuario_ses'];
    $coifuncionario=$_SESSION['coifuncionario_ses'];

 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");

 if($comando=="Aceptar")
   {
     if(empty($coifuncionario))
       $coifuncionario = 0;

     $hoy = Date("Y-m-d");
     $q = "insert into ParaHacer values($paciente, $pieza, $pieza, $procedimiento, '$comentario', $coifuncionario)"; 
     mysql_query($q);

     $error = mysql_error();
     if(!empty($error)) {
        echo "<script>alert('No se pudo agregar en el ParaHacer por $error EN $q')</script>";
     }

     $q = "insert into pases values($paciente, '$hoy', $pieza, $procedimiento, $medico)";
     mysql_query($q);

     if($proc==620)
       {
          $q = "insert into piezasPaciente values($paciente, $pieza, 4)";
	  mysql_query($q);
	  $q = "update piezasPaciente set estado=4 where pieza=$pieza and paciente=$paciente";
	  mysql_query($q);
       }
   }
    echo "Elegir la pieza";
    echo "<table border=0 width=90% bgcolor=\"#cddddd\">";
    echo "<tr>";
    echo "<td colspan=2>";
    echo "Paciente ";
    echo "<input type='text' name='paciente' value='$paciente'>";
    if(!empty($paciente)) {
          $q="select Cedula, Nombre from Pacientes where Cedula=$paciente";
	  $query=mysql_query($q);
	  $reg = mysql_fetch_object($query);
	  $nombre = $reg->Nombre;
    } else
          $nombre = "";

    echo "<input type='submit' value='Elegir' name='comando'>";
    echo $nombre;
    echo "</td>";
    echo "</tr>";
    echo "<tr>\n";
    echo "<td>";

    $q="select Pieza from Piezas order by Pieza";
    $query=mysql_query($q);

    echo "<select name='pieza' size=15>";
    while($reg=mysql_fetch_object($query))
      {
         $pieza=$reg->Pieza;
         echo "<option value='$pieza'>$pieza</option>\n";
      } 

    echo "</select>";
    echo "</td>\n";
    echo "<td valign=top>";
    echo "Procedimiento";
    
        $q="select * from Procedimientos order by Nombre";
        $query=mysql_query($q);

        echo "<select name='procedimiento'>";
        while($reg=mysql_fetch_object($query))
          {
           $proc=$reg->Codigo;
	   $nombre=$reg->Nombre;
           echo "<option value='$proc'>$nombre</option>\n";
	  }
       echo "</select>";

    echo "<br>";
        echo "Medico";
	    
        $q="select * from Medicos order by Nombre";
        $query=mysql_query($q);

        if(empty($medico))
	    $medico=0;
        echo "<select name='medico'>";
        while($reg=mysql_fetch_object($query))
         {       
           $med=$reg->Numero;
           $nombre=$reg->Nombre;

	   if($med==$medico)
	      $sel="selected";
	   else
	      $sel="";
           echo "<option value='$med' $sel>$nombre</option>\n";
         }
         echo "</select>";

    echo "<br>";
    echo "Comentario : <textarea name='comentario' cols=60 rows=10>$comentario</textarea>";
    echo "</td>";
    echo "</tr>\n";
    echo "</table>";
   echo "<br>\n";

   

mysql_close();
?>
   <br>
   <input type="submit" name="comando" value="Aceptar" >
   <hr>
</form>
</body>
</html>
