<script type="text/javascript" language="javascript">
</script>

<?php
require_once("../functions/fechahora.php");
require_once("../functions/db.php");
require_once("historia.php");

conectar();
mostrarHistoriaConnombre($paciente);
desconectar();
?>
