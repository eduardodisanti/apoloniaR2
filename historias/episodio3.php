<HTML>
<HEAD>
	<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=iso-8859-1">
	
<script language="JavaScript">
var proced = 0;
var dientesElegidos = 0;

 function clickDiente(diente)
 {

    var opt = document.createElement("option");
    lista = document.getElementById("lbDientes");
    
    opt.text=diente;
    opt.value=diente;
    lista.options.add(opt);

   ++dientesElegidos;
   
   ponerBotonAceptar();
 }
 
 function quitarDiente()
 {
 lista = document.getElementById("lbDientes");

    indice = lista.options.selectedIndex;
    
    lista.remove(indice);
    
    --dientesElegidos;
    if(dientesElegidos < 0)
       dientesElegidos = 0;
       
    ponerBotonAceptar();      
 } 
 
  function cambiarProc() 
  {
     box = lista = document.getElementById("procedimientos");
     proced = box.options.selectedIndex;
     
     ponerBotonAceptar();
  }
  
  function ponerBotonAceptar() {
  
       boton = document.getElementById("aceptar");
      if(proced !=0 && dientesElegidos > 0) {
         boton.disabled = false;
      }
      else
         boton.disabled = true;
  }
  
</script>
</HEAD>
<BODY>
<?php

  include ("../functions/db.php");

function pasoSiguiente() {

}

function   colocarBotonSiguiente() {

     echo "<input type='submit' id='aceptar' value='Aceptar' style='position: absolute; top:400px; left: 500px' disabled onclick='pasoSiguiente()'>";
}

function colocarPaciente($paciente) {

   $q = query("select * from Pacientes where Cedula=$paciente order by Nombre");
   
   $reg = fetch($q);
   $cedula = $reg->Cedula;
   $nombre = $reg->Nombre;

   echo "<table border=0 style='position: absolute; top:0px; left: 350px'>";
   echo "<tr>";
   echo "   <td>$cedula</td><td><b>$nombre</b></td>";
   echo "</tr>";
   echo "</table>";
}

  function colocarListaProcedimientos() {
  
   echo "<SELECT id='procedimientos' SIZE=10 onChange='cambiarProc()' style='position: absolute; top:50px; left: 390px'>";
   echo "    <OPTION value='0' selected>Sin especificar</OPTION>\n";
   $q = query("select * from Procedimientos where Activo='S' order by Nombre");
   while($reg = fetch($q))
    {
          $Nombre=$reg->Nombre;
          $Codigo=$regi->Codigo;
          $nNombre=substr($Nombre, 0,55);
          echo "<OPTION value='$Codigo'>$nNombre</OPTION>\n";
    }
    echo "</SELECT>";
  }

  function colocarListaDientes() {
  
  echo "<SELECT id='lbDientes' SIZE=8 STYLE='position: absolute; top: 50px; left: 350px' ondblclick='quitarDiente()'>";
  echo "</select>";
  }
  
  function colocarDiente($diente, $estado) {
  
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
     echo "<a href='#' onclick='clickDiente($diente)' style='position: absolute; top: $y; left:$x'><img src='../img/piezas/$estado/$diente.png' border=0></a>";
  }
  
  function colocarBoca($paciente) {
  
   $q = query("select * from piezasPaciente where paciente=$paciente");
   while($reg = fetch($q))
    {
     $pieza = $reg->pieza;
     $estado = $reg->estado;
     
     colocarDiente($pieza, $estado);
    }
  }
  
  function colocarDientesGenerales() {
  
   echo "<a href='#' onclick='clickDiente(777)' style='position: absolute; top: 104; left:120'>Superior</a>";
   echo "<a href='#' onclick='clickDiente(888)' style='position: absolute; top: 329; left:120'>Inferior</a>";
   echo "<a href='#' onclick='clickDiente(999)' style='position: absolute; top: 189; left:100'>Toda la Boca</a>";
  }
  
  conectar();
  
  echo "<form action='episodio2.php' method='submit'>";
  echo "<input type='hidden' name='paciente' value=$paciente>";
  
  colocarPaciente($paciente);
  colocarBoca($paciente);
  colocarDientesGenerales();
  colocarListaDientes();
  colocarListaProcedimientos();
  colocarBotonSiguiente();
  
  echo "</form>";
  desconectar();
?>
    </BODY>
</HTML>
