<?php
// UDMv4.4 //
/***************************************************************\
                                                                 
  ULTIMATE DROP DOWN MENU Version 4.4 by Brothercake             
  http://www.udm4.com/                                           
                                                                 
  This script may not be used or distributed without license     
                                                                 
\***************************************************************/



//set a path to the configuration file
$config = $_SERVER['DOCUMENT_ROOT'] . '/udm4-php/udm-resources/udm-custom.ini';



/***************************************************************\
\***************************************************************/

//override config with GET var
if(isset($_GET['config'])&&$_GET['config']!='') { $config=$_GET['config']; }

//import configuration file
@require_once($config);

//if speech module exists enforce vertical orientation and turn off repositioning
if(isset($um['speech'])) { $um['orientation'][0]='vertical';$um['behaviors'][2]='no'; }

//restrict positions to positive values
if(stristr($um['orientation'][4],'-')) { $um['orientation'][4]='0'; }
if(stristr($um['orientation'][5],'-')) { $um['orientation'][5]='0'; }

//get writing mode from h align variable, set right alignment if it's there and set negative x value
$umdir='left';
if($um['orientation'][1]=='rtl')
{
	$umdir='right';
	$um['orientation'][1]='right';
	$um['orientation'][4]='-'.$um['orientation'][4];
}

//map old values for windowed control management for backward compatibility
if($um['behaviors'][3]=='yes') { $um['behaviors'][3]='default'; }
if($um['behaviors'][3]=='no') { $um['behaviors'][3]='iframe'; }

//check for undefined new variables
if(!isset($um['reset'])) { $um['reset']=array('yes','yes','yes'); }
if(!isset($um['hstrip'])) { $um['hstrip']=array('none','yes'); }
if(!isset($um['reset'][3])) { $um['reset'][3]='no'; }

//detect popup alignment
$ump=($um['orientation'][0]=='popup');

//convert values for popup aligment
if($ump)
{
	$um['orientation'][1]='left';
	$um['orientation'][2]='top';
	$um['orientation'][3]='absolute';
	$um['orientation'][4]='-2000px';
	$um['orientation'][5]='-2000px';
	$um['navbar'][0]=0;
	$um['navbar'][1]=0;
}

//remember images so we can cache them
$m=0;
$umimgs=array();

//core javascript string, global udm object
$umjs='var um=new Object;';

//create um.e javascript array of menu and menu item data
//testing for number variables and outputting as appropriate
$umary=array('orientation','list','behaviors','navbar','items','menus','menuItems');
$umjs.="um.e=[";
foreach($umary as $data)
{
	foreach($um[$data] as $subdata)
	{
		$umjs.=ereg("^[+\-]?[0-9]+$",$subdata)?"$subdata,":"'$subdata',";
		//if this value is an image then remember it
		if(eregi("(gif|png|mng|jpg|jpeg|bmp)",$subdata)) { $umimgs[$m++]=$subdata; }
	}
}
$umjs.="];";

//create um.v javascript array of adhoc menu data
$umjs.="um.v=[];";
foreach($um["menuClasses"] as $key=>$data)
{
	$umjs.="um.v['$key']=[";
	foreach($data as $subkey=>$subdata)
	{
		$umjs.="'$subdata',";
		//if this value is an image then remember it
		if(eregi("(gif|png|mng|jpg|jpeg|bmp)",$subdata)) { $umimgs[$m++]=$subdata; }
	}
	$umjs.="];";
}

//create um.w javascript array of adhoc menu item data
$umjs.="um.w=[];";
foreach($um["itemClasses"] as $key=>$data)
{
	$umjs.="um.w['$key']=[";
	foreach($data as $subkey=>$subdata)
	{
		$umjs.="'$subdata',";
		//if this value is an image then remember it
		if(eregi("(gif|png|mng|jpg|jpeg|bmp)",$subdata)) { $umimgs[$m++]=$subdata; }
	}
	$umjs.="];";
}

//count ad-hoc classes
$umjs.='um.vl='.(count($um['menuClasses'])).';';
$umjs.='um.wl='.(count($um['itemClasses'])).';';

//compile dynamic menus arrays, if there are any
$umjs.='um.menuCode=[];';
foreach($um["menuCode"] as $key=>$data)
{
	$umjs.='um.menuCode[\''.$key.'\']=\''.$data.'\';';
}

//baseSRC
$umjs.='um.baseSRC=\''.$um['baseSRC'].'\';';

//declare i and j to avoid strict errors
$umjs.='var i,j;';

//if there are any stored images
if(count($umimgs)>0)
{
	//open javascript array
	$umjs.="um.imn=[";

	//add each to array
	foreach($umimgs as $src)
	{
		$umjs.="'$src',";
	}

	//close javascript array and write caching loop with the result of a php count()
	$umjs.="];um.im=[];i=0;do{um.im[i]=new Image;um.im[i].src=um.baseSRC+um.imn[i];i++;}while(i<"
		.count($umimgs)
		.");";
}

