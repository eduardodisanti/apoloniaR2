<?php

   $db=mysql_connect("elias","apolonia","virgen");
   mysql_select_db("apolonia");

   if($cmd=="add")
      {
          $r=mysql_query("insert into jerarquiaProcedimientos values($procPadre, $procAnulado)");
      } else
          if($cmd=="del")
	    {
		$r=mysql_query("delete from jerarquiaProcedimientos where procedimientoPadre = $procPadre and procedimientoAnulado = $procAnulado");
	    }

   $err = mysql_error();
   if(!empty($err))
        die("Error, avisar $err");

   echo "<center>Mantenimiento de Jerarquia de Procedimientos</center><br>";

   $query = mysql_query("select * from Procedimientos where Activo='S' order by Nombre");


   echo "<form action='jerarquiaProcedimientos.php'>";
   echo "<select name = procedimiento id=procedimiento>";
   while($reg = mysql_fetch_object($query)) {


     $proc = $reg->Codigo;
     $nom  = $reg->Nombre;

     if(empty($procedimiento))
        $procedimiento=$proc;

     if($proc==$procedimiento) {

        $sel = "selected";  
     } else
            $sel = "";

     echo "<option value='$proc' $sel>$nom</option>";
   }

   echo "</select>";
   echo "<input type='submit' value='Enviar'>";
   echo "</form>";

   $procPadre = $procedimiento;
   echo "<h3>$nombre</h3>";

   
   echo "<table border=0 width=99% bgcolor='#000000'>\n";
   echo "<tr bgcolor='#ffffff'>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Accion";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Anula";
   echo "    </td>\n";

   echo "</tr>\n";
   $query = mysql_query("select * from Procedimientos where Activo='S' and Codigo != $procPadre order by Nombre ");

   while(($reg=mysql_fetch_object($query)))
      {
         $procAnulado=$reg->Codigo;
	 $nom=$reg->Nombre;

          $nq = mysql_query("select * from jerarquiaProcedimientos where procedimientoPadre=$procPadre and procedimientoAnulado=$procAnulado");

	  $nreg = mysql_num_rows($nq);
	  $esta = ($nreg != 0);
	  if($esta)
	     $color="#ffffff";
	  else
	     $color="#fcfcfc";

          echo "<tr bgcolor='$color'>\n";
	    echo "   <td align='center'>\n";
	    if(!$esta) {
	         echo "<a href='jerarquiaProcedimientos.php?procPadre=$procPadre&procAnulado=$procAnulado&cmd=add&procedimiento=$procedimiento'>";
	         echo "      <img src='../img/cancel.png' border=0>";
		 echo "</a>";
	    }
	    else {
	          echo "<a href='jerarquiaProcedimientos.php?procPadre=$procPadre&procAnulado=$procAnulado&cmd=del&procedimiento=$procedimiento'>";
	          echo "      <img src='../img/ok.png' border=0>";
		  echo "</a>";
	    }
            echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	$nom";
	    echo "   </td>\n";
	  echo "</tr>\n";
      }
   echo "</table>";
   mysql_close();
?>
<center><a href='#' onclick='window.close()'>Cerrar ventana</a></center>
