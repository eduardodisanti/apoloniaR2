<?php

   $db=mysql_connect("elias","apolonia","virgen");
   mysql_select_db("apolonia");

   if($cmd=="add")
      {
          $r=mysql_query("insert into MetaTrabProc values($Meta, $Trabajo)");

      } else
          if($cmd=="del")
	    {
		$r=mysql_query("delete from MetaTrabProc where Meta=$Meta and Procedimiento=$Trabajo");
	    }

   $err = mysql_error();
   if(!empty($err))
        die("Error, avisar $err");

   echo "<center>Mantenimiento de MetaTrabajos por Procedimiento</center><br>";

   $query = mysql_query("select * from MetaTrabajos where id=$Meta");
   $reg = mysql_fetch_object($query);

   $nombre = $reg->descripcion;
   echo "<h3>$Meta $nombre</h3>";
   
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
   $result=mysql_query("select Codigo, Nombre from Procedimientos order by Nombre");

   while(($reg=mysql_fetch_object($result)))
      {
         $cod=$reg->Codigo;
	 $nom=$reg->Nombre;

          $nq = mysql_query("select * from MetaTrabProc where Meta=$Meta and Procedimiento=$cod");
	  $nreg = mysql_fetch_object($nq);
	  $esta = $nreg->Meta;
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
	       echo "<a href='metatrab_proc.php?Meta=$Meta&Trabajo=$cod&cmd=del'>";
	       echo "      <img src='../img/basura.png' border=0>";
	       echo "</a>";
	      } else
	         {
	           echo "<a href='metatrab_proc.php?Meta=$Meta&Trabajo=$cod&cmd=add'>";
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