//continue compiling core javascript
$umjs.='var umTree=null;um.gp=function(umRI){return (um.vn(umRI.nodeName).toLowerCase()==\'li\')?umRI:this.gp(umRI.parentNode);};um.ready=0;um.pi=function(n){n=parseInt(n,10);return (isNaN(n)?0:n);};um.un=\'undefined\';um.m=document;um.gd=function(umD){return um.m.getElementById(umD);};um.xd=function(umD){umD.style.display=\'block\';};um.xn=function(umD){umD.style.display=\'none\';};um.xv=function(umD){umD.style.visibility=\'visible\';};um.xh=function(umD){umD.style.visibility=\'hidden\';};um.ne=function(umD){return umD.parentNode.className==\'udm\';};um.u=navigator.userAgent.toLowerCase();um.d=(typeof um.m.getElementById!=um.un&&(typeof um.m.createElement!=um.un||typeof um.m.createElementNS!=um.un));um.o5=/opera[\/ ][56]/.test(um.u);um.k=(navigator.vendor==\'KDE\');if(um.o5){um.d=0;};um.b=(um.d||um.o5);um.o7=(um.d&&typeof window.opera!=um.un);um.o75=0;um.o73=0;um.o71=0;if(um.o7){um.ova=um.pi(um.u.split(/opera[\/ ]/)[1].match(/[7-9]/)[0]);um.ovi=um.pi(um.u.split(/opera[\/ ][7-9]\./)[1].match(/^[0-9]/)[0]);um.o75=(um.ova>=8||um.ovi>=5);um.o73=(um.ova>=8||um.ovi>=3);um.o71=(um.ova==7&&um.ovi<=1);}um.s=(navigator.vendor==\'Apple Computer, Inc.\');um.s2=(um.s&&typeof XMLHttpRequest!=um.un);um.wie=(um.d&&typeof um.m.all!=um.un&&typeof window.opera==um.un&&!um.k);um.mie=(um.wie&&um.u.indexOf(\'mac\')>0);um.mx=(um.u.indexOf(\'tasman 0.9\')>0);if(um.mx){um.mie=1;}um.omie=0;if(um.mie){um.wie=0;um.omie=(/msie 5\.[0-1]/.test(um.u));}um.ie=(um.wie||um.mie);um.wie5=(um.wie&&um.u.indexOf(\'msie 5\')>0);um.wie55=(um.wie&&um.u.indexOf(\'msie 5.5\')>0);um.wie50=(um.wie5&&!um.wie55);um.wie6=(um.wie&&um.u.indexOf(\'msie 6\')>0);if(um.wie6){um.wie55=1;}um.q=(um.wie5||(um.mie&&!um.mx)||((um.mx||um.wie6||um.o7)&&um.m.compatMode!=\'CSS1Compat\'));um.og=0;um.dg=0;if(navigator.product==\'Gecko\'&&!um.s){um.sub=um.pi(navigator.productSub);um.og=(um.sub<20030312);um.dg=(um.sub<20030208);}';

//create other core javascript arrays

//hstrip
$umary=array();
foreach($um['hstrip'] as $umv)
{
	$umary[]=$umv;
}
$umjs.='um.hstrip=[\''.implode("','",$umary).'\'];';

//reset
$umary=array();
foreach($um['reset'] as $umv)
{
	$umary[]=$umv;
}
$umjs.='um.reset=[\''.implode("','",$umary).'\'];';

//keys - this leaves a trailing comma in the array
$umkb=isset($um['keys']);
if($umkb)
{
	$umjs.="um.keys=[";
	foreach($um['keys'] as $data)
	{
		//convert key handling codes to numbers
		$umjs.=ereg("^[0-9]+$",$data)?"$data,":"'$data',";
	}
	$umjs.="];";
}

//speech
$umsp=($umkb&&isset($um['speech']));
if($umsp)
{
	$umary=array();
	foreach($um['speech'] as $umv)
	{
		$umary[]=$umv;
	}
	$umjs.='um.speech=[\''.implode("','",$umary).'\'];';
}

//carry on compiling core javascript
$umjs.='um.kb=('.($umkb?'true':'false').'&&!(um.mie||um.o7||um.k||(um.s&&!um.s2)));um.skb=(um.kb||('.($umkb?'true':'false').'&&((um.o7&&!um.o71)||um.k)));um.sp=('.($umsp?'true':'false').'&&um.wie);if(um.mx||(um.wie50&&um.rp)){um.e[12]=\'no\';}um.rp='.($um['orientation'][3]=='relative'?'true':'false').';um.p='.($ump?'true':'false').';um.hz=((um.wie50&&'.($um['behaviors'][3]=='default'?'true':'false').')||(um.wie&&'.($um['behaviors'][3]=='hide'?'true':'false').'));um.a='.($um['orientation'][1]=='right'?'true':'false').';um.h='.($um['orientation'][0]=='horizontal'?'true':'false').';um.rg=(um.h&&'.($um['list'][0]=='rigid'?'true':'false').'&&'.($umdir!='right'?'true':'false').');um.ep=0;if('.($um['orientation'][0]=='expanding'?'true':'false').'){um.ep=1;um.e[0]=\'vertical\';}um.fe=false;if(um.e[3]==\'allfixed\'){um.e[3]=\'fixed\';if(um.wie){um.fe=true;}}um.f=(um.e[3]==\'fixed\'&&!(um.ie||um.og));um.nc='.(($um['items'][0]==0&&$um['items'][2]=='collapse')?'true':'false').';um.mc='.($um['menuItems'][0]==0&&$um['menuItems'][2]=='collapse'?'true':'false').';um.nm=((um.og&&um.rp)||(um.omie&&um.h)||((um.dg||um.wie50)&&'.($umdir=='right'?'true':'false').'));um.nr=(um.nm||um.mie);um.ns=(um.dg||um.o71||(um.wie50&&um.rp)||(um.o7&&um.f)||um.mie);um.cns=(typeof um.m.createElementNS!=um.un);um.ss=(um.cns&&typeof um.m.styleSheets!=um.un&&!(um.s||um.k||um.mx));um.ni='.(eregi("(gif|png|mng|jpg|jpeg|bmp)",$um['items'][28])?'true':'false').';um.mi='.(eregi("(gif|png|mng|jpg|jpeg|bmp)",$um['menuItems'][28])?'true':'false').';um.rn=0;um.rv=[];um.addReceiver=function(umFC,umEC){um.rv[um.rn++]=[umFC,umEC];};um.createElement=function(umE,umA){um.el=(um.cns)?um.m.createElementNS(\'http://www.w3.org/1999/xhtml\',umE):um.m.createElement(umE);if(typeof umA!=um.un){for(var i in umA){switch(i){case \'text\' :um.el.appendChild(um.m.createTextNode(umA[i]));break;case \'class\' : um.el.className=umA[i];break;default : um.el.setAttribute(i,\'\');um.el[i]=umA[i];break;}}}return um.el;};';

//whether to include iframe code and select-hiding code
$umif=($um['behaviors'][3]=='default'||$um['behaviors'][3]=='iframe');
$umhz=($um['behaviors'][3]=='default'||$um['behaviors'][3]=='hide');

//whether rigid width is in use
$umrw=($um['orientation'][0]=='horizontal'&&$um['list'][0]=='rigid');

//whether dropshadows are in use
$umds=($um['menus'][9]!='none');

//whether arrows are in use at all
$umaz=($um['items'][28]!='none'||$um['menuItems'][28]!='none');



//*************************************************************//
//*************************************************************//
//begin compiling dom script

$j=0;
$umjd=array();

