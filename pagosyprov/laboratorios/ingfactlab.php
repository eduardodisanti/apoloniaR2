<?php
function date_diff($date2, $date1)
  {
      $s = strtotime($date2) - strtotime($date1);
      $d = intval($s/86400);
      return($d);
  }

function total($guita) {

         echo "<tr><td colspan='9' bgcolor='#ffffff' align='right'>Total : </td><td bgcolor='ffffff' align='right'>$guita</td></tr>";
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

require("../../functions/db.php");
$link=conectar();

if($cmd=="Agregar")
{
   $query = "insert into FactLab values($lab, '$serie', $fact, '$nuevaFecha', $nuevoTrab, $nuevaCedula, $nuevaPieza)";

   query($query);
}

if($cmd=="dl") {

   $query = "delete from FactLab where Laboratorio = $lab and Serie = '$serie' and Numero = $numero and Paciente=$pac and Trabajo=$trabajo and Fecha='$fecha' and Pieza=$pieza and Laboratorio=$lab";   
//die($query);
   query($query);   
}

echo "<center><h4>Ingresar una factura $serie $factura</h4></center><hr>"; 

$query = "select Serie, Numero, Fecha, Trabajos.descripcion as desctrab, Paciente, Pacientes.Nombre as pacnomb, Pieza, FactLab.Laboratorio as Laboratorio, Laboratorios.descripcion as labdesc, Costo, FactLab.Trabajo as numtrab from FactLab, Trabajos, Pacientes, Laboratorios where Numero = $factura and Serie = '$serie' and FactLab.Laboratorio = $lab and Trabajos.id = FactLab.Trabajo and Pacientes.Cedula=FactLab.Paciente and Laboratorios.id = FactLab.Laboratorio order by Laboratorio, Fecha, Serie, Numero";

echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "<th colspan=2>&nbsp;&nbsp;</th>";
echo "	<th colspan=3>Documento</th>";
echo "	<th>Laboratorio</th>";
echo "	<th>Trabajo</th>";
echo "  <th>Paciente</th>";
echo "  <th>Pieza</th>";
echo "  <th>Importe</th>";

echo "</tr>\n";
if(!empty($lab))
   $q = query($query);

//echo mysql_error();

$labANT=0;
$guita = 0;
$totalTotal = 0;

while($reg = fetch($q))
 {
	$pac = $reg->Paciente;
	$nom = $reg->pacnomb;
	$tra = $reg->Laboratorio;
	$des = $reg->desctrab;
	$fec = $reg->Fecha;
	$nlab= $reg->labdesc;
	$importe= $reg->Importe;
	$estado = $reg->Episodio;
	$pieza  = $reg->Pieza;
	$ser    = $reg->Serie;
	$fact   = $reg->Numero;
	$precio = $reg->Costo;
	$ced    = $reg->Paciente;
	$lab    = $reg->Laboratorio;
	$trab   = $reg->numtrab;

     if($labANT==0)
        $labANT=$lab;

     if($labANT != $lab) {

        total($guita);
        $labANT = $lab;
	    $guita = 0;
     }

     $id = "lab=$lab&serie=$ser&numero=$fact&laboratorio=$lab&trabajo=$trab&pac=$pac&fecha=$fec&pieza=$pieza";
     
     echo "<tr bgcolor='#ffffff'>";
     echo " <td><a href='ingfactlab.php?$id&cmd=dl' title='Borrar esta linea'><img src='/img/basura.png' border = 0></a><td>";
     echo "</td>";
     echo "     <td>$fec</td>";
     echo "	<td>$ser</td>";
     echo "     <td>";
     echo "             $fact";
     echo "      </td>";
     echo "     <td>$nlab</td>";
     echo "     <td>$des</td>";
     echo "     <td><b>$ced</b> $nom</td>";
     echo "     <td>$pieza</td>";
     echo "     <td align='right'>$precio</td>";
     echo "</tr>";

     $guita = $guita + $precio;
     $totalTotal = $totalTotal + $precio;
}

total($guita);
echo "</table>";

echo "<center><h4>Agregar un renglon a la factura</h4></center><hr>";
 
echo "<form action='ajufactlab.php'>";
echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "	<th colspan=3>Documento</th>";
echo "	<th>Laboratorio</th>";
echo "	<th>Trabajo</th>";
echo "  <th>Paciente</th>";
echo "  <th>Pieza</th>";
echo "</tr>\n";


   echo "<input type='hidden' name='fact' value='$factura'>\n";
   echo "<input type='hidden' name='lab' value='$lab'>\n";
   echo "<input type='hidden' name='serie' value='$serie'>\n";

     if($labANT==0)
        $labANT=$lab;

     if($labANT != $lab) {

        total($guita);
        $labANT = $lab;
	$guita = 0;
     }

     $fec = Date("Y-m-d");
     echo "<tr bgcolor='#ffffff'>";
     echo "     <td><input type='text' name='nuevaFecha' value='$fec' maxlenght=10 size=10></td>";
     echo "	<td><input type='text' name = 'serie' value='$serie' size=1></td>";
     echo "     <td><input type='text' name='factura' value='$factura' size=8</td>";

     echo "     <td>";
                cargoLabs($lab);
     echo "     </td>";

     echo "     <td>";
                cargoTrabs($tra);
     echo "     </td>";


     echo "     <td>";
     echo "<input type=text name='nuevaCedula'>";
     echo "     </td>";
     echo "     <td>";
                 cargoPiezas($pieza);
     echo "     </td>";
     echo "</tr>";

 echo "</table>";

 echo "<center>";
 echo "<input type='submit' name='cmd' value='Agregar'>";
 echo "</CENTER>";
 echo "</form>";

?>
