<?php
defined("_ALLOW") or die ("Access denied");
isset($_GET['keyword']) or die ("Access denied");
global $lang;
?>
<?php
include_once("class/ccontent.php");
global $objcontent;
$keyword = $_GET['keyword'];
$prekeyword = $keyword;

$length = strlen($keyword);
for ($i=0; $i<$length; $i++) {
	$ctemp = $keyword[$i];
	if (!ctype_alnum($ctemp) && $ctemp != "*" && $ctemp != "'" && $ctemp != " ") $keyword[$i] = "_";
}
$keyword   = str_replace("*", '%', $keyword);
$keyword   = str_replace("'", '%', $keyword);
$strwhere = "";
$strwhere .= "(title) LIKE '%keyword%' COLLATE latin1_swedish_ci ";
$strwhere .= "OR (title_en) LIKE '%$keyword%' COLLATE latin1_swedish_ci ";
$strwhere .= "OR (introtext) LIKE '%$keyword%' COLLATE latin1_swedish_ci ";
$strwhere .= "OR (introtext_en) LIKE '%$keyword%' COLLATE latin1_swedish_ci ";
$strwhere .= "OR (full_text) LIKE '%$keyword%' COLLATE latin1_swedish_ci ";
$strwhere .= "OR (full_text_en) LIKE '%$keyword%' COLLATE latin1_swedish_ci ";
?>
<script language="javascript">
var keyword = "<?php echo $prekeyword; ?>";
var url = "index.php?module=com_search&keyword=" + keyword;
function GotoPage (page) {
	var urltopage;
	urltopage = url + "&curPage=" + page;
	location.href = urltopage;
//	Ajax_Goto(url);
}
</script>
<div class="title_category">
<?php
	if ($lang == "vn") echo "Kết quả tìm kiếm";
	else echo "Search Result";
?>
</div>
<div class="td_listcontent_tt">
<?php
//echo strtoupper($keyword);
global $totalRows;
$totalRows = $objcontent->CountFill($strwhere);
if ($totalRows > 0) {
	global $maxRows;
	$maxRows = 10;
	global $maxPages;
	$maxPages = 5;
	global $curPage;
	include_once("common/paging.php");
	$paging = Paging_GetPaging();
	$beginrow = ($curPage-1) * $maxRows;
	$array = $objcontent->Fill($strwhere, $maxRows, $beginrow);
	global $cfg_scale_width;
	global $maxwidthimage;
	$maxwidthimage = $cfg_scale_width;
	Paging_List_Content_TT ($array, 1);
	echo $paging;
}
else {
	echo "Not found";
}
?>
</div>