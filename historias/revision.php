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
var dientesNecesarios = 0;

var infoDientes = new Array();
var infoProc    = new Array();
var infoRXDiente = new Array();
var infoProcZona   = new Array();

//var paraHacer   = new Array();

document.onmousemove = mouseMove;
document.onmousedown = arrastrar;
document.onmouseup   = soltar;

function activarYdesactivarProcedimientosSegunPieza(unDiente) {

   var i=0, items;

     var diente=Number(unDiente);

     box = document.getElementById("procedimientos");
     items = box.options.length;

     for(i=0;i!=items;i++) {
        item = box.options[i];
        valor = box.options[i].value;

        item.disabled="";

        if(diente > 100) {
          if(infoProcZona[valor] != diente) 
             item.disabled="disabled";
        } else {
             if(infoProcZona[valor] >= 777)
                item.disabled="disabled";
          }
    }
}

function activarYdesactivarDientesPorProcedimiento(proced) {

   zona = infoProcZona[Number(proced)];

   if(zona==888) {
            desactivarDientes(11,28);
	    activarDientes(31,48);
   }
     else
       if(zona==777) {
             desactivarDientes(31,48);
             activarDientes(11,28);
        }
          else {
               activarDientes(11,48);
          }
}

function desactivarDientes(d1, d2) {

   var i;

     for(i=d1;i!=d2;i++)
          desactivarDiente(i);
}

function activarDientes(d1, d2) {

    var i;

    for(i=d1;i!=d2;i++)
         activarDiente(i);
}


function desactivarDiente(unDiente) {

  if(unDiente < 100) {
      xDiente = "diente"+unDiente;
      elDiente = document.getElementById(xDiente);

      estado = infoDientes[unDiente];
      if(elDiente) {
          elDiente.style.visibility='hidden';
     }
   }
}

function activarDiente(unDiente) {

   if(unDiente < 100) {
       xDiente = "diente"+unDiente;
       elDiente = document.getElementById(xDiente);

       estado = infoDientes[unDiente];
       if(elDiente) {
             elDiente.style.visibility='visible';
       }
   }
}

function cambiarMensaje(msg) {

    var lm = document.getElementById('lineaMensajes');

        lm.innerHTML=msg;
}

function repintarEstadosDiente(diente1) {

            pintarDiente(diente1);

}

function ponerRX(numeroDiente) {

 if(numeroDiente < 100) {
        xDiente = "diente"+numeroDiente;
	elDiente = document.getElementById(xDiente);

	x = elDiente.style.left;
	y = elDiente.style.top;

        img = new Image();
	img.src="../img/camera.png";

        document.images[xdiente]=img;
	alert(document.images[xdiente]);

        /* var textNode = document.createElement('img');
        textNode.src="../img/camera.png";
        textNode.setAttribute('width','14');
	textNode.setAttribute('left', x);
	textNode.setAttribute('top', y); */
	//window.addNode(textNode);
  }
}

function eliminarParaHacer(diente1, diente2, procedimiento) {
	
	//diagnostico = getProcedimiento();
	//estado = infoDientes[diente];
	//comentario = popComentarios();

    if(diente2 == 0)
       diente2 = diente1;
	ajax = nuevoAjax();
    
    ajax.open("POST", "../servicios/delParaHacer.php", true);
    ajax.onreadystatechange=function(){
    	
    	if(ajax.readyState==4) {
    	habilitarPantallaAjax("latapadora");
    	   resultado = ajax.responseText;
    	   //alert(resultado);

	   if(procedimiento==620) {
	         infoDientes[diente1]=3;
	   }  else
	        if(procedimiento==500)
	               infoRXDiente[diente1]=false;

	   repintarEstadosDiente(diente1);
    	}
    }
    inhabilitarPantallaAjax("latapadora");
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    ajax.send("pac="+paciente+"&diente="+diente1+"&dienteHasta="+diente2+"&proc="+procedimiento);
}

