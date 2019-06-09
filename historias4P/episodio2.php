<HTML>
<HEAD>
	<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=iso-8859-1">
	
<script src='../ajax/kajax.js'></script>
<script language="JavaScript">
var proced = 0;
var paciente = 0;
var usuario = 0;
var dientesElegidos = 0;
var dragging;
var dragObject;
var yOriginal;
var xOriginal;
var dropObject;
var dropTargets = [];

var infoDientes = new Array();
var infoProc    = new Array();
var paraHacer   = new Array();

document.onmousemove = mouseMove;
document.onmousedown = arrastrar;
document.onmouseup   = soltar;

function elegirProcedimiento(diente1, diente2, procedimiento) {

    alert("ERROR #44 (fatal), la estructura de la tabla no coincide con la esperada, GRAVE, avisar: "+diente1+","+diente2+","+procedimiento);
}

function eliminarParaHacer(diente1, diente2, procedimiento) {
	
	
	diagnostico = getProcedimiento();
	estado = infoDientes[diente];
	comentario = popComentarios();

	ajax = nuevoAjax();
    
    ajax.open("POST", "../servicios/delParaHacer.php", true);
    ajax.onreadystatechange=function(){
    	if(ajax.readyState==4) {
    	   resultado = ajax.responseText;
    	   alert(resultado);
    	}
    }
    
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    ajax.send("pac="+paciente+"&diente="+diente1+"&proc="+procedimiento);
}

function agregarParaHacer(diente1, diente2, procedimiento, nombreProc, texto) {
	
	
	diagnostico = getProcedimiento();
	estado = infoDientes[diente];

	ajax = nuevoAjax();
    
    ajax.open("POST", "../servicios/addParaHacer.php", true);
    ajax.onreadystatechange=function(){
    	if(ajax.readyState==4) {
    	   resultado = ajax.responseText;
    	   alert(resultado);
    	}
    }
    
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    ajax.send("pac="+paciente+"&diente="+diente1+"&proc="+procedimiento+"&coment="+texto+"&usr="+usuario);
}

function actualizarDiente(diente) {

	diagnostico = getProcedimiento();
	estado = infoDientes[diente];
	comentario = popComentarios();

    if(diagnostico != 0) {
    
    	pintarDiente(diente);
		ajax = nuevoAjax();
    
    	ajax.open("POST", "../servicios/setDiagnosticoPieza.php", true);
    	ajax.onreadystatechange=function(){
    	if(ajax.readyState==4) {
    	   resultado = ajax.responseText;
    	  // alert(resultado);
    	 }
    	}
    	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        ajax.send("pac="+paciente+"&diente="+diente+"&estado="+estado+"&diag="+diagnostico+"&coment="+comentario+"&usr="+usuario);

    } else
           alert("Error, no se ha elegido un diagnostico");
}

function guardarYseguir() {

   alert("Datos guardados en base de datos de simulacion");
   return(false);
}

function removeRowFromTable(indice)
{
  var tbl = document.getElementById('tablaHecho');
  var lastRow = tbl.rows.length;
  if (lastRow > 1) tbl.deleteRow(indice);
}

