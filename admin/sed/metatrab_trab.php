<?php

   $db=mysql_connect("elias","apolonia","virgen");
   mysql_select_db("apolonia");

   if($cmd=="add")
      {
          $r=mysql_query("insert into MetaTrabTrab values($Meta, $Trabajo, $posicion)");

      } else
          if($cmd=="del" || $comando=="Quitar")
	    {
              $r=mysql_query("delete from MetaTrabTrab where Meta=$Meta and Trabajo=$elegido");
	    } else
	       if($comando=="Agregar")
	        {
		   agregarA($Meta, $disponible);
		}

   $err = mysql_error();
   if(!empty($err))
        die("Error, avisar $err");

   echo "<center>Mantenimiento de Trabajos por MetaTrabajos</center>";
   echo "<h4><font color='#FF0000'>Asignar los trabajos de cata meta trabajo en el orden que los realiza el odontologo</font></h4>";
   $query = mysql_query("select * from MetaTrabajos where id=$Meta");
   $reg = mysql_fetch_object($query);
   $nombre = $reg->descripcion;
   echo "<h3>$Meta $nombre</h3>";

   echo "<form action='metatrab_trab.php'>";
   echo "<table border=0>";
   echo "<tr>";
   echo "  <td>";
       opcionDisponibles();
   echo "  </td>";
   echo "  <td align='center'>";
   echo "  <input type='submit' name='comando' value='Agregar'><br>";
   echo "  <input type='submit' name='comando' value='Quitar'>";
   echo "  <input type='hidden' name='Meta' value='$Meta'>";
   echo "  </td>";
   echo "  <td>";
       opcionElegidos($Meta);
   echo "  </td>";
   echo "</tr>";
   echo "</form>";

   mysql_close();

function opcionDisponibles()
{

   $result=mysql_query("select id, Descripcion from Trabajos order by descripcion");
   echo "<select name='disponible' size=30>";
   while(($reg=mysql_fetch_object($result)))
   {
      echo "<option value='$reg->id'>$reg->Descripcion</option>";
   }
   echo "</select>";
}
function opcionElegidos($elMeta)
{

   $result=mysql_query("select id, descripcion, Orden from MetaTrabTrab, Trabajos where Meta=$elMeta and Trabajo=id order by Orden");

  echo "<select name='elegido' size=30>";
  while(($reg=mysql_fetch_object($result)))
   {
      echo "<option value='$reg->id'>$reg->descripcion</option>";
   }
  echo "</select>";
}

function agregarA($Meta, $Trabajo)
{
    $query = "select Orden from MetaTrabTrab where Meta=$Meta order by Orden desc";
    $q = mysql_query($query);
    $reg=mysql_fetch_object($q);

    $num = $reg->Orden;
    if(empty($num))
       $num=0;

    $num++;

  echo "insert into MetaTrabTrab values($Meta, $Trabajo, $num)";
    mysql_query("insert into MetaTrabTrab values($Meta, $Trabajo, $num)");
}

?>
<center><a href='#' onclick='window.close()'>Cerrar ventana</a></center>
