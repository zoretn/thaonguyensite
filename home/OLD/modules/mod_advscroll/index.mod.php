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
    <table cellspacing="0" cellpadding="0" border="0">
    <?php
		foreach ($arrayadv as $objadv) {
		?>
        	<tr><td><?php $objadv->Out_TheHien(104); ?></td></tr>
        <?php
		}
	?>
    </table>
    <?php
	}
?>
</div>