<?php
   function usuario($numero)
   {
      $query="select * from Usuarios where funcionario=$numero";
      $q= mysql_query($query);
      $reg=mysql_fetch_object($q);
      return($usr);
   }
?>
