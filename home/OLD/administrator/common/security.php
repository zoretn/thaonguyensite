<?php
defined("_ALLOW") or die ("Access denied");
function checkadmin () {
	if (isset($_SESSION['_idadmin'])) {
		$idadmin = $_SESSION['_idadmin'];
		if ($idadmin == "") return false;
		return true;
	}
	else
		return false;
}
function checksupper () {
	if (isset($_SESSION['supper'])) {
		if ($_SESSION['supper']==1) return true;
		return false;
	}
}
function checkpermission ($style, $value) {
	$checkadmin = checkadmin();
	if ($checkadmin == false) return false;
	if (isset($_SESSION['supper'])) {
		if ($_SESSION['supper']==1) return true;
	}
	$sgrant = $_SESSION["$style"];
	if (!is_array($sgrant)) {
		if ($sgrant==1) return true;
		return false;
	}
	$count = count($sgrant);
	for ($i=0; $i<$count; $i++)
		if ($sgrant[$i] == $value) return true;
	return false;
}
?>