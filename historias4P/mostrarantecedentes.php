<?php
require_once("../functions/fechahora.php");
require_once("../functions/db.php");
require_once("historia.php");

conectar();
//mostrarAntecedentes($paciente);

 function mostrarListaDeEnfermedades() {

    $q = "select * from enfermedades";
    
    $qry = query($q); 
    echo "<select name='codigo'>";
    echo "<option name='0' value='0'>--Sin especificar</option>";

    while($reg = fetch($qry)) {
    
        $codigo = $reg->codigo;
        $nombre = $reg->nombre;
        $color  = $reg->color;
    
        echo "<option name='$codigo' value='$codigo'>$nombre</option>";
    }
    echo "</select>";
 }

  
   $pac = $paciente;
   if($cmd=="Agregar")
     {
         $hoy  = Date("Y-m-d");
         $hora = Date("H:i");

         $q = "insert into Antecedentes values($pac, '$hoy', '$hora', '$nota', $codigo)";

         query($q);
     }

   $q = "select * from Antecedentes where Paciente = $pac order by Fecha, hora";
   $query = query($q);

   echo "<table border=0 width=95% bgcolor='#000000'>";
   echo "<tr>";
   echo "<th bgcolor='#fcfcfc'>Fecha</th><th bgcolor='fcfcfc'>Nota</th>";
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

   echo "<hr>";
   if($operacion=="edit")
     {
      echo "<form action='mostrarantecedentes.php'>";
	  echo "Nuevo antecedente <textarea cols=55 lines=5 name='nota'></textarea>";
	  echo "Codigo de enfermedad : ";
	  mostrarListaDeEnfermedades();
	  echo "  <input type='hidden' name='paciente' value='$pac'>";
	  echo "  <input type='submit' name=cmd value='Agregar'>";
      echo "  <input type='hidden' name=operacion value='$operacion'>";
      echo "</form>"; 
     }

desconectar();
?>