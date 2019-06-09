<html>
<head>
<script language="javascript" type="text/javascript" src="../jscripts/tiny_mce/tiny_mce.js"></script>

<script language="javascript" type="text/javascript">
tinyMCE.init({
mode : "textareas",
theme : "advanced",
plugins : "table,save,advhr,advimage,advlink,emotions",
theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,forecolor,backcolor",
theme_advanced_buttons2 : "tablecontrols,separator,emotions",
theme_advanced_buttons3 : "",
theme_advanced_toolbar_location : "top",
theme_advanced_toolbar_align : "left",
extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"
});
</script>
</head>
<body>
<?php

if($accion=="Publicar")
{
    $fp=fopen("mensaje.html","w");
      fputs($fp, $texto);
    fclose($fp);
}

$fp=fopen("mensaje.html","r");

   $mensaje="";
   while($x=fgets($fp))
    {
       $mensaje=$mensaje.$x;
    } 
   fclose($fp);

  echo "<center><b>Editar cartelera</b></center>";
  echo "<form name='frm' action='editboard.php'>";
  echo "<textarea name='texto' cols=80 rows=20>$mensaje</textarea>";
  echo "<center><input type='submit' value='Publicar' name='accion'></center>";
  echo "</form>";

?>
</body>
</html>
