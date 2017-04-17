// Based on tmEdit v3.0 - Copyright (c) 2002-2004 interactivetools.com, inc., dynarch.com
// TMEdit - © Copyright 2004, 2005 thinkmambo.com
// Released under ThinMambo Free Software License (see TMEdit_license.txt)

function Dialog(url, action, init) {
	if (typeof init == "undefined") {
		init = window;
	}
	Dialog._geckoOpenModal(url, action, init);
};

Dialog._parentEvent = function(ev) {
	if (Dialog._modal && !Dialog._modal.closed) {
		setTimeout(function(){Dialog._modal.focus();}, 1);
		TMEdit._stopEvent(ev);
	}
};

Dialog._return = null;

Dialog._modal = null;

Dialog._arguments = null;

Dialog._geckoOpenModal = function(url, action, init) {
	var dlg = window.open(url, "hxtddialog", "toolbar=no,menubar=no,personalbar=no,width=10,height=10," + "scrollbars=no,resizable=yes,dependent=yes");
	Dialog._modal = dlg;
	Dialog._arguments = init;

	function capwin(w) {
		TMEdit._addEvent(w, "click", Dialog._parentEvent);
		TMEdit._addEvent(w, "mousedown", Dialog._parentEvent);
	};
	// release the captured events
	function relwin(w) {
		TMEdit._removeEvent(w, "click", Dialog._parentEvent);
		TMEdit._removeEvent(w, "mousedown", Dialog._parentEvent);
	};
	capwin(window);
	for (var i = 0; i < window.frames.length; capwin(window.frames[i++]));
	Dialog._return = function (val) {
		if (val && action) {
			action(val);
		}
		relwin(window);
		for (var i = 0; i < window.frames.length; relwin(window.frames[i++]));
		Dialog._modal = null;
	};
};
function openBox (winWidth, winHeight, scrollbars, toolbar, top, left, fileSrc) {
	var newParameter = "width = " + winWidth + ", height = " + winHeight;
	newParameter += ", scrollbars = " + scrollbars + ",toolbar = " + toolbar + ", top = " + top;
	newParameter += ",left = " + left;
	window.open (fileSrc,"a",newParameter);
};