function agregarParaHacer(diente1, diente2, procedimiento, nombreProc, texto) {
	
	if(diente2 == 0)
       diente2 = diente1;
	diagnostico = getProcedimiento();
	estado = infoDientes[diente1];

	ajax = nuevoAjax();
    
    ajax.open("POST", "../servicios/addParaHacer.php", true);
    ajax.onreadystatechange=function(){
    	if(ajax.readyState==4) {
    		habilitarPantallaAjax("latapadora");
    	   resultado = ajax.responseText;
	   if(resultado=='ACK') {
               actualizarDiente(diente1);
	   } else
    	             alert("Avisar : "+resultado);
    	}
    }
    inhabilitarPantallaAjax("latapadora");
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    ajax.send("pac="+paciente+"&diente="+diente1+"&dienteHasta="+diente2+"&proc="+procedimiento+"&coment="+texto+"&usr="+usuario);
}

function actualizarDiente(diente) {

	diagnostico = getProcedimiento();
	estado = infoDientes[diente];
	comentario = popComentarios();

	extraccion = (infoDientes[diente]==0);
	recupero   = (infoDientes[diente]==3);

    if(extraccion || recupero)
        diagnostico = 0;

    if(diagnostico != 0 || extraccion || recupero) {
    
    	pintarDiente(diente);
	ajax = nuevoAjax();
    
    	ajax.open("POST", "../servicios/setDiagnosticoPieza.php", true);
    	ajax.onreadystatechange=function(){
 
    	if(ajax.readyState==4) {
    		habilitarPantallaAjax("latapadora");
    	   resultado = ajax.responseText;
    	   //alert(resultado);
    	 }
    	}
    	inhabilitarPantallaAjax("latapadora");
    	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        ajax.send("pac="+paciente+"&diente="+diente+"&est="+estado+"&diag="+diagnostico+"&coment="+comentario+"&usr="+usuario);

    } else
           alert("Error, no se ha elegido un diagnostico");
}

function guardarYseguir() {

   alert("Datos guardados en base de datos de simulacion");
   return(false);
}

function removeRowFromTable(indice, diente1, diente2, procedimiento) {
var tbl = document.getElementById('tablaHecho');
var lastRow = tbl.rows.length;
if (lastRow > 1) {
                     tbl.deleteRow(indice);
                     eliminarParaHacer(diente1, diente2, procedimiento);
  }
   else alert("No se puede borrar"); 
}

