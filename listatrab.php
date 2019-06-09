<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php

   $db=mysql_connect("127.0.0.1","apolonia","virgen");
   mysql_select_db("apolonia");
   
   $hoy=Date("Y-m-d");
   if($cmd=="agregar")
      {
          $r = mysql_query("select * from TrabSoc where Paciente=$pac and Trabajo=$trab and Fecha='$hoy'");
	  $rg=mysql_fetch_object($r);
	  $repeticiones = $rg->Repeticiones;
	  if(empty($repeticiones))
	    {
             $r=mysql_query("insert into TrabSoc values($pac,$trab,'$hoy','N',0)");
	     $r=mysql_query("insert into HistTrabSoc values($pac,$trab,'$hoy','P')");
	    } else
	      {
	        $repeticiones = $repeticiones+1;
		$r=mysql_query("update TrabSoc set Repeticiones=$repeticiones where Paciente=$pac and Trabajo=$trab and Entregado='N'");
		$r=mysql_query("insert into HistTrabSoc values($pac,$trab,'$hoy','R')");
	      }
      } else
          if($cmd=="borrar")
	    {
		$r=mysql_query("delete from TrabSoc where Paciente=$pac and Trabajo=$trab and Entregado='N'");
		$r=mysql_query("insert into HistTrabSoc values($pac,$trab,'$hoy','X')");
	    }  else
          	if($cmd=="colocar")
		   {
		     $r=mysql_query("delete from TrabSoc where Paciente=$pac and Trabajo=$trab and Entregado='N'");
		     $r=mysql_query("insert into HistTrabSoc values($pac,$trab,'$hoy','C')");
	           }

   echo "<center>";
   echo "Trabajos enviados a laboratorio";
   echo "<table border=0 width=99% bgcolor='#000000'>\n";
   echo "<tr valign=\"top\"  bgcolor='#cccccc'>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "    Asignados<br>";
   $hoy=date("Y-m-d");
//echo "select Trabajo, descripcion from TrabSoc,Trabajos where paciente=$pac  and Terminado='N' and id=Trabajo order by Trabajo";

   $q="select Trabajo, descripcion from TrabSoc,Trabajos where paciente=$pac  and Entregado='N' and Trabajo = id order by descripcion";
   $result=mysql_query($q);
   echo "     <table border=0 bgcolor=\"#000000\" width='100%'>";
   while($reg=mysql_fetch_object($result))
     {
 	echo "	  <tr bgcolor=\"#ffffff\">\n";
	echo "	    <td>";
	$cod=$reg->Trabajo;
	$trab=$reg->descripcion;
	if(!empty($cod))
	  {
	   echo "$trab";
	  }
	else
	   echo "&nbsp";
	echo "	    </td>\n";
	echo "	    <td width=22px>\n";
	echo "		<a href='listatrab.php?pac=$pac&cmd=borrar&trab=$cod' title='Anular este pedido'>";
	echo "		<img src='../img/basura.png' border=0>";
	echo "		</a>";
	echo "	    </td>\n";
	echo "	    <td width=22px>\n";
	echo "		<a href='listatrab.php?pac=$pac&cmd=agregar&trab=$cod' title='Retrabajo, tiene problemas no pasa a la siguiente etapa'>";
	echo "		<img src='../img/critico.png' border=0>";
	echo "		</a>";
	echo "	    </td>\n";
	echo "	    <td width=22px>\n";
	echo "		<a href='listatrab.php?pac=$pac&cmd=colocar&trab=$cod' title='El trabajo es correcto, puedo seguir trabajando'>";
	echo "		<img src='../img/ok24.png' border=0>";
	echo "		</a>";
	echo "	    </td>\n";
	echo "	  </tr>\n";
     }
   echo "	</table>\n";
   echo "    </td>\n";
   echo "    <td align=\"center\" colspan=1>\n";
   echo "    Disponibles<br>";
   echo "	<table bgcolor=\"#000000\" cellspacing=1  width='100%'>\n";
   $result=mysql_query("select id, descripcion from Trabajos order by descripcion");
   while($reg=mysql_fetch_object($result))
      {
	echo "  <tr bgcolor=\"#ffffff\">\n";
	echo "	    <td>";   
        $cod=$reg->id;
	$nom=$reg->descripcion;
	$tie=$reg->Tiempo;
	echo "<a href='listatrab.php?pac=$pac&cmd=agregar&trab=$cod'>$nom</a>";
      }
	echo "	    </td>";   
	echo "	  </tr>\n";
	echo "    </table>\n";      
   echo "</td>";   
   echo "</tr>";
   echo "</table>";
   mysql_close();
?>
