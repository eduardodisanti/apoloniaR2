<?php

if($accion=="Publicar")
{
    $fp=fopen("noticias.html","w");
      fputs($fp, $texto);
    fclose($fp);
}
   $fp=fopen("noticias.html","r");

   $mensaje="";
   while($x=fgets($fp))
    {
       $mensaje=$mensaje.$x;
    } 
   fclose($fp);

  echo "<center><b>Editar noticias</b></center>";
  echo "<form name='frm' action='editnews.php'>";
  echo "<textarea name='texto' cols=80 rows=20>$mensaje</textarea>";
  echo "<center><input type='submit' value='Publicar' name='accion'></center>";
  echo "</form>";

?>
