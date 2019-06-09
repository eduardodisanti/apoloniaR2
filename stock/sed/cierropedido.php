<?php

function laburo() {

 $link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");
 mysql_select_db("apolonia");

 $q = "delete from pedidos";
 mysql_query($q);

 $qry = mysql_query("select * from tmppedidos");

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

 $q = "delete from tmppedidos";
 mysql_query($q);

 mysql_close();

}

if($accion=="act")
   laburo();
else {
       echo "<center>";
       echo "<table border=1 bgcolor='#cccccc'>";
       echo "<tr><td align='center'>";
       echo "<h3>Este proceso actualiza los pedidos nuevos y elimina los pedidos en proceso</h3>";

       echo "El proceso es <b>irreversible</b> solo debe usarse cuando ha llegado el cierre de stock<br><br>";
       echo "<form action='cierropedido.php'>";
       echo "<input type='hidden' name='accion' value='act'>";
       echo "<input type='submit' name='comando' value='Actualizar'>";
       echo "</form>";
       echo "</td></tr>";
       echo "</table>";
       echo "</center>";
     }
?>
