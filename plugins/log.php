<?
  $archivo = "log/apolonia.log";

  function escribir_log($usuario, $texto) {

$archivo = "log/apolonia.log";
     $fp = fopen($archivo, "a"); 

     $hoy=Date("Y-m-d");
     $ahora=Date("H:i:s");
     $ip = $_SERVER["REMOTE_ADDR"];
     fputs($fp, "$hoy | $ahora | desde $ip | de $usuario | $texto\n");

     fclose($fp);
  }

?>
