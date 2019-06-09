<?php

require("../functions/db.php");
$link=conectar();

if(empty($cmd))
  {
   $query = "select * from FactLab where Paciente=$pac and Laboratorio=$codlab and Trabajo=$trabajo and Pieza=$pieza";

   $qry = query($query);

   echo mysql_error();
   $reg = fetch($qry);

   $serie = $reg->Serie;
   $numero= $reg->Numero;
   $ffecha= $reg->Fecha;

   if(!empty($serie)) {
       $query = "select * from RecFact where SerieFact='$serie' and NumeroFact=$numero";
       $q = query($query);
       $resp = mysql_num_rows($q);
       if($resp!=0)
         $facturaPagada = true;
       else
         $facturaPagada = false;
   }

   if(empty($serie)) 
      $mostrar=true;
   else
      $mostrar=false;

   echo "<form action='remitolab.php'>";
   echo "<table border=0 width='100%'>";
   echo "<tr><th colspan=2>Ingreso de remito de laboratorio</th></tr>";
   echo "<tr><th colspan=2>&nbsp;&nbsp;</th></tr>";
   echo "<tr>";
   echo "   <td>";
   echo "      Serie";   
   echo "   </td>";
   echo "   <td>";
   echo "      Numero";
   echo "   </td>";
   echo "</tr>";

   echo "<tr>";
   echo "  <td><input type='text' size=2 width=3 name='serie' value='$serie'></td>";
   echo "  <td><input type='text' size=8 width=8 name='numero' value='$numero'></td>";
   echo "</tr>";

   echo "<tr>";
   echo "   <td colspan=2 colspan=2 align='center'>";
   if($mostrar)
      echo "    <input type='submit' name='cmd' value='Ingresar'>";
   else
     {
      if($facturaPagada) {

            echo "<b>Trabajo ya pago por CaDI con la factura $serie-$numero de fecha $ffecha</b>";
      } else
           {
             echo "<b>Ya fue ingresado, puede cerrar la ventana</b>";
             echo "<script>window.close()</script>";
	   }
     }
   echo "   </td>";
   echo "</tr>";

   echo "</table>";
   echo "<input type='hidden' name='pac' value='$pac'>";
   echo "<input type='hidden' name='trabajo' value='$trabajo'>";
   echo "<input type='hidden' name='fecha' value='$fecha'>";
   echo "<input type='hidden' name='pieza' value='$pieza'>";
   echo "<input type='hidden' name='codlab' value='$codlab'>";
   echo "</form>";
  } 
     else  {
             echo "<h3>Registrado</h3>";
             $query="insert into FactLab values($codlab, '$serie',$numero, '$fecha', $trabajo, $pac, $pieza)";

	     query($query);
	     echo mysql_error();
           }
?>
