<?php

   $db=mysql_connect("elias","apolonia","virgen");
   mysql_select_db("apolonia");

   if($cmd=="add")
      {
          $r=mysql_query("insert into articulosprocedimiento values($procedimiento, $articulo)");

      } else
          if($cmd=="del")
	    {
		$r=mysql_query("delete from articulosprocedimiento where procedimiento=$procedimiento and articulo=$articulo");
	    }

   $err = mysql_error();
   if(!empty($err))
        die("Error, avisar $err");

   echo "<center>Mantenimiento de Materiales por Procedimiento</center><br>";

   $query = mysql_query("select * from Procedimientos where Codigo=$procedimiento");
   $reg = mysql_fetch_object($query);

   $nombre = $reg->Nombre;
   echo "<h3>$Procedimiento $nombre</h3>";
   
   echo "<table border=0 width=99% bgcolor='#000000'>\n";
   echo "<tr bgcolor='#ffffff'>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Codigo";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Pertenece";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Nombre";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Accion";
   echo "    </td>\n";

   echo "</tr>\n";
   $result=mysql_query("select id, nombre from articulos where nombre > '(NO PEDIR)z' order by nombre");

   while(($reg=mysql_fetch_object($result)))
      {
         $cod=$reg->id;
	 $nom=$reg->nombre;

          $nq = mysql_query("select * from articulosprocedimiento where procedimiento=$procedimiento and articulo=$cod");

	  $nreg = mysql_fetch_object($nq);
	  $esta = $nreg->procedimiento;
	  if(empty($esta))
	     $color="#ffffff";
	  else
	     $color="#fcfcfc";

          echo "<tr bgcolor='$color'>\n";
	    echo "   <td>\n";
	    echo "	$cod";
	    echo "   </td>\n";
	    echo "   <td align='center'>\n";
	    if(!empty($esta))
	                 echo "      <img src='../img/ok.png' border=0>";
	    else
	                 echo "      <img src='../img/cancel.png' border=0>";
            echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	$nom";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    if(!empty($esta))
	      {
	       echo "<a href='trab_proc.php?procedimiento=$procedimiento&articulo=$cod&cmd=del'>";
	       echo "      <img src='../img/basura.png' border=0>";
	       echo "</a>";
	      } else
	         {
	           echo "<a href='trab_proc.php?procedimiento=$procedimiento&articulo=$cod&cmd=add'>";
	           echo "      <img src='../img/ok.png' border=0>";
	           echo "</a>";
	           echo "   </td>\n";
		 }
	  echo "</tr>\n";
      }
   echo "</table>";
   mysql_close();
?>
<center><a href='#' onclick='window.close()'>Cerrar ventana</a></center>
