<?php
defined("_ALLOW") or die ("Access denied");
global $lang;
global $cfg_yahoo;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td class="titlemodule" >
<?php
if ($lang=="vn") echo $moduletitle;
else echo $moduletitle_en;
?>
</td></tr>
<tr><td class="mainmodule" align="center" style="padding-bottom:10px; padding-top:10px;">
<?php
include_once("class/cadmin.php");
global $objadmin;
$arrayadmin = $objadmin->Fill("ym <> ''");
if (is_array($arrayadmin)) {
	?>
   <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <?php
	foreach ($arrayadmin as $objadmin) {
		?>
        <tr><td align="center" class="ht">
        <a href="ymsgr:sendIM?<?php echo $objadmin->ym; ?>">
        <img src="http://mail.opi.yahoo.com/online?u=<?php echo $objadmin->ym; ?>&m=g&t=2" />
        <br /><?php echo $objadmin->fullname; ?>
        </a>
        </td></tr>
        <?php
	}
	?>
    </table>
    <?php
}
?>
</td></tr>
</table>