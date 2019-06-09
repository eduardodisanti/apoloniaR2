<?php

function colocarDiente($diente, $estado, $corrX, $corrY) {
  
     switch($diente) {
     
        case 18: $x = 12;
                 $y = 189; 
                break;
                
        case 17: $x = 18;
                 $y = 149; 
                break;
                
        case 16: $x = 25;
                 $y = 104; 
                break;
                
        case 15: $x = 43;
                 $y = 72; 
                break;
                
        case 14: $x = 59;
                 $y = 52; 
                break;
                
        case 13: $x = 78;
                 $y = 24; 
                break;
                
        case 12: $x = 100;
                 $y = 15; 
                break;
                
        case 11: $x = 121;
                 $y = 9; 
                break;
                

        case 21: $x = 150;
                 $y = 9; 
                break;
                
        case 22: $x = 171;
                 $y = 16; 
                break;
                
        case 23: $x = 201;
                 $y = 26; 
                break;
                
        case 24: $x = 219;
                 $y = 54; 
                break;
                
        case 25: $x = 235;
                 $y = 80; 
                break;
                
        case 26: $x = 245;
                 $y = 106; 
                break;
                
        case 27: $x = 255;
                 $y = 153; 
                break;
                
        case 28: $x = 262;
                 $y = 194; 
                break;     

        case 38: $x = 262;
                 $y = 216; 
                break;
                
        case 37: $x = 251;
                 $y = 248; 
                break;
                
        case 36: $x = 242;
                 $y = 287; 
                break;
                
        case 35: $x = 230;
                 $y = 329; 
                break;
                
        case 34: $x = 223;
                 $y = 357; 
                break;
                
        case 33: $x = 211;
                 $y = 378; 
                break;
                
        case 32: $x = 190;
                 $y = 392; 
                break;
                
        case 31: $x = 164;
                 $y = 398; 
                break;
                
                
        case 41: $x = 113;
                 $y = 398; 
                break;
                
        case 42: $x = 91;
                 $y = 392; 
                break;
                
        case 43: $x = 64;
                 $y = 378; 
                break;
                
        case 44: $x = 50;
                 $y = 357; 
                break;
                
        case 45: $x = 37;
                 $y = 329; 
                break;
                
        case 46: $x = 26;
                 $y = 287; 
                break;
                
        case 47: $x = 18;
                 $y = 248; 
                break;
                
        case 48: $x = 12;
                 $y = 216; 
                break;                               
     }
         //echo "<a href='#' onclick='#' style='position: absolute; top: $y; left:$x'>";
         
         $id = "diente$diente";

	 $x = $corrX + $x;
	 $y = $corrY + $y;
         echo "<img src='../img/piezas/$estado/$diente.png' border=0 id=$id  ondblclick='clickDiente($diente,  $estado)' style='position: absolute; top: $y; left:$x'>\n";
         //echo "</a>\n";
         echo "<script>";
         echo "agregarInfoDiente($diente, $estado);\n";
	 echo "pintarDiente($diente);\n";
         echo "makeDraggable($id);\n";
         echo "</script>";
  }
  
  
  function colocarBoca($paciente, $corrX, $corrY) {
  
   $q   = "select * from Piezas where Pieza < 49 and Pieza > 0 order by Indice";
   $qry = query($q);

   $id=0;
   while($reg = fetch($qry)) {

      $id++;
      $pieza = $reg->Pieza;

      $q = query("select * from piezasPaciente where paciente=$paciente and Pieza=$pieza");

      $reg = fetch($q);
      $npieza = $reg->pieza;
      if(!empty($npieza))
         $estado = $reg->estado;
      else {
         $estado = 3;
         $npieza = $pieza;
      }
      
      colocarDiente($npieza, $estado, $corrX, $corrY);
   }
  
  }
  
  function colocarDientesGenerales() {
  
   echo "<a href='#' onclick='clickDiente(777)' style='position: absolute; top: 329; left:120'>Superior</a>";
   echo "<a href='#' onclick='clickDiente(888)' style='position: absolute; top: 104; left:120'>Inferior</a>";
   echo "<a href='#' onclick='clickDiente(999)' style='position: absolute; top: 189; left:100'>Toda la Boca</a>";
  }
?>
