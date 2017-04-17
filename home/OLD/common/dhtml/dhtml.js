// JavaScript Document
var isNav4;
var isIE4;
var range = "";
var styleObj = "";
if (navigator.appVersion.charAt(0) == "4") {
	if (navigator.appName == "Netscape") {
		isNav4 = true;
	}
	else if (navigator.appVersion.indexOf("MSIE") != -1) {
		range = "all.";
		styleObj = ".style";
//		alert("IE");
		isIE4 = true;
	}
}

function XGetObj(objectName) {
	/*
	var theObj;
	if (typeof(objectName) == "string") {
		theObj = eval("document." + range + objectName + styleObj);
		if (isNav4) {
			theObj = eval("document." + objectName)
		}
		else {
			theObj = eval("document.all." + objectName)
		}
	}
	else
		theObj = objectName;
	return theObj;
	*/
	var e;
	if(typeof(objectName)!='string')
		return objectName;
	if(document.getElementById)
		e=document.getElementById(objectName);
	else if(document.all)
		e=document.all[objectName];
	else e=null;
	return e;	
}

function shiftTo(obj, x, y) {
	var theObj;
	theObj = XGetObj(obj);
	if (isNav4) {
		theObj.moveTo(x,y);
	}
	if (isIE4) {
		theObj.style.pixelLeft = x;
		theObj.style.pixelTop = y;
	}
}
function shiftBy(obj, deltaX, deltaY) {
	var theObj = XGetObj(obj)
	if (isNav4) {
		theObj.moveBy(deltaX, deltaY);
	}
	else {
		theObj.style.pixelLeft += deltaX;
		theObj.style.pixelTop += deltaY;
	}
}
function XShow(obj) {
	var theObj = XGetObj(obj);
	theObj.style.visibility = "visible";
}
function XHide(obj) {
	var theObj = XGetObj(obj);
	theObj.style.visibility = "hidden";
}
function getObjectLeft(obj) {
	var theObj = XGetObj(obj);
	if (isNav4) {
		return theObj.style.left;
	}
	else {
		return theObj.style.pixelLeft;
	}
}
function getObjectTop(obj) {
	var theObj = XGetObj(obj);
	if (isNav4) {
		return theObj.style.top;
	}
	else {
		return theObj.style.pixelTop;
	}
}