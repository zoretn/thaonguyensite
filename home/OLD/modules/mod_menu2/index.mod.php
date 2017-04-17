<?php
defined("_ALLOW") or die ("Access denied");
?>
<?php
include_once("class/cmenu.php");
include_once("class/cmenuitem.php");
function showmenu2($position, $style, $cmThemeOffice, $ThemeOffice) {
	$objmenu = new menu;
	$ItemidMenu = -1;
	if (isset($_GET['Itemid'])) $ItemidMenu = $_GET['Itemid'];
	$strwhereoutmenu  = "position='$position' ";
	$strwhereoutmenu .= "AND (showin ='' OR showin LIKE '%#{$ItemidMenu}#%' )";
	$arraymenu = $objmenu->Fill($strwhereoutmenu);
	if (is_array($arraymenu)) {
?>
	<table cellspacing="0" cellpadding="0" border="0">
<?php
		if ($style==0) {
			echo "<tr>";
			foreach ($arraymenu as $objmenu) {
				$menuid = $objmenu->id;
				echo "<td id='myMenuID$menuid'>";
				$objmenu->Out_TheHien2($cmThemeOffice, $ThemeOffice);
				echo "</td>";
			}
			echo "</tr>";
		}
		else {
			foreach ($arraymenu as $objmenu) {
				$menuid = $objmenu->id;
				if ($objmenu->hidetitle == 0) {
					$titlemenu = $objmenu->Get_Title();
					echo "<tr><td class=\"title_menu\">$titlemenu</td></tr>";
				}
				echo "<tr><td id='myMenuID$menuid'>";
				$objmenu->Out_TheHien2($cmThemeOffice, $ThemeOffice);
				echo "</td></tr>";
			}
		}
//		echo $strwhereoutmenu;
?>
	</table>
<?php
	}
}
?>