function addRowToTable(diente1, diente2, procedimiento, nombreProc, texto)
{
  var tbl = document.getElementById('tablaHecho');
  var lastRow = tbl.rows.length;
  // if there's no header row in the table, then iteration = lastRow + 1
  var iteration = lastRow;
  var row = tbl.insertRow(lastRow);
  
    // Operacion
  /* var cellLeft = row.insertCell(0);
  var textNode = document.createElement('img');
  textNode.src="../img/trashcan_empty.png";
  textNode.setAttribute('width','14');
  textNode.ondblclick = function() { removeRowFromTable(iteration); }
  cellLeft.appendChild(textNode);
  */
  
  // Pieza1
  var cellLeft = row.insertCell(0);
  //var textNode = document.createTextNode(diente1);
  var nodoLink = document.createElement('a');
  nodoLink.innerHTML = "<a href='javascript:elegirProcedimiento("+diente1+","+diente2+","+procedimiento+")'>"+diente1+"</a>"; 
  cellLeft.appendChild(nodoLink);
  

  // Pieza2
  var cellLeft = row.insertCell(1);
  var textNode = document.createTextNode(diente2);
  cellLeft.appendChild(textNode);
  
  // Procedimiento
  var cellLeft = row.insertCell(2);
  var textNode = document.createTextNode(nombreProc);
  cellLeft.appendChild(textNode);
  
   // Comentario
  var cellLeft = row.insertCell(3);
  var textNode = document.createTextNode(texto);
  cellLeft.appendChild(textNode); 
  
/*  
  // right cell
  var cellRight = row.insertCell(1);
  var el = document.createElement('input');
  el.type = 'text';
  el.name = 'txtRow' + iteration;
  el.id = 'txtRow' + iteration;
  el.size = 40;
  
  el.onkeypress = keyPressTest;
  cellRight.appendChild(el);
  
  // select cell
  var cellRightSel = row.insertCell(2);
  var sel = document.createElement('select');
  sel.name = 'selRow' + iteration;
  sel.options[0] = new Option('text zero', 'value0');
  sel.options[1] = new Option('text one', 'value1');
  cellRightSel.appendChild(sel);
  */
}


function getProcedimiento() {

     a = 0;
     box = lista = document.getElementById("procedimientos");
     proced = box.options.selectedIndex;
    
    if(proced > 0 ) {
       a = box.options[proced].value;
    }

     return(a);
}

function getNombreProcedimiento() {

     a = 0;
     box = lista = document.getElementById("procedimientos");
     proced = box.options.selectedIndex;
    
    if(proced > 0 ) {
       a = box.options[proced].text;
    }

     return(a);
}

function popDiente() {
    
    if(dientesElegidos > 0 ) {
       a = lista.options[0].value;
       lista = document.getElementById("lbDientes");
       lista.remove(0);
       dientesElegidos--;
    }

    return(a);
}

function popComentarios() {
    
    txt = document.getElementById("tbComentario");
    a = txt.value;

    txt.value = "";
    return(a);
}

function agregarHecho() {

   diente1 = popDiente();
   diente2 = popDiente();

   procedimiento = getProcedimiento();
   nombreProcedimiento = getNombreProcedimiento();
   
   texto = popComentarios();
   
   agregarParaHacer(diente1, diente2, procedimiento, nombreProcedimiento, texto);
   addRowToTable(diente1, diente2, procedimiento, nombreProcedimiento, texto);
   
   ponerBotonAceptar();
   return(false);
}

 function clickDiente(diente, estado)
 {

  if(estado != 0 && dientesElegidos < 2) {
    var opt = document.createElement("option");
    lista = document.getElementById("lbDientes");
    
    opt.text=diente;
    opt.value=diente;
    lista.options.add(opt);

   ++dientesElegidos;
   
   ponerBotonAceptar();
   } else
       {
        if(estado != 0)
            msg="No es posible agregar mas piezas a la lista de trabajo";
        else
            msg="No es posible elegir una pieza ausente";
        alert(msg);
       }
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
  
      boton = document.getElementById("agregar");
      if(proced !=0 && dientesElegidos > 0) {
         boton.disabled = false;
         cambiarColoresDientes();
      }
      else
         boton.disabled = true;
  }
  
  function pasoSiguiente() {

      // ** prepara todo para<el submit **//
      return(true);
  }
  
  function cambiarColoresDientes() {


     var a, b, c;
     
     lista = document.getElementById("lbDientes");

     a = lista.options[0].value;
     if(dientesElegidos > 1)
        b = lista.options[1].value;
     else
        b = a;
     
     if(b < a) {
         c = a;
         a = b;
         b = c;
      }
      
      for(i = a; i <= b; i++)
        {
          xdiente = "diente"+i;
          pintarDiente(i);
        }
  }
  
  function pintarDiente(numeroDiente) {
  
     if(numeroDiente < 100) {
       xDiente = "diente"+numeroDiente;
       elDiente = document.getElementById(xDiente);
              
       estado = infoDientes[numeroDiente];
       elDiente.src= "../img/piezas/" + estado + "/" + numeroDiente + ".png";
     }
  }
  
  function agregarInfoDiente(diente, info) {
  
    infoDientes[diente]=info;
   
   }
  
  function agregarInfoProcedimiento(unaIdprocedimiento, info) {
  
    infoProc[unaIdprocedimiento]=info;
   
   }
      
  function tomarInfoDientes(diente) {
  
      return(infoDientes[diente]);
   }
   
  function tomarInfoProcedimiento(unaIdprocedimiento) {
  
      return(infoProcedimeintos[unaIdprocedimiento]);
  }
    
  function welcome() {
    
   dragging = false;
   dragObject = null;
}

