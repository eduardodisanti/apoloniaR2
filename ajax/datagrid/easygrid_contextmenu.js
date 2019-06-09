/*
* Easy Grid Context Menu
*
* @package easygrid
* @author $Author: sheiko $  
* @version $Id: controller.php, v 1.0 2006/10/31 15:58:15 sheiko Exp $ 
* @since v.1.0 
* @copyright (c) Dmitry Sheiko http://www.cmsdevelopment.com 
*/ 
var gridAcceptContextMenu=true;
var CurrentID; 

document.write('<div id="context_menu" class="context_menu">&nbsp;</div>');

function gridHideContextMenu(){
	var context_menu=document.getElementById('context_menu');
	context_menu.style.visibility="hidden";
	alert('Call editing widow for record #'+CurrentID);
	document.body.onmousedown=null;
}

function acceptRightClick() {
	gridAcceptContextMenu=true;
}

function gridShowContextMenu(id, even) {
	if (gridAcceptContextMenu) {
		CurrentID=id;
		gridAcceptContextMenu=false;
	
		context_menu.document.getElementById("context_menu");
		context_menu.innerHTML='<a href="#" onClick="return false;">View</a>';
		context_menu.innerHTML +='<a href="#" onClick="return false;">Modify</a>';
		
		document.body.onmousedown=gridHideContextMenu;
		
		var rightedge = document.body.clientWidth-event.clientX;
		var bottomedge = document.body.clientHeight-event.clientY;
		
		if (rightedge < context_menu.offsetWidth)
			context_menu.style.left = document.body.scrollLeft + event.clientX - context_menu.offsetWidth;
		else
			context_menu.style.left = document.body.scrollLeft + event.clientX;
		if (bottomedge < context_menu.offsetHeight)
			context_menu.style.top = document.body.scrollTop + event.clientY - context_menu.offsetHeight;
		else
			context_menu.style.top = document.body.scrollTop + event.clientY;
		context_menu.style.visibility = "visible";
		
		setTimeout("acceptRightClick()",100);
	}
	return false;
}