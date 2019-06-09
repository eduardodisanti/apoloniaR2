<?php
require_once("../functions/fechahora.php");

function mostrarHistoriaBAD($cedula) {

  $hoy = fechaHoy();

  $fechaAnt="";
  $procAnt=-1;

  $q = "select Fecha,Hora,Pieza,Procedimiento, Comentario, Episodios.usuario, Procedimientos.Nombre as nproc, Usuarios.usuario as nusuario from Episodios, Procedimientos, Usuarios where Paciente=$cedula and Procedimiento = Procedimientos.Codigo and Episodios.usuario = Usuarios.funcionario order by Fecha desc, Hora desc, Procedimiento, Pieza";

  
  $query = query($q);
  
  $color='#fffffcc';
  
  echo "<table border=0 bgcolor='#ffff99' bordercolor='#ffcc00' cellpadding=0 cellspacing=1>";
  
  while($reg = fetch($query)) {
  
     $fecha = $reg->Fecha;
     $pieza = $reg->Pieza;
     $procedimiento = $reg->Procedimiento;
     $nproc         = $reg->nproc;
     $hora          = $reg->Hora;
     $comentario    = $reg->Comentario;
     $usuario       = $reg->usuario;
     $nusuario      = $reg->nusuario;
    
     $dq = query("select estado from piezasPaciente where paciente=$cedula and pieza=$pieza");
     $dr = fetch($dq);
     echo mysql_error();

     $estado = $dr->estado;
     if(empty($estado))
        $estado = 3;
     if($estado==5) $estado=1;
        
     	echo "<tr bgcolor='$color'>";
     	echo "  <td colspan=1 width=48><img src='../img/historias.png'></td>";
     	echo "  <td colspan=1>$fecha</td>";
     	echo "  <td colspan=2>";
	    echo " 	$pieza <img src='../img/piezas/$estado/$pieza.png'>";
		echo "  </td>";
     	echo "</tr>";
     
     	echo "<tr bgcolor='$color'>";
     	echo "  <td colspan=4>$nproc</td>";
     	echo "</tr>";
     
     	echo "<tr bgcolor='$color'>";
     	echo "  <td colspan=4>$comentario</td>";
     	echo "</tr>";
     
     	echo "<tr bgcolor='$color'>";
     	echo "  <td colspan=4 align='right'><img src='../img/personal.png'>$nusuario</td>";
     	echo "</tr>";
     
     if($fecha != $fechaAnt) {
         mostrarTrabajosLaboratorioDia($fecha, $cedula);
         $fechaAnt = $fecha;
      }
   
         echo "<tr bgcolor='#ffffaa'><td colspan=4>&nbsp;&nbsp;</td></tr>\n";
     
         if($color=='#ffffcc')
           $color = '#ffff66';
         else
           $color = '#ffffcc';
  }
   
  echo "</table>";

   echo "<br><center>Diagnosticos</center>";
   mostrarDiagnosticos($cedula);
}

function mostrarHistoriaConnombre($cedula) {

    $q = query("select * from Pacientes where Cedula=$cedula");
    $r = fetch($q);

    $ced = $r->Cedula;
    $nom = $r->Nombre;

    echo "<h4>$ced &nbsp;$nbsp $nom</h4>";
    mostrarHistoria($cedula);
}

