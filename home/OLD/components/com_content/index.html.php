<?php
defined("_ALLOW") or die ("Access denied");
$task = $_GET['task'];
include_once("class/ccontent.php");
include_once("class/ccategory.php");
global $objcategory;
global $objcontent;
global $lang;
$urlpaging = "";
$urlpaging  = "index.php?module=com_content&task=blogcategory";
if ($task=="blogcategory") {
	$catid = $_GET['id'];
	$urlpaging .= "&id=" . $catid;
}
else if ($task=="view") {
	$id =$_GET['id'];
	$objcontent = $objcontent->Doc($id);
	$catid = $objcontent->catid;
}
else {
	$urlpaging  = "index.php?module=com_content&task=blogsection";
	$sid = $_GET['id'];
	$urlpaging .= "&id=" . $sid;
}
if (isset($_GET['Itemid'])) {
	$itemid = $_GET['Itemid'];
	$urlpaging .= "&Itemid=$itemid";
}
?>
<script language="javascript">
var url = "<?php echo $urlpaging; ?>";
function GotoPage (page) {
	var urltopage;
	urltopage = url + "&curPage=" + page;
	location.href = urltopage;
//	Ajax_Goto(url);
}
</script>
<?php
global $maxwidthimage;
global $cfg_scale_width;
switch ($task) {
	case "view":
		global $cfg_full_width;
		$maxwidthimage = $cfg_full_width;
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-image:url(images/banggt_07.jpg); background-repeat:repeat-y;">
	<tr>
		<td style="background-image:url(images/banggt_03.jpg); background-repeat:no-repeat;">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td style="font-family:tahoma; font-size:12px; font-weight:bold; color:#FF0000; padding-left:160px; padding-top:10px;">
						<?php
	$objcategory = $objcategory->Doc($catid);
	echo $objcategory->Get_Title();
?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo $objcontent->Out_TheHien($maxwidthimage); ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="background-image:url(images/banggt_10.jpg); background-repeat:no-repeat;" height="21">
		</td>
	</tr>
</table>
<?php
$ttime = $objcontent->ttime;
global $lang;
global $totalRows;
$maxRows = 10;
$idcontent = $objcontent->id;
/////////Các tin đã đưa//////////////////
$strwhere = "catid=$catid AND time < '$ttime' AND id <> $idcontent";
$totalRows = $objcontent->CountFill($strwhere);
if ($totalRows > 0) {
?>
<div class="title_list_foot"><?php if ($lang=="vn") echo "Các tin đã đưa"; else if($lang=='en') echo "Older news";else echo "其他新闻" ?></div>
<div class="td_listcontent_foot">
  <?php
	$begin = $totalRows - $maxRows;
	if ($begin < 0) $begin = 0;
	$array = $objcontent->Fill($strwhere, $maxRows, $begin);
	include_once("common/paging.php");
	$maxwidthimage = $cfg_scale_width;
	Paging_content_foot($array, 1);
?>
</div>
<?php
}
////////////Các tin khác/////////////////////////
$strwhere = "catid=$catid AND time >= '$ttime' AND id <> $idcontent";
$totalRows = $objcontent->CountFill($strwhere);
if ($totalRows > 0) {
?>
<div class="title_list_foot"><?php if ($lang=="vn") echo "Các tin khác"; else if ($lang=='en') echo "Later news";else echo "其他新闻" ?></div>
<div class="td_listcontent_foot">
  <?php
	$begin = $totalRows - $maxRows;
	if ($begin < 0) $begin = 0;
	$array = $objcontent->Fill($strwhere, $maxRows, $begin);
	include_once("common/paging.php");
	$maxwidthimage = $cfg_scale_width;
	Paging_content_foot($array, 1);
?>
</div>
<?php
}
		break;
	case "blogcategory":
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-image:url(images/banggt_07.jpg); background-repeat:repeat-y;">
	<tr>
		<td style="background-image:url(images/banggt_03.jpg); background-repeat:no-repeat;">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td style="font-family:tahoma; font-size:12px; font-weight:bold; color:#FF0000; padding-left:160px; padding-top:10px;">
						<?php
	$objcategory = $objcategory->Doc($catid);
	echo $objcategory->Get_Title();
?>
					</td>
				</tr>
				<tr>
					<td>
						<?php
	global $totalRows;
  	$totalRows = $objcontent->CountFill("catid=" . $catid);
	if ($totalRows > 0) {
		$pagingcolumns = 1;
		global $maxRows;
		$maxRows = 6;
		global $maxPages;
		$maxPages = 20;
		include_once("common/paging.php");
		global $curPage;
		$paging = Paging_GetPaging();
		$beginrow = ($curPage-1) * $maxRows;
		$array = $objcontent->Doc_danh_sach($catid, $maxRows, $beginrow);
		$maxwidthimage = $cfg_scale_width;
		Paging_List_Content_TT ($array, $pagingcolumns);
		echo $paging;
	}
  ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="background-image:url(images/banggt_10.jpg); background-repeat:no-repeat;" height="21">
		</td>
	</tr>
</table>
<?php
		break;
	case "blogsection":
?>
<div class="title_category">
<?php
	include_once("class/csection.php");
	global $objsection;
	$objsection = $objsection->Doc($sid);
	$objsection->Out_Title_Link();
?>
</div>
<div class="td_listcontent_tt">
  <?php
	global $totalRows;
  	$totalRows = $objcontent->CountFill("sid=" . $sid);
	if ($totalRows > 0) {
		$pagingcolumns = 1;
		global $maxRows;
		$maxRows = 10;
		global $maxPages;
		$maxPages = 5;
		include_once("common/paging.php");
		global $curPage;
		$paging = Paging_GetPaging();
		$beginrow = ($curPage-1) * $maxRows;
		$array = $objcontent->Fill("sid=" . $sid, $maxRows, $beginrow);
		$maxwidthimage = $cfg_scale_width;
		Paging_List_Content_TT ($array, $pagingcolumns);
		echo $paging;
	}
  ?>
</div>
<?php
	default:
		die("Address Fail");
}
?>