function addRowToTable(diente1, diente2, procedimiento, nombreProc, texto){  var tbl = document.getElementById('tablaHecho');  var lastRow = tbl.rows.length;  // if there's no header row in the table, then iteration = lastRow + 1  var iteration = lastRow;  var row = tbl.insertRow(lastRow);
  
    // Operacion  var cellLeft = row.insertCell(0);  var textNode = document.createElement('img');
  textNode.src="../img/trashcan_empty.png";
  textNode.setAttribute('width','14');
  textNode.ondblclick = function() { removeRowFromTable(iteration, diente1, diente2, procedimiento); }  cellLeft.appendChild(textNode);
    // Pieza1  var cellLeft = row.insertCell(1);  var textNode = document.createTextNode(diente1);  cellLeft.appendChild(textNode);

  // Pieza2  var cellLeft = row.insertCell(2);  var textNode = document.createTextNode(diente2);  cellLeft.appendChild(textNode);
  
  // Procedimiento  var cellLeft = row.insertCell(3);  var textNode = document.createTextNode(nombreProc);  cellLeft.appendChild(textNode);
  
   // Comentario  var cellLeft = row.insertCell(4);  var textNode = document.createTextNode(texto);  cellLeft.appendChild(textNode); 
  /*    // right cell  var cellRight = row.insertCell(1);  var el = document.createElement('input');  el.type = 'text';  el.name = 'txtRow' + iteration;  el.id = 'txtRow' + iteration;  el.size = 40;    el.onkeypress = keyPressTest;  cellRight.appendChild(el);    // select cell  var cellRightSel = row.insertCell(2);  var sel = document.createElement('select');  sel.name = 'selRow' + iteration;  sel.options[0] = new Option('text zero', 'value0');  sel.options[1] = new Option('text one', 'value1');  cellRightSel.appendChild(sel);
  */}


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

   if(procedimiento==620)
      {
	 infoDientes[diente1]=4;
	 repintarEstadosDiente(diente1);
      } else
            if(procedimiento==500) {
                  infoRXDiente[diente1]=true;
		  repintarEstadosDiente(diente1);
            }

   activarDientes(11,48);
   return(false);
}

 function clickDiente(diente, estado)
 {
  activarYdesactivarProcedimientosSegunPieza(diente);

  if(estado != 0 && dientesElegidos < 2) {
    var opt = document.createElement("option");
    lista = document.getElementById("lbDientes");
    
    opt.text=diente;
    opt.value=diente;
    lista.options.add(opt);

   ++dientesElegidos;
   
   cambiarMensaje("Elegida pieza "+diente);
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
       
    cambiarMensaje("Descartada pieza "+diente);
    ponerBotonAceptar();
 } 
 
  function cambiarProc() 
  {
     
     box = document.getElementById("procedimientos");
     proced = box.options.selectedIndex;
     //alert("Voy a activar por "+proced);
     activarYdesactivarDientesPorProcedimiento(proced); 
     ponerBotonAceptar();
     
  }
  
  function ponerBotonAceptar() {
  
      boton = document.getElementById("agregar");
      if(proced !=0 && dientesElegidos > 0) {
         boton.disabled = false;
         //cambiarColoresDientes();
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
       ancho=elDiente.width;
       if(infoRXDiente[numeroDiente]) {
          //ponerRX(numeroDiente);
	  elDiente.src= "../img/camara.png";
	  elDiente.width=ancho;
       }	
     }
  }
  
  function agregarInfoDiente(diente, info) {
  
    infoDientes[diente]=info;
   
   }
  
  function agregarInfoProcedimiento(unaIdProcedimiento, info, zona) {
 
     var uip = Number(unaIdProcedimiento);

      infoProc[uip]=info;
      infoProcZona[uip]=Number(zona); 

   }
      
  function tomarInfoDientes(diente) {
  
      return(infoDientes[diente]);
   }
   
  function tomarInfoProcedimiento(unaIdprocedimiento) {
  
      return(infoProcedimeintos[unaIdprocedimiento]);
  }
    
  function welcome() {
    
   dragging = false;
   dragObject = null;}

function mouseMove(ev){	ev           = ev || window.event;	var mousePos = mouseCoords(ev);
	
	if(dragging == true) {
	
        dragObject.style.position = 'absolute';		dragObject.style.top      = mousePos.y - mouseOffset.y;		dragObject.style.left     = mousePos.x - mouseOffset.x;
	} else
	      {
   	          mouseOffset = getMouseOffset(this, ev);
	          boton = document.getElementById("agregar");
	          if(mousePos.y < 240)
	              boton.style.top = mousePos.y - 10;
	      }
}

function arrastrar(ev){	ev           = ev || window.event;	var mousePos = mouseCoords(ev);
	
	if(dragging == false) {
	
	   if(dragObject!=null) {
  	      dragging = true;
  	      dragObject.focus();
  	   }
	}
}

function soltar(ev){	ev           = ev || window.event;	var mousePos = mouseCoords(ev);
	
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

function getPosition(e){	var left = 0;	var top  = 0;	while (e.offsetParent){		left += e.offsetLeft;		top  += e.offsetTop;		e     = e.offsetParent;	}	left += e.offsetLeft;	top  += e.offsetTop;	return {x:left, y:top};}

function getMouseOffset(target, ev){	ev = ev || window.event;	var docPos    = getPosition(target);	var mousePos  = mouseCoords(ev);	return {x:mousePos.x - docPos.x, y:mousePos.y - docPos.y};}
function mouseCoords(ev){	if(ev.pageX || ev.pageY){		return {x:ev.pageX, y:ev.pageY};	}	return {		x:ev.clientX + document.body.scrollLeft - document.body.clientLeft,		y:ev.clientY + document.body.scrollTop  - document.body.clientTop	};}

function makeDraggable(item){	if(!item) return;	item.onmousedown = function(ev){		dragObject  = this;
		mouseOffset = getMouseOffset(this, ev);
		if(dragging==false) {
			xOriginal = this.style.left;
			yOriginal = this.style.top;
		}		return false;	}}

function makeDropable(item){	if(!item) return;
	
	item.onmouseup = function(ev){		dropObject  = this;		mouseOffset = getMouseOffset(this, ev);
		alert(dropObject.id);		return false;	}}

function addDropTarget(dropTarget){	dropTargets.push(dropTarget);}


function buscoDondeDropie(xx, yy) {

    diente = 0;
    encontre = false;
    
    x = parseInt(xx);
    y = parseInt(yy);
    i = 0;
    
   while(i<dropTargets.length && !encontre){		var curTarget  = dropTargets[i];		var targPos    = getPosition(curTarget);		var targWidth  = parseInt(curTarget.offsetWidth);		var targHeight = parseInt(curTarget.offsetHeight);
				if(            (x >= targPos.x)                &&			(x <= (targPos.x + targWidth))  &&			(y >= targPos.y)                &&			(y <= (targPos.y + targHeight))) {				
				encontre = true;
		} else
		      i++;	}    
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

function colocarListaHecho($paciente) {

	  $dienteDesde=0;
	  $dienteHasta=0;
	  $piezaAnt=0;
	  $procAnt=0;
	  
      echo "<table id='tablaHecho' border=0 cellspacing=1 cellpadding=1 width=450px bgcolor='#cccccc' style='position:absolute; top:250px;left: 330px;font-size:11px;font:Arial'>\n";
      echo "<tr bgcolor='#ffffff'>";
      echo "<th>Op</th><th>Pieza</th><th>Pieza</th><th>Procedimiento</th><th>Comentario</th>";
      echo "</tr>";
      echo "</table>\n";

      echo "<script>";
          $q = "select Pieza, PiezaHasta, Procedimiento,Nombre, Comentario from ParaHacer,Procedimientos where Paciente=$paciente and Procedimientos.codigo=ParaHacer.Procedimiento order by Pieza, PiezaHasta, Procedimiento";
          $qry = query($q);
          while($reg = fetch($qry)) {
             	echo "addRowToTable($reg->Pieza, $reg->PiezaHasta, $reg->Procedimiento, '$reg->Nombre', '$reg->Comentario');\n";
             } 
             if($reg->Procedimiento==500)
	        		{
		  					echo "infoRXDiente[$reg->Pieza]=true;";
					}
     echo "</script>";

}

function ponerCuadroMensajes() {

    echo "<div id='lineaMensajes' STYLE='position: absolute; left:0; top:485'>";
    echo "";
    echo "</div>";
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

  function colocarListaProcedimientos() {
  
   echo "<SELECT id='procedimientos' SIZE=10 onChange='cambiarProc()' style='position: absolute; top:70px; left: 350px'>";
   echo "    <OPTION value='0' selected>Sin especificar</OPTION>\n";
   $q = query("select * from Procedimientos where Activo='S' order by Nombre");
   
   while($reg = fetch($q))
    {
          $Nombre=$reg->Nombre;
          $Codigo=$reg->Codigo;
          $nNombre=substr($Nombre, 0,55);
	  $zona = $reg->Zona;
          echo "<OPTION value='$Codigo'>$nNombre</OPTION>\n";
    }
    echo "</SELECT>";
    
    echo "<script>";
    $q = query("select * from Procedimientos where Activo='S' order by Nombre");
    
    while($reg = fetch($q))
    { 
          $proc = $reg->Codigo;
          $loDeja=$reg->loDeja;
          $zona=$reg->Zona; 
          echo "agregarInfoProcedimiento($proc, $loDeja, $zona);\n";
     }
         echo "</script>";
  }
  
  function colocarEditor() {
  
  echo "<TEXTAREA id='tbComentario' ROWS=3 COLS=40 style='position: absolute; top:0px; left: 400px'></TEXTAREA>";
  }
  
  function colocarListaDientes() {
  
  echo "<SELECT id='lbDientes' SIZE=3 STYLE='position: absolute; top: 0px; left: 350px' ondblclick='quitarDiente()'>";
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


        case 777: $x = 10;
        		  $y = 15;
                break;
                
        case 888: $x = 10;
        		  $y = 390;
                break;
                
        case 999: $x = 180;
        		  $y = 80;
                break;
     }
         //echo "<a href='#' onclick='#' style='position: absolute; top: $y; left:$x'>";
         
         $id = "diente$diente";
         echo "<img src='../img/piezas/$estado/$diente.png' border=0 id=$id  ondblclick='clickDiente($diente,  $estado)' style='position: absolute; top: $y; left:$x'>\n";
         //echo "</a>\n";
         echo "<script>";
         echo "agregarInfoDiente($diente, $estado);\n";
	 echo "pintarDiente($diente);\n";
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
  
  function colocarBocaTemporal($paciente) {
  
                     echo "<MAP NAME=\"MAP1\">";
                     echo "<AREA SHAPE=RECT COORDS=\"30,136,53,160\"   ondblclick='clickDiente(85, 3)'\">";
                     echo "<AREA SHAPE=RECT COORDS=\"40,165,57,187\"   ondblclick='clickDiente(84, 3)'\">";
                     echo "<AREA SHAPE=RECT COORDS=\"57,187,70,203\"   ondblclick='clickDiente(83, 3)'\">";
                     echo "<AREA SHAPE=RECT COORDS=\"70,198,82,213\"   ondblclick='clickDiente(82, 3)'\">";
                     echo "<AREA SHAPE=RECT COORDS=\"82,202,96,218\"   ondblclick='clickDiente(81, 3)'\">";
                     echo "<AREA SHAPE=RECT COORDS=\"96,200,110,218\"  ondblclick='clickDiente(71, 3)'\">";
                     echo "<AREA SHAPE=RECT COORDS=\"113,198,126,212\" ondblclick='clickDiente(72, 3)'\">";
                     echo "<AREA SHAPE=RECT COORDS=\"126,185,141,200\" ondblclick='clickDiente(73, 3)'\">";
                     echo "<AREA SHAPE=RECT COORDS=\"137,161,156,187\" ondblclick='clickDiente(74, 3)'\">";
                     echo "<AREA SHAPE=RECT COORDS=\"137,134,166,161\" ondblclick='clickDiente(75, 3)'\">";
                     echo "<AREA SHAPE=RECT COORDS=\"141,65,168,96\"   ondblclick='clickDiente(65, 3)'\">";
                     echo "<AREA SHAPE=RECT COORDS=\"139,52,160,65\"   ondblclick='clickDiente(64, 3)'\">";
                     echo "<AREA SHAPE=RECT COORDS=\"129,37,146,52\"   ondblclick='clickDiente(63, 3)'\">";
                     echo "<AREA SHAPE=RECT COORDS=\"116,23,133,37\"   ondblclick='clickDiente(62, 3)'\">";
                     echo "<AREA SHAPE=RECT COORDS=\"97,16,116,36\"    ondblclick='clickDiente(61, 3)'\">";
                     echo "<AREA SHAPE=RECT COORDS=\"80,16,97,36\"     ondblclick='clickDiente(51, 3)'\">";
                     echo "<AREA SHAPE=RECT COORDS=\"62,23,79,39\"     ondblclick='clickDiente(52, 3)'\">";
                     echo "<AREA SHAPE=RECT COORDS=\"50,37,66,52\"     ondblclick='clickDiente(53, 3)'\">";
                     echo "<AREA SHAPE=RECT COORDS=\"40,51,60,72\"     ondblclick='clickDiente(54, 3)'\">";
                     echo "<AREA SHAPE=RECT COORDS=\"29,72,60,100\"    ondblclick='clickDiente(55, 3)'\">";
                  
                  echo "</MAP>";
                  echo "<IMG SRC=\"../img/bocatemporal.jpg\" NAME=\"Imagen1\" ALIGN=LEFT WIDTH=196 HEIGHT=265 BORDER=0 USEMAP=\"#MAP1\" style='position: absolute; left: 60px; top: 110px'>";
  }
  
  function colocarDientesGenerales() {
  
#   echo "<a href='#' onclick='clickDiente(777)' style='position: absolute; top: 104; left:120'>Superior</a>";
#   echo "<a href='#' onclick='clickDiente(888)' style='position: absolute; top: 329; left:120'>Inferior</a>";
#   echo "<a href='#' onclick='clickDiente(999)' style='position: absolute; top: 189; left:100'>Toda la Boca</a>";

   echo "<div style='position: absolute; top: 0; left:10'>Superior</div>";
   echo "<div style='position: absolute; top: 425; left:10'>Inferior</div>";
   echo "<div style='position: absolute; top: 90; left:80'>Toda la Boca</div>";

   colocarDiente(999,3);
   colocarDiente(777,3);
   colocarDiente(888,3); 
  }
  
    function ponerUsuario($usr) {
  
      echo "<script>\n";
      echo "	usuario=$usr;\n";
      echo "</script>\n";
  }
  
  function colocarToolBar() {
  
    echo "<table border=0 style='position: absolute; top: 450; left:0' cellspacing=1 cellpadding=2 id='laToolBar'>";
    echo "<tr>";
//    echo "	<td width=48px valign=top align=center>";
//    echo "		<a href='#' id='eliminar' title='Marcar pieza para eliminar' style='display:block'><img src='../img/button_cancel.png' border=0></a>";
//    echo "	</td>";
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
    echo "		<a href='#' id='reparar' title='Marcar pieza como reparada' style='display:block'><img src='../img/add.png' border=0></a>";
    echo "	</td>";
    echo "</tr>";
    
    echo "<script>";
//         echo "addDropTarget(eliminar);";
         echo "addDropTarget(restaurar);";
         echo "addDropTarget(basura);";
         echo "addDropTarget(protesis);";
         echo "addDropTarget(reparar);";
    echo "</script>";
  }
  
  conectar();
  
//  echo "<form action='episodio.php' method='submit'>";
  echo "<input type='hidden' name='paciente' value=$paciente>";
  
  colocarBotonAgregar();
  colocarListaDientes();
  colocarPaciente($paciente);
  colocarListaHecho($paciente);
  colocarBocaTemporal($paciente);
  colocarBoca($paciente);
  colocarEditor();
  colocarListaProcedimientos();
  //colocarBotonAgregar();
  colocarDientesGenerales();
  //colocarBotonAceptar(); 
    colocarToolBar(); 
  ponerCuadroMensajes();
  ponerUsuario($usuario); 
  
  echo "<script>";
  echo "cambiarMensaje('Usuario: $usuario');\n";
  echo "</script>";
//  echo "</form>";
  desconectar();
?>
<div id='latapadora' style='position:absolute;top:0;left:0;width:100%;height:100%;visibility:hidden; background-image: url("../img/gris.gif"); background-repeat: repeat;'>
<img src='../img/Throbber-small.gif' style='position:absolute;top:150px;left:300px'>
</div>
    </BODY>
</HTML>