function mostrarHistoria($cedula) {

  $hoy = fechaHoy();

  $fechaAnt="";
  $procAnt=-1;

  $q = "select Fecha,Hora,Pieza,Procedimiento, Comentario, Episodios.usuario, Procedimientos.Nombre as nproc, Usuarios.usuario as nusuario from Episodios, Procedimientos, Usuarios where Paciente=$cedula and Procedimiento = Procedimientos.Codigo and Episodios.usuario = Usuarios.funcionario order by Fecha desc, Hora desc, Procedimiento, Pieza";

  
  $query = query($q);
  
  $color='#fffffcc';
  
  echo "<table border=0 bgcolor='#ffff99' bordercolor='#ffcc00' cellpadding=0 cellspacing=1>";
  
  while($reg = fetch($query)) {
  
     $fecha = $reg->Fecha;
     $pieza = $reg->Pieza;
     $procedimiento = $reg->Procedimiento;
     $nproc         = $reg->nproc;
     $hora          = $reg->Hora;
     $comentario    = $reg->Comentario;
     $usuario       = $reg->usuario;
     $nusuario      = $reg->nusuario;
    
     $dq = query("select estado from piezasPaciente where paciente=$cedula and pieza=$pieza");
     $dr = fetch($dq);
     echo mysql_error();

     $estado = $dr->estado;
     if(empty($estado))
        $estado = 3;
   
    if($fechaAnt=="") {
      $fechaAnt=$fecha;
      $procAnt = $procedimiento;
      $nomProcAnt = $nproc;
      $comentAnt = $comentario;
      $usuAnt = $nusuario;
    }
    
     if($fechaAnt != $fecha || $procAnt != $procedimiento || $comentAnt != $comentario) {

     	echo "<tr bgcolor='$color'>";
     	echo "  <td colspan=1 width=48><img src='../img/historias.png'></td>";
     	echo "  <td colspan=1>$fechaAnt</td>";
     	echo "  <td colspan=2>$listaPiezas";
	echo "  </td>";
     	echo "</tr>";
     
     	echo "<tr bgcolor='$color'>";
     	echo "  <td colspan=4>$nomProcAnt</td>";
     	echo "</tr>";
     
     	echo "<tr bgcolor='$color'>";
     	echo "  <td colspan=4>$comentAnt</td>";
     	echo "</tr>";
     
     	echo "<tr bgcolor='$color'>";
     	echo "  <td colspan=4 align='right'><img src='../img/personal.png'>$usuAnt</td>";
     	echo "</tr>";
     
         mostrarTrabajosLaboratorioDia($fechaAnt, $cedula);
	 mostrarPasesDia($fechaAnt, $cedula);
   
         echo "<tr bgcolor='#ffffaa'><td colspan=4>&nbsp;&nbsp;</td></tr>\n";
     
         if($color=='#ffffcc')
           $color = '#ffff66';
         else
           $color = '#ffffcc';

	   $fechaAnt = $fecha;
	   $procAnt = $procedimiento;
	   $nomProcAnt=$nproc;
	   $usuAnt=$nusuario;
	   $comentAnt=$comentario;
	   $listaPiezas="";
      }
      
      if($estado==5) $estado=1;
	     $listaPiezas=$listaPiezas." $pieza <img src='../img/piezas/$estado/$pieza.png'>";
  }
     	echo "<tr bgcolor='$color'>";
     	echo "  <td colspan=1 width=48><img src='../img/historias.png'></td>";
     	echo "  <td colspan=1>$fechaAnt</td>";
     	echo "  <td colspan=2>$listaPiezas";
	echo "  </td>";
     	echo "</tr>";
     
     	echo "<tr bgcolor='$color'>";
     	echo "  <td colspan=4>$nomProcAnt</td>";
     	echo "</tr>";
     
     	echo "<tr bgcolor='$color'>";
     	echo "  <td colspan=4>$comentAnt</td>";
     	echo "</tr>";
     
     	echo "<tr bgcolor='$color'>";
     	echo "  <td colspan=4 align='right'><img src='../img/personal.png'>$usuAnt</td>";
     	echo "</tr>";
   
  echo "</table>";

   mostrarDiagnosticos($cedula);
}

function mostrarTrabajosLaboratorioDia($fecha, $paciente) {

      $rq="select Trabajo,Trabajos.descripcion, Laboratorios.descripcion as desclab, EstadosTrabajo.Descripcion as DescEstado, Pieza from HistTrabSoc,Trabajos, Laboratorios, EstadosTrabajo where Paciente=$paciente and Fecha='$fecha' and Trabajos.id=Trabajo and Laboratorios.id = HistTrabSoc.Laboratorio and EstadosTrabajo.Codigo=Episodio";

    $rqry=query($rq);

    while($rrow=fetch($rqry))
      {
       echo "<tr bgcolor='#ffcc66'>";
       echo "<td align='center'><img src='../img/miniLaboratorio.png'><b>$rrow->Pieza</b></td>";
       echo "<td colspan=1>$rrow->descripcion</td>";
       echo "<td>";
       echo "$rrow->desclab";
       echo "</td>";
       echo "<td>";
       echo "$rrow->DescEstado";
       echo "</td>";
       echo "</tr>";
      }
}

