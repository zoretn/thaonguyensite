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
$menutitle_cn = "";
$describe = "";
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
	$menutitle_cn = $objmenuitem->title_cn;
	$describe = $objmenuitem->describe;
	
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
			<?php echo ($menuid > -1) ? 'Edit' : 'Add';?> Menu Item :: Component - Contact </th>
		</tr>
		</table>

		<table width="100%">
		<tr valign="top">
			<td width="60%">
				<table class="adminform">
				<tr>
					<th colspan="2">
					Details					</th>
				</tr>
				<tr>
					<td width="10%" align="right">Title</td>
					<td width="200px">
					<input name="title_menuitem" type="text" class="inputbox" id="title_menuitem" value="<?php echo $menutitle; ?>" size="30" maxlength="100" />					</td>
				  </tr>
				<tr>
					<td width="10%" align="right">Title (English)</td>
					<td width="200px">
					<input name="title_en_menuitem" type="text" class="inputbox" id="title_en_menuitem" value="<?php echo $menutitle_en; ?>" size="30" maxlength="100" />					</td>
				  </tr>
				  <tr>
					<td width="10%" align="right">Title (Chinese)</td>
					<td width="200px">
					<input name="title_cn_menuitem" type="text" class="inputbox" id="title_cn_menuitem" value="<?php echo $menutitle_cn; ?>" size="30" maxlength="100" />					</td>
				  </tr>
                  <tr>
				  <td>Describe</td>
				  <td colspan="2"><input name="describe_menuitem" type="text" class="text_area" id="describe_menuitem" value="<?php echo $describe; ?>" size="50" maxlength="255" /></td>
				  </tr>				
				<tr>
				  <td align="right" valign="top">Parent </td>
				  <td><select name="listparentid" size="10" class="inputbox" onchange="ChangeParentSublevel(this.value);">
				   <option value="0#-1" selected="selected">Top</option>
					<?php
					include_once("../class/cmenuitem.php");
					$arraylistparent = array();
					$objmenuitem->menu = $menumenutype;
					$objmenuitem->Get_ArraySubItem($arraylistparent, $currentid,"");
					if (is_array($arraylistparent)) {
						foreach ($arraylistparent as $objparentitem) {
							if (isset($objparentitem['title'])) {
						?>
						<option value="<?php echo $objparentitem['value']; ?>"><?php echo $objparentitem['title']; ?></option>
						<?php
							}
						}
					}
					?>
				    </select>
				    <input name="parentid_menuitem" type="hidden" id="parentid_menuitem" value="0" />				  
				    <input name="sublevel_menuitem" type="hidden" id="sublevel_menuitem" value="0" /></td>
				  </tr>
				<tr>
					<td align="right">URL:</td>
					<td>
                    <?php echo $menuurl; ?>					</td>
				</tr>			
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
			</table>			</td>
		  </tr>
		</table>

		<input name="task" type="hidden" id="task">
		<input type="hidden" name="module" value="<?php echo $module;?>" />
		<input name="id_menuitem" type="hidden" id="id_menuitem" value="<?php echo $menuid; ?>" />
		<input name="menu_menuitem" type="hidden" id="menu_menuitem" value="<?php echo $menumenutype; ?>" />
		<input name="url_menuitem" type="hidden" id="url_menuitem" value="<?php echo $menuurl; ?>" />
		<input name="type_menuitem" type="hidden" id="type_menuitem" value="com_contact">
		<input name="param_menuitem" type="hidden" id="param_menuitem" />
		</form>
</div></div>