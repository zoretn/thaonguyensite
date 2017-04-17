<?php
//date_default_timezone_set('Asia/Jakarta');
function timetostring ($time) {
	/*
	0: dd/mm/yyyy
	1: mm/dd/yyyy
	*/
	global $lang;
	$dayname[0] = "Chủ nhật";
	$dayname[1] = "Thứ hai";
	$dayname[2] = "Thứ ba";
	$dayname[3] = "Thứ tư";
	$dayname[4] = "Thứ năm";
	$dayname[5] = "Thứ sáu";
	$dayname[6] = "Thứ bảy";

	if ($lang=="en") {
		$dayname[0] = "Sunday";
		$dayname[1] = "Monday";
		$dayname[2] = "Tuesday";
		$dayname[3] = "Wendsday";
		$dayname[4] = "Thursday";
		$dayname[5] = "Friday";
		$dayname[6] = "Saturday";
	}
	$info = getdate($time);
	$hour = $info['hours'];
	$minute = $info['minutes'];
	$result = "";
	$result .= $hour . ":" . $minute . " ";
	$indexwday = $info['wday'];
	$result .= $dayname[$indexwday] . ", ";
	if ($lang=="en") {	
		$result .= $info['mon'] . "/";	
		$result .= $info['mday'] . "/";
		$result .= $info['year'];
	}
	else {
		$result .= $info['mday'] . "/";
		$result .= $info['mon'] . "/";
		$result .= $info['year'];
	}
	return $result;
}
function parttotime ($day, $mon, $year, $hour=0, $minute=0, $second=0) {
	$result = mktime($hour,$minute,$second,$mon,$day,$year);
	return $result;
}
?>