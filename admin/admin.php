<?php
    session_start();
    $nivel = $_SESSION['coinivelusuario'];

    if($nivel < 7) {

        die("<h2>Usted no esta autorizado a ejecutar este comando</h2>");
    }
?>
<html>
<head>
   <title>Administración del sistema</title>
</head>
<body>
   <center>
    <h2>Administraci&oacute;n</h2>
   </center>
   <li><a href="especial.php">Especialidades</a></li>
   <li><a href="proced.php">Procedimientos</a></li>
   <li><a href="jerarquiaProcedimientos.php">Jerarquia de Procedimientos</a></li>
   <li>&nbsp;&nbsp;<a href="metatrabproc.php">Meta Trabajos de laboratorio x procedimiento</a></li>
   <li>&nbsp;&nbsp;<a href="trabproc.php">Procedimientos odontologicos y trabajos de laboratorio</a></li>
    <li>&nbsp;&nbsp;<a href="materialesproc.php">Procedimientos odontologicos y materiales</a></li>
   <li><a href="usuarios.php">Usuarios</a></li>
   <li><a href="lab.php">Laboratorios</a></li>
   <li>&nbsp;&nbsp<a href="metatrab.php">Meta Trabajos de Laboratorio</a></li>
   <li>&nbsp;&nbsp;&nbsp;<a href="trab.php">Trabajos de laboratorio</a></li>
   <li>&nbsp;&nbsp;&nbsp;<a href="../informes/laboratorio/tt-eal-01.php">Imprimir la TT-EAL-01</a></li>

   <li><a href="molde.php">Molde de horarios</a></li>
   <li><a href="horasturnos.php">Horas por turno</a></li>
   <li><a href="seguros.php">Seguros</a></li>
   <li><a href="ordenes.php">Mantenimiento de Ordenes</a></li><br>
   <li><a href="gargosup.php">Mantenimiento de Suplentes</a></li><br>
   
   <li><a href="../plugins/news/editnews.php">Editar noticias</a></li>
   <li><a href="../plugins/editboard.php">Editar cartelera</a></li><br>
   <li><a href="../plugins/editorden.php">Texto de la orden</a></li><br>

   <li><a href="marcarpaga.php">Marcar pacientes que siempre pagan</a></li>
</body>
</html>
