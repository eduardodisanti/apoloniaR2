<?php
session_start();
require("../functions/db.php");
$link=conectar();
if($cmd=='dl')
 {
   $query = "delete from gastosEpisodios where Paciente=$pac and Fecha='$fecha' and Pieza=$pieza and Hora='$hora' and Articulo=$material";
   query($query);
 }
  else
    if($cmd=='Agregar')
         {  
	    $query = "insert into gastosEpisodios values($pac,'$fecha',$pieza,'$hora',$material, $cantidad)";  
	    query($query);
	 } else 
	  if($cmd=='add')
	   {
	      $query = "update gastosEpisodios set cantidad=cantidad + 1 where Paciente=$pac and Fecha='$fecha' and Pieza=$pieza and Hora='$hora' and Articulo=$material";
	         query($query);
	    } else
	              if($cmd=='sub')
		         {
			   $query = "update gastosEpisodios set cantidad=cantidad - 1 where Paciente=$pac and Fecha='$fecha' and Pieza=$pieza and Hora='$hora' and Articulo=$material";
			   query($query);
			 }

if(empty($id))
   $id=0;


if(empty($fecha)) {

   $fecha=date("Y-m-d");
   }

if(empty($hora)) {

       $hora=date("H:n:s");
}


echo "<body bgcolor='#ffffff'>";
echo "<table border=0 bgcolor='#cccccc' width='100%'>";
echo "<tr><td width='80%' align='center'><b>Lista de gastos</b></td>";
echo "<td align=right>";
echo "<a href='#' onclick='window.close()'><img src='../img/remove.png' border=0></a>";
echo "</td>";
echo "</tr>";
echo "</table>";
$query = "select id, descripcion from materialesExternos order by descripcion";
$q = query($query);

echo "<table border=0 width=99%>";
echo "<tr><td width='200px'>";
echo "<form action='gastoepisodio.php' method='post'>";
echo "<select id='material' name='material' size=25>";

while($reg = fetch($q)) {

     $id = $reg->id;
     $descripcion = $reg->descripcion;
     echo "<option value='$id'>$descripcion</option>";
}
echo "</select>";
echo "</td>";
echo "<td valign='center' width='200px'>";
echo "Cantidad <input type='text' value='1' size=3 name='cantidad'>";
echo "<input type='submit' name='cmd' value='Agregar'>"; 
echo "<input type='hidden' name='pac' value='$pac'>";
echo "<input type='hidden' name='fecha' value='$fecha'>";
echo "<input type='hidden' name='hora' value='$hora'>";
echo "<input type='hidden' name='pieza' value='$pieza'>";

echo "</td>";
echo "</form>";
$query = "select id, descripcion, cantidad, pieza, Paciente from gastosEpisodios, materialesExternos where articulo=id and Paciente=$pac and Fecha='$fecha' and Pieza=$pieza and Hora='$hora'";

$qry = query($query);

echo "<td valign='top'>";
echo "<table bgcolor='#000000' cellspacing='1' width='100%'>";
echo "<tr bgcolor='#cccccc'><th>&nbsp;</th><th>Material</th><th>Cantidad</th>><th>cmd</th></tr>";
while($reg=fetch($qry))
{
  $art = $reg->id;
  $nom = $reg->descripcion;
  $can = $reg->cantidad;
  $pieza=$reg->pieza;
  $pac  =$reg->Paciente;

  echo "<tr bgcolor='#ffffff'>";
  echo "   <td>";

  echo "       <a href='gastoepisodio.php?pac=$pac&fecha=$fecha&hora=$hora&material=$art&pieza=$pieza&cmd=dl'><img src='../img/basura.png' border=0></a>";
  echo "   </td>";
  echo "   <td>$nom</td>";
  echo "   <td align='right'>$can</td>";
  echo "   <td align='center'>";
  echo "   <a href='gastoepisodio.php?pac=$pac&fecha=$fecha&hora=$hora&material=$art&pieza=$pieza&cmd=add'><img src='../img/add.png' border=0 width='12px'></a>";
  echo "&nbsp;&nbsp;";
  if($can > 0)
echo "   <a href='gastoepisodio.php?pac=$pac&fecha=$fecha&hora=$hora&material=$art&pieza=$pieza&cmd=sub'><img src='../img/remove.png' border=0 width='12px'></a>";

  echo "   </td>";
  echo "</tr>";
}
echo "</table>";
echo "</td></tr>";
echo "</table>";
?>

