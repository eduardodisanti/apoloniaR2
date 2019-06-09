<?php
session_start();


     $laboratorio =  $_SESSION['coifuncionario'];
     echo "<h2 align='center'>Proveedores de Laboratorio</h2>";
     echo "<a href='venctrabProv.php?cmd=listar'>Vencimiento de trabajos de lab.</a><br>";
     echo "<a href='../informes/venctrabxpac.php?cmd=listar'>Trabajos de lab x cedula</a><br>";
     echo "<a href='../pagosyprov/laboratorios/factlab.php?cmd=lab&val=$laboratorio'>Su facturacion</a><br>";
?>
