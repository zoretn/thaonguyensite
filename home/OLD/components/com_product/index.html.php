<?php
defined("_ALLOW") or die ("Access denied");
$task = $_GET['task'];
include_once("class/cproduct.php");
include_once("class/cproductcategory.php");
global $objproductcategory;
global $objproduct;
global $lang;
$urlpaging = "";
$urlpaging  = "index.php?module=com_product&task=blogcategory";
if ($task=="blogcategory") {
	$catid = $_GET['id'];
	$urlpaging .= "&id=" . $catid;
}
else if ($task=="view") {
	$id =$_GET['id'];
	$objproduct = $objproduct->Doc($id);
	$catid = $objproduct->catid;
}
else {
	$urlpaging  = "index.php?module=com_product&task=blogsection";
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
global $cfg_scale_widthproduct;
switch ($task) {
	case "view":
		global $cfg_full_widthproduct;
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-image:url(images/banggt_07.jpg); background-repeat:repeat-y;">
	<tr>
		<td style="background-image:url(images/banggt_03.jpg); background-repeat:no-repeat;">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td style="font-family:tahoma; font-size:12px; font-weight:bold; color:#FF0000; padding-left:160px; padding-top:10px;">
			<?php
	$objproductcategory = $objproductcategory->Doc($catid);
	echo $objproductcategory->Get_Title();
?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo $objproduct->Out_TheHien($cfg_full_widthproduct); ?>
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
global $lang;
global $totalRows;
$maxRows = 100;
$idproduct = $objproduct->id;
$orderproduct = $objproduct->order;
/////////Các sản phẩm đã đưa//////////////////
$strwhere = "catid=$catid AND  id <> $idproduct";
$totalRows = $objproduct->CountFill($strwhere);
if ($totalRows > 0) {
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td class="title_list_foot">
			<?php if ($lang=="vn") echo "Các sản phẩm khác"; else if($lang=='en') echo "Other products";else echo "其他产品" ?>
		</td>
	</tr>
	<tr>
		<td style="padding-left:25px; padding-right:5px;">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td class="td_listproduct_foot">
			<?php
	$begin = $totalRows - $maxRows;
	if ($begin < 0) $begin = 0;
	$array = $objproduct->Fill($strwhere, $maxRows, $begin);
	include_once("common/paging.php");
	$maxwidthimage = $cfg_scale_widthproduct;
	Paging_content_foot($array, 2);
?>
		</td>
	</tr>
</table>
		</td>
	</tr>
</table>
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
	$objproductcategory = $objproductcategory->Doc($catid);
	echo $objproductcategory->Get_Title();
?>
		</td>
	</tr>
	<tr>
		<td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000000; text-align:justify; padding-top:40px; padding-bottom:10px; padding-left:40px; padding-right:10px;">
			<?php
				if($lang=='vn')echo "$objproductcategory->introtext";else echo "$objproductcategory->introtext_en";
			?>
		</td>
	</tr>
	<tr>
		<td style="padding-left:25px; padding-right:5px;">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
		<td class="td_listproduct_tt">
			<?php
	global $totalRows;
  	$totalRows = $objproduct->CountFill("catid=" . $catid);
	if ($totalRows > 0) {
		$pagingcolumns = 2;
		global $maxRows;
		$maxRows = 12;
		global $maxPages;
		$maxPages = 5;
		include_once("common/paging.php");
		global $curPage;
		$paging = Paging_GetPaging();
		$beginrow = ($curPage-1) * $maxRows;
		$array = $objproduct->Doc_danh_sach($catid, $maxRows, $beginrow);
		$maxwidthimage = $cfg_scale_widthproduct;
		Paging_List_Content_TT ($array, $pagingcolumns);
		echo $paging;
	}
  ?>
		</td>
	</tr>
			</table>
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
<div class="title_productcategory">
<?php
	include_once("class/cproductsection.php");
	global $objproductsection;
	$objproductsection = $objproductsection->Doc($sid);
	$objsection->Out_Title_Link();
?>
</div>
<div class="td_listproduct_tt">
  <?php
	global $totalRows;
  	$totalRows = $objcontent->CountFill("sid=" . $sid);
	if ($totalRows > 0) {
		$pagingcolumns = 2;
		global $maxRows;
		$maxRows = 12;
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