<?php
defined("_ALLOW") or die ("Access denied");
?>
<?php
checksupper() or die ("Access denied");
?>
<?php
$task = "";
if (isset($_REQUEST['task']))
	$task = $_REQUEST['task'];
else if (isset($_GET['task']))
	$task = $_GET['task'];

?>
<?php
include("components/com_category/toolbar.html.php");
include_once("../class/csection.php");
?>
<br />
<div align="center" class="centermain">
<div class="main">
<form action="index.php" method="post" name="adminForm" id="adminForm" >
<?php
switch ($task) {
	case "new":
	case "edit":
	case "menulink":
		$id = -1;
		$title = "";
		$title_en = "";
		$title_cn = "";
		$describe = "";
		$tag = "";
		$tsid = -1;
		$introtext = "";
		$introtext_en = "";
		$introtext_cn = "";		
		$msgtask = "New";
		$msgtitle = "";
		if ($task == "edit") {
			include_once ("../class/ccategory.php");
			$id = $_GET['id'];
			$objcategory = $objcategory->Doc($id);
			$title = $objcategory->title;
			
			$title_en = $objcategory->title_en;
			$title_cn = $objcategory->title_cn;
			$describe = $objcategory->describe;
			
			$tag = $objcategory->tag;
			
			$tsid = $objcategory->sid;
			$introtext = $objcategory->introtext;
			$introtext_en = $objcategory->introtext_en;
			$introtext_cn = $objcategory->introtext_cn;
			$msgtask = "Edit";
			$msgtitle = "[" . $title . "]";
		}
		else if ($task == "menulink") {
			include_once ("../class/cmenuitem.php");
			$objmenuitem->DocForm ();
			$objmenuitem->Ghi ();
			$id = $_REQUEST['id'];
			$title = $_REQUEST['title'];
			$title_en = $_REQUEST['title_en'];
			$title_cn = $_REQUEST['title_cn'];
			$describe = $_REQUEST['describe'];
			$tsid = $_REQUEST['sid'];
			$introtext = $_REQUEST['introtext'];
			$introtext_en = $_REQUEST['introtext_en'];
			$introtext_cn = $_REQUEST['introtext_cn'];
			$msgtask = "Edit";
			$msgtitle = "[" . $title . "]";
		}
?>
<script language="javascript" type="text/javascript">
function submitbutton(pressbutton) {
	var form = document.adminForm;
	if (pressbutton == 'cancel') {
		submitform( pressbutton );
		return;
	}
	form.title_menuitem.value = trim(form.title_menuitem.value);
	if ( pressbutton == 'menulink' ) {		
		if ( form.menu_menuitem.value == "" ) {
			alert( "Please select a Menu" );
			return;
		} 
		else if ( form.title_menuitem.value == "" ) {
			alert( "Please enter a Title for this menu item" );
			return;
		}
	}
	var title = form.title.value;
	form.title.value = trim(title);
	title = form.title.value;
	var sid = form.sid.value;
	if (title == "") {
		alert("Category must have a title");
		return;
	}
	else if (sid==-1) {
		alert("Category must have a section");
		return;
	}
	else {
		submitform(pressbutton);
	}
}
</script>
<table class="adminheading">
		<tr>
			<th class="sections">
			Category:
			<small>
			<?php echo $msgtask; ?>
			</small>
			<small><small>
			<?php echo $msgtitle; ?>
			</small></small>
			</th>
		</tr>
	  </table>

		<table width="100%">
		<tr>
			<td valign="top" width="70%">
				<table class="adminform">
				<tr>
					<th colspan="3">
					Category Details
				    <input name="id" type="hidden" id="id" value="<?php echo $id; ?>" /></th>
				<tr>				
				<tr>
					<td width="8%">
					Title</td>
					<td colspan="2">
					<input class="text_area" type="text" name="title" value="<?php echo $title; ?>" size="50" maxlength="255" />					</td>
				</tr>
				<tr>
					<td>
					Title (English)</td>
					<td colspan="2">
					<input name="title_en" type="text" class="text_area" id="title_en" value="<?php echo $title_en; ?>" size="50" maxlength="255" />					</td>
				</tr>
				<tr>
					<td>
					Title (Chinese)</td>
					<td colspan="2">
					<input name="title_cn" type="text" class="text_area" id="title_cn" value="<?php echo $title_cn; ?>" size="50" maxlength="255" />					</td>
				</tr>
                <tr>
				  <td>Describe</td>
				  <td colspan="2"><input name="describe" type="text" class="text_area" id="describe" value="<?php echo $describe; ?>" size="50" maxlength="255" /></td>
				  </tr>
				<tr>
				  <td>Tag</td>
				  <td colspan="2"><input name="tag" type="text" class="text_area" id="tag" value="<?php echo $tag; ?>" size="50" maxlength="255" /></td>
				  </tr>
				<tr>
				  <td>Section</td>
				  <td colspan="2">
				  <?php
				  $arraysection = $objsection->Doc_danh_sach();
				  ?>
				  <select name="sid" class="inputbox" size="1" >
	<option value="-1" <?php if ($tsid==-1) echo "selected='selected'"; ?> >- Select Section -</option>
	<?php
		if (is_array($arraysection)) {
			$count = count($arraysection);
			for ($i=0; $i<$count; $i++) {
	?>
		<option value="<?php echo $arraysection[$i]->id; ?>" <?php if ($tsid==$arraysection[$i]->id) echo "selected='selected'"; ?> ><?php echo $arraysection[$i]->title; ?> <?php if ($arraysection[$i]->describe != "") echo " (" . $arraysection[$i]->describe . ")"; ?></option>
	<?php
			}
		}
	?>
</select>				  </td>
				  </tr>
				<tr>
				  <td valign="top">Introtext</td>
				  <td colspan="2"><textarea name="introtext" id="introtext" style="width:100%"><?php echo $introtext; ?></textarea></td>
				  </tr>
				<tr>
				  <td valign="top">Introtext (English) </td>
				  <td colspan="2"><textarea name="introtext_en" id="introtext_en" style="width:100%"><?php echo $introtext_en; ?></textarea></td>
				  </tr>
				  <tr>
				  <td valign="top">Introtext (Chinese) </td>
				  <td colspan="2"><textarea name="introtext_cn" id="introtext_cn" style="width:100%"><?php echo $introtext_en; ?></textarea></td>
				  </tr>
			</table>
			</td>
			<!--  Td Menu //-->
			<?php
				include_once ("../class/cmenu.php");
			?>
			<td valign="top" width="40%">
					<table class="adminform">
					<tr>
						<th colspan="2">
						Link to Menu						</th>
					</tr>
					<tr>
						<td colspan="2">
						This will create a new menu item in the menu you select
					    <br /><br />						</td>
					</tr>
					<?php
						$arraymenu = $objmenu->Doc_danh_sach();						
					?>
					<tr>
					  <td valign="top" width="100">
						Select a Menu
						<input name="id_menuitem" type="hidden" id="id_menuitem" value="-1" />
					  <input name="url_menuitem" type="hidden" id="url_menuitem" <?php if ($id != -1) echo "value=\"index.php?module=com_content&task=blogcategory&id=$id\""; ?>  />
					  <input name="sublevel_menuitem" type="hidden" id="sublevel_menuitem" value="0" />
					  <input name="type_menuitem" type="hidden" id="type_menuitem" value="content_blog_category" />
					  <input name="parentid_menuitem" type="hidden" id="parentid_menuitem" value="0" />
					  <input name="param_menuitem" type="hidden" id="param_menuitem" /></td>
						<td>
						<select name="menu_menuitem" size="5" class="inputbox" >
						<?php
						if (is_array($arraymenu)) {
							$countmenu = count($arraymenu);
							for ($i=0; $i<$countmenu; $i++) {
								$objmenu = $arraymenu[$i];
						?>
							<option value="<?php echo $objmenu->id; ?>"><?php echo $objmenu->title; ?> <?php if ($objmenu->describe != "") echo " (" . $objmenu->describe . ")"; ?></option>
						<?php
							}
						}
						?>
						</select>						</td>
					</tr>
					<tr>
						<td valign="top" width="100">
						Menu Item Name						</td>
						<td>
						<input type="text" name="title_menuitem" class="inputbox" value="" size="25" />						</td>
					<tr>
						<td valign="top" width="100">
						Menu Item Name (English)						</td>
						<td>
						<input type="text" name="title_en_menuitem" class="inputbox" value="" size="25" />						</td>
					</tr>
					<tr>
					  <td valign="top">Menu Item Describe</td>
					  <td><input name="describe_menuitem" type="text" class="inputbox" id="describe_menuitem" value="" size="25" /></td>
					  </tr>
					<?php
					if ($id != -1) {
					?>
					<tr>
						<td>						</td>
						<td>
						<input name="menu_link" type="button" class="button" value="Link to Menu" onClick="submitbutton('menulink');" />						</td>
					</tr>
					<?php
					}
					?>
					<tr>
					<!-----------------------/////////-->
						<th colspan="2">
						Existing Menu Links						</th>
					</tr>
					<?php
					include_once ("../class/cmenuitem.php");
					$strwhere = "url='index.php?module=com_content&task=blogcategory&id=$id'";
					$arraymenuitem = $objmenuitem->Fill($strwhere);
					if (is_array($arraymenuitem)) {
						$countarrayitem = count($arraymenuitem);
						for ($i=0; $i<$countarrayitem; $i++) {
							$objmenuitem = $arraymenuitem[$i];
							$menu_menuitem = $objmenuitem->menu;
							$objmenu = $objmenu->Doc($menu_menuitem);
						?>
						<tr>
				<td colspan="2">
				<hr/>				</td>
			</tr>
			<tr>
				<td width="100" valign="top">Menu</td>
				<td><?php echo $objmenu->title; ?><?php if ($objmenu->describe != "") echo " ($objmenu->describe)"; ?></td>
			</tr>
			<tr>
				<td width="100" valign="top">Item Title</td>
				<td><strong><?php echo $objmenuitem->title ?><?php if ($objmenuitem->describe != "") echo " ($objmenuitem->describe)"; ?></strong></td>
			</tr>
					<?php
						}
					}
					else {
					?>
						<tr>
							<td colspan="2">
							<hr/>				</td>
						</tr>
						<tr>
							<td colspan="2">
							None							</td>
						</tr>
					<?php
					}
					?>
					<tr>
						<td colspan="2">						</td>
					</tr>
					</table>
			  <br />
            </td>
		  </tr>
		</table>
<?php
		break;
	case "order":
	case "remove":
	case "save":
		include_once ("../class/ccategory.php");
		if ($task=="remove") {
			if (isset($_REQUEST['cid'])) {
				$arrayid = $_REQUEST['cid'];
				$count = count($arrayid);
				include_once ("../class/ccategory.php");
				global $objcategory;
				for ($i=0; $i<$count; $i++) {
					$sid = $arrayid[$i];
					$objcategory = $objcategory->Doc($sid);
					$objcategory->Xoa();
				}
			}
		}
		else if ($task=="save") {
			$objcategory->DocForm();
			$resultid = $objcategory->Ghi();
			if (isset($_REQUEST['menu_menuitem'])) {
				if ($_REQUEST['menu_menuitem']!="" && $_REQUEST['title_menuitem']!="") {
				include_once ("../class/cmenuitem.php");
					$objmenuitem->DocForm();
					$objmenuitem->url = "index.php?module=com_content&task=blogcategory&id=$resultid";
					$objmenuitem->Ghi();
				}
			}
		}
		else {
			if(isset($_REQUEST['order'])) {
				$arrayorder = $_REQUEST['order'];
				$arraypreorder = $_REQUEST['preorder'];
				$arrayid = $_REQUEST['id'];
				$count = count($arrayorder);
				for ($i=0; $i<$count; $i++) {
					if ($arrayorder[$i] != $arraypreorder[$i]) {
						$sid = $arrayid[$i];
						$objcategory = $objsection->Doc($sid);
						$objcategory->ChangeOrder($arrayorder[$i]);
					}
				}
			}
		}
		$task = "";
?>
<?php
	default:
?>
<script language="javascript" src="../common/js/checknumber.js">
</script>
<table class="adminheading">
		<tr>
			 <th class="sections">
			Category Manager
			</th>
			<td width="right">
<?php
$tsid = -1;
if (isset($_REQUEST['sid'])) $tsid = $_REQUEST['sid'];
$arraysection = $objsection->Doc_danh_sach();
?>
<select name="sid" class="inputbox" size="1" onchange="document.adminForm.submit();"  >
	<option value="-1" <?php if ($tsid==-1) echo "selected='selected'"; ?> >- Select Section -</option>
	<?php
	if (is_array($arraysection)) {
		$count = count($arraysection);
		for ($i=0; $i<$count; $i++) {
	?>
		<option value="<?php echo $arraysection[$i]->id; ?>" <?php if ($tsid==$arraysection[$i]->id) echo "selected='selected'"; ?> ><?php echo $arraysection[$i]->title; ?> <?php if ($arraysection[$i]->describe != "") echo " (" . $arraysection[$i]->describe . ")"; ?> </option>
	<?php
		}
	}
	?>
</select>
		  </td>
		</tr>
</table>
<table class="adminlist">
	<tr>
		<th width="20" nowrap="nowrap">#</th>
		<th width="50%" nowrap="nowrap" class="title">Category Name</th>
		<th width="5%" nowrap="nowrap">Order</th>
		<th width="35%" nowrap="nowrap" class="title">Section</th>
		<th nowrap="nowrap">Category ID</th>
	</tr>
	<?php
	include_once ("../class/ccategory.php");	
	$strwhere = "";
	if ($tsid != -1) $strwhere = "sid = $tsid";
	$array = $objcategory->Fill($strwhere);	
	if (is_array($array)) {
		$indexrow = 0;
		$count = count($array);
		for ($i=0; $i<$count; $i++) {
			$objcategory = $array[$i];
			$link = "index.php?module=com_category&task=edit&id=" . $objcategory->id;
	?>
	<tr class="<?php echo "row$indexrow"; ?>" >
		<td><input type="checkbox" name="cid[]" value="<?php echo $objcategory->id; ?>" onclick="isChecked(this.checked);" /></td>
		<td><a href="<?php echo $link; ?>"><?php echo $objcategory->title; ?> <?php if ($objcategory->describe != "") echo " ($objcategory->describe)"; ?></a></td>
		<td align="center">
		<input type="text" name="order[]" size="5" value="<?php echo $objcategory->order; ?>" class="text_area" style="text-align: center"  onchange="return checkunsigned(this);" />
		<input type="hidden" name="preorder[]" value="<?php echo $objcategory->order; ?>" />		</td>
		<td>
		<?php
			$sid = $objcategory->sid;
			$objsection = $objsection->Doc($sid);
			$linksection = "index.php?module=com_section&task=edit&id=" . $objsection->id;
		?>
		<a href="<?php echo $linksection; ?>"><?php echo $objsection->title; ?> <?php if ($objsection->describe != "") echo " ($objsection->describe)"; ?></a>
		</td>
		<td align="center"><input type="text" name="id[]" size="5" value="<?php echo $objcategory->id; ?>" readonly class="text_area" style="text-align: center;" /></td>
	</tr>
	<?php
			$indexrow = 1 - $indexrow;
		}
	}
	?>
</table>
<?php
	break;
}
?>
  <input name="module" type="hidden" id="module" value="com_category">
  <input name="boxchecked" type="hidden" id="boxchecked" value="0" />
  <input name="task" type="hidden" id="task" value="" />
</form>
</div></div>
</td></tr>
</table>