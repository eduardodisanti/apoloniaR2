<?php
session_start();

//if($_SESSION['coinivelusuario'] < 3)
//  die("Session no autorizada");
  
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
echo "<head><title>Recepcion de mercaderia</title>";
echo "<script src='../ajax/kajax.js'></script>";
echo "<script>";
echo "
function cambiarTransferencia() 
{
  var xid;
  
   xid = document.getElementById &&
         document.getElementById ('numero').value;
         
         window.location='recmerc.php?numero='+xid;
}


function recargar()
{
    xid = document.getElementById &&
                              document.getElementById ('numero').value;


    window.location='recmerc.php?numero='+xid;

}
";

echo "</script>";
echo "</head>";
echo "<body bgcolor='#ffffff'>";

echo "<table width='99%' bgcolor='#aacccc'>";
echo "<tr>";
echo "   <td>Numero de transferencia</td>";

if(empty($numero))
   $numero = 0;
echo "<td>";
echo "<input type='text' name='numero' id='numero' onChange='cambiarTransferencia()' value=$numero>";
echo "</select>";
echo "<input type='submit' value='Recargar' OnClick='recargar();'>";
echo "&nbsp;&nbsp;";
echo "</table>";

echo "<iframe id='frm' src='recmercaux.php?numero=$numero' width=99% height=295px border=0></iframe>";

?>

