<?php
require_once("class/Mateo.phpm");
session_start();
//$m = $_SESSION['mateo'];
//$tema = $m->getTema();

require("../functions/db.php");
$link=conectar();

if(empty($id))
   $id=1;
echo "<body bgcolor='#ffffff'>";
if(empty($fechadesde))
   $fechadesde='1900-01-01';
if(empty($fechahasta))
   $fechahasta='2999-12-31';

$query = "select Codigo, Articulo, Fecha,Hora, Origen, Destino, TipoDoc, Documento, Unidades, Responsable from Movstock where Articulo=$id and Fecha >= '$fechadesde' and Fecha <= '$fechahasta' order by Articulo, Fecha";

$qry = query($query);

echo "<table width='99%' bgcolor='#000000' cellspacing='1'>";
echo "<tr bgcolor='#cccccc'><th>Fecha</th><th>Hora</th><th>Origen</th><th>Destino</th><th>Tipo</th><th>Documento</th><th>Entradas</th><th>Salidas</th><th>Firma</th></tr>";
while($reg=fetch($qry))
{

  $cod = $reg->Codigo;
  $fec = $reg->Fecha;
  $hor = $reg->Hora;
  $ori = $reg->Origen;
  $tip = $reg->TipoDoc;
  $des = $reg->Destino;
  $doc = $reg->Documento;
  $uni = $reg->Unidades;
  $fir = $reg->Responsable;
  
  $aq = "select nombre from almacenes where id=$ori";
  $aqq= query($aq);
  $areg = fetch($aqq);
  $xori = $areg->nombre;

  $aq = "select nombre from almacenes where id=$des";
  $aqq= query($aq);
  $areg = fetch($aqq);
  $xdes = $areg->nombre;
  
  $entradas = $salidas = "&nbsp;&nbsp;";
  
  if($cod==1)
     $entradas = $uni;
  else
     $salidas = $uni;

  $xtip = $tip;

  switch($tip) {

     case "T" :
                $xtip = "Transf.";
                break;

    case "I" :
               $xtip = "Ing.Man.";
	       break;

    case "R" :
               $xtip = "Remito";
	       break;

    case "A" :
              $xtip = "Ajuste";
	      break;


}
     
  echo "<tr bgcolor='#ffffff'>";
  echo "   <td>$fec</td>";
  echo "   <td>$hor</td>";
  echo "   <td>$xori</td>";
  echo "   <td>$xdes</td>";
  echo "   <td>$xtip</td>";
  echo "   <td>$doc</td>";
  echo "   <td align=right>$entradas</td>";
  echo "   <td align=right>$salidas</td>";
  echo "   <td>$fir</td>";  
  echo "</tr>";

}
echo "</table>";

?>

