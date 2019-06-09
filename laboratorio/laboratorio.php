<?php
     $nivel = $_SESSION['coinivelusuario'];
     $nivel = $coinivelusuario;
     echo "<h2 align='center'>Menu de laboratorios $coinivelusuario</h2>";

   echo "<li><a href='asignarTrab.php'>Asignar trabajos a pacientes</a></li>";
   //echo "<li><a href='../informes/laboratorios/trablab.php'>Trabajos por Laboratorio</a></li>";
?>

<a href="../informes/laboratorios/listxlab.php">Informe de impresion y colocacion</a><br>
<a href="../informes/laboratorios/listpendxlab.php">Listados de trabajos pendientes de un laboratorio</a><br>
<a href="../informes/venctrab.php?cmd=listar">Vencimiento de trabajos de lab.</a><br>
<a href="../informes/venctrabxpac.php?cmd=listar">Trabajos de lab x cedula</a><br>
<a href="../informes/estadoTrabajos.php">Trabajos de laboratorio</a><br>
<a href="../informes/laboratorios/resumenlab.php">Resumen diario de trabajos</a><br>
<a href="../informes/venctrabxmed.php">Trabajos x medico</a><br>
<a href="cambiarlab.php">Cambiar un trabajo de laboratorio y/o vencimiento</a><br>
<a href="cambiarsuc.php">Cambiar un trabajo de Sucursal</a><br>
<br>
<a href="../informes/laboratorios/tt-eal-01.php">TT-EAL-01</a>
<a href="../informes/laboratorios/tt-eal-02.php">TT-EAL-02</a>
<a href="../informes/laboratorios/tt-eal-03.php">TT-EAL-03</a><br>
<a href="../informes/laboratorios/factlabnocolo.php">Trabajos facturados por el laboratorio y no colocados al paciente por falta de horas</a><br>
<a href="../informes/laboratorios/omisioncolocado.php">Omision de marcar trabajos por los medicos</a><br>

<a href="../informes/laboratorios/nocolocadoxfaltas.php">Trabajos no colocados x faltas del paciente<a><br>
<a href='../informes/laboratorios/factlabxpac.php'>Facturas por paciente</a><br>
<a href='../pagosyprov/laboratorios/busfact.php'>Visualizar facturas</a><br>
<?php

    if($nivel>=6) {

      echo "<a href='../pagosyprov/laboratorios/menul.html'>Control de laboratorios</a><br>";
      echo "<a href='../admin/lab.php'>Administracion de laboratorios (TT-EAL-03)</a><br>";
      echo "<a href='../admin/trabproc.php'>Administracion de trabajos (TT-EAL-04)</a>";
    }

?>
