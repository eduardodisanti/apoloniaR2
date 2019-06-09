<html>
<head>

<?php

if($accion=="Publicar")
{
    $fp=fopen("../textos/textoorden.txt","w");
      fputs($fp, $texto);
    fclose($fp);
}

$fp=fopen("../textos/textoorden.txt","r");

   $mensaje="";
   while($x=fgets($fp))
    {
       $mensaje=$mensaje.$x;
    } 
   fclose($fp);

  echo "<center><b>Texto de la orden impresa</b></center>";
  echo "<form name='frm' action='editorden.php'>";
  echo "<textarea name='texto' cols=80 rows=10>$mensaje</textarea>";
  echo "<center>";
  echo "<input type='submit' value='Publicar' name='accion'>";
  echo "<a href='../agenda/ordenGD.php'>Probar la orden</a>";
  echo "</center>";
  echo "</form>";

?>
</body>
</html>
