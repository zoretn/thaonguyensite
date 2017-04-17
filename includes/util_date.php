<?php
function formatDate($datestamp,$formatdate)
{
	$sDate = "";
	$tzoffset = 0;
	if ($datestamp == "0000-00-00") 
	{
		$datestamp = "0000-00-00 00:00:00";
	}
	@list($date,$time) = explode(" ",$datestamp);
	@list($year,$month,$day) = explode("-",$date);
	@list($hour,$minute,$second) = explode(":",$time);
	$hour = $hour + $tzoffset;


	$year_org = $year;
	if($year<=1971) $year=1971;
	
	$sDate =  str_replace("1971", $year_org , $sDate);
	$tstamp = mktime($hour,$minute,$second,$month,$day,$year);
	$sDate = date($formatdate,$tstamp);
	$sDate =  str_replace("1971", $year_org , $sDate);
	return $sDate;
}
function date_getyear($datestamp)
{
	$tzoffset = 0;
	if ($datestamp == "0000-00-00" || $datestamp == "0000-00-00 00:00:00") {
		$datestamp = date("Y-m-d")." 00:00:00";
	}
	list($date,$time) = explode(" ",$datestamp);
	list($year,$month,$day) = explode("-",$date);
	return $year;
}
function convert_date($datestamp,$dateconvert)
{
	$tzoffset = 0;
	if ($datestamp == "00000000") 
	{
		$datestamp = "00000000000000";
	}
	$date = substr($datestamp, 0, 8);
		$year	= substr($date, 0, 4);
		$month	= substr($date, 4, 2);
		$day	= substr($date, 6);
	$time = substr($datestamp, 8);
		$hour	= substr($time, 0, 2);
		$hour = $hour + $tzoffset;
		$minute	= substr($time, 2, 2);
		$second	= substr($time, 4);
	$tstamp = mktime($hour,$minute,$second,$month,$day,$year);
	$sDate = date($dateconvert,$tstamp);
	return $sDate;
}
function OptionDate($select_current,$year_begin,$year_end,$day_label,$month_label,$year_label)
{
	if($year_begin>$year_end) return false;
	if($select_current==1) $selected="selected";
	else $selected="";
	$today=getdate();
	$month = $today['mon']; 
	$mday = $today['mday']; 
	$year = $today['year']; 
	$strday="<select  name=\"$day_label\" class=input>";
	for($i=1;$i<=31;$i++)
	{
		if($i==$mday) $strday.="<option value=\"$i\" $selected>Ng� y $i</option>";
		else $strday.="<option value=\"$i\">Ng� y $i</option>";
	}
	$strday.="</select>";
	$strmonth="<select  name=\"$month_label\" class=input>";
	for($i=1;$i<=12;$i++)
	{
		if($i==$month) $strmonth.="<option value=\"$i\" $selected>tháng $i</option>";
		else $strmonth.="<option value=\"$i\">tháng $i</option>";
	}
	$strmonth.="</select>";
	$stryear="<select  name=\"$year_label\" class=input>";
	for($i=$year_begin;$i<=$year_end;$i++)
	{
		if($i==$year) $stryear.="<option value=\"$i\" $selected>năm $i</option>";
		else $stryear.="<option value=\"$i\">năm $i</option>";
	}
	$stryear.="</select>";
	return $strday.$strmonth.$stryear;
}
?>