function mouseMove(ev){
	ev           = ev || window.event;
	var mousePos = mouseCoords(ev);
	
	if(dragging == true) {
	
        dragObject.style.position = 'absolute';
		dragObject.style.top      = mousePos.y - mouseOffset.y;
		dragObject.style.left     = mousePos.x - mouseOffset.x;
	} else
	      {
   	          mouseOffset = getMouseOffset(this, ev);
	          //boton = document.getElementById("agregar");
	          //if(mousePos.y < 240)
	          //    boton.style.top = mousePos.y - 10;
	      }
}

function arrastrar(ev){
	ev           = ev || window.event;
	var mousePos = mouseCoords(ev);
	
	if(dragging == false) {
	
	   if(dragObject!=null) {
  	      dragging = true;
  	      dragObject.focus();
  	   }
	}
}

function soltar(ev){
	ev           = ev || window.event;
	var mousePos = mouseCoords(ev);
	
	if(dragging == true) {
	  
	  	x = mousePos.x;
	    y = mousePos.y;
	    target = buscoDondeDropie(x,y);
	    diente = dragObject.id.substring(6,8);
	    estado1 = tomarInfoDientes(diente);
	    
	    estado = 9999;
	    switch(target) {
	    
	         case "eliminar" :
	                          estado = 4;
	                          break;
	                          
             case "restaurar" :
	                          estado = 3;
	                          break;
	                          
             case "basura" :
	                          estado = 0;
	                          break;
	                          
             case "protesis" :
	                          estado = 1;
	                          break;
	                          
             case "reparar" :
	                          estado = 2;
	                          break;
	    }
	    
	    dragging = false;
	    
	    if(estado!=9999) {
	    	agregarInfoDiente(diente, estado);
	    	actualizarDiente(diente);
	    } else
	            estado=estado1;
		
	    dragObject.style.position = 'absolute';
	    dragObject.style.top  = yOriginal;
	    dragObject.style.left = xOriginal;
	    
	} else {
	
	    if(dragObject != null) {
    	     diente = dragObject.id.substring(6,8);
	         clickDiente(diente);
	    }
	  }
	dragObject = null;
}
	
function ponerCursor(tipodecursor) {

      document.body.style.cursor=tipodecursor;
}

function getPosition(e){
	var left = 0;
	var top  = 0;

	while (e.offsetParent){
		left += e.offsetLeft;
		top  += e.offsetTop;
		e     = e.offsetParent;
	}

	left += e.offsetLeft;
	top  += e.offsetTop;

	return {x:left, y:top};
}

function getMouseOffset(target, ev){
	ev = ev || window.event;

	var docPos    = getPosition(target);
	var mousePos  = mouseCoords(ev);
	return {x:mousePos.x - docPos.x, y:mousePos.y - docPos.y};
}

function mouseCoords(ev){
	if(ev.pageX || ev.pageY){
		return {x:ev.pageX, y:ev.pageY};
	}
	return {
		x:ev.clientX + document.body.scrollLeft - document.body.clientLeft,
		y:ev.clientY + document.body.scrollTop  - document.body.clientTop
	};
}

function makeDraggable(item){
	if(!item) return;
	item.onmousedown = function(ev){
		dragObject  = this;
		mouseOffset = getMouseOffset(this, ev);
		if(dragging==false) {
			xOriginal = this.style.left;
			yOriginal = this.style.top;
		}
		return false;
	}
}

