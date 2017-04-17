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
include_once("class/cadv.php");
global $objadv;
$arrayadv = $objadv->Fill($strwhere);
if (is_array($arrayadv)) {
?>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<?php
	global $cfg_scale_widthadv;
	foreach ($arrayadv as $objadv) {
		echo "<tr><td align='center'>";
		$objadv->Out_TheHien($cfg_scale_widthadv);
		echo "</td></tr>";
	}
?>
</table>
<?php
}
?>
</div>