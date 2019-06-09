function nuevoAjax(){	var xmlhttp=false; 	try { 		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP"); 	} catch (e) { 		try { 			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); 		} catch (E) { 			xmlhttp = false; 		}  	}	if (!xmlhttp && typeof XMLHttpRequest!='undefined') { 		xmlhttp = new XMLHttpRequest();	}	return xmlhttp;}

function inhabilitarPantallaAjax(ladiv) {
	
	obj = document.getElementById(ladiv);
	obj.top=0;
	obj.left=0;
	obj.style.height=document.body.clientHeight;
	
	obj.style.visibility="visible";
}

function habilitarPantallaAjax(ladiv) {
	
	obj = document.getElementById(ladiv);  
	obj.style.visibility="hidden";
}
