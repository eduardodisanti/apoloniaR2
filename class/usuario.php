<?php
class usuario
 {
           var $usuario="";
           var $clave="";
           var $email="";
           var $funcionario=0;
           var $cargo="";
           var $nivel=-1;
           var $medico=98;
	   var $rol=-1;
	   var $validar = true;

   function usuario($numero,$pass, $validar)
        {
	       $validar = true;
	       $query="select usuario,clave,email,funcionario,cargo,nivel,medico,rol from Usuarios where usuario='$numero'";
	       $q=mysql_query($query);
	       $error=mysql_error();
	       if(!empty($error))
	           die("usuario.php: $error link es $link");
	       $reg=mysql_fetch_object($q);

	       //echo "<br>".$query."-".$reg->clave."-$pass"."<br>";
	       if(!empty($reg->usuario))
	          if($validar && $reg->clave == $pass)
	            {
		          $this->usuario=$reg->usuario;
		          $this->clave=$reg->clave;
		          $this->email=$reg->email;
		          $this->funcionario=$reg->funcionario;
		          $this->cargo=$reg->cargo;
		          $this->nivel=$reg->nivel;
		          $this->medico=$reg->medico;
		          $this->rol   =$reg->rol;
		       }
		         else
		             $this->nivel=-1;
         }



   function usuarios($numero,$pass)
     {
       $validar = true;
       $query="select usuario,clave,email,funcionario,cargo,nivel,medico,rol from Usuarios where usuario='$numero'";
       $q=mysql_query($query);
       $error=mysql_error();
       if(!empty($error))
              die("usuario.php: $error link es $link");

       //echo "<br>".$query."-".$reg->nivel."<br>";
       $reg=mysql_fetch_object($q);
       if(!empty($reg->usuario))
         if($reg->clave==$pass && $validar)
         {
       $this->usuario=$reg->usuario;
       $this->clave=$reg->clave;
       $this->email=$reg->email;
       $this->funcionario=$reg->funcionario;
       $this->cargo=$reg->cargo;
       $this->nivel=$reg->nivel;
       $this->medico=$reg->medico;
       $this->rol   =$reg->rol;
         }
          else
             $this->nivel=-1;
     }
           
 }
?>
