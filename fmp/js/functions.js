var fcolor = "#333366";
var backcolor = "#CC0000";
var textcolor = "#ffffff";
var capcolor = "#ffffff";
var closecolor = "#CC0000";
var width = 235;
var border = "2";
var offsetx = 9;
var offsety = 9;
var x = 0;
var y = 0;
var snow = 0;
var sw = 0;
var cnt = 0;
var dir = 2; // 2 - Center; 1 - Right;  0 - Left;
var tr = 1;

var ns4, ie4, ie5, ns6, over;

function initTooltip(){
	ns4 = (document.layers)? true:false
	ie4 = (document.all)? true:false
	ns6 = (!document.all && document.getElementById)? true:false

// Microsoft Stupidity Check.
	if (ie4) {
		if (navigator.userAgent.indexOf('MSIE 5')>0 || navigator.userAgent.indexOf('MSIE 6')>0) {
			ie5 = true;
		} else {
			ie5 = false; }
	} else {
		ie5 = false;
	}

	if (ns4) over = document.overDiv
	if (ie4) over = overDiv.style
	if (ns6) over = document.getElementById('overDiv').style
	document.onmousemove = mouseMove;
	if (ns4) document.captureEvents(Event.MOUSEMOVE)

}

// Clears popups if appropriate
function nd() {
	if ( cnt >= 1 ) { sw = 0 };
	if ( sw == 0 ) {
		snow = 0;
		hideObject(over);
	} else {
		cnt++;
	}
}

// house summary
function complex(text) {
	var _container = '<table border="0" cellspacing="0" cellpadding="0">\r\n<tr>\r\n<td class="color1"><table width="100%" border="0" cellspacing="1" cellpadding="1">\r\n<tr>\r\n<td class="color2"><table width="100%" border="0" cellspacing="0" cellpadding="0">\r\n<tr>\r\n<td class="color7" width="8"><img src="images/1x1.gif" width="8" height="1"></td>\r\n<td style="padding:7px">';
	if (!text) {
		_container = '&nbsp;';
	} else {
		_container += text;
	}
	_container += '</td></tr></table></td>\r\n</tr>\r\n</table></td>\r\n</tr>\r\n</table>';
	layerWrite(_container);
	dir = 1;
	disp();
}


function complex2() {

var text  = '1) Click the "Add new page" button and follow the wizard instructions to generate html page for your form.When html code is generated you will be redirected back to this panel.<br><BR>';
    text += '2) If you need to have form data sent by email or just need to set up an autoresponder, click \"Add email template" button to create email template for your form. To send several different emails from one form simply create several email templates each with unique configuration you need.<br><br>'; 
    text += '3) If you need to store form data in the MySQL database, click "Add db template" button to create db template for your form. To store different data in several different tables simply create several db templates.<br><br>';
    text += '4) Your form will also require error template - the page that will be shown if for example user left some of required fields in the form blank. The error template is generated automatically by Form Maker Pro, however if you are familiar with HTML you can edit it to look and feel more like the rest of your site.<br><br>';
    text += '5) Click "Get package" button to download the zip archive with files package needed for correct work of your web form . Extract the zip archive to your computer and then simply upload these  files to your server following the "readme" file instructions (You will find this file in the downloaded zip archive)';

offsety =235;
	var _container = '<table width="600" border="0" cellspacing="0" cellpadding="0">\r\n<tr>\r\n<td class="color1"><table width="100%" border="0" cellspacing="1" cellpadding="1">\r\n<tr>\r\n<td class="color2"><table width="100%" border="0" cellspacing="0" cellpadding="0">\r\n<tr>\r\n<td class="color7" width="8"><img src="images/1x1.gif" width="8" height="1"></td>\r\n<td style="padding:7px">';
	if (!text) {
		_container = '&nbsp;';
	} else {
		_container += text;
	}
	_container += '</td></tr></table></td>\r\n</tr>\r\n</table></td>\r\n</tr>\r\n</table>';
	layerWrite(_container);
	dir = 1;
	disp();
}


function complex3() {

var text  = '1)	Add required amount of html pages. To add each new page click the "Add new page" button, and follow the wizard instructions. To arrange pages in the order you need, please set the "position" property for each page while adding it to the form. <br><BR>';
    text += '2)	Generate email templates and/or db templates in the same way as for simple one page form and download your package.<br>'; 

offsety =98;
	var _container = '<table width="600" border="0" cellspacing="0" cellpadding="0">\r\n<tr>\r\n<td class="color1"><table width="100%" border="0" cellspacing="1" cellpadding="1">\r\n<tr>\r\n<td class="color2"><table width="100%" border="0" cellspacing="0" cellpadding="0">\r\n<tr>\r\n<td class="color7" width="8"><img src="images/1x1.gif" width="8" height="1"></td>\r\n<td style="padding:7px">';
	if (!text) {
		_container = '&nbsp;';
	} else {
		_container += text;
	}
	_container += '</td></tr></table></td>\r\n</tr>\r\n</table></td>\r\n</tr>\r\n</table>';
	layerWrite(_container);
	dir = 1;
	disp();
}

// Common calls
function disp() {
	if (snow == 0) 	{
		if (dir == 2) { // Center
			moveTo(over,x+offsetx-(800/2),y+offsety);
		}
		if (dir == 1) { // Right
			moveTo(over,x+offsetx,y-offsety);
		}
		if (dir == 0) { // Left
			moveTo(over,x-offsetx-800,y+offsety);
		}
		showObject(over);
		snow = 1;
	}
}

// Moves the layer
function mouseMove(e) {
	if (ns4) {x=e.pageX; y=e.pageY;}
	if (ie4) {x=event.x; y=event.y;}
	if (ie5) {x=event.x+document.body.scrollLeft; y=event.y+document.body.scrollTop;}
	if (ns6) {x=e.pageX+10; y=e.pageY;}
	if (snow) {
		if (dir == 2) { // Center
			moveTo(over,x+offsetx-(800/2),y+offsety);
		}
		if (dir == 1) { // Right
			moveTo(over,x+offsetx,y-offsety);
		}
		if (dir == 0) { // Left
			moveTo(over,x-offsetx-800,y+offsety);
		}
	}
}

function cClick() {
	hideObject(over);
	sw=0;
}

function layerWrite(txt) {
    if (ns4) {
        var lyr = document.overDiv.document
        lyr.write(txt)
        lyr.close()
    }
    else if (ie4) {
		document.all["overDiv"].innerHTML = txt
	}
	else if (ns6) {
		document.getElementById("overDiv").innerHTML = txt
	}
}

function showObject(obj) {
    if (ns4) obj.visibility = "show"
    else if (ie4) obj.visibility = "visible"
	else if (ns6) obj.visibility = "visible";
}

function hideObject(obj) {
    if (ns4) obj.visibility = "hide"
    else if (ie4) obj.visibility = "hidden"
	else if (ns6) obj.visibility = "hidden";
}

function moveTo(obj,xL,yL) {
    obj.left = xL
    obj.top = yL
}