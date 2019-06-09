<?php
require_once("class/Mateo.phpm");

session_start();
$m = $_SESSION['mateo'];
$tema = $m->getTema();

function date_diff($date2, $date1)
  {
      $s = strtotime($date2) - strtotime($date1);
      $d = intval($s/86400);
      return($d);
  }
if(empty($cmd))
  $cmd=bajar;

require("../functions/db.php");
$link=conectar();
echo "<head><title>Lista de reposicion</title>";
echo "</head>";
echo "<body bgcolor='#ffffff'>";

if(empty($f1) || empty($f2)) {
  $f1 = Date("Y-m")."-01";
  $f2 = Date("Y-m")."-31";
}

$hoy = Date("Y-m-d");
$ahora= Date("H:n:s");

$q = "select id, nombre from almacenes where id > 0 order by nombre";
$query = query($q);

$numeroAlmacenes = 0;

$subtitulo = "<tr><td>&nbsp;</td>";
$titulo= "<tr bgcolor='#cccccc'><th width=40%>Articulo</th>";

while($reg=fetch($query)) {

   $id = $reg->id;
   $nom= $reg->nombre;

   $almacenes[$numeroAlmacenes]=$nom;
   $ids[$numeroAlmacenes]=$id;
   ++$numeroAlmacenes;

   $subtitulo=$subtitulo."<td>Ped</td><td>Con</td>";
   $titulo=$titulo."<th colspan=2>".$nom."</th>";
}

$titulo.= "<td colspan=2>Total</td></tr>";
$subtitulo.="<td>Ped.</td><td>Cons</td><td>Stk</td></tr>";

//$q = "select articulos.nombre as articulo, articulos.id as idart, familias.nombre as familia from articulos, familias where articulos.nombre > ' ' and familias.id = articulos.familia order by familia, articulos.nombre";


$q = "select articulos.nombre as articulo, articulos.id as idart, familias.nombre as familia from articulos, familias where articulos.nombre > ' ' and familias.id = articulos.familia order by articulos.nombre, familia";

$query = query($q);
echo "<table width='100%' border=1>";
echo "<tr>";
echo "   <td colspan=$numeroAlmacenes>Listado de reposicion $hoy $ahora pedidos entre";
echo "   <form action='inventario.php'>";
echo "    <input type=text size=10 name=f1 value='$f1'> y <input type=text size=10 name=f2 value='$f2'>";
echo "    <input type='submit' value='Enviar'>";
echo "</td>";
echo "</tr>";


// cagda 

         echo "<tr><td></td><td colspan=$numeroAlmacenes align=center><b>$familia</b></td></tr>";
       echo $titulo;
          echo $subtitulo;
          $familiaAnt = $familia;


$familiaAnt="";
while($reg = fetch($query))
{

  $familia = $reg->familia;
  $art     = $reg->articulo;
  $idart   = $reg->idart;

   // cagada
   $familiaAnt = $familia;

   if($familiaAnt != $familia) {
      echo "<tr><td></td><td colspan=$numeroAlmacenes align=center><b>$familia</b></td></tr>";
      echo $titulo;
      echo $subtitulo;
      $familiaAnt = $familia;
   }

  $ellink="fichastck.php?articulo=$idart";
  $linium="<tr><td><a href='$ellink' target='_blank'>$art</a></td>"; 
  $totpedido=0;
  $totconsum=0;
  for($i=0;$i<$numeroAlmacenes;$i++) {

     $alm = $ids[$i];
     $q = "select (entradas - salidas) as saldo from stock where articulo=$idart and almacen=0";
     $qqq = query($q);
     $rq = fetch($qqq);
     $stockCentral = $rq->saldo;

     $q = "select sum(cantidad) as cant from pedidos where almacen=$alm and articulo=$idart";
          $qqq = query($q);
	  $rq = fetch($qqq);
	  $cant1 = $rq->cant;  
	  $totpedido+=$cant1;

     $q = "select sum(Unidades) as canta from Movstock where Destino=$alm and Articulo=$idart and Fecha >= '$f1' and Fecha <='$f2' and Codigo=2";
     $qq = query($q);
     $rqq = fetch($qq);
     $x = mysql_error();
     $canta = $rqq->canta;
     $totconsum+=$canta;

     $xcant = number_format($canta);
     $xcant1= number_format($cant1);

     if($xcant=="0")
       $xcant="&nbsp;&nbsp;";
     if($xcant1=="0")
       $xcant1="&nbsp;&nbsp;";

     $linium.="<td align=right bgcolor='#ccccc'>$xcant1</td><td align=right>$xcant</td>";
  } 
  $linium.="<td align=right><b>$totpedido</b></td><td align=right><b>$totconsum</b></td><td align=right>$stockCentral</td>";
  $linium.="</tr>";
  //if($totpedido!=0 || $totconsum!=0)
    echo $linium;
}
echo "</table>";

?>
