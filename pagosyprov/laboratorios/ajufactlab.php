<?php
function date_diff($date2, $date1)
  {
      $s = strtotime($date2) - strtotime($date1);
      $d = intval($s/86400);
      return($d);
  }
function verSiSePaga($lab, $anio, $mes, $trab) {

   $q = "select * from histprec where tipo=1 and proveedor=$lab and articulo=$trab and anio=$anio and mes=$mes";

   $qry = query($q);
   $filas=filas($qry);

   return($filas!=0);
}


function total($guita, $tablaImpuestos) {

   $impuestos = 0;

    $q = query("select * from TipoIva");
    while($reg = fetch($q))
       {
          $id = $reg->id;
	  $descripcion = $reg->descripcion;
	  echo "<tr><td colspan='9' bgcolor='#ffffff' align='right'>$descripcion : </td><td colspan=3 bgcolor='ffffff' align='right'>";
	  echo number_format($tablaImpuestos[$id], 2);
	  $impuestos += $tablaImpuestos[$id];
	  echo "</td></tr>";
       }
    echo "<tr><td colspan='10' bgcolor='#ffffff' align='right'>Sub Total : </td><td bgcolor='ffffff' align='right' colspan=2>";
    echo number_format($guita, 2);
    echo "</td></tr>";
     echo "<tr><td colspan='10' bgcolor='#ffffff' align='right'>Total : </td><td bgcolor='ffffff' align='right' colspan=2>";
     echo number_format($guita + $impuestos, 2);
     echo "</td></tr>";

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
      $qry = query("select id, descripcion from Laboratorios where id = $elLab order by descripcion");
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
      $qry = query("select id, descripcion from Trabajos where Facturable='S' order by descripcion");
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

if($cmd=="agrLP") {

   $query = "insert into histprec values(1, $lab, $anio, $mes, $trabajo, $precio, $impues)";

   query($query);
}

if($cmd=="Agregar")
{

   $query = "insert into FactLab values($lab, '$serie', $fact, '$nuevaFecha', $nuevoTrab, $nuevaCedula, $nuevaPieza)";

   query($query);

   $factura = $fact;
}

if($cmd=="dl") {

   $query = "delete from FactLab where Laboratorio = $lab and Serie = '$serie' and Numero = $numero and Paciente=$pac and Trabajo=$trabajo and Fecha='$fecha' and Pieza=$pieza and Laboratorio=$lab";   
//die($query);
   query($query);   
   $factura = $numero;

}

if($cmd=="ed") {

    echo "<script languaje='javascript'>";
    echo "window.open('renglonfact.php?lab=$lab&serie=$serie&numero=$numero&trabajo=$trab&pac=$pac&fec=$fecha&pieza=$pieza', 'Ajuste de Factura','width=400, height=300')";
    echo "</script>";

   $query = "update FactLab set where Laboratorio = $lab and Serie = '$serie' and Numero = $numero";   
   die($query);
   //query($query);
}

echo "<center><h4>Ajuste de factura $serie $factura</h4></center><hr>"; 

$query = "select Serie, Numero, Fecha, Trabajos.descripcion as desctrab, Paciente, Pacientes.Nombre as pacnomb, Pieza, FactLab.Laboratorio as Laboratorio, Laboratorios.descripcion as labdesc, Costo, FactLab.Trabajo as numtrab, TipoIva, TipoIva.valor as impuesto from FactLab, Trabajos, Pacientes, Laboratorios, TipoIva where Numero = $factura and Serie = '$serie' and FactLab.Laboratorio = $lab and Trabajos.id = FactLab.Trabajo and Pacientes.Cedula=FactLab.Paciente and Laboratorios.id = FactLab.Laboratorio and TipoIva = TipoIva.id order by Laboratorio, Fecha, Serie, Numero";

echo "<table border=0 width=99% bgcolor='#000000' cellspacing='1'>\n";
echo "<tr bgcolor='#cccccc'>";
echo "<th colspan=2>&nbsp;&nbsp;</th>";
echo "	<th colspan=3>Documento</th>";
echo "	<th>Laboratorio</th>";
echo "	<th>Trabajo</th>";
echo "  <th>Paciente</th>";
echo "  <th>Pieza</th>";
echo "  <th>Importe</th>";
echo "  <th>Iva</th>";
echo "  <th>ST</th>";
echo "</tr>\n";

$q = query($query);

$labANT=0;
$guita = 0;
$totalTotal = 0;
$totalImpuestos = 0;

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
	$impues = $reg->impuesto;
	$tipoIva= $reg->TipoIva;

     $anio=strtok($fec,"-");
     $mes=strtok("-");
     $sePagara = verSiSePaga($lab, $anio, $mes, $trab);

     if($sePagara==true) {
        $colorPagar='#00FF00';
	 $agregarListaPrecios="";
     }
     else {
        $colorPagar='#FF0000';
        $agregarListaPrecios="<a href='ajufactlab.php?serie=$serie&factura=$factura&lab=$lab&cmd=agrLP&trabajo=$trab&anio=$anio&mes=$mes&precio=$precio&impues=$impues'>OK</a>";
     }

     if($labANT==0)
        $labANT=$lab;

     if($labANT != $lab) {

        total($guita, tablaImpuestos);
        $labANT = $lab;
	    $guita = 0;
     }

     $id = "lab=$lab&serie=$ser&numero=$fact&laboratorio=$lab&trabajo=$trab&pac=$pac&fecha=$fec&pieza=$pieza";
     
     echo "<tr bgcolor='#ffffff'>";
     echo " <td><a href='ajufactlab.php?$id&cmd=dl' title='Borrar esta linea'><img src='/img/basura.png' border = 0></a><td><a href='";
     echo "renglonfact.php?lab=$lab&serie=$ser&fact=$fact&trabajo=$trab&pac=$pac&fec=$fec&pieza=$pieza' title='Modificar esta linea'>";
     echo "<img src='/img/lista.png' border=0 width=32></a></td>";
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
     echo "     <td align='right'>$impues%</td>";
     echo "     <td align='right' bgcolor='$colorPagar'>$agregarListaPrecios</td>";
     echo "</tr>";

     $totalImpuestos+=($precio * ($impues / 100));
     $tablaImpuestos[$tipoIva]+= ($precio * $impues / 100);
     $guita = $guita + $precio;
     $totalTotal = $totalTotal + $precio;
}

total($guita, $tablaImpuestos);
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

        total($guita, tablaImpuestos);
        $labANT = $lab;
	$guita = 0;
     }

     if(empty($fec))
          $fec = Date("Y-m-d");

     echo "<tr bgcolor='#ffffff'>";
     echo "     <td><input type='text' name='nuevaFecha' value='$fec' maxlenght=10 size=10></td>";
     echo "	<td>$serie</td>";
     echo "     <td>$factura</td>";

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
