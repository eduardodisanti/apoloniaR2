/*
* Easy Grid
*
* @package easygrid
* @author $Author: sheiko $  
* @version $Id: controller.php, v 1.0 2006/10/31 15:58:15 sheiko Exp $ 
* @since v.1.0.1 
* @copyright (c) Dmitry Sheiko http://www.cmsdevelopment.com 
*/ 

var divName = 'TblBody'; 
var divTblLength = 'TblLength'; 
var RangeForm = 'RangeForm'; 
var PaginationForm = 'PaginationForm'; 
var ArrowToUp = '<img src="arr_top.gif" width="13" height="8" border="0" alt="Ascent Sorting">';
var ArrowToDown = '<img src="arr_bottom.gif" width="13" height="8" border="0" alt="Descent Sorting">';
var TblLength = 0;
var PaginationFrameHalfLength = 2;

var sUrl = "controller.php";

var columns = { counter: 0, settings: new Array() };
var filters = { counter: 0, settings: new Array() };

function settings(obj, json) {
	obj.settings[obj.counter++] = eval( '(' + json + ')' ); 
	
}



function gridPagination() {
	var Output = '';
	var Range = document.getElementById(RangeForm).limit.value - document.getElementById(RangeForm).offset.value;
	var Offset = document.getElementById(RangeForm).offset.value;
	var RangeFinish = Offset*1+Range*1;
	var PageNumber = 0;
	var Params = '';

	if(Offset>=Range) { 
		Params = Offset-Range; if(Params<0) Params=0;
		Output += '<a onclick="setGridRange('+(Params*1)+', '+(Params*1+Range)+');">&lt;</a>';
		
	}

	PageNumber = Math.ceil(TblLength/Range);
	if(Offset<1)
		CurrentPage = 0;
	else
		CurrentPage = Math.ceil(Offset/Range);	
	for(i=0; i<PageNumber;i++) {		
		if(i>=CurrentPage-PaginationFrameHalfLength && i<=CurrentPage+PaginationFrameHalfLength) {
			Output += '<a onclick="setGridRange('+(i*Range)+', '+(i*Range+Range)+');">'+i+'</a>';
		}
	}

	if((TblLength>Range && !RangeFinish) || TblLength>RangeFinish) {
		Output += '<a onclick="setGridRange('+(RangeFinish*1)+', '+(RangeFinish*1+Range)+');">&gt;</a>';
	}
	return Output;
}

function tableFieldList() {
	var output = '';
	for(i=0;i<columns.settings.length;i++) {
		output += columns.settings[i].field+',';
	}
	return output;
}

function tableHeaders() {
	var output = '<thead><tr>';
	for(i=0;i<columns.settings.length;i++) {
		output += '<th width="'+columns.settings[i].width+'" nowrap="nowrap"><table cellpadding="0" cellspacing="0" border="0"><tr><td>'+columns.settings[i].title+'</td><td><a onclick="sortTbl(\''+columns.settings[i].field+'\',\'asc\')">'+ArrowToUp+'</a><br /><a onclick="sortTbl(\''+columns.settings[i].field+'\',\'desc\')">'+ArrowToDown+'</a></td></tr></table></th>';
	}
	output += '</tr></thead>';
	return output;
}

function buildList(json) {
	var output = '';
	var res = '';
	
	var in_list = eval( '(' + json + ')' ); 
	
	TblLength = in_list.tlength;
	document.getElementById(divTblLength).innerHTML = in_list.tlength;
	document.getElementById(PaginationForm).innerHTML = gridPagination();
	
	
	for(i=0;i<in_list.value.length;i++) {
		output += '<tr id="id_'+i+'" oncontextmenu="return gridShowContextMenu(\'id_'+i+'\', event)">';
		for(j=0;j<in_list.columns.length;j++) {
			eval ( "res = in_list.value[i]."+in_list.columns[j]+";" );
			output += '<td>'+res+'</td>';
		}
		output += '</tr>';
	}
	if(output.length==0) return '<tr><td colspan="5" class="grid_indication"></td></tr>';
	return tableHeaders()+ "<tbody>" +output+ "</tbody>";
}

var handleSuccess = function(o){
	if(o.responseText !== undefined){
		document.getElementById(divName).innerHTML = '<table class="grid_table" cellspacing="0" cellpadding="0">' + buildList(o.responseText) + "</table>";
	}
};

var handleFailure = function(o){
	if(o.responseText !== undefined){
		document.getElementById(divName).innerHTML = '<div class="grid_indication">Server Error</div>';
	}
};

var callback =
{
  success:handleSuccess,
  failure:handleFailure,
  argument:['foo','bar']
};
function sortTbl(field,direction) {
	return makeRequest('orderby='+field+'&direction='+direction);
}
function setGridRange(offset, limit) {
	document.getElementById(RangeForm).offset.value = offset;
	document.getElementById(RangeForm).limit.value = limit;
	makeRequest('offset='+offset+'&limit='+limit);
}
function makeRequest(postData){
	if(postData.length!=0) postData += "&";
	postData += "fields="+tableFieldList();
	var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, callback, postData);
	
}