$umjd[$j++]="um.ap=function(umC,umE){um.rl=um.rv.length;if(um.rl>0){um.i=0;do{if(um.rv[um.i][1]==''){um.rv[um.i][0](umE,umC);}else if(umC==um.rv[um.i][1]){um.rv[um.i][0](umE);}um.i++;}while(um.i<um.rl);}};";
$umjd[$j++]="if(!um.k&&typeof window.addEventListener!=um.un){window.addEventListener('load',umIni,0);}else if(um.o7){um.m.addEventListener('load',umIni,0);}else if(um.wie){window.attachEvent('onload',umIni);um.ex=['onmouseover','onmouseout','onmousedown','onmouseup','onclick','onmousewheel','onfilterchange','onkeydown','onfocus','onactivate','onscroll','over','out'];um.gg=um.ex.length;window.attachEvent('onunload',function(){um.da=document.all.length;i=0;do{um.t=document.all[i];j=0;do{um.t[um.ex[j]]=null;j++;}while(j<um.gg);i++;}while(i<um.da);});}else{if(typeof window.onload=='function'){um.on=onload;window.onload=function(){um.on();umIni();};}else{window.onload=umIni;}}";
$umjd[$j++]="function umIni(){if(typeof um.ini!=um.un||(um.k&&typeof window.sidebar==um.un)){return;}um.ini=1;um.ha=0;umTree=(um.b)?um.gd('udm'):null;if(umTree!=null&&um.d){um.ap('000',umTree);";
$umjd[$j++]="for(i in um.menuCode){um.nh=um.gd(i);if(um.nh!=null){if(um.mie){um.menuCode[i]=um.menuCode[i].replace(/<\/(li|ul)>/ig,'</\$1>\\n');}um.nh.innerHTML+=um.menuCode[i];if(um.mie){um.dm=um.gm(um.nh);um.xn(um.dm);um.xh(um.dm);}}}";
$umjd[$j++]="um.bub=0;um.wsr=0;um.rtl=um.m.getElementsByTagName('html')[0].getAttribute('dir')=='rtl';um.kdf=0;if(um.o7){um.m.addEventListener('keydown',function(e){if(e.keyCode==16){um.kdf=1;}},0);um.m.addEventListener('keyup',function(e){if(e.keyCode==16){um.kdf=0;}},0);}um.skb=(um.skb&&typeof umKM=='function');um.kb=(um.skb&&um.kb);";
if($umkb) 
{
	$umjd[$j++]="if(um.skb){um.kbm=new umKM;um.ap('001',um.kbm);}";
}
$umjd[$j++]="um.sp=(um.sp&&typeof udmSpeechModule=='function');";
if($umsp) 
{
	$umjd[$j++]="if(um.sp){um.sapi=new udmSpeechModule;um.ap('002',um.sapi);}";
}
$umjd[$j++]="um.n=new umNav(umTree);um.ap('009',um.n);if(um.fe){um.tr.style.left=(um.getScrollAmount(1))+'px';um.tr.style.top=(um.getScrollAmount())+'px';window.attachEvent('onscroll',function(){um.tr.style.left=(um.getScrollAmount(1))+'px';um.tr.style.top=(um.getScrollAmount())+'px';});}if(um.s){umTree.style.KhtmlOpacity='1';}um.s1=(typeof umTree.style.KhtmlOpacity!=um.un);um.ready=1;um.ap('010',um.tr);}};";
$umjd[$j++]="function umNav(umTree){um.n=this;um.tr=umTree;if(um.wie){um.tr.style.color='black';}um.jv='javascript:void(0)';";
if($umrw) 
{
	$umjd[$j++]="if(um.rg){um.rw=0;}";
}
$umjd[$j++]="um.li=umTree.getElementsByTagName('li');um.ll=um.li.length;i=0;do{";
if(count($um['menuClasses'])>0) 
{
	$umjd[$j++]="if(um.wl>0){um.t=um.li[i];um.t8=um.es(um.t.className);if(um.t8==''&&!um.ne(um.t)){um.t=um.gp(um.li[i].parentNode);um.t8=um.es(um.t.className);if(um.t8!=''&&!um.ne(um.t)){um.li[i].className=um.t8;}}}";
}
$umjd[$j++]="this.it(um.li[i]);i++;}while(i<um.li.length);";
if(count($um['itemClasses'])>0) 
{
	$umjd[$j++]="if(um.vl>0){um.mo=um.gu(um.tr);um.en=um.mo.length;if(um.en>0){i=0;do{um.t8=um.es(um.mo[i].className);if(um.t8==''){um.t=um.mo[i].parentNode.parentNode;um.t8=um.es(um.t.className);if(um.t8!=''&&um.t8!='udm'){um.mo[i].className=um.t8;}}i++;}while(i<um.en);}}";
}
$umjd[$j++]="um.mf=0;um.lf=0;um.ety=typeof document.addEventListener!=um.un?'addEventListener':typeof document.attachEvent!=um.un?'attachEvent':'';um.epx=um.ety=='attachEvent'?'on':'';if(um.ety!=''){um.m[um.ety](um.epx+'mousedown',function(e){if(!e){e=window.event;}um.mf=1;";
if($umkb) 
{
	$umjd[$j++]="if(um.skb){um.ha=0;}";
}
$umjd[$j++]="clearInterval(um.oc);um.or=0;if(um.reset[0]!='no'){";
if($umhz) 
{
	$umjd[$j++]="if(um.hz){if(!um.tr.contains(event.srcElement)){um.n.ts('visible');}}";
}
$umjd[$j++]="um.cm(e);}},0);um.m[um.ety](um.epx+'mouseup',function(){um.mf=0;},0);}";
if($umkb) 
{
	$umjd[$j++]="if(um.kb){um.kbm.bdh();}";
}

if($umkb) 
{
	$umjd[$j++]="if(um.skb&&um.o7){um.kbm.bfh();}";
}

