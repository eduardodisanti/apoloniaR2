<?php

function colocarListaHecho($paciente, $x, $y) {

      $x=$x."px";
      echo "<table id='tablaHecho' border=0 cellspacing=1 cellpadding=1 width=450px bgcolor='#cccccc' style='position:absolute; top:$y;left: $x;font-size:11px;font:Arial'>\n";
      echo "<tr bgcolor='#ffffff'>";
      echo "<th>Op</th><th>Pieza</th><th>Pieza</th><th>Procedimiento</th><th>Comentario</th>";
      echo "</tr>";
      echo "</table>\n";

      echo "<script>";
          $q = "select Pieza,Procedimiento,Nombre, Comentario from ParaHacer,Procedimientos where Paciente=$paciente and Procedimientos.codigo=ParaHacer.Procedimiento order by pieza";
          $qry = query($q);
          while($reg = fetch($qry)) {
             echo "addRowToTable($reg->Pieza, $reg->Pieza, $reg->Procedimiento, '$reg->Nombre', '$reg->Comentario');\n";
             if($reg->Procedimiento==500)
	        {
		  echo "infoRXDiente[$reg->Pieza]=true;";
		}
	  }
     echo "</script>";

}

?>
