<!-- Original:  David Sosnowski (support@codelifter.com) -->
<!-- Web Site:  http://www.codelifter.com -->

<!-- This script and many more are available free online at -->
<!-- The JavaScript Source!! http://javascript.internet.com -->

<!-- Begin
// set the popup window width and height

var windowW = 214;  // wide
var windowH = 300;  // high

// set vertical offset if you want the popup
// to rise above or stop below screen bottom;

var Yoffset = 0;   // in pixels, negative values allowed

// set the vertical motion parameters

var windowStep = 2; // move increment (pixels)
var moveSpeed = 10; // move speed (larger is slower)

// set the horizontal positioning of the window
// choices are left, center, right

Xmode = "right";

// in left or right Xmode, set any offset from
// the screen edge here, if desired

Xoffset = 35;

// set the url of the page to show in the popup
var urlPop = "consant.php"

// set the title of the page

var title =  "This Is A Frameless Peeker";

// set this to true if the popup should close
// upon leaving the launching page; else, false

var autoclose = true;

// ============================
// do not edit below this line
// ============================

var windowX = (screen.width/2)-(windowW/2);
if (Xmode=="left") windowX=0+Xoffset;
if (Xmode=="right") windowX=screen.availWidth-Xoffset-windowW;
var windowY = (screen.availHeight);
var windowYstop = windowY-windowH-Yoffset;
var windowYnow = windowY;

s = "width="+windowW+",height="+windowH;
var beIE = document.all?true:false
function openPeeker() {
if (beIE) {
PFW = window.open("","popFrameless","fullscreen,"+s);
PFW.blur();
window.focus();
PFW.resizeTo(windowW,windowH);
PFW.moveTo(windowX,windowY);
var frameString=""+
"<html>"+
"<head>"+
"<title>"+title+"</title>"+
"</head>"+
"<frameset rows='*,0' framespacing=0 border=0 frameborder=0>"+
"<frame name='top' src='"+urlPop+"' scrolling=auto>"+
"<frame name='bottom' src='about:blank' scrolling='no'>"+
"</frameset>"+
"</html>"
PFW.document.open();
PFW.document.write(frameString);
PFW.document.close();
}
else {
PFW=window.open(urlPop,"popFrameless","scrollbars,"+s);
PFW.blur();
window.focus(); 
PFW.resizeTo(windowW,windowH);
PFW.moveTo(windowX,windowY);
}
PFW.focus();
if (autoclose) {
window.onunload = function(){PFW.close()}
}
movePFW();
}
function movePFW() {
if (document.all) {
if (windowYnow>=windowYstop) {
PFW.moveTo(windowX,windowYnow);
PFW.focus();
windowYnow=windowYnow-windowStep;
timer=setTimeout("movePFW()",moveSpeed);
}
else {
clearTimeout(timer);
PFW.moveTo(windowX,windowYstop);
PFW.focus();
   }
}
else {
PFW.moveTo(windowX,windowYstop);
   }
}
//  End -->
