<?php
defined("_ALLOW") or die ("Access denied");
?>
<?php
include_once("class/cmenuitem.php");
function ShowPathItem ($id) {
	global $lang;
	if ($id<=0 || $id=="") {
		echo "<a href=\"index.php\">";
		echo ($lang=="vn")?"Trang chủ":"Home";
		echo "</a>";
	}
	else {
		global $objmenuitem;
		$tobjmenuitem = $objmenuitem->Doc($id);
		$parentid = $tobjmenuitem->parentid;
		ShowPathItem($parentid);
		if ($objmenuitem->url != "index.php") {
			echo "&nbsp;>>&nbsp;";
			$turl = $tobjmenuitem->Get_Url();
			if ($turl != "null") {
				echo "<a href=\"$turl\">";
			}
			echo $tobjmenuitem->Get_Title();
			if ($turl != "null") {
				echo "</a>";
			}
		}		
	}
}
$tItemid = 0;
if (isset($_GET['Itemid']))
	$tItemid = $_GET['Itemid'];
ShowPathItem($tItemid);
?>