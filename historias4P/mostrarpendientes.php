<?php
require_once("../functions/fechahora.php");
require_once("../functions/db.php");
require_once("historia.php");

conectar();
mostrarPendientes($paciente);
desconectar();
?>