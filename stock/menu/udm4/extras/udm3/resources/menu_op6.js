//UDMv3.8.6
var maryl,aryl,jaryl,karyl;maryl=mI.length;for (var f=0;f<maryl;f++){if(typeof sP[f]=="undefined"){sP[f]=[mI[f][2],mI[f][3],mI[f][3],0,0,"","","","","","",""];}if(typeof cP[f]=="undefined"){cP[f]=new Array;}if(typeof sI[f]=="undefined"){sI[f]=new Array;}if(typeof cI[f]=="undefined"){cI[f]=new Array;}jaryl=sI[f].length;for (var sf=0;sf<jaryl;sf++){if(typeof cP[f][sf]=="undefined"){cP[f][sf]=new Array;}if(typeof cI[f][sf]=="undefined"){cI[f][sf]=new Array;}}}if(remoteTRIGGERING){staticMENU=false;}cellCLICK=true;if(saHOVER==""){saHOVER=saLINK;}if(aHOVER==""){aHOVER=aLINK;}var bh=baseHREF;var ttt='<table border=0 cellpadding=0 cellspacing=';var aL=absLEFT; var aT=absTOP;if(aT<0){aT=0;}if(aL<0){aL=0;}var shy=false;if ((typeof shSIZE)=="string"){shy=true;shSIZE=Number(shSIZE); }var bW=window.innerWidth; var bHe=window.innerHeight; if(documentWIDTH>0){bW=documentWIDTH;}var eS=0;var nS=0;for (var j=0;j<maryl;j++){if(mI[j][2]==""){mI[j][2]=10;}if(mI[j][1]==""){mI[j][1]='&nbsp;'; }nS+=mI[j][2]+bSIZE; }eS=bW-nS-bSIZE;var nH=fSIZE+5+vPADDING;if (fSIZE<13){nH+=(13-fSIZE);}var onH=nH;var thisT,splitT,thisH,Trows;var Mrows=new Array;var Nrows=new Array;var thisNH=new Array;var thisAH=new Array;for(var i=0;i<maryl;i++){thisT=mI[i][1];splitT=thisT.split('<br>');Mrows[i]=splitT.length;Nrows[i]=Mrows[i];}function cFun(a,b){return b-a;}Mrows.sort(cFun);nH=nH*Mrows[0];var aH=nH+(bSIZE*2); var snH=sfSIZE+5+svPADDING;if (sfSIZE<13){snH+=(13-sfSIZE);}var asH=snH+(sbSIZE*2); for(i=0;i<maryl;i++){thisNH[i]=nH;if(menuALIGN=="free"){thisNH[i]=onH*Nrows[i];}thisAH[i]=nH+(bSIZE*2);if(menuALIGN=="free"){thisAH[i]=thisNH[i]+(2*bSIZE);}}var free=false;var xp=0;var aP=new Array;var aPL=new Array;if(menuALIGN=="free"){free=true;for (var xc=0;xc<maryl;xc++){aP[xc]=mI[xc][6]+aT;aPL[xc]=mI[xc][7]+aL;}}else{aP[xp]=aT;}var stAdjust=0; var abR; var rL; var ralign=false;if(menuALIGN=="right"){ralign=true;abR=aL; aL=eS-abR;rL=aL;if(rL<0){rL=0;}aL=0;}var calign=false;if(menuALIGN=="center"){calign=true;aL=parseInt(eS/2);rL=aL;if(rL<0){rL=0;}aL=0;}var lalign=false;if(menuALIGN=="left"){lalign=true;abR=aL;rL=aL; if((op5||stretchMENU)&&abR>0){stAdjust=abR+(2*bSIZE);}if(rL<0){rL=0;}if(stretchMENU){aL=0;}}var subLEFT=rL;if(ralign){subLEFT-=abR;}if(lalign){subLEFT+=abR;}var ntl=0;for (var intl=0;intl<maryl;intl++){if(mI[intl][1]!=""){ntl++;}}function doNothing(){}var back_defs=[mCOLOR,bCOLOR,rCOLOR,smCOLOR,sbCOLOR,srCOLOR];var useIMG=[false,false,false,false,false,false];var bks=new Array;for (var b=0;b<6;b++){bks[b]='bgcolor='+back_defs[b];if((back_defs[b].indexOf('.gif') != -1) || (back_defs[b].indexOf('.jpg') != -1) || back_defs[b]==''){useIMG[b]=true;}if(useIMG[b]){bks[b]='background="'+bh + back_defs[b]+'"'; }if(back_defs[b]==''){bks[b]='';}}var oks=new Array;var ocks=new Array;for(i=0;i<maryl;i++){oks[i]=[bks[0],bks[1],bks[2],bks[3],bks[4],bks[5]];if(mI[i][9]!=""){oks[i][0]='bgcolor='+mI[i][9];}if(mI[i][10]!=""){oks[i][2]='bgcolor='+mI[i][10];}oks[i][12]=aLINK;oks[i][13]=aHOVER;if(mI[i][11]!=""){oks[i][12]=mI[i][11];}if(mI[i][12]!=""){oks[i][13]=mI[i][12];}if(sP[i][6]!=""){oks[i][3]='bgcolor='+sP[i][6]; }if(sP[i][7]!=""){oks[i][5]='bgcolor='+sP[i][7];}if(sP[i][8]!=""){oks[i][4]='bgcolor='+sP[i][8];}if(sP[i][9]!=""){oks[i][6]='bgcolor='+sP[i][9];}oks[i][7]=saLINK;oks[i][8]=saHOVER;if(sP[i][10]!=""){oks[i][7]=sP[i][10];}if(sP[i][11]!=""){oks[i][8]=sP[i][11];}oks[i][9]=shCOLOR;ocks[i]=new Array;aryl=sI[i].length;if(aryl>0){for(j=0;j<aryl;j++){ocks[i][j]=[bks[0],bks[1],bks[2],bks[3],bks[4],bks[5]];if(cI[i][j].length>0){if(cP[i][j][6]!=""){ocks[i][j][3]='bgcolor='+cP[i][j][6]; }if(cP[i][j][7]!=""){ocks[i][j][5]='bgcolor='+cP[i][j][7];}if(cP[i][j][8]!=""){ocks[i][j][4]='bgcolor='+cP[i][j][8];}if(cP[i][j][9]!=""){ocks[i][j][6]='bgcolor='+cP[i][j][9];}ocks[i][j][7]=saLINK;ocks[i][j][8]=saHOVER;if(cP[i][j][10]!=""){ocks[i][j][7]=cP[i][j][10];}if(cP[i][j][11]!=""){ocks[i][j][8]=cP[i][j][11];}ocks[i][j][9]=shCOLOR;}}}}var oR=new Array;var ltPos,rtPos;var obGrid=new Object();for (var obr=0;obr<17;obr++){oR[obr]=new Array;}function storeObjects(){obGrid=document.getElementById("grid"); for (var sob=0;sob<maryl;sob++){oR[0][sob]=d.getElementById('roll'+sob);oR[1][sob]=d.getElementById('subnav'+sob);oR[2][sob]=d.getElementById('sublinks'+sob);if((vOFFSET+sP[sob][3])>0){oR[3][sob]=d.getElementById('gridblocker'+sob);}if(d.getElementById('gridLblocker'+sob)){oR[12][sob]=d.getElementById('gridLblocker'+sob);}if(shCOLOR!=""){oR[4][sob]=d.getElementById('shadow'+sob);}for (var sobr=5;sobr<17;sobr++){oR[sobr][sob]=new Array;}aryl=sI[sob].length;for (var soj=0;soj<aryl;soj++){oR[5][sob][soj]=d.getElementById('subroll'+sob+'-'+soj);oR[13][sob][soj]=d.getElementById('sublink'+sob+'-'+soj);oR[14][sob][soj]=d.getElementById('srolllink'+sob+'-'+soj);ltPos=oR[13][sob][soj].offsetTop;rtPos=oR[14][sob][soj].offsetTop;oR[14][sob][soj].style.top=0-(rtPos-ltPos);if(cP[sob][soj]){if(cP[sob][soj].length>0){oR[6][sob][soj]=d.getElementById('subroll'+sob+'-'+soj);if(shCOLOR!=""){oR[7][sob][soj]=d.getElementById('childshadow'+sob+'-'+soj);}if((chhOFFSET+cP[sob][soj][4])>0){oR[8][sob][soj]=d.getElementById('childgrid'+sob+'-'+soj);}oR[9][sob][soj]=d.getElementById('childnav'+sob+'-'+soj);oR[10][sob][soj]=d.getElementById('childlinks'+sob+'-'+soj);oR[11][sob][soj]=new Array;oR[15][sob][soj]=new Array;oR[16][sob][soj]=new Array;jaryl=cI[sob][soj].length;for (var scj=0;scj<jaryl;scj++){oR[11][sob][soj][scj]=d.getElementById('childroll'+sob+'-'+soj+'-'+scj);oR[15][sob][soj][scj]=d.getElementById('childlink'+sob+'-'+soj+'-'+scj);oR[16][sob][soj][scj]=d.getElementById('crolllink'+sob+'-'+soj+'-'+scj);ltPos=oR[15][sob][soj][scj].offsetTop;rtPos=oR[16][sob][soj][scj].offsetTop;oR[16][sob][soj][scj].style.top=0-(rtPos-ltPos);}}}}}genericOnloadFunction();}function miH(hr){if(hr&&hr.style){hr.style.visibility="hidden";}}function miV(hv){if(hv&&hv.style){hv.style.visibility="visible";}}var pId=-1;var pCId=-1;var rTimer=0;var rCount=0;var cjc;function aCM(n){if(pId>-1){if(rTimer!=0){clearTimeout(rTimer); rTimer=0; rCount=0;}if(typeof oR[0][pId] !="undefined"){miH(oR[0][pId]);}if(typeof oR[3][pId] !="undefined"){miH(oR[3][pId]);}if(typeof oR[12][pId] !="undefined"){miH(oR[12][pId]);}if(typeof oR[1][pId] !="undefined"){miH(oR[1][pId]);}if(typeof oR[2][pId] !="undefined"){miH(oR[2][pId]);}if(typeof oR[4][pId] !="undefined"){miH(oR[4][pId]);}if(pCId>-1){if(typeof oR[5][pId][pCId]!="undefined"){miH(oR[5][pId][pCId]);}if(cP[pId][pCId]){if(cP[pId][pCId].length>0){aryl=cI[pId][pCId].length;for (cjc=0;cjc<aryl;cjc++){if(typeof oR[11][pId][pCId][cj]!="undefined"){miH(oR[11][pId][pCId][cj]);}if(typeof oR[15][pId][pCId][cj]!="undefined"){miH(oR[15][pId][pCId][cj]);}if(typeof oR[16][pId][pCId][cj]!="undefined"){miH(oR[16][pId][pCId][cj]);}}if(typeof oR[10][pId][pCId]!="undefined"){miH(oR[10][pId][pCId]);}if(typeof oR[9][pId][pCId]!="undefined"){miH(oR[9][pId][pCId]);}if(typeof oR[8][pId][pCId]!="undefined"){miH(oR[8][pId][pCId]);}if(typeof oR[7][pId][pCId]!="undefined"){miH(oR[7][pId][pCId]);}}}}if(typeof obGrid!="undefined"){miH(obGrid);}}pId=-1; pCId=-1;usegrid=false;}function cM(n){var nsNum=n;if(pCId==-1&&!usegrid){aCM(nsNum); }else{if(rCount==0){rCount++;rTimer=setTimeout("cM(pId)",closeTIMER);}else{aCM(nsNum); if(typeof menuClosingFunction=="function") { menuClosingFunction(); }pId=-1;pCId=-1;}}}var usegrid=false;function gridClearMenus(){usegrid=true;cM();}var n;var gridOkay=false;function oM(n,gridTrue){if(typeof mI[n]=="undefined"){return false;}if(typeof oR[0][n]!="undefined"){miV(oR[0][n]);}if(sI[n]!=""){if(sI[n]!=''){if(typeof oR[4][n]!="undefined"&&sI[n].length>0){miV(oR[4][n]);}}if(typeof oR[1][n]!="undefined"){miV(oR[1][n]);}if(typeof oR[2][n]!="undefined"){miV(oR[2][n]);}if(typeof oR[3][n]!="undefined"){miV(oR[3][n]);}if(typeof oR[12][n]!="undefined"){miV(oR[12][n]);}if(pCId>-1){miH(oR[5][n][pCId]); }}if(typeof obGrid!="undefined"){if(typeof gridTrue=="undefined"){miV(obGrid);}else{aCM(n);}}pId=n;}function cCM(snum,cnum){if(pCId>-1){if(typeof oR[5][snum][pCId]!="undefined"){miH(oR[5][snum][pCId]);}if(cP[snum][pCId].length>0&&cI[snum][pCId].length>0){if(typeof oR[9][snum][pCId]!="undefined"){miH(oR[9][snum][pCId]);}if(typeof oR[10][snum][pCId]!="undefined"){miH(oR[10][snum][pCId]);}if(typeof oR[7][snum][pCId]!="undefined"){miH(oR[7][snum][pCId]);}if(typeof oR[8][snum][pCId]!="undefined"){miH(oR[8][snum][pCId]);}}pCId=-1;}}var shPos=shSIZE;if(shy){shPos=0-shSIZE;}var cmStyle,cmLeft,cmTop;function actuallyOpenChild(snum,cnum){miV(oR[7][snum][cnum]); miV(oR[9][snum][cnum]);miV(oR[10][snum][cnum]);if(remoteTRIGGERING){cmStyle=oR[5][snum][cnum].style;cmTop=parseInt(cmStyle.top)-sbSIZE+chvOFFSET+cP[snum][cnum][3];if(!rba){if((cmTop+oR[9][snum][cnum].offsetHeight+shSIZE)>(bHe+scaroTop)){cmTop-=((cmTop+oR[9][snum][cnum].offsetHeight+shSIZE)-(bHe+scaroTop)); }}oR[7][snum][cnum].style.top=(cmTop+shPos)+"px";oR[9][snum][cnum].style.top=cmTop+"px";oR[10][snum][cnum].style.top=cmTop+"px";if(oR[8][snum][cnum]){oR[8][snum][cnum].style.top=cmTop+"px";}if(cP[snum][cnum][1]=="left"){cmLeft=(parseInt(cmStyle.left)+oR[5][snum][cnum].offsetWidth+sbSIZE)+chhOFFSET+cP[snum][cnum][4];if(oR[8][snum][cnum]){oR[8][snum][cnum].style.left=(cmLeft-chhOFFSET-cP[snum][cnum][4])+"px";}}else{cmLeft=(parseInt(cmStyle.left)-oR[9][snum][cnum].offsetWidth-sbSIZE)-chhOFFSET-cP[snum][cnum][4];if(oR[8][snum][cnum]){oR[8][snum][cnum].style.left=(cmLeft+oR[9][snum][cnum].offsetWidth)+"px";}}oR[7][snum][cnum].style.left=(cmLeft+shPos)+"px";oR[9][snum][cnum].style.left=cmLeft+"px";oR[10][snum][cnum].style.left=cmLeft+"px";karyl=cI[snum][cnum].length;for(i=0;i<karyl;i++){oR[11][snum][cnum][i].style.left=(parseInt(oR[9][snum][cnum].style.left)+sbSIZE)+"px";oR[11][snum][cnum][i].style.top=(parseInt(oR[9][snum][cnum].style.top+(remChildTop[snum][cnum][i]))+((i+1)*sbSIZE))+"px";}}if((chhOFFSET+cP[snum][cnum][4])>0){miV(oR[8][snum][cnum]);}}var snum; var cnum;function oCM(snum,cnum){miV(obGrid);var ntS=snum; var ntC=cnum;if(sI[snum][cnum][4]){miV(oR[5][snum][cnum]);}if(cP[snum][cnum].length>0&&cI[snum][cnum].length>0){actuallyOpenChild(ntS,ntC);}pCId=cnum;}var linkClicked=false;function goToUrl(cUrl,cTarg){if(cellCLICK||(cellCLICK==mu)){if(linkClicked==true){return false;}if(cTarg=="_self"){self.document.location=cUrl; return true;}else if(cTarg=="_top"){top.document.location=cUrl; return true;}else if(cTarg=="_parent"){parent.document.location=cUrl; return true;}else if(cTarg=="_blank"){var newwin=open(cUrl); return true;}else{if(top[cTarg]){top[cTarg].document.location=cUrl;}else{document.location=cUrl;}return true;}}else{return false;}}var mnDisplay='';if(remoteTRIGGERING){mnDisplay='display:none';}var T='';var S='';var spbk='';if(bCOLOR!=""){spbk=' background:'+bCOLOR+'\; ';if(useIMG[1]){spbk=' background-image:url('+ bh + bCOLOR+')\; ';}}var stbSize=bSIZE;if(stretchMENU||showBORDERS){S+='<span class="printhide" id="stretchnav" ';var spbb='';if(showBORDERS){spbb=spbk;}else{stbSize=0;}S+='style="'+mnDisplay+'\;'+spbb+' z-index:'+(zORDER+1)+'\; position:absolute\; top:'+aP[xp]+'\; left:0\;">'; var stretchLayer='';if(stretchMENU){stretchLayer=bks[0];}aH-=bSIZE;S+='<table cellpadding=0 cellspacing='+stbSize+' border=0 width='+bW+'  height='+aH+'><tr><td '+stretchLayer+' onmouseover="gridClearMenus()" onmousedown="aCM()">&nbsp;</td></tr></table>';S+='</span>';}var GRw=bW;if(gridWIDTH>0){GRw=gridWIDTH;}var GRh=bHe;if(gridHEIGHT>0){GRh=gridHEIGHT;}var GRbc="";if(redGRID){GRbc="background-color:red";}T+='<span id="grid" style="'+GRbc+'\;visibility:hidden\; position:absolute\; top:0\; left:0\; width:'+GRw+'\; height:'+GRh+'\; z-index:'+zORDER+'" onmousedown="aCM()" onmouseover="gridClearMenus()"></span>';if(!free){T+='<span class="printhide" id="mainnav" style="'+mnDisplay+'\;'+spbk+' z-index:'+(zORDER+2)+'\; position:absolute\; top:'+aP[xp]+'px\; left:'+rL+'px\;"><table cellpadding=0 cellspacing='+bSIZE+' border=0><tr>';  }var cSt=new Array;var cTd=new Array;var space=new Array;var aTxt=new Array;var sTxt=new Array;var cTxt=new Array;var altNull='';function writeStatus(sTxt){window.status=sTxt; return true;}cSt=new Array;var linkHover='';for (i=0;i<maryl;i++){aTxt[i]='';if(mI[i][5]!="none"){if(altDISPLAY=="title"){aTxt[i]=' title="'+mI[i][5]+'" ';}if(altDISPLAY=="status"){aTxt[i]=' onmouseover="return writeStatus(mI['+i+'][5])" onmouseout="return writeStatus(altNull)" ';}}space[i]=' left:0px\;';if(mI[i][3]=="left"){space[i]=' left:'+tINDENT+'px\;';}if(mI[i][3]=="right"){space[i]=' left:-'+tINDENT+'px\;';}if(mI[i][1]!=""){if(mI[i][0]==""){mI[i][0]="javascript:doNothing()"; }if(free){T+='<span class="printhide" style="'+cSt[i]+'\; '+spbk+' z-index:'+(zORDER+2)+'\; position:absolute\; top:'+aP[i]+'px\; left:'+aPL[i]+'px\;"><table cellpadding=0 cellspacing='+bSIZE+' border=0><tr>';}var op6a=1;var op6b=-1;T+='<td onmouseover="aCM()\; oM('+i+')" class=mTD height='+thisNH[i]+' '+oks[i][0]+' width="'+(mI[i][2])+'"><table cellpadding=0 cellspacing=0 border=0 width="'+(mI[i][2])+'" height="'+thisNH[i]+'"><tr><td align="'+mI[i][3]+'" onclick="goToUrl(mI['+i+'][0],mI['+i+'][4])" '+aTxt[i]+'><a href="'+mI[i][0]+'" target="'+mI[i][4]+'" onmouseover="if(op6){linkClicked=true;}" onmouseout="if(op6){linkClicked=false;}" onclick="return true" style="background-color:transparent\;position:relative\; top:'+(vtOFFSET+op6b)+'\; '+space[i]+'"><font color="'+oks[i][12]+'">'+mI[i][1]+'</font></a></td></tr></table></td>'; if(free){T+='</tr></table></span>';}}}if(!free){T+='</tr></table></span>';}var layLeft=rL+bSIZE;for (i=0;i<maryl;i++){if(free){layLeft=mI[i][7]+bSIZE+aL; xp=i;}T+='<span class="printhide" id="roll'+i+'" style="'+mnDisplay+'\;'+cTd[i]+'\; position:absolute\; top:'+(aP[xp]+bSIZE)+'\; left:'+layLeft+'\; z-index:'+(zORDER+3)+'\; visibility:hidden\;" onmouseout="if(!keepLIT){miH(this)}"><table cellpadding=0 cellspacing=0 border=0 '+oks[i][2]+' onmouseover="oM('+i+')"><tr><td style="width:'+(mI[i][2])+'\; height:'+thisNH[i]+'\;" align="'+mI[i][3]+'" class=mTD onclick="goToUrl(mI['+i+'][0],mI['+i+'][4])" '+aTxt[i]+'><a href="'+mI[i][0]+'" target="'+mI[i][4]+'" onmouseover="if(op6){linkClicked=true;}" onmouseout="if(op6){linkClicked=false;}" onclick="return true" style="'+cSt[i]+'\; background-color:transparent\;position:relative\; top:'+(vtOFFSET+op6b)+'\; '+space[i]+'"><font color="'+oks[i][13]+'">'+mI[i][1]+'</font></a></td></tr></table></span>';if(!free){layLeft+=(mI[i][2]+bSIZE);}}var cupObj;function clearChildRoll(bucM,bucS,bucObj){aryl=cI[bucM][bucS].length;for(cj=0;cj<aryl;cj++){cupObj=document.getElementById('childroll'+bucM+'-'+bucS+'-'+cj);if(cupObj!=bucObj){miH(cupObj);}}}var M='';var C='';var SUBaL=0;var chTop=new Array;var Xrows=new Array;var XCrows=new Array;var thatH;var remSubTop=new Array;var remChildTop=new Array;var thisLink;for (var c=0;c<maryl;c++){Xrows[c]=0;XCrows[c]=new Array;sTxt[c]=new Array;cTxt[c]=new Array;remSubTop[c]=new Array;remChildTop[c]=new Array;if(free){xp=c;}var mzSubAbsTop=sbSIZE;chTop[c]=new Array;chTop[c][0]=aP[xp]+thisAH[c]+vOFFSET+sP[c][3];space=' left:0px\;';if(sP[c][2]=="left"){space=' left:'+stINDENT+'px\;';}if(sP[c][2]=="right"){space=' left:-'+stINDENT+'px\;';}if(!free){if(c==0){SUBaL=rL+bSIZE;}else{SUBaL+=mI[(c-1)][2]+bSIZE;}}else{SUBaL=aPL[c];}var acL=SUBaL+hOFFSET+sP[c][4];if(sP[c][1]=="right"){acL=SUBaL-(sP[c][0]-mI[c][2])-hOFFSET-sP[c][4];}if((vOFFSET+sP[c][3])>0){M+='<div id="gridblocker'+c+'" style="width:'+sP[c][0]+'px\; height:'+(vOFFSET+sP[c][3])+'\; visibility:hidden\; z-index:'+(zORDER+1)+'\;position:absolute\; top:'+(aP[xp]+thisAH[c])+'px\; left:'+acL+'px\;" onmouseover="if(rTimer!=0){clearTimeout(rTimer)\;rCount=0\;}"></div>';}var gblw=acL-mI[c][2]-SUBaL;var gbposL=(SUBaL+mI[c][2]+(2*bSIZE));if(sP[c][1]=="right"){gblw=mI[c][7]+bSIZE+aL-sP[c][0]-acL; gbposL=(mI[c][7]+bSIZE+aL-gblw);}aryl=sI[c].length;for (i=0;i<aryl;i++){if(sI[c][i][0]!=''&&sI[c][i][1]!=''){thisH=snH;thisT=sI[c][i][1];splitT=thisT.split('<br>');Trows=splitT.length;if (Trows>1){Xrows[c]+=(Trows-1);}}}var shb=0;if(shy){shb=(2*shSIZE);}if(gblw>0){M+='<div id="gridLblocker'+c+'" style="width:'+gblw+'px\; height:'+(((snH+sbSIZE)*aryl)+((snH)*Xrows[c])+sbSIZE+shb+shSIZE)+'px\; visibility:hidden\; z-index:'+(zORDER+1)+'\;position:absolute\; top:'+(aP[xp]+thisAH[c]+vOFFSET+sP[c][3])+'px\; left:'+gbposL+'px\;" onmouseover="if(rTimer!=0){clearTimeout(rTimer)\;rCount=0\;}"></div>';}var subParent;M+='<span class="printhide" id="subnav'+c+'" style="visibility:hidden\; z-index:'+(zORDER+4)+'\; position:absolute\; top:'+(aP[xp]+thisAH[c]+vOFFSET+sP[c][3])+'px\; left:'+acL+'px\;"><table cellpadding=0 cellspacing=0 width="'+sP[c][0]+'" border=0 '+oks[c][4]+'>';for (i=0;i<aryl;i++){if(sI[c][i][0]!=''&&sI[c][i][1]!=''){subParent='subnav'+c;thatH=thisH;thisH=snH;thisT=sI[c][i][1];splitT=thisT.split('<br>');Trows=splitT.length;if (Trows>1){thisH=(snH*Trows);}if(i==0){remSubTop[c][i]=0;}else{remSubTop[c][i]=thatH+remSubTop[c][(i-1)];}M+='<tr><td class=SUBmTD><table cellpadding=0 cellspacing=0 border=0 '+oks[c][3]+' style="position:relative\; margin-top:'+sbSIZE+'\; margin-left:'+sbSIZE+'\; margin-right:'+sbSIZE+'\; height:'+(thisH)+'\;" width="'+(sP[c][0]-(sbSIZE*2))+'"><tr><td class=SUBmTD align="'+sP[c][2]+'"><table cellpadding=0 cellspacing=0 border=0 width="'+(sP[c][0]-(sbSIZE*2))+'" height='+(thisH)+'><tr><td class=SUBmTD align="'+sP[c][2]+'">&nbsp;</td></tr></table></td></tr></table></td></tr>';}}M+='<tr><td><div style="width:2px\; height:'+sbSIZE+'px\;"></div></td></tr>';M+='</table></span>';M+='<span class="printhide" id="sublinks'+c+'" style="visibility:hidden\; z-index:'+(zORDER+5)+'\; position:absolute\; top:'+(aP[xp]+thisAH[c]+vOFFSET+sP[c][3])+'px\; left:'+acL+'px\;"><table cellpadding=0 cellspacing=0 width="'+sP[c][0]+'" border=0>'; var scSt=new Array;var scTd=new Array;for (i=0;i<aryl;i++){cTxt[c][i]=new Array;sTxt[c][i]='';if(sI[c][i][3]!="none"){if(altDISPLAY=="title"){sTxt[c][i]=' title="'+sI[c][i][3]+'" ';}if(altDISPLAY=="status"){sTxt[c][i]=' onmouseover="return writeStatus(sI['+c+']['+i+'][3])" onmouseout="return writeStatus(altNull)" ';}}if(sI[c][i][0]=="#"){sI[c][i][0]="javascript:doNothing()"; }subParent='subnav'+c;thisH=snH;thisT=sI[c][i][1];splitT=thisT.split('<br>');Trows=splitT.length;if (Trows>1){thisH=(snH*Trows);}chTop[c][i+1]=chTop[c][i]+thisH+sbSIZE;thisLink=' href="'+sI[c][i][0]+'"';if(sI[c][i][0]=="javascript:doNothing()") { thisLink=''; }M+='<tr><td><table border=0 cellpadding=0 cellspacing=0 style="position:relative\; top:'+mzSubAbsTop+'\; margin-top:0\; margin-left:'+sbSIZE+'\; margin-right:'+sbSIZE+'\; " onmouseover="if(rTimer!=0){clearTimeout(rTimer)\;rCount=0\;}cCM('+c+','+i+')\; oCM('+c+','+i+')\;"><tr><td class=SUBmTD align="'+sP[c][2]+'" width="'+(sP[c][0]-(sbSIZE*2))+'" height='+(thisH)+' onclick="goToUrl(sI['+c+']['+i+'][0],sI['+c+']['+i+'][2])" '+sTxt[c][i]+'><a '+thisLink+' id="sublink'+c+'-'+i+'" target="'+sI[c][i][2]+'" onmouseover="if(op6){linkClicked=true;}" onmouseout="if(op6){linkClicked=false;}" onclick="return true" style="background-color:transparent\;position:relative\; top:'+(svtOFFSET)+'\; '+space+'"><font color="'+oks[c][7]+'">'+ sI[c][i][1]+'</font></a></td></tr></table></td></tr>';mzSubAbsTop += sbSIZE;}M+='<tr><td><div style="width:2px\; height:'+sbSIZE+'px\;"></div></td></tr>';M+='</table></span>';for (i=0;i<aryl;i++){thisH=snH;thisT=sI[c][i][1];splitT=thisT.split('<br>');Trows=splitT.length;if (Trows>1){thisH=(snH*Trows);}thisLink=' href="'+sI[c][i][0]+'"';if(sI[c][i][0]=="javascript:doNothing()") { thisLink=''; }M+='<span class="printhide" id="subroll'+c+'-'+i+'" style="'+scTd[i]+'\; z-index:'+(zORDER+5)+'\; position:absolute; top:'+(chTop[c][i]+sbSIZE)+'\; left:'+(acL+sbSIZE)+'\; visibility:hidden\;" onmouseover="if(rTimer!=0){clearTimeout(rTimer)\;rCount=0\;}" onmouseout="if(!keepSubLIT){miH(this)}">';M+='<table cellpadding=0 cellspacing=0 border=0 '+oks[c][5]+' onmouseover="cCM('+c+','+i+')\; oCM('+c+','+i+')\;"><tr><td class=SUBmTD align="'+sP[c][2]+'" width="'+(sP[c][0]-(sbSIZE*2))+'" height='+thisH+' onclick="goToUrl(sI['+c+']['+i+'][0],sI['+c+']['+i+'][2])" '+sTxt[c][i]+'><a '+thisLink+' id="srolllink'+c+'-'+i+'" target="'+sI[c][i][2]+'" onmouseover="if(op6){linkClicked=true;}" onmouseout="if(op6){linkClicked=false;}" onclick="return true" style="'+scSt[i]+'\;background-color:transparent\;position:relative\; '+space+'"><font color="'+oks[c][8]+'">'+ sI[c][i][1]+'</font></a></td></tr></table>';M+='</span>';}shb=0;if(shy){shb=(2*shSIZE);}if(shCOLOR!=""){M+='<span class="printhide" id="shadow'+c+'" style="visibility:hidden\;background-image:url('+bh + oks[c][9]+')\; background-color:'+oks[c][9]+'\; z-index:'+(zORDER+3)+'\; position:absolute\; top:'+(aP[xp]+thisAH[c]+vOFFSET+sP[c][3]+shSIZE-shb)+'px\; left:'+(acL+shSIZE-shb)+'px\; width:'+(sP[c][0]+shb)+'\; height:' + (((snH+sbSIZE)*aryl)+((snH)*Xrows[c])+sbSIZE+shb) + 'px\;"></span>';}for (var sq=0;sq<aryl;sq++){remChildTop[c][sq]=new Array;if(cP[c][sq].length>0&&cI[c][sq].length>0){XCrows[c][sq]=0;var chL,cgL;if(cP[c][sq][1]=="right"){chL=acL-cP[c][sq][0]-chhOFFSET-cP[c][sq][4];cgL=chL+cP[c][sq][0];}else{chL=acL + sP[c][0]+chhOFFSET+cP[c][sq][4];cgL=(chL-(chhOFFSET+cP[c][sq][4]));}jaryl=cI[c][sq].length;for (var cj=0;cj<jaryl;cj++){thisH=snH;thisT=cI[c][sq][cj][1];splitT=thisT.split('<br>');Trows=splitT.length;if (Trows>1){XCrows[c][sq]+=(Trows-1);}}if((chhOFFSET+cP[c][sq][4])>0){C+='<span id="childgrid'+c+'-'+sq+'" style="visibility:hidden\; z-index:'+(zORDER+1)+'\; position:absolute\; top:'+((chTop[c][sq]+chvOFFSET)+cP[c][sq][3])+'px\; left:'+cgL+'px\; width:'+(chhOFFSET+cP[c][sq][4])+'px\; height:'+(((snH+sbSIZE)*cI[c][sq].length)+((snH)*XCrows[c][sq])+sbSIZE+shb+shSIZE)+'px\;" onmouseover="if(rTimer!=0){clearTimeout(rTimer)\;rCount=0\;}"></span>';}C+='<span class="printhide" id="childnav'+c+'-'+sq+'" style="visibility:hidden\; z-index:'+(zORDER+6)+'\; position:absolute\; top:'+ (chTop[c][sq]+chvOFFSET+cP[c][sq][3])+'px\; left:'+chL+'px\;"><table cellpadding=0 cellspacing=0 width="'+cP[c][sq][0]+'" border=0 '+ocks[c][sq][4]+'>'; for (cj=0;cj<jaryl;cj++){thatH=thisH;thisH=snH;thisT=cI[c][sq][cj][1];splitT=thisT.split('<br>');Trows=splitT.length;if (Trows>1){thisH=(snH*Trows);}if(cj==0){remChildTop[c][sq][cj]=0;}else{remChildTop[c][sq][cj]=thatH+remChildTop[c][sq][(cj-1)];}C+='<tr><td class=SUBmTD><table cellpadding=0 cellspacing=0 '+ocks[c][sq][3]+' border=0 style="position:relative\; margin-top:'+sbSIZE+'\; margin-left:'+sbSIZE+'\; margin-right:'+sbSIZE+'\; height:'+(thisH)+'\;" width="'+(cP[c][sq][0]-(sbSIZE*2))+'"><tr><td class=SUBmTD align="'+cP[c][sq][2]+'"><table cellpadding=0 cellspacing=0 border=0 width="'+(cP[c][sq][0]-(sbSIZE*2))+'" height='+(thisH)+'><tr><td class=SUBmTD align="'+cP[c][sq][2]+'">&nbsp;</td></tr></table></td></tr></table></td></tr>';}C+='<tr><td><div style="width:2px\; height:'+sbSIZE+'px\;"></div></td></tr>';C+='</table></span>';var cspace=' left:0px\;';if(cP[c][sq][2]=="left"){cspace=' left:'+stINDENT+'px\;';}if(cP[c][sq][2]=="right"){cspace=' left:-'+stINDENT+'px\;';}C+='<span class="printhide" id="childlinks'+c+'-'+sq+'" style="visibility:hidden\; z-index:'+(zORDER+7)+'\; position:absolute\; top:'+(chTop[c][sq]+chvOFFSET+cP[c][sq][3])+'px\; left:'+chL+'px\;"><table cellpadding=0 cellspacing=0 width="'+cP[c][sq][0]+'" border=0>'; mzSubAbsTop=sbSIZE;for (cj=0;cj<jaryl;cj++){cTxt[c][sq][cj]='';if(cI[c][sq][cj][3]!="none"){if(altDISPLAY=="title"){cTxt[c][sq][cj]=' title="'+cI[c][sq][cj][3]+'" ';}if(altDISPLAY=="status"){cTxt[c][sq][cj]=' onmouseover="return writeStatus(cI['+c+']['+sq+']['+cj+'][3])" onmouseout="return writeStatus(altNull)" ';}}thisH=snH;thisT=cI[c][sq][cj][1];splitT=thisT.split('<br>');Trows=splitT.length;if (Trows>1){thisH=(snH*Trows);}if(cI[c][sq][cj][0]=="#"){cI[c][sq][cj][0]="javascript:doNothing()";}thisLink = ' href="'+cI[c][sq][cj][0]+'"'; if(cI[c][sq][cj][0]=="javascript:doNothing()") { thisLink = ''; }C+='<tr><td class=SUBmTD><table cellpadding=0 cellspacing=0 border=0 style="position:relative\; top:'+mzSubAbsTop+'\; margin-top:0\; margin-left:'+sbSIZE+'\; margin-right:'+sbSIZE+'\; " onmouseover="if(rTimer!=0){clearTimeout(rTimer)\;rCount=0\;}if(cI['+c+']['+sq+']['+cj+'][4]){oR[11]['+c+']['+sq+']['+cj+'].style.visibility=\'visible\'\;}"  onmouseout="if(oR[11]['+c+']['+sq+']['+cj+']){oR[11]['+c+']['+sq+']['+cj+'].style.visibility=\'hidden\'\;}"><tr><td class=SUBmTD align="'+cP[c][sq][2]+'" width="'+(cP[c][sq][0]-(sbSIZE*2))+'" height='+(thisH)+' onclick="goToUrl(cI['+c+']['+sq+']['+cj+'][0],cI['+c+']['+sq+']['+cj+'][2])" '+cTxt[c][sq][cj]+'><a '+thisLink+' id="childlink'+c+'-'+sq+'-'+cj+'" target="'+cI[c][sq][cj][2]+'" onmouseover="if(op6){linkClicked=true;}" onmouseout="if(op6){linkClicked=false;}" onclick="return true" style="background-color:transparent\;position:relative\; top:'+(svtOFFSET)+'\; '+cspace+'"><font color="'+ocks[c][sq][7]+'">'+ cI[c][sq][cj][1]+'</font></a></td></tr></table></td></tr>';mzSubAbsTop += sbSIZE;}C+='<tr><td><div style="width:2px\; height:'+sbSIZE+'px\;"></div></td></tr>';C+='</table></span>';}var thisCHT = chTop[c][sq]+chvOFFSET+sbSIZE;if(cP[c][sq].length>0){thisCHT+=cP[c][sq][3];}karyl=cI[c][sq].length;for (cj=0;cj<karyl;cj++){thisH=snH;thisT=cI[c][sq][cj][1];splitT=thisT.split('<br>');Trows=splitT.length;if (Trows>1){thisH=(snH*Trows);}thisLink = ' href="'+cI[c][sq][cj][0]+'"'; if(cI[c][sq][cj][0]=="javascript:doNothing()") { thisLink = ''; }C+='<span class="printhide" id="childroll'+c+'-'+sq+'-'+cj+'" style="visibility:hidden\; z-index:'+(zORDER+8)+'\; position:absolute\; top:'+thisCHT+'px\; left:'+(chL+sbSIZE)+'px\;" onmouseover="if(rTimer!=0){clearTimeout(rTimer)\;rCount=0\;}this.style.visibility=\'visible\';clearChildRoll('+c+','+sq+',this);" onmouseout="miH(this)" onmouseup="miH(this)"><table cellpadding=0 cellspacing=0 border=0 '+ocks[c][sq][5]+' onmouseout="this.parentNode.style.visibility=\'hidden\'\;"><tr><td class=SUBmTD align="'+cP[c][sq][2]+'" width="'+(cP[c][sq][0]-(sbSIZE*2))+'" height='+thisH+' onclick="goToUrl(cI['+c+']['+sq+']['+cj+'][0],cI['+c+']['+sq+']['+cj+'][2])" '+cTxt[c][sq][cj]+'><a id="crolllink'+c+'-'+sq+'-'+cj+'" '+thisLink+' target="'+cI[c][sq][cj][2]+'" onmouseover="if(op6){linkClicked=true;}" onmouseout="if(op6){linkClicked=false;}" onclick="return true" style="background-color:transparent\; position:relative\; '+cspace+'"><font color="'+ocks[c][sq][8]+'">'+ cI[c][sq][cj][1]+'</font></a></td></tr></table></span>';thisCHT+=(thisH+sbSIZE);}if((typeof XCrows[c][sq]!="undefined")&&shCOLOR!=""){C+='<span class="printhide" id="childshadow'+c+'-'+sq+'" style="visibility:hidden\;background-image:url('+bh + ocks[c][sq][9]+')\; background-color:'+ocks[c][sq][9]+'\; z-index:'+(zORDER+5)+'\; position:absolute\; top:'+((chTop[c][sq]+chvOFFSET)+shSIZE+cP[c][sq][3]-shb)+'px\; left:'+(chL+shSIZE-shb)+'px\; width:'+(cP[c][sq][0]+shb)+'\; height:' + (((snH+sbSIZE)*cI[c][sq].length)+((snH)*XCrows[c][sq])+sbSIZE+shb) + 'px\;"></span>';}}}var oldBW=window.innerWidth;var oldBH=window.innerHeight;var fws;var allready=false;function findWindowSize(){var newBW=window.innerWidth;var newBH=window.innerHeight;if (newBW==oldBW&&newBH==oldBH){fws = setTimeout("findWindowSize()",100); }else{if((newBW!=oldBW)||(newBH+24)<oldBH) { clearTimeout(fws); if(window.innerWidth>(nS+absLEFT)){window.location.reload();}else{fws = setTimeout("findWindowSize()",100);}}else{fws = setTimeout("findWindowSize()",100);}}}function windowStart(){allready=true;storeObjects();if(allowRESIZE==true){findWindowSize();}}if(!free){d.write(S);}d.write(T);d.write(M);d.write(C);window.onload=windowStart;function clickToClose() {aCM();if(typeof menuClosingFunction=="function") { menuClosingFunction(); }}document.onclick=clickToClose;var mtPos,mtProps,scaroTop,ecX,ecY,rba;function activateMenu(mmNum,mmXPos,mmYPos,scaroFollow){if(!allready){return false;}if(typeof sP[mmNum]=="undefined"||!remoteTRIGGERING){return false;}rba=false;if(typeof mmXPos!="undefined"){rba=true;}vOFFSET=0;hOFFSET=0;sP[mmNum][3]=0;sP[mmNum][4]=0;oM(mmNum,false); if(!rba) { mtPos=[event.clientX+32,event.clientY];}else {mtPos=[0,0];}ecX=mtPos[0];ecY=mtPos[1];scaroTop=window.pageYOffset;aryl=sI[mmNum].length;if(!rba){for(i=0;i<aryl;i++){cP[mmNum][i][1]="left";}}else {for(i=0;i<aryl;i++){if(typeof rcP[mmNum][i]!="undefined") { cP[mmNum][i][1]=rcP[mmNum][i][1]; }}}mtProps=[oR[1][mmNum].offsetWidth,oR[1][mmNum].offsetHeight];if(mtPos[0]>(bW/2)){mtPos[0]=ecX-64-mtProps[0]; if(!rba){for(i=0;i<aryl;i++){cP[mmNum][i][1]="right";}}else {for(i=0;i<aryl;i++){if(typeof rcP[mmNum][i]!="undefined") { cP[mmNum][i][1]=rcP[mmNum][i][1]; }}}}if((mtPos[1]+mtProps[1]+shSIZE)>(bHe+scaroTop)){mtPos[1]-=((mtPos[1]+mtProps[1]+shSIZE)-(bHe+scaroTop)); }if(typeof mmXPos !="undefined") { mtPos[0]=mmXPos; if(typeof mmYPos !="undefined"){mtPos[1]=mmYPos;}else{mtPos[1]=0;}if(shy) { mtPos[0]+=parseInt(shSIZE); mtPos[1]+=parseInt(shSIZE); }if(typeof scaroFollow!="undefined" && scaroFollow) { mtPos[1]+=scaroTop;}}hOFFSET=mtPos[0];vOFFSET=mtPos[1];oR[1][mmNum].style.left=hOFFSET+"px";oR[1][mmNum].style.top=(vOFFSET)+"px";oR[2][mmNum].style.left=hOFFSET+"px";oR[2][mmNum].style.top=(vOFFSET)+"px";if(shCOLOR!=""){oR[4][mmNum].style.left=(hOFFSET+shPos)+"px";oR[4][mmNum].style.top=(vOFFSET+shPos)+"px";}for(i=0;i<aryl;i++){oR[5][mmNum][i].style.left=(hOFFSET+sbSIZE)+"px";oR[5][mmNum][i].style.top=(vOFFSET+remSubTop[mmNum][i]+((i+1)*sbSIZE))+"px";}obGrid.style.top = scaroTop+"px";oR[1][mmNum].style.visibility="visible";oR[2][mmNum].style.visibility="visible";if(shCOLOR!=""){oR[4][mmNum].style.visibility="visible";}}function deactivateMenus(gridWait) { if(typeof gridWait=="undefined" || gridWait==true) {aCM(); if(typeof menuClosingFunction=="function") { menuClosingFunction(); }}else if (gridWait==false) {gridClearMenus();}}