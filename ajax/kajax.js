function nuevoAjax(){

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