<?php

    session_start();
    
     $coiusuario = $_SESSION['coifuncionario'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><title>Revision</title>
<script>

var abierto;
var idabierto;
var posicion1;

function cargar() {

     hoja = document.getElementById("hoja");
     posicion1 = Number((hoja.style.left).replace("px","  "));
     hoja.style.left=posicion1+"px";
     abierto = false;
     idabierto=0;
}

function cerrarPanel() {

      cerrarAuxiliar(0);
}

function mostrarAntecedentes(paciente) {


    aux = document.getElementById("auxiliar");
    if(!abierto) {
        abrirAuxiliar(posicion1);
    }

    if(idabierto != 1 && abierto) {
                  aux.src="mostrarantecedentes.php?operacion=edit&paciente="+paciente;
                  idabierto = 1;
        }
         else
             cerrarAuxiliar(0);
}

function mostrarPendientes(paciente) {

    aux = document.getElementById("auxiliar");
    if(!abierto) {
        abrirAuxiliar(posicion1);
    }

        if(idabierto != 2 && abierto) {
                  aux.src="mostrarpendientes.php?paciente="+paciente;
                  idabierto = 2;
         }
         else
             cerrarAuxiliar(0);
}

function mostrarHistoria(paciente) {

    aux = document.getElementById("auxiliar");
    if(!abierto) {
        abrirAuxiliar(posicion1);
    }
        if(idabierto != 3 && abierto) {
                  aux.src="mostrarepisodio.php?paciente="+paciente;
                  idabierto = 3;
        }
         else
             cerrarAuxiliar(0);
}

function mostrarDiagnosticos(paciente) {


    aux = document.getElementById("auxiliar");
    if(!abierto) {
        abrirAuxiliar(posicion1);
    }

        if(idabierto != 4 && abierto) {
                  aux.src="mostrardiagnosticos.php?paciente="+paciente;
                  idabierto = 4;
         }
         else
             cerrarAuxiliar(0);
        
}

function abrirAuxiliar(i) {

var hoja;

   i+=80;
   hoja = document.getElementById("hoja");
   
       hoja.style.left = i+"px"; 

   if(i < 0)
       setTimeout("abrirAuxiliar("+i+")",5);    
   else
      hoja.style.left = "0px";
       
   abierto = true;
}

function cerrarAuxiliar(i) {

var hoja;

   i-=80;
   hoja = document.getElementById("hoja");
   
       hoja.style.left = i+"px"; 

   if(i > posicion1)
       setTimeout("cerrarAuxiliar("+i+")",5);
   else
       hoja.style.left = posicion1+"px";
       
   abierto = false;
   idabierto = 0;
}

</script></head><body onload="cargar()">

<?php 
include("../functions/db.php");
include("menuhistoria.php");

if(empty($paciente))
   $paciente = 1716611;
$db = conectar();

$q = query("select * from Pacientes where Cedula=$paciente");
$reg = fetch($q);
$nombrePaciente = $reg->Nombre;

echo "<div id='hoja' width=1300px style='position: absolute; top:0; left:-400px; visibility: visible; overflow:hidden'>";
echo "<blockquote style='width : 1300px; height : 540px; margin-top: 0px; margin-left: 0px; border: none'>";
echo "<table border=0 cellpadding=0 cellspacing=0 width=1300px>";
echo "<tr>";
echo "<td></td>";
echo "	<td colspan=2 bgcolor='#cccccc'>";
echo "Paciente : $nombrePaciente ($paciente)";
echo " <a href='hojahistoria.php?paciente=$paciente&medico=$medico&comando=Paso2'>Vista Episodio</a>";
echo " 		<a href='nuevarevision.php?medico=$medico&comando=Paso2'>Otro paciente</a>";
echo "	</td>";
echo "</tr>";
echo "<tr>";
echo "<td height=510px width=400px bgcolor='#ffffff' valign='top'>";
echo "    <iframe id='auxiliar' src='mostrarepisodio.php?paciente=$paciente' width=100% height=510px border=0></iframe>";
echo "</td>\n";
echo "<td width=100px bgcolor='#000000' valign='top'>";
        mostrarMenuHistoria($paciente);
echo "</td>";
echo "<td width=800px height=520px valign=top>";
echo "    <iframe src='revision.php?paciente=$paciente&usuario=$coiusuario' width=100% height=510px border=0></iframe>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</blockquote>";
echo "</div>";
  
desconectar();   
?></body></html>
