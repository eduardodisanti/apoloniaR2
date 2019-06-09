<HTML>
<HEAD>
	<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=iso-8859-1">
	<TITLE></TITLE>
	<META NAME="GENERATOR" CONTENT="StarOffice/5.2 (Win32)">
	<META NAME="CREATED" CONTENT="20010607;10182931">
	<META NAME="CHANGEDBY" CONTENT="Eduardo Di Santi">
	<META NAME="CHANGED" CONTENT="20010607;11381431">
</HEAD>
<BODY BGCOLOR="#9999cc">
<HR>
<FONT COLOR="#800000"><FONT FACE="Arial, sans-serif"><FONT SIZE=4>Consulta de la Historia </FONT></FONT></FONT>
<FONT SIZE=4>Paciente :
<?php
     $apoloniaPaciente=$paciente;
$con = mysql_connect("127.0.0.1","root","virgen");
$base=mysql_select_db("apolonia",$con);

      $query=mysql_query("select * from Pacientes where Cedula=$apoloniaPaciente") or 
          die("No se pudo encontrar el paciente $apoloniaPaciente : ".mysql_error());
      $rowi=mysql_fetch_object($query); 
      $Nombre=$rowi->Nombre;
      $Seguro=$rowi->Seguro;
      echo $Nombre." (".$Seguro.")<HR>";

echo "<CENTER><FONT COLOR=\"#800000\">Diagnosticos</FONT>";
echo "<TABLE BORDER=3 WIDTH=80% BORDER=0 BGCOLOR=\"#ccccff\" CELLPADDING=0 CELLSPACING=0>";
echo "<TH BGCOLOR=\"#BBBBBB\">Pieza</TH><TH BGCOLOR=\"#BBBBBB\">Procedimiento</TH><th BGCOLOR=\"#BBBBBB\">Firma</th>";
$query=mysql_query("select Pieza, Diagnostico, Usuarios.usuario as nusuario from Diagnosticos, Usuarios  where Paciente=$apoloniaPaciente and Usuarios.funcionario = Diagnosticos.usuario  order by Pieza") or die("Error : ".mysql_error());

while($row = mysql_fetch_object($query))
   {
     echo "<TR><TD>$row->Pieza</TD>";
        echo "<TD>$row->Diagnostico</TD>";
       echo "<TD>$row->nusuario</TD>";
     echo "</TR>";
   }
echo "</TABLE></CENTER><HR>";
mysql_free_result($query);

echo "<CENTER><FONT COLOR=\"#800000\">Historia</FONT>";
echo "<TABLE BORDER=3 WIDTH=80% BORDER=0 BGCOLOR=\"#ccccff\" CELLPADDING=0 CELLSPACING=0>";
echo "<TH BGCOLOR=\"#BBBBBB\">Fecha</TH><TH BGCOLOR=\"#BBBBBB\">Pieza</TH><TH  BGCOLOR=\"#BBBBBB\">Procedimiento</TH><th>Firma</th>";
$query= mysql_query("select Fecha,Pieza,Procedimientos.Nombre,Comentario, Usuarios.usuario as nusuario from Episodios, Procedimientos, Usuarios where Paciente=$apoloniaPaciente and Procedimientos.Codigo=Episodios.Procedimiento and Usuarios.funcionario = Episodios.usuario order by Fecha,Hora,Pieza") or die ("Error:".mysql_error());

while($row = mysql_fetch_object($query))
   {
     echo "<TR><TD>$row->Fecha</TD><TD>$row->Pieza</TD><TD>$row->Nombre</TD></TR>\n";
     echo "<TR><TD COLSPAN=3 BGCOLOR=\"#99cbcc\">";
           $tok=strtok($row->Comentario,"\n");
           while($tok)
             {
              echo "$tok<BR>";
              $tok=strtok("\n");
             }
     echo "</TD><td>$row->nusuario</td>
        </TR>\n";

    $rq="select Trabajo,descripcion,Entregado from TrabSoc,Trabajos where Paciente=$apoloniaPaciente and Fecha='$row->Fecha' and id=Trabajo";
    $rqry=mysql_query($rq);
    while($rrow=mysql_fetch_object($rqry))
      {
        
       echo "<tr bgcolor='#fcfcfc'<td>$rrow->Trabajo</td><td colspan=3>$rrow->descripcion</td></tr>";
      }
   }
echo "</TABLE></CENTER><HR>";
$result= mysql_query("select Pieza,Procedimiento,Nombre from ParaHacer,Procedimientos where ".
"Paciente=$apoloniaPaciente and Procedimientos.codigo=ParaHacer.Procedimiento order by pieza") or die ("Error:".mysql_error());

echo "<CENTER><FONT COLOR=\"#800000\">Para Hacer</FONT>";
echo "<TABLE BORDER=3 WIDTH=80% BORDER=0 BGCOLOR=\"#ccccff\" CELLPADDING=0 CELLSPACING=0>";
echo "<TH BGCOLOR=\"#BBBBBB\">Pieza</TH><TH BGCOLOR=\"#BBBBBB\">Procedimiento</TH>";
while($row = mysql_fetch_object($result))
   {
        echo "<TR>";
        echo "<TD>$row->Pieza</TD>";
        echo "<TD>";
           $tok=strtok($row->Nombre,"\n");
           while($tok)
             {
              echo "$tok<BR>";
              $tok=strtok("\n");
             }
        echo "</TD>";
     echo "</TR>";

   }

   echo "</TABLE></CENTER><HR>";

   echo "<CENTER><FONT COLOR=\"#800000\">Pendientes de laboratorio</FONT>";
   echo "<TABLE BORDER=1 WIDTH=80% BORDER=0 BGCOLOR=\"#ccccff\" CELLPADDING=0 CELLS
   PACING=0>";

 $rq="select Trabajo,descripcion,Entregado from TrabSoc,Trabajos where Paciente
 =$apoloniaPaciente and id=Trabajo and Entregado='N'";

 $rqry=mysql_query($rq);
   while($rrow=mysql_fetch_object($rqry))
     {
      echo "<tr bgcolor='#fcfcfc'<td>$rrow->Trabajo</td><td>$rrow->descripcion</
      td></tr>";
     }

echo "</TABLE></CENTER><HR>";
mysql_free_result($result);

mysql_free_result($query);
mysql_close($con);
?>

