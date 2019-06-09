<?php

   $db=mysql_connect("elias","apolonia","virgen");
   mysql_select_db("apolonia");

   if($cmd1 == "Actualizar")
      {
      	//echo "update mensajes set texto='$texto' where id=1";
      	  mysql_query("update mensajes set texto='$texto' where id=111");
      }
      
   if($cmd=="Agregar")
      {
          $r=mysql_query("insert into Procedimientos values($Codigo,'$Nombre',$Lugares, $Ordenes, '$TipoOrd', $ImporteTaller, $Sesiones, $espe, '$notas', $basemucam, $cadencia,'$activo', $dosis, $laDeja, $zona, '$externo')");
      } else
          if($cmd=="Borrar")
	    {
		$r=mysql_query("delete from Procedimientos where Codigo=$codigo");
	    }
	     else
          	if($cmd=="Actualizar")
	    	{
                    //die("$activ-$notas-$basemucam-$cadencia- $activo");

		    $r=mysql_query("update Procedimientos set Nombre='$Nombre', Lugares=$Lugares, Ordenes=$Ordenes, TipoOrden='$TipoOrd', ImporteTaller=$ImporteTaller, Sesiones=$Sesiones,  Especialidad=$espe, Notas='$notas', BaseMucam=$basemucam, Cadencia=$cadencia, Activo='$activo', Dosificacion = $dosis, loDeja=$laDeja, Zona=$zona, Externo='$externo'  where Codigo=$Codigo");
	    	}

   $err = mysql_error();
   if(!empty($err))
        die("Error, avisar $err update Procedimientos set Nombre='$Nombre', Lugares=$Lugares, Ordenes=$Ordenes, TipoOrden='$TipoOrd', ImporteTaller=$ImporteTaller, Sesiones=$Sesiones,  Especialidad=$espe, Notas='$notas', BaseMucam=$basemucam, Cadencia=$cadencia, Activo='$activo', Dosificacion = $dosis, loDeja=$laDeja where Codigo=$Codigo");

   echo "<center><h3>Modificar procedimiento</h3></center><hr>";
   echo "<center><a href='proced.php'>Volver</a></center>";
   echo "<table border=0 width=99% bgcolor='#000000'>\n";
   echo "<tr bgcolor='#ffffff'>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Codigo";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Nombre";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Lugares";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        cant. Ordenes de tratamiento";
   echo "    </td>\n";
