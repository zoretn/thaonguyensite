// JavaScript Document
function checkemail (email) {
	if (email=="") {
		return false;
	}
	if (email.indexOf(" ")>-1) {
		return false;
	}
	if (email.indexOf("@")==-1) {
		return false;
	}
	var i=1;
	var slength=email.length;
	//Neu email la chuoi khong co dau .
	if (email.indexOf(".")==-1) {
		return false;
	}
	//Neu email la chuoi co 2 dau . gan nhau
	if (email.indexOf("..")!=-1) {
		return false;
	}
	//Neu email la chuoi co 2 dau @
	if (email.indexOf("@")!=email.lastIndexOf("@")) {
		return false;
	}
	//Neu email la chuoi co dau . cuoi cung
	if (email.lastIndexOf(".")==email.length-1) {
		return false;
	}
	//Neu email la chuoi co ky tu dau tien la so
	var strso="0123456789";
	if (strso.indexOf(email.charAt(0))!=-1) {
		return 0;
	}
	//Neu email la chuoi co ky tu khong thuoc cac ky tu sau:
	var str="abcdefghijklmnopqrstuvwxyz-@._0123456789";
	for (var j=0; j<email.length; j++) {
		if (str.indexOf(email.charAt(j))==-1) {
			return false;
		}
	}
	return true;
}
function CheckContact (frm) {
	if (frm.txthoten.value=="") {
		frm.txthoten.focus();
		return false;
	}
	if (frm.txtdienthoai.value=="") {
		frm.txtdienthoai.focus();
		return false;
	}
	if (frm.txtemail.value=="") {
		frm.txtemail.focus();
		return false;
	}
	if (checkemail(frm.txtemail.value)==false) {
		frm.txtemail.focus();
		return false;
	}
	if (frm.txtchude.value=="") {
		frm.txtchude.focus();
		return false;
	}
	if (frm.txtnoidung.value=="") {
		frm.txtnoidung.focus();
		return false;
	}
	return true;
}