function mostrarPasesDia($fecha, $paciente) {

      $rq="select pieza, Procedimientos.Nombre as proc, Medicos.Nombre as med from pases, Procedimientos, Medicos where medico=Medicos.Numero and pases.procedimiento = Procedimientos.Codigo and paciente=$paciente and fecha='$fecha'";

          $rqry=query($rq);

	   while($rrow=fetch($rqry))
	    {
	        echo "<tr bgcolor='#ffccff'>";
	        echo "<td align='center'><b>$rrow->pieza</b></td>";
	        echo "<td colspan=1>$rrow->proc</td>";
	        echo "<td colspan=2>";
		echo "$rrow->med";
		echo "</td>";
		echo "</tr>";
   	    }
}

function mostrarAntecedentes($pac) 
{
  $q = "select * from Antecedentes where Paciente = $pac order by Fecha, hora";
  $query = query($q);
  echo mysql_error();
  echo "<table border=0 width=95% bgcolor='#000000'>";
  echo "<tr>";
  echo "<th bgcolor='#fcfcfc'>Fecha</th><th bgcolor='#fcfcfc'>Nota</th>";
  echo "</tr>\n";
  $count = 0;
  while($reg = fetch($query))
      {
        $fecha = $reg->Fecha;
        $xnota  = nl2br($reg->Descripcion);

        if($count==0)
           $color="#ffffff";
        else
           $color="#cccccc";

        echo "<tr><td bgcolor='$color'>$fecha</td><td bgcolor='$color'>$xnota</td></tr>";
        $count++;
        if($count==2)
           $count=0;
      }
      echo "</table>";
}

function mostrarPendientes($paciente)
{
$result= query("select Pieza,Procedimiento,Nombre, Comentario from ParaHacer,Procedimientos where Paciente=$paciente and Procedimientos.codigo=ParaHacer.Procedimiento order by pieza") or die ("Error:".mysql_error());

echo "<TABLE BORDER=0 BGCOLOR=\"000000\" CELLPADDING=0 CELLSPACING=1>";
echo "<TH BGCOLOR=\"#BBBBBB\">Pieza</TH><TH BGCOLOR=\"#BBBBBB\">Procedimiento</TH>";
while($row =fetch($result))
   {
     echo "<TR bgcolor='#ffffff'><TD>$row->Pieza</TD><TD>$row->Nombre</TD></TR>";
     echo "<TR bgcolor='#00aacc'><TD colspan=2>$row->Comentario</TD></TR>";
   }
echo "</TABLE></CENTER><HR>";

echo "<CENTER><FONT COLOR=\"#800000\">Diagnosticos</FONT>";
   mostrarDiagnosticos($paciente);
}

function mostrarDiagnosticos($paciente)
{

echo "<TABLE BORDER=0 WIDTH=99% BORDER=0 BGCOLOR=\"#000000\" CELLPADDING=0 CELLSPACING=1>";
echo "<TH BGCOLOR=\"#BBBBBB\">Pieza</TH><TH BGCOLOR=\"#BBBBBB\">Fecha</TH><TH BGCOLOR=\"#BBBBBB\">Procedimiento</TH>";
$query=query("select Paciente, Fecha, Diagnostico, Comentario, Pieza, Nombre, usuario from Diagnosticos, Procedimientos  where Paciente=$paciente and Procedimientos.Codigo = Diagnosticos.Diagnostico order by Pieza, Fecha") or die("Error : ".mysql_error());

while($row =fetch($query))
   {
     echo "<TR bgcolor='#ffffff'><TD align=right>";
     echo "<img src='../img/piezas/3/$row->Pieza.png'>$row->Pieza";
     echo "</TD><TD align=right>$row->Fecha</TD><TD>$row->Nombre</TD></TR>";
     echo "<tr bgcolor='#00aacc'><TD colspan=3>$row->Comentario</TD></tr>";
   }
echo "</TABLE></CENTER><HR>";
}

?>
