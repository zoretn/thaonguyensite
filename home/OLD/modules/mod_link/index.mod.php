<?php
defined("_ALLOW") or die ("Access denied");
global $lang;
global $cfg_yahoo;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr><td class="mainmodule" align="center" style="padding-bottom:10px; padding-top:10px;">
<?php
include_once("class/clink.php");
global $objlink;
$arraylink = $objlink->Fill($strwhere);
if (is_array($arraylink)) {
	?>
   <script type="text/JavaScript">
	function MM_jumpMenu(targ,selObj,restore){ //v3.0
		if (selObj.options[selObj.selectedIndex].value == -1) return;
		window.open(selObj.options[selObj.selectedIndex].value);
	  if (restore) selObj.selectedIndex=0;
	}
	//-->
	</script>
	
	<select name="listlink" size="1" class="list_area" style="width:135px; z-index:-1;" onchange="MM_jumpMenu('_blank',this,1)">
	<option value="-1"><?php if ($lang=="vn") echo "Chọn link"; else if($lang=='en') echo "Select link";else echo "選擇鏈接" ?></option>
	<?php
		foreach ($arraylink as $objlink) {
			$url = $objlink->Get_Url();
			$title = $objlink->Get_Title();
			?>
			<option value="<?php echo $url; ?>" ><?php echo $title; ?></option>
			<?php
		}
	?>
	</select>
	<?php
}
?>
</td></tr>
</table>