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
include("components/com_productcategory/toolbar.html.php");
include_once("../class/cproductsection.php");
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
		$introtext = "";
		$introtext_en = "";
		$introtext_cn = "";
		$describe = "";
		$image = "";
		$tag = "";
		$tsid = -1;
		$msgtask = "New";
		$msgtitle = "";
		if ($task == "edit") {
			include_once ("../class/cproductcategory.php");
			$id = $_GET['id'];
			$objproductcategory = $objproductcategory->Doc($id);
			$title = $objproductcategory->title;
			
			$title_en = $objproductcategory->title_en;
			$title_cn = $objproductcategory->title_cn;
			
			$introtext = $objproductcategory->introtext;
			
			$introtext_en = $objproductcategory->introtext_en;
			$introtext_cn = $objproductcategory->introtext_cn;
		$describe = $objproductcategory->describe;
			
			$image = $objproductcategory->image;
			
			$tag = $objproductcategory->tag;
			
			$tsid = $objproductcategory->sid;
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
			$introtext = $_REQUEST['introtext'];
			$introtext_en = $_REQUEST['introtext_en'];
			$introtext_cn = $_REQUEST['introtext_cn'];
			$image = $_REQUEST['image'];
			$tsid = $_REQUEST['sid'];
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
			Product Category:
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
					Product Category Details
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
				  $arrayproductsection = $objproductsection->Doc_danh_sach();
				  ?>
				  <select name="sid" class="inputbox" size="1" >
	<option value="-1" <?php if ($tsid==-1) echo "selected='selected'"; ?> >- Select Section -</option>
	<?php
		if (is_array($arrayproductsection)) {
			$count = count($arrayproductsection);
			for ($i=0; $i<$count; $i++) {
	?>
		<option value="<?php echo $arrayproductsection[$i]->id; ?>" <?php if ($tsid==$arrayproductsection[$i]->id) echo "selected='selected'"; ?> ><?php echo $arrayproductsection[$i]->title; ?> <?php if ($arrayproductsection[$i]->describe != "") echo " (" . $arrayproductsection[$i]->describe . ")"; ?></option>
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
				  <td valign="top">Introtext (English)</td>
				  <td colspan="2"><textarea name="introtext_en" id="introtext_en" style="width:100%"><?php echo $introtext_en; ?></textarea></td>
				  </tr>
				  <tr>
				  <td valign="top">Introtext (Chinese)</td>
				  <td colspan="2"><textarea name="introtext_cn" id="introtext_cn" style="width:100%"><?php echo $introtext_cn; ?></textarea></td>
				  </tr>
                <tr>
				  <td valign="top">Image</td>
				  <td colspan="2"><input name="image" type="text" class="text_area" id="image" value="<?php echo $image; ?>" size="30" maxlength="255"  />
			      <input name="button" type="button" onclick="openBox(750,500,'no','no',0,0,'../editor/tmedit/popups/insert_image_en.php?txt=image&sorturl=1', window);" value=" ... " /></td>
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
					  <input name="url_menuitem" type="hidden" id="url_menuitem" <?php if ($id != -1) echo "value=\"index.php?module=com_product&task=blogcategory&id=$id\""; ?>  />
					  <input name="sublevel_menuitem" type="hidden" id="sublevel_menuitem" value="0" />
					  <input name="type_menuitem" type="hidden" id="type_menuitem" value="product_blog_category" />
					  <input name="parentid_menuitem" type="hidden" id="parentid_menuitem" value="0" />
					  <input name="param_menuitem" type="hidden" id="param_menuitem" value="0" /></td>
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
					$strwhere = "url='index.php?module=com_product&task=blogcategory&id=$id'";
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
		include_once ("../class/cproductcategory.php");
		if ($task=="remove") {
			if (isset($_REQUEST['cid'])) {
				$arrayid = $_REQUEST['cid'];
				$count = count($arrayid);
				include_once ("../class/cproductcategory.php");
				for ($i=0; $i<$count; $i++) {
					$sid = $arrayid[$i];
					$objproductcategory = $objproductcategory->Doc($sid);
					$objproductcategory->Xoa();
				}
			}
		}
		else if ($task=="save") {
			$objproductcategory->DocForm();
			$resultid = $objproductcategory->Ghi();
			if (isset($_REQUEST['menu_menuitem'])) {
				if ($_REQUEST['menu_menuitem']!="" && $_REQUEST['title_menuitem']!="") {
				include_once ("../class/cmenuitem.php");
					$objmenuitem->DocForm();
					$objmenuitem->url = "index.php?module=com_product&task=blogcategory&id=$resultid";
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
						$objproductcategory = $objproductsection->Doc($sid);
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
			Product Category Manager
			</th>
			<td width="right">
<?php
$tsid = -1;
if (isset($_REQUEST['sid'])) $tsid = $_REQUEST['sid'];
$arrayproductsection = $objproductsection->Doc_danh_sach();
?>
<select name="sid" class="inputbox" size="1" onchange="document.adminForm.submit();"  >
	<option value="-1" <?php if ($tsid==-1) echo "selected='selected'"; ?> >- Select Section -</option>
	<?php
	if (is_array($arrayproductsection)) {
		$count = count($arrayproductsection);
		for ($i=0; $i<$count; $i++) {
	?>
		<option value="<?php echo $arrayproductsection[$i]->id; ?>" <?php if ($tsid==$arrayproductsection[$i]->id) echo "selected='selected'"; ?> ><?php echo $arrayproductsection[$i]->title; ?> <?php if ($arrayproductsection[$i]->describe != "") echo " (" . $arrayproductsection[$i]->describe . ")"; ?></option>
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
		<th width="50%" nowrap="nowrap" class="title">Product Category Name</th>
		<th width="5%" nowrap="nowrap">Order</th>
		<th width="35%" nowrap="nowrap" class="title">Section</th>
		<th nowrap="nowrap">Product Category ID</th>
	</tr>
	<?php
	include_once ("../class/cproductcategory.php");	
	$strwhere = "";
	if ($tsid != -1) $strwhere = "sid = $tsid";
	$array = $objproductcategory->Fill($strwhere);	
	if (is_array($array)) {
		$indexrow = 0;
		$count = count($array);
		for ($i=0; $i<$count; $i++) {
			$objproductcategory = $array[$i];
			$link = "index.php?module=com_productcategory&task=edit&id=" . $objproductcategory->id;
	?>
	<tr class="<?php echo "row$indexrow"; ?>" >
		<td><input type="checkbox" name="cid[]" value="<?php echo $objproductcategory->id; ?>" onclick="isChecked(this.checked);" /></td>
		<td><a href="<?php echo $link; ?>"><?php echo $objproductcategory->title; ?> <?php if ($objproductcategory->describe) echo " ($objproductcategory->describe)"; ?></a></td>
		<td align="center">
		<input type="text" name="order[]" size="5" value="<?php echo $objproductcategory->order; ?>" class="text_area" style="text-align: center"  onchange="return checkunsigned(this);" />
		<input type="hidden" name="preorder[]" value="<?php echo $objproductcategory->order; ?>" />		</td>
		<td>
		<?php
			$sid = $objproductcategory->sid;
			$objproductsection = $objproductsection->Doc($sid);
			$linksection = "index.php?module=com_productsection&task=edit&id=" . $objproductsection->id;
		?>
		<a href="<?php echo $linksection; ?>"><?php echo $objproductsection->title; ?> <?php if ($objproductsection->describe != "") echo " ($objproductsection->describe)"; ?></a>
		</td>
		<td align="center"><input type="text" name="id[]" size="5" value="<?php echo $objproductcategory->id; ?>" readonly class="text_area" style="text-align: center;" /></td>
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
  <input name="module" type="hidden" id="module" value="com_productcategory">
  <input name="boxchecked" type="hidden" id="boxchecked" value="0" />
  <input name="task" type="hidden" id="task" value="" />
</form>
</div></div>
</td></tr>
</table>