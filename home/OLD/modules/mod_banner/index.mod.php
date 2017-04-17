<?php
defined("_ALLOW") or die ("Access denied");
?>
<?php
include_once("class/cbanner.php");
global $objbanner;
if ($strwhere != "") $strwhere .= " AND ";
$strwhere .= "active=1";
$arraybanner = $objbanner->Fill($strwhere);
if (is_array($arraybanner)) {
	$count = count($arraybanner);
	$randombanner = rand(0,$count-1);
	global $cfg_widthbanner;
	$arraybanner[$randombanner]->Out_TheHien($cfg_widthbanner);
}
?>