if($umrw) 
{
	$umjd[$j++]="if(um.rg){this.aw();}";
}
$umjd[$j++]="um.cc=null,um.cr=0,um.oc=null,um.or=0;if(!um.ie){um.tr.contains=function(umN){return (umN==null)?false:(umN==this)?true:this.contains(umN.parentNode);};}um.lw=um.getWindowDimensions();um.lh=um.gc(um.tr).offsetHeight;if(um.og&&um.hstrip[0]!='none'){um.tr.style.height=(um.hstrip[1]=='yes')?(um.lh+um.e[17])+'px':um.lh+'px';}um.pss=um.m.getElementById('udm-purecss');if(um.pss!=null){um.pss.disabled=1;}um.vs=setInterval('um.n.ws()',55);};";
$umjd[$j++]="umNav.prototype.it=function(umI){if(um.wie){um.of=(um.wie55)?'onactivate':'onfocus';um.gc(umI).attachEvent(um.of,function(){";
if($umkb) 
{
	$umjd[$j++]="if(um.kb&&!um.lf){um.bub=0;umI.over(1,um.gc(umI));}";
}
$umjd[$j++]="});}um.t3=um.es(umI.className);um.vh=(um.t3.indexOf('onclick')!=-1)?'onclick':'onmouseover';um.ii=um.ne(umI);var umM=null;umM=(typeof um.gu(umI)[0]!=um.un)?um.gu(umI)[0]:null;if(typeof um.fl==um.un){um.fl=um.gc(umI);}";
if($umaz) 
{
	$umjd[$j++]="if(umM!=null&&!um.nr){if(((um.ii&&um.e[45]!='none')||(!um.ii&&um.e[89]!='none'))&&um.n.cck()){if(um.ii){um.ac=um.e[45];um.aa=(um.ni)?um.e[48]:'¦¦';}else{um.ac=um.e[89];um.aa=(um.mi)?um.e[92]:'¦¦';if(typeof um.w[um.t3]!=um.un){um.ac=um.w[um.t3][23];um.aa=(um.mi)?um.w[um.t3][25]:'¦¦';}}if(um.aa=='¦¦'){um.at={'class':'udmA','text':um.ac};um.ar=um.ar=um.gc(umI).appendChild(um.createElement('span',um.at));}else{if(um.wie){um.gc(umI).innerHTML+='<img class=\'udmA\' alt=\''+um.aa+'\' title=\'\' />';um.ar=um.gc(umI).lastChild;um.ar.src=um.baseSRC+um.ac;}else if(um.s||um.k){um.at={'class':'udmA'};um.ar=um.gc(umI).appendChild(um.createElement('span',um.at));um.at={'src':um.baseSRC+um.ac,'alt':um.aa,'title':''};um.ar.appendChild(um.createElement('img',um.at));}else{um.at={'class':'udmA','alt':um.aa,'title':''};um.ar=um.gc(umI).appendChild(um.createElement('img',um.at));um.ar.src=um.baseSRC+um.ac;}}if(um.vh=='onclick'){um.ar.onmousedown=function(){return false;}};um.ar.onmouseover=function(e){um.t=um.gp(this.parentNode).parentNode.childNodes;um.tl=um.t.length;i=0;do{if(um.t[i].nodeName!='#text'&&um.gu(um.t[i]).length>0){if(um.gu(um.t[i])[0].style.visibility=='visible'){(!e)?event.cancelBubble=1:e.stopPropagation();this.parentNode.style.zIndex=um.e[6]+=2;return false;break;}}clearInterval(um.oc);um.or=0;i++;}while(i<um.tl);return true;};um.ar.onmouseout=function(){clearInterval(um.oc);um.or=0;};um.xd(um.ar);if(um.ii){this.wp(um.ar,umI,um.e[26],um.e[18],1);}}}";
}
$umjd[$j++]="if(um.mie){um.spn=umI.getElementsByTagName('span')[0];if(typeof um.spn!=um.un){um.spn.onclick=function(){this.parentNode.click();};}}";
if($umrw) 
{
	$umjd[$j++]="if(um.rg&&um.ne(umI)){um.n.dw(umI);}";
}
$umjd[$j++]="if(um.mie){um.t=um.gc(umI);if(um.t.className&&/nohref/.test(um.t.className)){um.gc(umI).href=um.jv;}}";
if($umkb) 
{
	$umjd[$j++]="if(um.skb){um.kbm.bth(umI);}";
}
$umjd[$j++]="umI.onmousedown=function(e){um.lf=1;um.ap('030',um.gc(this));(!e)?event.cancelBubble=1:e.stopPropagation();};umI.onmouseup=function(e){um.ap('035',um.gc(this));(!e)?event.cancelBubble=1:e.stopPropagation();};if(um.vh!='onclick'){umI.onclick=function(e){if(!um.bub){um.qc(um.gc(this).href);}um.bub=1;};}else if(!um.mie){umI.onmouseover=function(){um.n.lr(um.gc(umI),1);um.bub=0;};}if(!(um.mie&&um.vh=='onclick')){umI[um.vh]=function(e){um.tv=(um.ie)?window.event.srcElement:e.target;if(um.tv.nodeName=='#text'&&e.type=='click'){um.tv=um.tv.parentNode;}um.t7=um.es(um.gp(um.tv).className);um.uc=(um.lf&&!um.nm&&um.t7.indexOf('onclick')!=-1);if(um.uc){um.rt=um.e[10];um.e[10]=1;}if(um.t7.indexOf('onclick')==-1){um.bub=0;}else if(!um.lf){if(!um.bub){um.qc(um.tv.href);}um.bub=1;}this.over(0,um.tv);if(um.uc){um.e[10]=um.rt;um.lf=0;if(um.gu(um.gp(um.tv)).length>0){if(typeof um.tv.blur!=um.un){um.tv.blur();}if(um.gu(um.gp(um.tv))[0].style.display=='block'){um.n.cd(this.parentNode);(!e)?event.cancelBubble=1:e.stopPropagation();return false;}(!e)?event.cancelBubble=1:e.stopPropagation();um.t7=um.es(um.gp(um.tv).className);return (um.t7.indexOf('(true)')!=-1);}else{um.qc(um.tv.href);um.bub=1;}}if(!e){e=window.event;}return (e.type=='click'||um.o7||um.mx);};umI.onmouseout=function(e){this.out(e);};}umI.over=function(umF,umT){if(um.bub||(!umF&&um.ha&&um.kdf)){return false;}um.cf=um.n.cck();if(!um.cf||um.mf){um.mf=0;if(!um.ec){if(um.gm(this)!=null){this.removeChild(um.gm(this));}}return false;}";
if($umkb) 
{
	$umjd[$j++]="if(umF){if(!um.wsr){um.kbm.cws(umTree);um.wsr=1;}";
if($umsp) 
{
	$umjd[$j++]="if(um.sp){um.sapi.speechBuffer(um.gc(umI));event.cancelBubble=1;}";
}
$umjd[$j++]="um.ha=1;if(um.ie&&event.altKey){um.n.ck(um.gp(umT).parentNode);}um.ap('040',umT);}";
}
$umjd[$j++]="if(!umF){um.nn=um.vn(umT.nodeName).toLowerCase();if(/(li|ul)/.test(um.nn)){return false;}";
if($umkb) 
{
	$umjd[$j++]="if(um.skb){if(!um.lf){um.e[10]=um.mt[0];um.e[11]=um.mt[1];}um.nf=um.gc(this);if(um.ha){um.n.ck(umI.parentNode);um.n.cd(um.gp(umT).parentNode);um.nf.focus();um.nf.blur();um.ha=0;}}";
}
$umjd[$j++]="um.ap('020',umT);}clearInterval(um.cc);um.cr=0;um.n.lr(um.gc(umI),1);um.n.pr(umM,umI,umF,umT);return umI;};umI.out=function(e){if(um.o7&&um.ha&&um.kdf){return;}if(um.lf){um.gc(this).blur();}um.lf=0;if(!e){e=window.event;e.relatedTarget=e.toElement;}if(!umI.contains(e.relatedTarget)){if(!um.tr.contains(e.relatedTarget)){clearInterval(um.cc);um.cr=0;}um.n.cp(umM,umI);um.ap('025',um.gc(this));}};if(!um.ie){umI.contains=function(umN){return (umN==null)?false:(umN==this)?true:this.contains(umN.parentNode);};}um.ap('008',umI);};";
$umjd[$j++]="umNav.prototype.cck=function(){if(typeof document.defaultView!=um.un&&typeof document.defaultView.getComputedStyle!=um.un){um.sa=document.defaultView.getComputedStyle(um.fl,'').getPropertyValue('display');}else if(typeof um.fl.currentStyle!=um.un){um.sa=um.fl.currentStyle.display;}um.mv=1;um.ec=(!um.wie||um.tr.currentStyle.color=='black');return ((um.sa!='inline'||typeof um.sa==um.un)&&um.ec);};";
$umjd[$j++]="umNav.prototype.lr=function(umL,umV){if(umL!=null&&typeof umL.style!=um.un&&!(um.p&&um.mx)){um.cl=um.es(umL.className);um.ii=um.ne(um.gp(umL));if(umV){umL.style.zIndex=um.e[6]+=2;(um.cl=='')?umL.className='udmR':umL.className+=(umL.className.indexOf('udmR')==-1)?' udmR':'';}else{if(um.cl.indexOf('udmR')!=-1){umL.className=um.cl.replace(/([ ]?udmR)/g,'');}}";
if($umaz) 
{
	$umjd[$j++]="um.n.wv(umL,um.ii);";
}
$umjd[$j++]="}};";
$umjd[$j++]="umNav.prototype.pr=function(umG,umJ,umK,umR){";
if($umkb) 
{
	$umjd[$j++]="if(um.skb&&umK){um.kbm.cu(umG,umJ,umR);}";
}
$umjd[$j++]="if(!um.nm&&umG!=null&&umG.style.visibility!='visible'){if(um.wie){if(um.e[61]>0){um.gc(umG).style.marginTop=um.e[61]+'px';}else if(um.e[63]=='collapse'){umG.firstChild.style.marginTop=0+'px';}}";
if($umkb) 
{
	$umjd[$j++]="if(um.skb&&umK){um.n.ou(umG);}";
}
$umjd[$j++]="if(!(um.skb&&umK)){um.n.tu(umG,null);}}if(umG==null){um.n.tu(null,umJ);}};";
$umjd[$j++]="umNav.prototype.tu=function(umG,umJ){if(um.cr){clearInterval(um.oc);um.oj=umG;um.ij=umJ;um.or=1;um.oc=setInterval('um.n.tu(um.oj,um.ij)',um.e[10]);}else if(um.or){clearInterval(um.oc);um.or=0;this.ou(umG,umJ);}else{um.ap('061',umG);um.oj=umG;um.ij=umJ;um.or=1;um.oc=setInterval('um.n.tu(um.oj,um.ij)',um.e[10]);}};";
$umjd[$j++]="umNav.prototype.ou=function(umO,umP){if(umO==null){this.cd(umP.parentNode);return false;}this.cd(um.gp(umO).parentNode);if(typeof umO.m==um.un){umO.m=um.gu(umO);umO.l=umO.m.length;if(umO.l>0){for(var i=0;i<umO.l;i++){um.xh(umO.m[i]);um.xn(umO.m[i]);}}}if(um.ep){umO.style.position='relative';}";
if($umhz) 
{
	$umjd[$j++]="if(um.hz){this.ts('hidden');}";
}
$umjd[$j++]="um.xd(umO);";
if($umaz) 
{
	$umjd[$j++]="if(!um.nr&&um.e[89]!='none'){um.kl=umO.childNodes.length;i=0;do{um.tn=umO.childNodes.item(i);um.nn=um.vn(um.tn.nodeName).toLowerCase();if(um.nn=='li'){um.ar=um.n.ga(um.gc(um.tn));if(um.ar!=null){this.wp(um.ar,um.tn,um.e[70],um.e[62],0);}}i++;}while(i<um.kl);}";
}
$umjd[$j++]="um.ap('058',umO);this.pu(umO);";
if($um['behaviors'][2]=='yes') 
{
	$umjd[$j++]="if(um.e[12]=='yes'){this.ru(umO);}";
}
$umjd[$j++]="um.mp={x:(umO.offsetLeft),y:(umO.offsetTop)};um.sh=null;";
if($umds) 
{
	$umjd[$j++]="if(!um.ns&&um.e[58]!='none'){this.hl(umO);}";
}

