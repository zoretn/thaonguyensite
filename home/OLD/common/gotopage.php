<?php
defined("_ALLOW") or die ("Access denied");
?>
<?php
$header = "";
/*
$header .= $cfg_live_site;
if ($paramadmin==1)
	$header .= "administrator/";
*/
$option = 0;
$header  = "index.php";
if ($module != "") {
	$header .= "?module=" . $module;
	if (isset($_GET['task'])) {
		$task = $_GET['task'];
		if ($task == "view") $task = "blogcategory";
		$header .= "&task=$task";
	}
	if (isset($_GET['Itemid'])) {
		$itemid = $_GET['Itemid'];
		$header .= "&Itemid=$itemid";
	}
	if (isset($_GET['id']) || isset($_GET['showitem'])) {
		$header .= "&showitem=0";
	}
}
?>
<script language="javascript">
function GotoPage (page="") {
	var url = "<?php echo $header; ?>";
	if (page!="") url = url + "&curPage=" + page;
	location.href = url;
}
</script>