/*   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Tipo de orden";
   echo "    </td>\n"; */
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        cantidad Ordenes Taller";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Sesiones";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "        Especialidad";
   echo "    </td>\n";
   echo "    <td colspan=3 align=\"center\">\n";
   echo "        cmd";
   echo "    </td>\n";
   echo "</tr>\n";
   $ORDEN="Nombre";

   $result = mysql_query("select Codigo from Procedimientos order by Codigo desc limit 1");
   $reg = mysql_fetch_object($result);
   $codigoNuevo = $reg->Codigo + 1;
   $result=mysql_query("select * from Procedimientos where Codigo=$codigo");

   while(($reg=mysql_fetch_object($result)))
      {
         $cod=$reg->Codigo;
	 $nom=$reg->Nombre;
         $lug=$reg->Lugares;
         $ord=$reg->Ordenes;
         $tip=$reg->TipoOrden;
         $imt=$reg->ImporteTaller;
         $ses=$reg->Sesiones;
	 $esp=$reg->Especialidad;
	 $basemucam=$reg->BaseMucam;
	 $cadencia=$reg->Cadencia;
	 $notas=$reg->Notas;
	 $activo=$reg->Activo;
	 $dosis=$reg->Dosificacion;
	 $ladeja = $reg->loDeja;
	 $zona = $reg->Zona;
	 $externo = $reg->Externo;

          echo "<form action=\"unproced.php\" method=post>\n";
          echo "<tr bgcolor='#ffffff'>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"hidden\" size=8 name=\"Codigo\" value=\"$cod\">$cod";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=40 name=\"Nombre\" value=\"$nom\">";
	    echo "   </td>\n";
	    echo "   <td>\n";
	    echo "	<input type=\"text\" size=5 name=\"Lugares\" value=\"$lug\">";
	    echo "   </td>\n";
            echo "   <td>Cantidad de ordenes Tratamiento\n";
            echo "      <input type=\"text\" size=5 name=\"Ordenes\" value=\"$ord\">";
            echo "   </td>\n";
 /*           echo "   <td>\n";
            $sel="";
            $sel[$tip]="selected";
            echo "<select name='TipoOrd'>";
            echo "    <option value='A' $sel[A]>Orden A</option>\n";
            echo "    <option value='B' $sel[B]>Orden B</option>\n";
            echo "    <option value='C' $sel[C]>Orden C</option>\n";
            echo "    <option value='D' $sel[D]>Orden D</option>";
            echo "    <option value='E' $sel[E]>Orden E</option>";
            echo "    <option value='F' $sel[F]>Orden F</option>";
            echo "    <option value='G' $sel[G]>Orden G</option>";
            echo "    <option value='H' $sel[H]>Orden H</option>";
            echo "    <option value='I' $sel[I]>Orden I</option>";
            echo "    <option value='J' $sel[J]>Orden J</option>";
            echo "    <option value='K' $sel[K]>Orden K</option>";
            echo "    <option value='L' $sel[L]>Orden L</option>";
            echo "    <option value='M' $sel[M]>Orden M</option>";
            echo "    <option value='N' $sel[N]>Orden N</option>";
            echo "    <option value='O' $sel[O]>Orden O</option>";
            echo "</select>";
            echo "   </td>\n";
  */        
             echo "      <input type=\"hidden\" name=\"TipoOrd\" value=\"$tip\">";
            echo "   <td>\n";
            echo "      Cantidad ordenes de taller <input type=\"text\" size=7 name=\"ImporteTaller\" value=\"$imt\">";
            echo "   </td>\n";
            echo "   <td>\n";
            echo "      <input type=\"text\" size=5 name=\"Sesiones\" value=\"$ses\">";
            echo "   </td>\n";
            echo "   <td>\n";
            echo "      <input type=\"text\" size=5 name=\"espe\" value=\"$esp\">";
            echo "   </td>\n";
            echo "   <td colspan=3>";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Actualizar\">";
	    echo "	<input type=\"submit\" name=\"cmd\" value=\"Borrar\">";
	    echo "   </td>\n";
	  echo "</tr>\n";
	  echo "<tr bgcolor='#cccccc'>\n";
	  echo " <td colspan=2>";
          echo "    Notas <textarea name=\"notas\" cols=\"40\">$notas</textarea>";
          echo " </td>";
          echo " <td colspan=2>";
          echo "    Codigo mucam de orden de tratamiento <input type=\"text\" size=5 name=\"basemucam\" value=\"$basemucam\">";
          echo " </td>";

	  echo " <td colspan=1>";
          echo "    Cadencia mensual <input type=\"text\" size=2 name=\"cadencia\" value=\"$cadencia\">";
          echo " </td>";
	  echo " <td colspan=1>";
	  echo "Dosificacion <input type=\"text\" size=2 name=\"dosis\" value=\"$dosis\">";
          echo " </td>";
	  echo " <td colspan=1>";
          echo "    Visible <input type=\"text\" name=\"activo\" value=\"$activo\" size=1>";
          echo " </td>";
	  echo " </td>";
	  echo " <td colspan=1>";
	  echo " Deja la(s) pieza(s) ";
	  
	  echo "<input type=\"text\" name=\"laDeja\" value=\"$ladeja\" size=1>";
	  echo " </td>";
	  echo " <td>";
	  echo "      Zona del la boca:";
	  echo "<input type=\"text\" size=3 name=\"zona\" value=\"$zona\">";
	  echo " </td>";
          echo " <td>";
          echo "      Externo:";
          echo "<input type=\"text\" size=1 name=\"$externo\" value=\"$externo\">";
          echo " </td>";

          echo "<input type='hidden' name='codigo' value=$codigo>";
	  echo "</tr>\n";
	  echo "</form>\n";
      }
   echo "</table>";
   mysql_close();
?>
