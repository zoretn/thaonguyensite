<?php
defined("_ALLOW") or die ("Access denied");
global $lang;
?>
<?php if ($moduletitle . $moduletitle_en != "") { ?>
    <div class="titlemodule"><?php if ($lang=="vn") echo $moduletitle; else echo $moduletitle_en; ?>
    </div>
<?php } ?>
<div class="mainmodule">
<?php
	include_once("class/ccontent.php");
	global $objcontent;
	$array = $objcontent->Fill($strwhere,10);
	if (is_array($array)) {
		$count = count($array);
		?>	
		<marquee direction="up" scrolldelay="1" scrollamount="2" height="300" onmouseover="stop()" onmouseout="start()" >
		<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<?php
		for ($i=0; $i<$count && $i<10; $i++) {
			$objcontent = $array[$i];
			echo "<tr><td style='padding-top:10px;'>";
			$objcontent->Out_TheHien_Marquee();
			echo "</td></tr>";
		}
		?>
		</table>
		</marquee>
		<?php
	}
?>
</div>