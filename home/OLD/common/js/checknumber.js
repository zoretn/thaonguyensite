// JavaScript Document
function checkunsigned (txtnumber) {
	var val = txtnumber.value;
	if (checknumber(txtnumber)) {
		if (val>0)
			return true;
	}
	txtnumber.value = txtnumber.defaultValue;
	return false;
}
function checkunsignedInt (txtnumber) {
	var val = txtnumber.value;
	if (checknumberInt(txtnumber)) {
		if (val>0)
			return true;
	}
	txtnumber.value = txtnumber.defaultValue;
	return false;
}
function checknumber (txtnumber) {
	var inputStr = txtnumber.value;
	var ageEntry = parseFloat(inputStr)
	if (isNaN(ageEntry)) {
		return false;
	}
	return true;
}
function checknumberInt (txtnumber) {
	var inputStr = txtnumber.value;
	var ageEntry = parseInt(inputStr)
	if (isNaN(ageEntry)) {
		return false;
	}
	return true;
}