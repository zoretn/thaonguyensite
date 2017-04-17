self.onError=null;
currentX = currentY = 0; 
whichIt = null; 
lastScrollX = 0; lastScrollY = 0;
//NS = (document.layers) ? 1 : 0;
IE = (document.all) ? 1: 0;
NS = 1;
if (IE==1) NS = 0;

<!-- STALKER CODE -->
function xGetElementById(e){
	if(typeof(e)!='string')
		return e;
	if(document.getElementById)
		e=document.getElementById(e);
	else if(document.all)
		e=document.all[e];
	else e=null;
	return e;
}
function xLeft(e, iX){
	if(!(e=xGetElementById(e)))
		return 0;
	var css=xDef(e.style);
	if (css && xStr(e.style.left)) {
		if(xNum(iX))
			e.style.left=iX+'px';
		else {
			iX=parseInt(e.style.left);
			if(isNaN(iX))
				iX=0;
		}
	}
	else if(css && xDef(e.style.pixelLeft)) {
		if(xNum(iX))
			e.style.pixelLeft=iX;
		else
			iX=e.style.pixelLeft;
	}
	return iX;
}
function xTop(e, iY){
	if(!(e=xGetElementById(e)))
		return 0;
	var css=xDef(e.style);
	if(css && xStr(e.style.top)) {
		if(xNum(iY))
			e.style.top=iY+'px';
		else {
			iY=parseInt(e.style.top);
			if(isNaN(iY))
				iY=0;
		}
	}
	else if(css && xDef(e.style.pixelTop)) {
		if(xNum(iY))
			e.style.pixelTop=iY;
		else
			iY=e.style.pixelTop;
	}
	return iY;
}
function xMoveTo(e,x,y){
	xLeft(e,x);
	xTop(e,y);
}
function Scroll (arrayidobj) {
	var obj;
	var i, n;
	n = arrayidobj.length;
	obj = new Array();
	for (i=0; i<n; i++) {
		var id = arrayidobj[i] + "";
		obj[i] = xGetElementById(id);
	}
	if(IE) { 
		diffY = document.body.scrollTop; 
		diffX = 0; 
	}
	if(NS) {
		diffY = self.pageYOffset;
		diffX = self.pageXOffset;
//		alert ("diffY: " + diffY + ", diffX: " + diffX);
	}
	if(diffY != lastScrollY) {
		percent = 0.1 * (diffY - lastScrollY);
		if(percent > 0) percent = Math.ceil(percent);
		else
			percent = Math.floor(percent);
		if(IE) {
			for (i=0; i<n; i++)
				obj[i].style.pixelTop += percent;
		}
		if(NS) {
			for (i=0; i<n; i++)
				obj[i].style.top = lastScrollY + percent + "px";
				
		}
		lastScrollY = lastScrollY + percent;
	}
	if(diffX != lastScrollX) {
		percent = .1 * (diffX - lastScrollX);
		if(percent > 0)
			percent = Math.ceil(percent);
		else
			percent = Math.floor(percent);
		if(IE) {
			for (i=0; i<n; i++)
				obj[i].style.pixelLeft += percent;
		}
		if(NS) {
			for (i=0; i<n; i++)
				obj[i].style.pixelLeft = lastScrollX + percent + "px";
		}
		lastScrollY = lastScrollY + percent;
	} 
}
if(NS || IE) {	
	var arrayid = new Array();
	arrayid[0] = "advscroll_left";
	arrayid[1] = "advscroll_right";
	action = window.setInterval("Scroll(arrayid)",10);
}
function layerPos(layerName, Xx, widthSize) {
	var brandObj = document.getElementById(layerName); 	
	brandObj.style.left = Xx + Math.ceil((document.body.clientWidth - widthSize)/2);
}