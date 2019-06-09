<?php

 $anio = 2008;
 $mes  = 10;

$link=mysql_connect("elias","apolonia","virgen") or die("Error, la base de datos no acepto la coneccion");

   mysql_select_db("apolonia");

   $query = "select * from Laboratorios";
   $ql = mysql_query($query);

   while($reg=mysql_fetch_object($ql))
    {

        $lab = $reg->id;
        echo "====================[$lab $reg->nombre]==================\n"; 

        $query="select id, Costo, TipoIva from Trabajos";
        $q = mysql_query($query);

	while($regt=mysql_fetch_object($q)) {
	    $id = $regt->id;
	    $precio = $regt->Costo;
	    $ximp    = $regt->TipoIva;


            if($ximp=="B")
	       $imp=22;
	    else
	       $imp=10;
            $query="insert into histprec values(1,$lab,$anio, $mes, $id, $precio, $imp)";
	    echo $query."\n";
	    mysql_query($query);
	}
    }

   mysql_close();
?>