function makeDropable(item){
	if(!item) return;
	
	item.onmouseup = function(ev){
		dropObject  = this;
		mouseOffset = getMouseOffset(this, ev);
		alert(dropObject.id);
		return false;
	}
}

function addDropTarget(dropTarget){
	dropTargets.push(dropTarget);
}


function buscoDondeDropie(xx, yy) {

    diente = 0;
    encontre = false;
    
    x = parseInt(xx);
    y = parseInt(yy);
    i = 0;
    
   while(i<dropTargets.length && !encontre){
		var curTarget  = dropTargets[i];
		var targPos    = getPosition(curTarget);
		var targWidth  = parseInt(curTarget.offsetWidth);
		var targHeight = parseInt(curTarget.offsetHeight);
		
		if(
            (x >= targPos.x)                &&
			(x <= (targPos.x + targWidth))  &&
			(y >= targPos.y)                &&
			(y <= (targPos.y + targHeight))) {
				
				encontre = true;
		} else
		      i++;
	}
    
    if(!encontre)
        idDelTarget = "";
    else
         idDelTarget = curTarget.id;    
           
    return(idDelTarget);
}
  
</script>
</HEAD>
<BODY onload="welcome()">
<?php

  include ("../functions/db.php");

function colocarListaParaHacer($paciente) {

      echo "<table id='tablaHecho' border=0 cellspacing=1 cellpadding=1 width=450px bgcolor='#cccccc' style='position:absolute; top:0px;left: 0px;font-size:11px;font:Arial'>\n";
      echo "<tr bgcolor='#ffffff'>";
      echo "<th>Pieza</th><th>Pieza</th><th>Procedimiento</th><th>Comentario</th>";
      echo "</tr>";
      echo "</table>";
      
      echo "<script>";
      $q = "select Pieza,Procedimiento,Nombre, Comentario from ParaHacer,Procedimientos where Paciente=$paciente and Procedimientos.codigo=ParaHacer.Procedimiento order by pieza";
      $qry = query($q);
      while($reg = fetch($qry)) {
      	echo "addRowToTable($reg->Pieza, $reg->Pieza, $reg->Procedimiento, '$reg->Nombre', '$reg->Comentario');\n";
      }
      echo "</script>";
}

function   colocarBotonAgregar() {

     echo "<input type='submit' id='agregar' value=' + ' style='position: absolute; top:200px; left: 750px' disabled onclick='return(agregarHecho())'>";
}

function   colocarBotonAceptar() {

     echo "<input type='submit' id='aceptar' value='Aceptar' style='position: absolute; top:460px; left: 268px' onclick='return(guardarYseguir())'>";
}

