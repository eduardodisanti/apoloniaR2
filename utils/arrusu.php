<?php


$link=mysql_connect("elias","root","virgen");

   mysql_select_db("apolonia");

   $query="select * from Usuarios";
   $q = mysql_query($query);
   while($reg=mysql_fetch_object($q))
       {
          $funcionario = $reg->funcionario;
	  $usuario     = $reg->usuario;

	  $aux = $usuario + 0;

          $medico = $reg->medico;
	  if($medico==1) {

            if($aux == $usuario)
	      mysql_query("update Usuarios set medico = $aux where funcionario=$funcionario"); 
            else
	      mysql_query("update Usuarios set medico = funcionario where funcionario=$funcionario");
	  }
       }

?>
