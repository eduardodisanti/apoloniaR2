<?php
function date_diff($date2, $date1)
  {
      $s = strtotime($date2) - strtotime($date1);
      $d = intval($s/86400);
      return($d);
  }

require("../../functions/db.php");

$link = conectar();
if($cmd=='Modificar')
{
   $query = "update FactLab set Laboratorio = $nuevoLab, Trabajo = $nuevoTrab, Paciente=$nuevaCedula, Pieza = $nuevaPieza where Serie='$serie' and Numero='$fact' and Fecha='$fecha' and Laboratorio=$lab and Trabajo=$trabajo and Paciente=$pac and Pieza=$pieza";

   query($query);

   $error = mysql_error();

   if(!empty($error))
      die($error);

   echo "<center>Modificado <a href='ajufactlab.php?serie=$serie&factura=$fact&lab=$lab'>Volver</a>";
}

function cargoPiezas($lapieza)
{
   echo "<select name='nuevaPieza'>";
   $qry = query("select Pieza from Piezas order by Pieza");
   while($reg = fetch($qry))
    {
        $diente = $reg->Pieza;
	if($diente == $lapieza)
	  $sel = "selected";
	else
	  $sel = "";

        echo "<option value='$diente' $sel>$diente</option>";
    }

   echo "</select>";
}

function cargoLabs($elLab) 
{
   echo "<select name='nuevoLab'>";
   $qry = query("select id, descripcion from Laboratorios order by descripcion");
   while($reg = fetch($qry))
     {
          $lab = $reg->id;
	  $nombre=$reg->descripcion;
          if($elLab == $lab)
              $sel = "selected";
          else
              $sel = "";

         echo "<option value='$lab' $sel>$nombre</option>";
     }

    echo "</select>";
}


function cargoTrabs($elTrab)
{
   echo "<select name='nuevoTrab'>";
   $qry = query("select id, descripcion from Trabajos order by descripcion");
   while($reg = fetch($qry))
      {
	  $trab = $reg->id;
	  $nombre=$reg->descripcion;
	  if($elTrab == $trab)
	             $sel = "selected";
	  else
	            $sel = "";
 	  echo "<option value='$trab' $sel>$nombre</option>";
     }
    echo "</select>";
}

echo "<center><h4>Ajuste de renglon de factura</h4></center><hr>";
 
$query = "select * from FactLab where Serie='$serie' and Laboratorio = $lab and Numero = $fact and Trabajo = $trabajo and Paciente = $pac and Pieza = $pieza";


echo "<form action='renglonfact.php'>";

echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "	<th colspan=3>Documento</th>";
echo "	<th>Laboratorio</th>";
echo "	<th>Trabajo</th>";
echo "  <th>Paciente</th>";
echo "  <th>Pieza</th>";
echo "</tr>\n";

$q = query($query);

$reg = fetch($q);

	$pac = $reg->Paciente;
	$tra = $reg->Trabajo;
	$fec = $reg->Fecha;
	$pieza  = $reg->Pieza;
	$ser    = $reg->Serie;
	$fact   = $reg->Numero;
	$lab    = $reg->Laboratorio;

   echo "<input type='hidden' name='trabajo' value='$tra'>";
   echo "<input type='hidden' name='fecha' value='$fec'>";
   echo "<input type='hidden' name='pac' value='$pac'>";
   echo "<input type='hidden' name='pieza' value='$pieza'>";
   echo "<input type='hidden' name='serie' value='$ser'>";
   echo "<input type='hidden' name='fact' value='$fact'>";
   echo "<input type='hidden' name='lab' value='$lab'>";

     if($labANT==0)
        $labANT=$lab;

     if($labANT != $lab) {

        total($guita);
        $labANT = $lab;
	$guita = 0;
     }

     echo "<tr bgcolor='#ffffff'>";
     echo "     <td>$fec</td>";
     echo "	<td>$ser</td>";
     echo "     <td>$fact</td>";

     echo "     <td>";
                cargoLabs($lab);
     echo "     </td>";

     echo "     <td>";
                cargoTrabs($tra);
     echo "     </td>";


     echo "     <td>";
     echo "<input type=text name='nuevaCedula' value='$pac'>";
     echo "     </td>";
     echo "     <td>";
                 cargoPiezas($pieza);
     echo "     </td>";
     echo "</tr>";

 echo "</table>";

 echo "<center>";
 echo "<input type='submit' name='cmd' value='Modificar'>";
 echo "</CENTER>";
 echo "</form>";

?>
