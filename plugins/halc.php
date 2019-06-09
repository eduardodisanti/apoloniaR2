<?php

   session_start();

   $coiusuario = $_SESSION['coiusuario'];
   $coiclave   = $_SESSION['coiclave'];

echo "<script src='../ajax/kajax.js'></script>";
echo "<script>";
echo "

function interpretarHermes(resultado, usuario, cliente,clave) {

     var sino, cant, res, x, imagen, y;
    
     //alert(resultado);
     res = resultado.split(\"|\");
     sino = res[0];
     cant=  res[1];

     switch(sino)
	    {
	      case 'X' : mensaje=\"Problemas en hermes\";
	          imagen=\"img/x.png\";
	      break;
              case 'N' : mensaje=\"Hermes no tiene nada para responderle \";
                  imagen=\"img/pacing.gif\";
	      break;
	      case 'S' : mensaje=\"Hermes tiene \"+ cant + \" respuestas sobre sus reclamos \";
	          imagen=\"img/lghtbulb.gif\";
	      break;
	   }
   
   xusuario = escape(usuario);
   xclave = escape(clave);
   
   x =\"'\";
   x+='http://hermes.kcreativa.com/script/hermes.php';
   x+='?cliente='+cliente;
   x+='&usuario='+xusuario;
   x+='&clave='+xclave;
   x+='&resolvido=N';
   x+='&validado=N';
   x+='&accion=login';
   x+=\"',\";
   x+=\"'hermes\";
   x+=\"',\";
   x+=\"'location=0,scrollbars=1,resizable=1\";
   x+=\"'\";
      
   
   y = \"<img src='\"+imagen+\"' border=0 align=middle height=30>\";

   y+= \"<input type=submit name=cmd value='\"+cant+\"' onclick=window.open(\"+x+\")>\";
   //x+= \"</form>\";

   return(y);
}

function comprobar(prov, id, clave, area)
{
  var precio, resultado;

      xid = document.getElementById(area);

     // aca hago mi llamada tipo AJAX 

     ajax = nuevoAjax();

     ajax.open(\"POST\", \"halcc3.php\", true);
     ajax.onreadystatechange=function(){
     if(ajax.readyState==4) {
	      resultado = ajax.responseText;
	      xid.innerHTML = interpretarHermes(resultado, id, prov, clave);
       } 
         else
	      xid.innerHTML = '<img src=\"img/pacing.gif\" width=64>';
    }

  ajax.setRequestHeader(\"Content-Type\",\"application/x-www-form-urlencoded\");
  ajax.send(\"cliente=\"+prov+\"&usuario=\"+id);
}
</script>";

function proxy_url($proxy_url)
{
   $proxy_name = '10.100.201.2';
   $proxy_port = 3128;
   $proxy_cont = '';

   $proxy_fp = fsockopen($proxy_name, $proxy_port);
   if (!$proxy_fp)    {return("X|0");}
       fputs($proxy_fp, "GET $proxy_url HTTP/1.0\r\nHost: $proxy_name\r\n\r\n");
   while(!feof($proxy_fp)) {$proxy_cont .= fread($proxy_fp,4096);}
   fclose($proxy_fp);
   $proxy_cont = substr($proxy_cont, strpos($proxy_cont,"\r\n\r\n")+4);
   return $proxy_cont;
} 


echo "<div id=hal style='position:absolute;top:0;left:0'>";

   echo "<table border=0>";
   echo "<tr>";
   echo "<td id='area'>hal</td>";
   echo "</tr>";
   echo "</table>";
      echo "<script>";
      echo "comprobar(111,'$coiusuario', '$coiclave', 'area');";
      echo "</script>";
   
echo "</div>";
?>
</body>
