<?
  $link=mysql_connect("elias","apolonia","virgen") or
                         die("Error, no se puede abrir la base de datos".mysql_error());
      $db=mysql_select_db("apolonia"); 
 
   $primero=$dia;
   $elanio=$anio;

   $dia=1;
   $mes=1;

   $diasemana=$primero;

   while($mes<=12)
     {
        $amd=$elanio."-".$mes."-".$dia;
        $qq="insert into Calendario values('$amd',$diasemana,'N')"; 
        mysql_query($qq);
        $err=mysql_error();
        if(!empty($err))
           echo "$err<br>";
        $diasemana=$diasemana+1;
        if($diasemana==8)
           $diasemana=1;
        $dia=$dia+1;

        if(($mes==1 || $mes==3 || $mes==5 || $mes==7 || $mes==8 || $mes==10 || $mes==12) && $dia==32)
          {
             $mes=$mes+1;
             $dia=1;
          } else
               if(($mes==4 || $mes==6 || $mes==9 || $mes==11) &&
                   $dia==31)
                   {
	             $mes=$mes+1;
        	     $dia=1;
                   }
              else
                       if(($mes==2) && $dia==29)
                         {
                            $mes=$mes+1;
                            $dia=1;
                         }
     }
   mysql_close();
?>
