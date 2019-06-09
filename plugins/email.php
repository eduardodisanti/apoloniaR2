<?php

session_start();
echo "<head>";
echo "<meta http-equiv='refresh' content='1200'>";
echo "</head>";

  require("../functions/imap.php");
  
  echo "<script src='../ajax/kajax.js'></script>";
echo "<script>";
echo "

function interpretarMail(resultado, usuario) {

     var sino, cant, res, x;

     res = resultado.split(\"|\");
     sino = res[0];
     cant=  res[1];

    imagen=\"img/x.png\";
     switch(sino)
	    {
	      case 'X' : mensaje=\"No puedo conectarme al correo\";
	          imagen=\"img/x.png\";
	      break;
              case 'N' : mensaje=\"No hay correo nuevo \";
                  imagen=\"img/happycomp.gif\";
	      break;
	      case 'S' : mensaje=\"Usted tiene \"+ cant + \" correos sin leer \";
	          imagen=\"img/email.gif\";
	      break;
	   }

   x = '<img src='+\"'\";
   x+= imagen;
   x+= \"' width=32>\";
   x+=cant;
   return(x);
}

function comprobar(id, clave, area)
{
  var precio, resultado;

      xid = document.getElementById(area);

     // aca hago mi llamada tipo AJAX 

     ajax = nuevoAjax();

     ajax.open(\"POST\", \"miroemail.php\", true);
     ajax.onreadystatechange=function(){
     if(ajax.readyState==4) {
	      resultado = ajax.responseText;
	      xid.innerHTML = interpretarMail(resultado, id);
       } 
         else
	      xid.innerHTML = '<img src=\"img/pacing.gif\" width=64>';
    }

   ajax.setRequestHeader(\"Content-Type\",\"application/x-www-form-urlencoded\");
   ajax.send(\"usuario=\"+id+\"&clave=\"+clave);
}
</script>";

echo "<div id=hal style='position:absolute;top:0;left:0'>";
$xusuario = $_SESSION['email_ses'];
$clave = $_SESSION['coiclave'];

echo "<table border=0>";
echo "<tr>";
echo "<td id='areaemail'>email";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<script>";
echo "comprobar(\"$xusuario\", \"$clave\", \"areaemail\")";
echo "</script>";

echo "</div>";
?>
