<?php

   $db=mysql_connect("elias","apolonia","virgen");
   mysql_select_db("apolonia");

   if($cmd=="add")
      {
          $Precio=0;
	  $Cupo=9999;
          $r=mysql_query("insert into TrabLab values($Laboratorio, $Trabajo, $Precio, $Cupo)");
      } else
          if($cmd=="del")
	    {
		$r=mysql_query("delete from TrabLab where Laboratorio=$Laboratorio and Trabajo=$Trabajo");
	    }

   $err = mysql_error();
   if(!empty($err))
        die("Error, avisar $err");

   echo "<center>Mantenimiento de Trabajos por Laboratorio</center><br>";

   $query = mysql_query("select * from Laboratorios where id=$Laboratorio");
   $reg = mysql_fetch_object($query);

   $nombre = $reg->descripcion;
   echo "<h3>$nombre</h3>";
   
   echo "<table border=0 width=99% bgcolor='#000000'>\n";
   echo "<tr bgcolor='#ffffff'>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Codigo";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Asignado";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Nombre";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Accion";
   echo "    </td>\n";

   echo "</tr>\n";
   $result=mysql_query("select Trabajos.id, Trabajos.descripcion, Etapas from Trabajos order by Descripcion");
   while(($reg=mysql_fetch_object($result)))
      {
         $cod=$reg->id;
	 $nom=$reg->descripcion;
	 $etapas=$reg->Etapas;

          $nq = mysql_query("select * from TrabLab where Trabajo=$cod and Laboratorio=$Laboratorio");

	  $nreg = mysql_fetch_object($nq);
	  $esta = $nreg->Trabajo;
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
	       echo "      <a href='trablab.php?Laboratorio=$Laboratorio&Trabajo=$cod&cmd=del'>";
	       echo "      <img src='../img/basura.png' border=0>";
	       echo "      </a>";
	      } else
	         {
	           echo "      <a href='trablab.php?Laboratorio=$Laboratorio&Trabajo=$cod&cmd=add'>";
	           echo "      <img src='../img/ok.png' border=0>";
	           echo "      </a>";
	           echo "   </td>\n";
		 }
	  echo "</tr>\n";
      }
   echo "</table>";
   mysql_close();
?>
<center><a href='#' onclick='window.close()'>Cerrar ventana</a></center>
