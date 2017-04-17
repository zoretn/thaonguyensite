<?php
defined("_ALLOW") or die ("Access denied");
?>
<?php
$header  = "index.php?module=com_frontpage";
global $lang;
global $maxwidthimage;
global $cfg_scale_widthproduct;
$catid = -1;
?>
<script language="javascript">
function GotoPage (page) {
	var url = "<?php echo $header; ?>";
	url = url + "&curPage=" + page;
	location.href = url;
}
</script>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>
			<!-----------------------GIOI THIEU-------------------->
<?php
include_once("class/cstaticcontent.php");
global $objstaticcontent;
$array = $objstaticcontent->Fill("tag LIKE '%home%'");

if (is_array($array)) {
	foreach ($array as $objstaticcontent)
		$objstaticcontent->Out_TheHien();
}
?>
		</td>
	</tr>
	<!----------------------PRODUCTS----------------------->
	<tr>
		<td>
			<?php
include_once("class/cproduct.php");
global $objproduct;
$strwhere = "tag LIKE '%home%'";
$array = $objproduct->Fill($strwhere, 12, 0);
if (is_array($array)) {
?>
			<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-image:url(images/banggt_07.jpg); background-repeat:repeat-y;">
				<tr>
					<td style="background-image:url(images/banggt_03.jpg); background-repeat:no-repeat;">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td style="font-family:tahoma; font-size:12px; font-weight:bold; color:#FF0000; padding-left:160px; padding-top:10px;">
						<?php if ($lang=="vn") echo "SẢN PHẨM ĐẶC TRƯNG"; else if($lang=="en") echo "Products"; else echo "精选产品"; ?>
					</td>
				</tr>
				<tr>
					<td style="padding-left:25px; padding-right:5px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
					<td class="td_listproduct_tt">
						 <?php
    global $maxRows;
    $maxRows = 10;
    global $maxPages;
    $maxPages = 5;
    global $totalRows;
    $totalRows = count($array);
    include_once("common/paging.php");
    $maxwidthimage = $cfg_scale_widthproduct;
    Paging_List_Content_TT($array,2);
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
		</td>
	</tr>
	<?php
}
?>
</table>
