<?php

   $db=mysql_connect("elias","apolonia","virgen");
   mysql_select_db("apolonia");

   echo "<center><h3>TT-AIT-01 [Documento que cuando se imprime pierde validez]</h3></center>";
   echo "<table border=1 width=99% bgcolor='#000000'>\n";
   echo "<tr bgcolor='#ffffff'>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Codigo";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Nombre";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        cantidad Ordenes tratamiento";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        cantidad Ordenes taller";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Especialidad";
   echo "    </td>\n";
      echo "    <td align=\"center\" colspan=1>\n";
         echo "        Cantidad de sesiones";
	    echo "    </td>\n";
   echo "</tr>\n";
   $ORDEN  = "Procedimientos.Nombre";
   $result = mysql_query("select Procedimientos.Codigo, Procedimientos.Nombre as nom,Lugares,Ordenes,TipoOrden,ImporteTaller,Sesiones,Especialidades.Nombre,BaseMucam,Cadencia,Notas,Activo,Especialidades.Nombre as nesp,Dosificacion, BaseMucam from Procedimientos, Especialidades  where Activo='S' and Especialidad = Especialidades.Codigo order by $ORDEN");

   while(($reg=mysql_fetch_object($result)))
      {
      
         $basemucam = $reg->BaseMucam;
         $q = "select * from Ordenes where codigoExterno = $basemucam"; 

       $valqry = mysql_query($q);
       $regval = mysql_fetch_object($valqry); 
        $val=$regval->Valor;       
         
         $cod=$reg->Codigo;
	 	 $nom=$reg->nom;
         $lug=$reg->Lugares;
         $ord=$reg->Ordenes;
         $tip=$reg->TipoOrden;
         $imt=$reg->ImporteTaller;
         $ses=$reg->Sesiones;
        
	 $esp=$reg->nesp;
	 $basemucam=$reg->BaseMucam;
	 $cadencia=$reg->Cadencia;
	 $notas=$reg->Notas;
	 $activo=$reg->Activo;
	 $dosis=$reg->Dosificacion;

        echo "<tr bgcolor='#ffffff'>\n";
	    echo "   <td>\n";
	    echo "	$cod";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	$nom";
	    echo "   </td>\n";
            echo "   <td>\n";
            echo "      <b>$ord</b> de $val pesos ($basemucam)";
            echo "   </td>\n";
            echo "   <td>\n";
            echo "      $imt";
            echo "   </td>\n";
            echo "   <td>\n";
            echo "      $esp";
            echo "   </td>\n";
	     echo "   <td>\n";
	                 echo "      $ses";
			             echo "   </td>\n";
	  echo "</tr>\n";
	  echo "<tr bgcolor='#cccccc'>\n";
	  echo " <td colspan=4>";
          echo "    Notas $notas";
          echo " </td>";
          echo " <td colspan=2 align=right>";
//          echo "    Codigo mucam $basemucam";
			echo "Dosificacion <b>$dosis</b>";
          echo " </td>";
	  echo "</tr>\n";
      }
   echo "</table>";
   
   $q = "select texto from mensajes where id=111";
   $rq = mysql_query($q);
   $reg = mysql_fetch_object($rq);
   $texto = nl2br($reg->texto);

   echo "<br><center>Notas</center>";
   echo "<table>";
   echo "<tr>";
   echo "	<td>";
   echo "<i>$texto</i>";
   echo "	</td>";
   echo "</tr>";
   echo "</table>";
   mysql_close();
?>
