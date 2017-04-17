<?php
defined("_ALLOW") or die ("Access denied");
?>
<?php
include_once("class/cmenu.php");
include_once("class/cmenuitem.php");

function showmenu($position, $style) {
	$objmenu = new menu;
	$ItemidMenu = -1;
	if (isset($_GET['Itemid'])) $ItemidMenu = $_GET['Itemid'];
	$strwhereoutmenu  = "position='$position' ";
	$strwhereoutmenu .= "AND (showin ='' OR showin = '$ItemidMenu' OR showin LIKE '{$ItemidMenu}#%' OR showin LIKE '%#{$ItemidMenu}#%' OR showin LIKE '%#{$ItemidMenu}')";
	$arraymenu = $objmenu->Fill($strwhereoutmenu);
	if (is_array($arraymenu)) {
?>
	<table cellspacing="0" cellpadding="0" border="0">
<?php
		if ($style==0) {
			echo "<tr>";
			foreach ($arraymenu as $objmenu) {
				echo "<td>";
				$objmenu->Out_TheHien();
				echo "</td>";
			}
			echo "</tr>";
		}
		else {
			foreach ($arraymenu as $objmenu) {
				echo "<tr><td>";
				$objmenu->Out_TheHien();
				echo "</td></tr>";
			}
		}
?>
	</table>
<?php
	}
}
?>