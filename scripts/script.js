function validate_numeric(string) {
	var validFormatRegExp = /^\d*(\.\d+)?$/;
	var isValid = validFormatRegExp.test(string);
	return isValid;
}
function validate_alphanumericnospace(string) {
	var invalidCharactersRegExp = /[^a-z\d]/i;
	var isValid = !(invalidCharactersRegExp.test(string));
	return isValid;
}
function validate_email(email) {
	var validFormatRegExp = /^\w(\.?\w)*@\w(\.?[-\w])*\.[a-z]{2,4}$/i;
	var isValid = validFormatRegExp.test(email);
	return isValid;
}
function validate_date(day, month, year) {
	var isValid = true;
	var enteredDate = new Date();
	enteredDate.setFullYear(year, month, day);
	if (enteredDate.getDate() != day) isValid = false;
	return isValid;
}
function getradio(rad) {
	var val = "";
	if (rad) {
		if (rad.length==undefined){
			if (rad.checked) {
				val=rad.value;
			}
		} else {
			for (i=0;i<rad.length;i++) {
				if (rad[i].checked) {
					val=rad[i].value;
					break;
				}
			}
		}
	}
	return val;
}

function OpenConfirm(url, msg) {
	var w = window.confirm(msg);
	if (w) window.location.href=url;
}
function OpenLink(url, target) {
	if (target!=null && target!="") {
		if (target=="_blank") {
			window.open(url);
		} else {
			window.open(url, target);
		}
	} else {
		window.location.href=url;
	}
}

function CheckConfig(frm, msg) {
	if (frm.config_name.value.length==0) {
		alert("Config name is invalid!");
		frm.config_name.focus();
	} else {
		w = window.confirm(msg);
		if (w) frm.submit();
	}
}
function CheckPost(frm, msg) {
//	if (ste.viewSource) { ste.toggleSource(); }
//	document.getElementById(ste.id).value = ste.getContent();
//	if (stf.viewSource) { stf.toggleSource(); }
//	document.getElementById(stf.id).value = stf.getContent();
//	nicEditors.findEditor('intro').saveContent();
//	nicEditors.findEditor('content').saveContent();

	if (frm.title.value=="") {
		alert("Title is invalid!");
		frm.title.focus();
	} else {
		w = window.confirm(msg);
		if (w) frm.submit();
	}
}
function CheckPhoto(frm, msg) {
	if (frm.id.value=="" && frm.image.value.length==0) {
		alert("Browse an image!");
		frm.image.focus();
	} else {
		w = window.confirm(msg);
		if (w) frm.submit();
	}
}

function CheckUser(frm, msg) {
	if (frm.id.value=="" && frm.username.value.length==0) {
		alert("Vui lòng nhập Tên đăng nhập!");
		frm.username.focus();
	} else if (frm.fullname.value.length==0) {
		alert("Nhập Họ và Tên đầy đủ!");
		frm.fullname.focus();
	} else if (frm.password.value!="" && frm.password.value!=frm.repassword.value) {
		alert("Mật khẩu nhập lại không giống nhau!");
		frm.repassword.focus();
	} else {
		w = window.confirm(msg);
		if (w) frm.submit();
	}
}
function ResetForm(frm) {
	w = window.confirm("Reset form?");
	if (w) frm.reset();
}
function CheckContact(frm, msg) {
	if (frm.yourname.value.length==0) {
		alert("Enter your name!");
		frm.yourname.focus();
	} else if (frm.company.value.length==0) {
		alert("Enter your company!");
		frm.company.focus();
	} else if (frm.address.value.length==0) {
		alert("Enter your company\'s address!");
		frm.address.focus();
	} else if (frm.email.value.length==0 || !validate_email(frm.email.value)) {
		alert("Your email is invalid!");
		frm.email.focus();
	} else if (frm.content.value.length==0) {
		alert("Enter your content!");
		frm.content.focus();
	} else if (frm.numberrandom.value.length<6) {
		alert("Enter code below!");
		frm.numberrandom.focus();
	} else {
		w = window.confirm(msg);
		if (w) {
			frm.submit();
		}
	}
}
function ShowSub(div) {
//	var txt = $('#'+div).html().toString();
//	if (txt.length>6) $('#divSubMenu').html(txt);
//	var txt = document.getElementById(div).innerHTML.toString();
//	if (txt.length>6) document.getElementById('divSubMenu').innerHTML = txt;
	var txt = div.innerHTML;
	if (txt.length>6) divSubMenu.innerHTML = txt;
}