function colocarPaciente($paciente) {

/*   $q = query("select * from Pacientes where Cedula=$paciente order by Nombre");
   
   $reg = fetch($q);
   $cedula = $reg->Cedula;
   $nombre = $reg->Nombre;

   echo "<table border=0 style='position: absolute; top:0px; left: 350px'>";
   echo "<tr>";
   echo "   <td>$cedula</td><td><b>$nombre</b></td>";
   echo "</tr>";
   echo "</table>";
 */
   echo "<script>";
   echo "paciente=$paciente";
   echo "</script>";
}

  function colocarListaProcedimientos($proc) {
  
   echo "<SELECT id='procedimientos' SIZE=10 onChange='cambiarProc()' style='position: absolute; top:0px; left: 0px'>";
   echo "    <OPTION value='0' selected>Sin especificar</OPTION>\n";
   $q = query("select * from Procedimientos where Activo='S' order by Nombre");
   
   while($reg = fetch($q))
    {
          $Nombre=$reg->Nombre;
          $Codigo=$reg->Codigo;
          $nNombre=substr($Nombre, 0,55);
	  if($proc==$Codigo)
	     $sel = "selected";
	  else
	     $sel = "";
          echo "<OPTION value='$Codigo' $sel>$nNombre</OPTION>\n";
    }
    echo "</SELECT>";
    
    echo "<script>";
    $q = query("select * from TipoProc");
    
    while($reg = fetch($q))
    { 
          $proc = $reg->id;
          $estadoBases  = $reg->estadoBases;
          $estadoMedios = $reg->estadoMedios;
          echo "agregarInfoProcedimiento($proc, $estadoBases.$estadoMedios);\n";
    }
    echo "</script>";
  }
  
  function colocarEditor() {
  
  echo "<TEXTAREA id='tbComentario' ROWS=8 COLS=50 style='position: absolute; top:250px; left: 0px'></TEXTAREA>";
  }
  
  function colocarListaDientes() {
  
  echo "<SELECT id='lbDientes' SIZE=3 STYLE='position: absolute; top: 0px; left: 350px' ondblclick='quitarDiente()'>";
  echo "</select>";
  
   echo "<script>";
   echo "addDropTarget(lbDientes);";
   echo "</script>";
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
         //echo "<a href='#' onclick='#' style='position: absolute; top: $y; left:$x'>";
         
         $id = "diente$diente";
         
         // Correccion de posicion
         $ancho = 32;
         $y = $y + 0;
         $x = $x + 460;
         echo "<img src='../img/piezas/$estado/$diente.png' border=0 id=$id ondblclick='clickDiente($diente,  $estado)' style='position: absolute; top: $y; left:$x'>\n";
         //echo "</a>\n";
         
         echo "<script>";
         echo "agregarInfoDiente($diente, $estado);\n";
         echo "makeDraggable($id);\n";
         echo "</script>";
  }
  
  function colocarBoca($paciente) {
  
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
      
      colocarDiente($npieza, $estado);
   }
  
  }
  
  function colocarDientesGenerales() {
  
   echo "<a href='#' onclick='clickDiente(777)' style='position: absolute; top: 329; left:120'>Superior</a>";
   echo "<a href='#' onclick='clickDiente(888)' style='position: absolute; top: 104; left:120'>Inferior</a>";
   echo "<a href='#' onclick='clickDiente(999)' style='position: absolute; top: 189; left:100'>Toda la Boca</a>";
  }
  
  function colocarToolBar() {
  
    echo "<table border=0 style='position: absolute; top: 450; left:480' cellspacing=1 cellpadding=2 id='laToolBar'>";
    echo "<tr>";
    echo "	<td width=48px valign=top align=center>";
    echo "		<a href='#' id='eliminar' title='Marcar pieza para eliminar' style='display:block'><img src='../img/button_cancel.png' border=0></a>";
    echo "	</td>";
    echo "	<td width=48px valign=top align=center>";
    echo "		<a href='#' id='restaurar' title='Marcar pieza en buen estado' style='display:block'><img src='../img/bookmark.png' border=0></a>";
    echo "	</td>";
    echo "	<td width=48px valign=top align=center>";
    echo "		<a href='#' id='basura' title='Marcar pieza ausentes' style='display:block'><img src='../img/trashcan_empty.png' border=0></a>";
    echo "	</td>";
    echo "	<td width=48px valign=top align=center>";
    echo "		<a href='#' id='protesis' title='Marcar pieza como protesis' style='display:block'><img src='../img/undo.png' border=0></a>";
    echo "	</td>";
    echo "	<td width=48px valign=top align=center>";
    echo "		<a href='#' id='reparar' title='Marcar pieza como reparada vital' style='display:block'><img src='../img/add.png' border=0></a>";
    echo "	</td>";
    echo "</tr>";
    
    echo "<script>";
         echo "addDropTarget(eliminar);";
         echo "addDropTarget(restaurar);";
         echo "addDropTarget(basura);";
         echo "addDropTarget(protesis);";
         echo "addDropTarget(reparar);";
    echo "</script>";
  }
  
  conectar();
  
  echo "<form action='episodio2.php' method='submit'>";
  echo "<input type='hidden' name='paciente' value=$paciente>";
  
//  colocarBotonAgregar();
  colocarToolBar();
  colocarPaciente($paciente);
//  colocarListaDientes();
  colocarBoca($paciente);
  colocarEditor();
  colocarListaProcedimientos($procedimiento);
  //colocarBotonAgregar();
//  colocarListaParaHacer($paciente);
//  colocarDientesGenerales();
  //colocarBotonAceptar();  
  echo "</form>";
  desconectar();
?>
    </BODY>
</HTML>

