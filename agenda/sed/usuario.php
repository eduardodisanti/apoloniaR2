<?php
class usuario
 {
           var $usuario="";
           var $clave="";
           var $email="";
           var $funcionario=0;
           var $cargo="";
           var $nivel=0;
           var $medico=98;

   function usuario($numero,$pass)
     {
       $query="select usuario,clave,email,funcionario,cargo,nivel,medico from Usuarios where usuario='$numero'";
       $q=mysql_query($query);
       $error=mysql_error();
       if(!empty($error))
              die("usuario.php: $error link es $link");
       $reg=mysql_fetch_object($q);
       if(!empty($reg) and $reg->clave==$pass)
         {
       $this->usuario=$reg->usuario;
       $this->clave=$reg->clave;
       $this->email=$reg->email;
       $this->funcionario=$reg->funcionario;
       $this->cargo=$reg->cargo;
       $this->nivel=$reg->nivel;
       $this->medico=$reg->medico;
         }
          else
             $this->nivel=-1;
     }
           
 }
?>