if($umif) 
{
	$umjd[$j++]="if(um.wie55&&(um.e[13]=='default'||um.e[13]=='iframe')){this.il(umO);}";
}
$umjd[$j++]="um.hf=(um.wie55&&typeof umO.filters!='unknown'&&umO.filters&&umO.filters.length>0);if(um.hf){umO.filters[0].Apply();}if(um.wie&&um.h){um.t=umO.parentNode;if(um.ne(um.t)){um.t=um.t.style;um.t.position='absolute';um.t.zIndex=um.e[6]+=2;um.t.position='relative';}}um.xv(umO);um.pk=um.gc(umO.parentNode);if(um.hf){um.ap('065',umO);umO.filters[0].Play();";
if($umds) 
{
	$umjd[$j++]="if(um.sh!=null){umO.onfilterchange=function(){um.xd(um.sh);um.ap('066',umO);};}";
}
$umjd[$j++]="}";
if($umds) 
{
	$umjd[$j++]="else if(um.sh!=null){um.xd(um.sh);}";
}
$umjd[$j++]="if(um.wie50){um.xn(umO);um.xd(umO);}um.ap('060',umO);return umO;};";
$umjd[$j++]="umNav.prototype.cd=function(umD){um.sm=(um.mie&&!um.mx)?um.gt(umD,'ul'):um.gu(umD);um.sml=um.sm.length;i=-1;while(++i<um.sml){this.clm(um.sm[i]);}};";
$umjd[$j++]="umNav.prototype.ck=function(umD){um.lk=(um.mie&&!um.mx)?um.gt(umD,'a'):umD.getElementsByTagName('a');um.lkl=um.lk.length;i=-1;while(++i<um.lkl){this.lr(um.lk[i],0);}};";
$umjd[$j++]="umNav.prototype.cp=function(umG,umA){clearTimeout(um.oc);um.or=0;this.lr(um.gc(umA),0);if(!um.nm&&umG!=null){this.cot(umG);}};";
$umjd[$j++]="umNav.prototype.cot=function(umQ){if(um.cr){clearInterval(um.cc);um.cr=0;this.clm(umQ);}else if(um.e[11]!='never'){um.ap('071',umQ);um.cb=umQ;um.cr=1;um.cc=setInterval('um.n.cot(um.cb)',um.e[11]);}};";
$umjd[$j++]="umNav.prototype.clm=function(umH){if(umH.style.visibility=='visible'){if(typeof um.sim==um.un||!um.sim||um.ha){um.xh(umH);um.xn(umH);";
if($umhz) 
{
	$umjd[$j++]="if(um.hz){if(um.ne(umH.parentNode)){this.ts('visible');}}";
}
$umjd[$j++]="um.t=['udmC','udmS'];i=0;do{if(um.wie55||i>0){um.t2=umH.parentNode.lastChild;if(um.t2.className){if(um.t2.className.indexOf(um.t[i])!=-1){umH.parentNode.removeChild(um.t2);}}}i++;}while(i<2);}um.ap('070',umH);}};";
if($umaz) 
{
	$umjd[$j++]="umNav.prototype.ga=function(umL){um.ta=null;um.t=['span','img'];var k=0;do{um.lss=umL.getElementsByTagName(um.t[k]);um.lsl=um.lss.length;j=-1;while(++j<um.lsl){um.t8=um.es(um.lss[j].className);if(um.t8=='udmA'){um.ta=um.lss[j];break;}}}while(++k<2);return um.ta;};";
$umjd[$j++]="umNav.prototype.wp=function(umY,umS,umZ,umB,umW){umY.fn=arguments;if(umY.offsetHeight>0&&!um.o7){this.wpo(umY.fn[0],umY.fn[1],umY.fn[2],umY.fn[3],umY.fn[4]);}else{umY.c=0;umY.ti=window.setInterval(function(){if(umY.offsetHeight>0){clearInterval(umY.ti);um.n.wpo(umY.fn[0],umY.fn[1],umY.fn[2],umY.fn[3],umY.fn[4]);}else{umY.c++;if(umY.c>=100){clearInterval(umY.ti);}}},55);}return true;};";
$umjd[$j++]="umNav.prototype.wpo=function(umY,umS,umZ,umB,umW){um.t2=um.gc(umS);um.t4=[umY.offsetWidth,umY.offsetHeight];umY.style.marginTop=um.pi(((um.t2.offsetHeight-um.t4[1])/2)-umB)+'px';um.t2.style[(um.a||um.rtl)?'paddingLeft':'paddingRight']=((umZ*2)+um.t4[0])+'px';if(um.wie&&um.rtl){umY.style.marginRight=((umW)?(0-um.e[26]):(0-um.e[70]))+'px';}if(((um.wie50&&um.a)||(um.wie55&&um.rtl))&&umW&&um.h){umY.style.top=(umB)+'px';umY.style.left=(umB)+'px';}if((umW&&um.ni)||(!umW&&um.mi)){um.ak=((umW)?um.e[47]:um.e[91]);if((um.t4[0]-um.ak)<0){um.ak=um.t4[0];}umY.style.clip=(um.a||um.rtl)?'rect(0,'+um.ak+'px,'+um.t4[1]+'px,0)':'rect(0,'+um.t4[0]+'px,'+um.t4[1]+'px,'+(um.t4[0]-um.ak)+'px)';}um.xv(umY);return true;};";
$umjd[$j++]="umNav.prototype.wv=function(umX,umW){if(um.nr){return false;}um.ta=this.ga(umX);if(um.ta!=null){um.t8=um.es(umX.className);um.io=(um.t8.indexOf('udmR')==-1);if(um.t8.indexOf('udmY')!=-1){um.io=0;}um.t7=um.es(um.gp(umX).className);um.tm=(um.s||um.k)?um.ta.firstChild:um.ta;um.tm.src=um.baseSRC+((umW)?(um.io)?um.e[45]:um.e[46]:(typeof um.w[um.t7]!=um.un)?(um.io)?um.w[um.t7][23]:um.w[um.t7][24]:(um.io)?um.e[89]:um.e[90]);}return um.ta;};";
}
$umjd[$j++]="umNav.prototype.pu=function(umU){umU.style.height='auto';umU.style.overflow='visible';um.is=(um.ne(umU.parentNode));um.t=umU.parentNode;um.pp={tw:um.t.offsetWidth,th:um.t.offsetHeight,mw:umU.offsetWidth,pw:(um.is)?um.gc(um.t).offsetWidth:um.t.parentNode.offsetWidth};um.x=(um.p)?2000:0;um.y=(um.p)?2000:0;if(!((um.h||um.p)&&um.is)){um.x=(um.is)?(um.a?(0-um.pp.mw):um.pp.pw):((um.a?(0-um.pp.mw):um.pp.pw)-um.e[51]-um.e[55]);um.y=(0-um.pp.th);}else if(um.h&&um.is&&um.a){um.x=(0-um.pp.mw+um.pp.tw);}um.x+=(um.is)?(um.a?(0-um.e[14]):um.e[14]):(um.a?(0-um.e[49]):um.e[49]);um.y+=(um.is)?(um.e[2]=='bottom')?(0-um.e[15]):um.e[15]:um.e[50];if(um.is){if(um.h){if(um.e[2]=='bottom'){um.y-=(umU.offsetHeight+um.pp.th);}if(um.s){if(um.nc&&!um.a){um.x-=um.e[18];}if(!um.s1&&um.rp){um.x+=um.getRealPosition(um.tr,'x');um.y+=um.getRealPosition(um.tr,'y');}}if(um.mie){um.x-=um.gc(um.t).offsetWidth;if(um.nc&&um.a&&!um.mx){um.x+=um.e[18];}um.y+=um.pp.th;}if(um.ie&&!um.mx&&um.hstrip[1]=='yes'){um.y-=um.e[17];}}else if(um.ie&&um.nc){um.y-=um.e[18];}}umU.style.marginLeft=um.x+'px';umU.style.marginTop=um.y+'px';if(!um.p||!um.is){umU.style.left='auto';umU.style.top='auto';}if(um.wie50){um.xn(umU);um.xd(umU);}};";
if($um['behaviors'][2]=='yes') 
{
	$umjd[$j++]="umNav.prototype.ru=function(umU,umS){um.t8=um.es(umU.className);if(/nomove/.test(um.t8)){return false;}um.wz=um.getWindowDimensions();um.mp={x:um.getRealPosition(umU,'x'),y:um.getRealPosition(umU,'y'),w:umU.offsetWidth,h:umU.offsetHeight,pw:umU.parentNode.parentNode.offsetWidth,m:32,nx:-1,ny:-1,sc:um.getScrollAmount(),scx:um.getScrollAmount(1)};if(um.wie50&&um.rtl){um.mp.x-=um.m.body.clientWidth;}if(typeof um.scr!=um.un){um.mp.h=scr.gmh(umU);}um.is=(um.ne(umU.parentNode));if(um.s){um.mp.x-=um.m.body.offsetLeft;um.mp.y-=um.m.body.offsetTop;}else if(um.mie){um.t=um.e[55]+um.e[51];um.mp.x-=um.t;um.mp.y-=um.t;}else{um.t=umU;while(!um.ne(um.t.parentNode)){um.mp.x+=um.e[51];um.mp.y+=um.e[51];um.t=um.t.parentNode.parentNode;}}if(!um.ie&&um.e[3]=='fixed'&&um.is){um.mp.x+=um.mp.scx;um.mp.y+=um.mp.sc;}um.t=[(um.mp.x+um.mp.w),(um.wz.x-um.mp.m+um.mp.scx)];if(um.t[0]>um.t[1]){if(um.is){um.mp.nx=(((um.p)?um.mp.x:0)-(um.t[0]-um.t[1]));}else{um.mp.nx=(((um.p)?(0-um.mp.w-um.mp.pw+um.e[55]-um.e[49]):(0-um.mp.w-um.e[55]-um.e[51]))-um.e[49]);}}if(um.mp.x<0){if(!um.is){um.mp.nx=(0-um.e[55]-um.e[51]+um.mp.pw+um.e[49]);}}um.yd=(um.mp.y+um.mp.h)-(um.wz.y-um.mp.m+um.mp.sc);if(um.f&&!um.is){um.yd+=um.mp.sc;}if(um.yd>0){um.t=umU.parentNode;um.y=um.getRealPosition(um.t,'y');while(!um.ne(um.t)){um.y+=um.e[51];um.t=um.t.parentNode.parentNode;}um.mp.ny=(0-um.y-(um.mp.m*2)+um.wz.y+um.mp.sc-um.mp.h);if(um.f){um.mp.ny-=um.mp.sc;}}if(um.mp.y<0){um.mp.ny=(0-(0-um.mp.y));}if(um.mp.nx!=-1){if(um.p){umU.style.left=um.mp.nx+'px';}else{umU.style.marginLeft=um.mp.nx+'px';}um.ap('110',umU);}if(um.mp.ny!=-1){if(um.p&&um.ne(umU.parentNode)){umU.style.marginTop=(2000-um.yd)+'px';}else{umU.style.marginTop=um.mp.ny+'px';}um.ap('120',umU);}um.t=umU;um.y=(um.pi(umU.style.marginTop)+umU.parentNode.offsetHeight+um.getRealPosition(umU.parentNode,'y'))-um.mp.sc;while(!um.ne(um.t.parentNode)){um.y+=um.e[51];um.t=um.t.parentNode.parentNode;}if(um.f){um.y+=um.mp.sc;}if(um.y<0){um.mp.ny=um.pi(umU.style.marginTop);if(isNaN(um.mp.ny)){um.mp.ny=0;}umU.style.marginTop=(um.mp.ny-um.y)+'px';}um.t=umU;um.x=um.getRealPosition(um.t,'x')-um.mp.scx;while(!um.ne(um.t.parentNode)){um.x+=um.e[51];um.t=um.t.parentNode.parentNode;}if(um.x<0){umU.style.marginLeft=(um.p&&um.ne(umU.parentNode))?'2000px':(um.mp.scx>0?0-um.x:0)+'px';umU.style.left='0';}return true;};";
}
if($umds) 
{
	$umjd[$j++]="umNav.prototype.hl=function(umH){um.at={'class':'udmS'};um.sh=umH.parentNode.appendChild(um.createElement('span',um.at));um.cn=um.es(umH.className);if(um.cn!=''){if(typeof um.v[um.cn]!=um.un){if(um.sh.className.indexOf(um.cn)==-1){um.sh.className+=' '+um.cn;}}}um.sh.style.width=umH.offsetWidth+'px';um.hh=umH.offsetHeight;if(typeof um.scr!=um.un){um.hh=scr.gmh(umH);}um.sh.style.height=um.hh+'px';um.mp={x:(umH.offsetLeft),y:(umH.offsetTop)};um.is=um.ne(um.sh.parentNode);if(um.s&&!um.s1&&!um.is){um.mp.x-=um.e[51];um.mp.y-=um.e[51];}um.sh.style.left=um.mp.x+'px';um.sh.style.top=um.mp.y+'px';return um.sh;};";
}
if($umif) 
{
	$umjd[$j++]="umNav.prototype.il=function(umH){um.at={'class':'udmC', 'src':'javascript:false;'};um.co=umH.parentNode.appendChild(um.createElement('iframe',um.at));um.co.tabIndex='-1';um.co.style.width=umH.offsetWidth+'px';um.co.style.height=(typeof um.scr!=um.un?scr.gmh(umH):umH.offsetHeight)+'px';um.co.style.left=umH.offsetLeft+'px';um.co.style.top=umH.offsetTop+'px';return um.co;};";
}
if($umrw) 
{
	$umjd[$j++]="umNav.prototype.dw=function(umA){um.rw+=umA.offsetWidth;if(um.nc){um.rw-=um.e[18];}else{um.rw+=um.e[17];}};";
$umjd[$j++]="umNav.prototype.aw=function(){if(um.o7||um.mie||um.q){if(um.mx){um.rw+=um.pi(document.defaultView.getComputedStyle(um.tr,'').paddingLeft);}else{um.rw+=(um.gp(um.gc(um.tr)).offsetLeft+um.getRealPosition(um.tr,'x'));}}if(um.mie||um.og){um.rw*=1.05;}if(um.getWindowDimensions().x<um.rw){um.tr.style.width=um.rw+'px';}else{if(um.wie50){um.tr.style.setExpression('width','document.body.clientWidth');}else{um.tr.style.width='100%';}}if(um.mie){um.tr.style.height=um.gc(um.tr).offsetHeight+'px';}};";
}
if($umhz) 
{
	$umjd[$j++]="umNav.prototype.ts=function(umZ){um.se=um.m.getElementsByTagName('select');um.sl=um.se.length;if(um.sl>0){i=0;do{um.se[i++].style.visibility=umZ;}while(i<um.sl);um.ap((umZ=='hidden')?'067':'077',um.se);}};";
}
$umjd[$j++]="umNav.prototype.ws=function(){clearInterval(um.vs);um.ch=um.gc(um.tr).offsetHeight;um.cz=um.getWindowDimensions();if((um.ch!=um.lh&&um.reset[2]!='no')||((um.cz.x!=um.lw.x||um.cz.y!=um.lw.y)&&um.reset[1]!='no')){um.closeAllMenus();";
if($umrw) 
{
	$umjd[$j++]="if(um.rg){um.rw=0;um.kn=um.tr.childNodes;um.kl=um.kn.length;i=0;do{if(um.kn[i].nodeName!='#text'){this.dw(um.kn[i]);}i++;}while(i<um.kl);this.aw();}";
}
$umjd[$j++]="um.lw=um.cz;um.lh=um.ch;if(um.og&&um.hstrip[0]!='none'){um.tr.style.height=(um.hstrip[1]=='yes')?(um.lh+um.e[17])+'px':um.lh+'px';}}um.vs=setInterval('um.n.ws()',55);};um.qc=function(umLH){if(um.reset[3]=='yes'&&umLH!=''&&umLH!=um.jv){um.closeAllMenus();}};";
$umjd[$j++]="um.vn=function(umNN){return umNN.replace(/html[:]+/,'');};um.es=function(umCM){return umCM==null?'':umCM;};um.gt=function(umRT,umTG,umCE){if(!umCE){umCE=[];}for(var i=0;i<umRT.childNodes.length;i++){if(umRT.childNodes[i].nodeName.toUpperCase()==umTG.toUpperCase()||umTG=='*'){umCE[umCE.length]=umRT.childNodes[i];}umCE=um.gt(umRT.childNodes[i],umTG,umCE);}return umCE;};um.gc=function(umRA){return umRA.getElementsByTagName('a')[0];};um.gu=function(umE){return umE.getElementsByTagName('ul');};um.gm=function(umE){um.mu=null;um.mn=umE.childNodes;um.ml=um.mn.length;i=0;do{um.nn=um.vn(um.mn[i].nodeName).toLowerCase();if(um.nn=='ul'){um.mu=um.mn[i];break;}i++;}while(i<um.ml);return um.mu;};um.cm=function(e){if(!e){e=window.event;}if(!um.tr.contains(e.srcElement||e.target)||e.keyCode){um.closeAllMenus();}};";
$umjd[$j++]="um.closeAllMenus=function(){um.n.cd(um.tr);um.n.ck(um.tr);um.ha=0;};um.getWindowDimensions=function(){if(typeof window.innerWidth!=um.un){um.wz={x:window.innerWidth,y:window.innerHeight};}else if(um.q){um.wz={x:um.m.body.clientWidth,y:um.m.body.clientHeight};}else{um.wz={x:um.m.documentElement.offsetWidth,y:um.m.documentElement.offsetHeight};}return um.wz;};um.getScrollAmount=function(umDR){return ((typeof umDR==um.un||!umDR)?(typeof window.pageYOffset!=um.un?window.pageYOffset:um.q?um.m.body.scrollTop:um.m.documentElement.scrollTop):(typeof window.pageXOffset!=um.un?window.pageXOffset:um.q?um.m.body.scrollLeft:um.m.documentElement.scrollLeft));};um.getRealPosition=function(umE,umX){um.ps=(umX=='x')?umE.offsetLeft:umE.offsetTop;um.te=umE.offsetParent;while(um.te!=null){um.ps+=(umX=='x')?um.te.offsetLeft:um.te.offsetTop;um.te=um.te.offsetParent;}return um.ps;};";
if($um['orientation'][0]=='popup') 
{
	$umjd[$j++]="um.activateMenu=function(umNI,umXP,umYP){var umVN=um.gd(umNI);if(umVN!=null&&!um.rtl){um.vm=um.gm(umVN);if(um.vm!=null){um.cf=um.n.cck();if(um.cf){um.n.cd(umVN);um.n.pr(um.vm,umVN,0);um.vm.style.left=umXP;um.vm.style.top=umYP;}}}};um.deactivateMenu=function(umNI){var umVN=um.gd(umNI);if(umVN!=null&&!um.rtl){um.n.cp(um.gm(umVN),umVN);}};";
}

//finish compiling dom script
//*************************************************************//
//*************************************************************//



//set private cache control
header("Cache-Control: private");

//send javascript mime-type header
header("Content-Type: text/javascript");

//output copyright notice
echo("/* UDMv4.4 */\n/***************************************************************\\\n\n  ULTIMATE DROP DOWN MENU Version 4.4 by Brothercake\n  http://www.udm4.com/\n\n  This script may not be used or distributed without license\n\n\\***************************************************************/\n");

//output core javascript
echo($umjs);

//output lines of DOM script
foreach($umjd as $umv) { echo($umv); }

?>