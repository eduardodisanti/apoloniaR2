<script languaje="javascript">
function abrir(dia, turno)
  {
     var url;
     
     url="moldeturno.php?dia="+dia+"&turno="+turno;
     if(dia==0)
        url=url+"&comando=Nuevo";
     window.open(url,"Turno","width=500,height=450,resizable,scrollbars");
  }
</script>
<?php

 require("../functions/db.php");
 
 $link=conectar();

 if(empty($comando))
   $comando="semana";
   
 switch ($comando)
   {
      case "semana" :
             mostrar_semana();
           break;
   }
 
 desconectar();
 
 function mostrar_semana()
  {
      $r=1;
      $dia_ant=null;

      echo "<center><a href='#' onclick='abrir(0,0)'>Agregar Turno</a></center>\n";      
      echo "<table border=0 bgcolor='#000000' cellpadding='0' cellspacing='1' width='400px'>\n";
      echo "<tr bgcolor='#cccccc'><th>Dia</th><th width='50px'>Turno</th><th width='50px'  align='center'>Hora</th></tr>\n";
      
      $sql="select DiaDesde, Turno,Hora from Molde group by DiaDesde, Turno order by DiaDesde, Turno,Hora";
      $q = query($sql);
      echo mysql_error();
      while($reg = fetch($q))
         {
	    $dia = $reg->DiaDesde;
	    $turno= $reg->Turno;
	    $hora= $reg->Hora;
	    if($diaAnt!=$dia)
	      {
	        $diaAnt=$dia;
	    	switch($dia)
		{
	         case 1:
		       $xdia="Lunes";
		       break;
		 case 2:
		       $xdia="Martes";
		       break;
		 case 3:
		       $xdia="Miercoles";
		       break;
		 case 4:
		       $xdia="Jueves";
		       break;
		 case 5:
		       $xdia="Viernes";
		       break;
		 case 6:
		       $xdia="Sabado";
		       break;
		 case 7:
		       $xdia="Domingo";
		       break;
		}
	      } else $xdia="&nbsp;&nbsp";
	       
	    
	    if($r==0)
	      {
	       $color="#77AF77";
	       $r=1;
	      }
	    else
	       {
	         $color="#77AAAA";
	         $r=0;
	       }
	    echo "<tr bgcolor='$color'><td><b>$xdia</b></td><td align='center'><a href='#' onclick='abrir($dia,$turno)'>$turno</a></td><td>$hora</td></tr>\n";
	 }
      echo "</table>\n";
  }
?>
