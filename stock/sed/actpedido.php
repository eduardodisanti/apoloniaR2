<?php
 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
  mysql_select_db("apolonia");


function laburo($almacen) {

 $qry = mysql_query("delete from pedidos where almacen=$almacen and enviados=cantidad");

 $qry = mysql_query("select * from tmppedidos where almacen=$almacen");

   while($reg = mysql_fetch_object($qry))
    {
      
      $art = $reg->articulo;
      $alm = $reg->almacen;
      $can = $reg->cantidad;
      $sal = $reg->saldo;
      $fir = $reg->firma;

      $q = "insert into pedidos values($alm,$art,$can,$can,'','0000-00-00',0,'')"; 

      mysql_query($q);
    }

 $q = "delete from tmppedidos where almacen=$almacen";
 mysql_query($q);

}

if($accion=="act")
   laburo($almacen);
else {
       echo "<center>";
       echo "<table border=1 bgcolor='#cccccc'>";
       echo "<tr><td align='center'>";
       echo "<h3>Este proceso actualiza los pedidos nuevos de la sucursal elegida</h3>";

       echo "El proceso es <b>irreversible</b> <br><br>";
       echo "<form action='actpedido.php'>";

       echo "Sucursal : <select name=almacen>";
       $q="select * from almacenes order by nombre";
       $qry = mysql_query($q);
       while($reg=mysql_fetch_object($qry))
        {
	   $alm   = $reg->id;
	   $nombre= $reg->nombre;
           echo "<option value=$alm>$nombre</option>";
        }
       echo "</select><br><br>";
       echo "<input type='hidden' name='accion' value='act'>";
       echo "<input type='submit' name='comando' value='Actualizar'>";
       echo "</form>";
       echo "</td></tr>";
       echo "</table>";
       echo "</center>";
     }

mysql_close();
?>
