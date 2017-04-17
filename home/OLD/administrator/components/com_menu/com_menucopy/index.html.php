<?php
defined( '_ALLOW' ) or die( 'Restricted access' );
checksupper() or die ("Access denied");

/**
* Writes the edit form for new and existing content item
*
* A new record is defined when <var>$row</var> is passed with the <var>id</var>
* property set to 0.
* @package Joomla
* @subpackage Menus
*/
$menuid = -1;
$menutitle = "";
$menutitle_en = "";
$menuurl = "index.php?module=com_contact";
$menumenutype = -1;
$currentid = -1;
if (isset($_GET['id'])) {
	$menuid = $_GET['id'];
	$currentid = $menuid;
	include_once ("../class/cmenuitem.php");
	$objmenuitem = $objmenuitem->Doc($menuid);
	$menutitle = $objmenuitem->title;
	
	$menutitle_en = $objmenuitem->title_en;
	
//	$menuurl = $objmenuitem->url;
	$menumenutype = $objmenuitem->menu;
}
else {
	$menumenutype = $_REQUEST['menu_menuitem'];
}
?>
		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>

<div align="center" class="centermain">
	<div class="main">
		<form action="index.php" method="post" name="adminForm">

		<table class="adminheading">
		<tr>
			<th>
			Copy Menu Items</th>
		</tr>
		</table>

		<table width="100%">
		<tr valign="top">
			<td width="60%">
				<table class="adminform">
				<tr>
					<th colspan="2">
					Copy	to	Menu:			</th>
				</tr>
				<tr>
					<td width="10%" align="right" valign="top">Menu</td>
					<td width="200"><select name="menu_menuitem" size="10" class="inputbox" id="menu_menuitem" >
                      <?php
					include_once ("../class/cmenu.php");
					$arraymenu = $objmenu->Doc_danh_sach();
					if (is_array($arraymenu)) {
						foreach ($arraymenu as $objmenu) {
					?>
                      <option value="<?php echo $objmenu->id; ?>" ><?php echo $objmenu->title; ?>(<?php echo $objmenu->describe; ?>)</option>
                      <?php
						}
					}
					else mosRedirect("index.php");
					?>
                    </select></td>
				  </tr>			
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
		  </table>			</td>
		  </tr>
		</table>

		<input type="hidden" name="boxchecked" value="1" />
        <input name="task" type="hidden" id="task">
		<input type="hidden" name="module" value="<?php echo $module;?>" />
        <?php
			$arraymenuitemid = $_REQUEST['cid'];
			foreach ($arraymenuitemid as $menuitemid) {
			?>
       	  <input name="menuitemid[]" type="hidden" value="<?php echo $menuitemid; ?>" />
            <?php
			}
		?>
		</form>
</div></div>