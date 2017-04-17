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
if (!isset($_GET['menu_menuitem']) && !isset($_REQUEST['menu_menuitem'])) die ("Access denied");
?>
<?php
$menutype = "";
if (isset($_GET['menu_menuitem']))
	$menutype = $_GET['menu_menuitem'];
else if (isset($_REQUEST['menu_menuitem']))
	$menutype = $_REQUEST['menu_menuitem'];
?>
<?php include("components/com_menu/toolbar.html.php"); ?>
<script language="javascript" type="text/javascript">
function submitbutton(pressbutton) {
	var form = document.adminForm;
	if (pressbutton == 'cancel') {
		submitform( pressbutton );
		return ();
	}
	else if (pressbutton == 'save') {
		var title = form.title_menuitem.value;
		form.title_menuitem.value = trim(title);
		title = form.title_menuitem.value;
		if (title == "") {
			alert("Menu must have a title");
			return;
		}
		
		var url = form.url_menuitem.value;
		var pos = url.indexOf("-1");
		if (pos >= 0) {
			alert("You must select target");
			return;
		}
		var strlength = url.length;
		if (url[strlength-1] == "=") {
			alert("You must select target");
			return;
		}
		
		submitform (pressbutton);
	}
	else {
		submitform(pressbutton);
	}
}
function ChangeParentSublevel (strvalue) {
	var arrayresult = strvalue.split("#");
	var form = document.adminForm;
	
	form.parentid_menuitem.value = arrayresult[0];
	form.sublevel_menuitem.value = arrayresult[1] + 1;
//	alert("Parent: " + arrayresult[0] + "Sublevel: " + arrayresult[1]);
	
//	alert(strvalue);
}
</script>
<?php
switch ($task) {
	case "new":
	?>
		<style type="text/css">
		fieldset {
			border: 1px solid #777;
		}
		legend {
			font-weight: bold;
		}
		</style>
		<script language="javascript" src="joomla/js/overlib_mini.js"></script>
		<script language="javascript" src="joomla/js/overlib_hideform_mini.js"></script>
<div align="center" class="centermain">
	<div class="main">
		<form action="index.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th class="menus">
			New Menu Item
			</th>			
		</tr>
		</table>

		<table class="adminform">
		<tr>
			<td width="50%" valign="top">
				<fieldset>
					<legend>Content</legend>
					<table class="adminform">
					<tr class="row0">
					<td width="20"></td>
					<td style="height: 30px;">
				<span class="editlinktip" style="cursor: pointer;">
						<!-- Tooltip -->
<a href="index.php?module=com_menu&menu_menuitem=<?php echo $menutype; ?>&task=edit&type=content_blog_category" onmouseover="return overlib('Displays a page of content items from category in a blog format', CAPTION, 'Blog - Content Category', BELOW, RIGHT, WIDTH, '250');" onmouseout="return nd();" >Blog - Content Category</a>				</span>			</td>
			<td width="20">
				<input type="radio" id="cb0" name="type" value="content_blog_category" onClick="isChecked(this.checked);" />
			</td>
			<td width="20">
			</td>
					</tr>
					<tr class="row1">
					<td width="20"></td>
					<td style="height: 30px;">
				<span class="editlinktip" style="cursor: pointer;">
						<!-- Tooltip -->
<a href="index.php?module=com_menu&amp;menu_menuitem=<?php echo $menutype; ?>&amp;task=edit&amp;type=content_blog_section" onmouseover="return overlib('Displays a page of content items from section in a blog format', CAPTION, 'Blog - Content Section', BELOW, RIGHT, WIDTH, '250');" onmouseout="return nd();" >Blog - Content Section </a>				</span>			</td>
			        <td width="20">
				<input type="radio" id="cb1" name="type" value="content_blog_section" onClick="isChecked(this.checked);" />
			</td>
			<td width="20">
			</td>
					</tr>
					<tr class="row0">
					<td width="20"></td>
					<td style="height: 30px;">
				<span class="editlinktip" style="cursor: pointer;">
						<!-- Tooltip -->
<a href="index.php?module=com_menu&menu_menuitem=<?php echo $menutype; ?>&task=edit&type=com_static" onmouseover="return overlib('Displays a page of static content item', CAPTION, 'Link - static Content', BELOW, RIGHT, WIDTH, '250');" onmouseout="return nd();" >Link - Static  Content </a></span></td>
			        <td width="20">
				<input type="radio" id="cb2" name="type" value="com_static" onClick="isChecked(this.checked);" />
			</td>
			<td width="20">
			</td>
					</tr>
					</table>
				</fieldset>
				<fieldset>
					<legend>Product</legend>
					<table class="adminform">
					<tr class="row0">
					<td width="20"></td>
					<td style="height: 30px;">
				<span class="editlinktip" style="cursor: pointer;">
						<!-- Tooltip -->
<a href="index.php?module=com_menu&menu_menuitem=<?php echo $menutype; ?>&task=edit&type=product_blog_category" onmouseover="return overlib('Displays a page of product items from category in a blog format', CAPTION, 'Blog - Product Category', BELOW, RIGHT, WIDTH, '250');" onmouseout="return nd();" >Blog - Product Category</a>				</span>
			</td>
			        <td width="20">
				<input type="radio" id="cb3" name="type" value="product_blog_category" onClick="isChecked(this.checked);" />
			</td>
			<td width="20">
			</td>
					</tr>
					<tr class="row1">
					<td width="20"></td>
					<td style="height: 30px;">
				      <span class="editlinktip" style="cursor: pointer;">
				        <!-- Tooltip -->
                          <a href="index.php?module=com_menu&amp;menu_menuitem=<?php echo $menutype; ?>&amp;task=edit&amp;type=product_blog_section" onmouseover="return overlib('Displays a page of product items from section in a blog format', CAPTION, 'Blog - Product Section', BELOW, RIGHT, WIDTH, '250');" onmouseout="return nd();" >Blog - Product Section</a></span>
				      </td>
			        <td width="20">
				<input type="radio" id="cb4" name="type" value="product_blog_section" onClick="isChecked(this.checked);" />
			</td>
			<td width="20">
			</td>
					</tr>
					<tr class="row0">
					<td width="20"></td>
					<td style="height: 30px;">
				<span class="editlinktip" style="cursor: pointer;">
						<!-- Tooltip -->
<a href="index.php?module=com_menu&menu_menuitem=<?php echo $menutype; ?>&task=edit&type=com_shoppingcart" onmouseover="return overlib('Displays a page of your cart', CAPTION, 'Component - Shopping Cart', BELOW, RIGHT, WIDTH, '250');" onmouseout="return nd();" >Component - Shopping Cart</a>				</span>
			</td>
			        <td width="20">
				<input type="radio" id="cb5" name="type" value="com_shoppingcart" onClick="isChecked(this.checked);" />
			</td>
			<td width="20">
			</td>
					</tr>
					</table>
				</fieldset>
			</td>
			<td width="50%" valign="top">
				<fieldset>
					<legend>Components</legend>
					<table class="adminform">
					<tr class="row0">
					<td width="20"></td>
					<td style="height: 30px;">
				<span class="editlinktip" style="cursor: pointer;">
						<!-- Tooltip -->
<a href="index.php?module=com_menu&menu_menuitem=<?php echo $menutype; ?>&task=edit&type=com_contact" onmouseover="return overlib('Displays a page of contact', CAPTION, 'Component - Contact', BELOW, RIGHT, WIDTH, '250');" onmouseout="return nd();" >Component - Contact </a></span></td>
			        <td width="20">
				<input type="radio" id="cb6" name="type" value="com_contact" onClick="isChecked(this.checked);" />
			</td>
			<td width="20">
			</td>
					</tr>
					<tr class="row1">
					<td width="20"></td>
					<td style="height: 30px;">
				<span class="editlinktip" style="cursor: pointer;">
						<!-- Tooltip -->
<a href="index.php?module=com_menu&amp;menu_menuitem=<?php echo $menutype; ?>&amp;task=edit&amp;type=com_faq" onmouseover="return overlib('Displays a page of FAQ', CAPTION, 'Component - FAQ', BELOW, RIGHT, WIDTH, '250');" onmouseout="return nd();" >Component - FAQ </a></span></td>
			        <td width="20">
				<input type="radio" id="cb7" name="type" value="com_faq" onClick="isChecked(this.checked);" />
			</td>
			<td width="20">
			</td>
					</tr>
					</table>
				</fieldset>
				<fieldset>
					<legend>Links</legend>
					<table class="adminform">
					<tr class="row0">
					<td width="20"></td>
					<td style="height: 30px;">
				<span class="editlinktip" style="cursor: pointer;">
						<!-- Tooltip -->
<a href="index.php?module=com_menu&amp;menu_menuitem=<?php echo $menutype; ?>&amp;task=edit&amp;type=url" onmouseover="return overlib('Displays a page of url', CAPTION, 'Url', BELOW, RIGHT, WIDTH, '250');" onmouseout="return nd();" >Url </a></span></td>
			        <td width="20">
				<input type="radio" id="cb8" name="type" value="url" onClick="isChecked(this.checked);" />
			</td>
			<td width="20">
			</td>
					</tr>
					<tr class="row1">
					<td width="20"></td>
					<td style="height: 30px;">
				<span class="editlinktip" style="cursor: pointer;">
						<!-- Tooltip -->
<a href="index.php?module=com_menu&amp;menu_menuitem=<?php echo $menutype; ?>&amp;task=edit&amp;type=com_parent" onmouseover="return overlib('Parent menuitem', CAPTION, 'Url', BELOW, RIGHT, WIDTH, '250');" onmouseout="return nd();" >Not Link Item </a></span></td>
			        <td width="20">
				<input type="radio" id="cb9" name="type" value="com_parent" onClick="isChecked(this.checked);" />
			</td>
			<td width="20">
			</td>
					</tr>
                    <tr class="row0">
					<td width="20"></td>
					<td style="height: 30px;">
				<span class="editlinktip" style="cursor: pointer;">
						<!-- Tooltip -->
<a href="index.php?module=com_menu&amp;menu_menuitem=<?php echo $menutype; ?>&amp;task=edit&amp;type=linkfile" onmouseover="return overlib('Link to File', CAPTION, 'Url', BELOW, RIGHT, WIDTH, '250');" onmouseout="return nd();" >Link to File </a></span></td>
			        <td width="20">
				<input type="radio" id="cb10" name="type" value="linkfile" onClick="isChecked(this.checked);" />
			</td>
			<td width="20">
			</td>
					</tr>
					</table>
				</fieldset>
			</td>
		</tr>
		</table>

		<input name="module" type="hidden" id="module" value="<?php echo $module; ?>" />
		<input name="menu_menuitem" type="hidden" id="menu_menuitem" value="<?php echo $menutype; ?>" />
		<input type="hidden" name="task" value="edit" />
		<input type="hidden" name="boxchecked" value="0" />
		</form>
		</div></div>
	<?php
		break;
	case "edit":
		if (isset($_REQUEST['type'])) $type = $_REQUEST['type'];
		else $type = $_GET['type'];
		include_once ("components/com_menu/$type/index.html.php");
		break;
	case "copy":
		include_once("components/com_menu/com_menucopy/index.html.php");
		break;
	case "remove":
	case "order":
	case "save":
	case "copymenusave":
		include_once ("../class/cmenuitem.php");
		if ($task=="remove") {
			if (isset($_REQUEST['cid'])) {
				$arrayid = $_REQUEST['cid'];
				$count = count($arrayid);
				for ($i=0; $i<$count; $i++) {
					$menuid = $arrayid[$i];
					$objmenuitem = $objmenuitem->Doc($menuid);
					$objmenuitem->Xoa();
				}
			}
		}
		else if ($task=="order") {
			$arrayorder = $_REQUEST['order'];
			$arraypreorder = $_REQUEST['preorder'];
			$arrayid = $_REQUEST['id'];
			$count = count($arrayorder);
			for ($i=0; $i<$count; $i++) {
				if ($arrayorder[$i] != $arraypreorder[$i]) {
					$menuid = $arrayid[$i];
					$objmenuitem = $objmenuitem->Doc($menuid);
					$objmenuitem->ChangeOrder($arrayorder[$i]);
				}
			}
		}
		else if ($task=="copymenusave") {
			include_once("../class/cmenuitem.php");
			$arraymenuitemid = $_REQUEST['menuitemid'];
			$menu = $_REQUEST['menu_menuitem'];
			foreach ($arraymenuitemid as $menuitemid) {
				$objmenuitem = $objmenuitem->Doc($menuitemid);
				$objmenuitem->Copy($menu);
			}
		}
		else {
			$objmenuitem->DocForm();
			$objmenuitem->Ghi ();
		}
	?>
	<?php
	default:
		include_once ("../class/cmenu.php");
		include_once ("../class/cmenuitem.php");
		$objmenu = $objmenu->Doc($menutype);
		?>
		<div align="center" class="centermain">
	<div class="main">
			<form action="index.php" method="post" name="adminForm">
			<table class="adminheading">
			<tr>
				<th class="menus">
				Menu Manager <small><small>[ <?php echo $objmenu->title;?> ]</small></small>
				</th>
			</tr>
			</table>
	
			<table class="adminlist">
			<tr>
				<th width="20">	</th>
				<th class="title" width="40%">
				Menu Item			</th>
				<th width="1%">Order</th>
				<th>
				Itemid			</th>
				<th width="35%" align="left">
				Url			</th>
			  </tr>
			<?php
			$arraymenuitem = array();
			$objmenuitem->Get_ArrayMenuItem($arraymenuitem, $menutype,"");
//			$arraymenuitem = $objmenuitem->Doc_danh_sach($menutype);
		if (is_array($arraymenuitem)) {
			$k = 0;
			foreach ($arraymenuitem as $tobjmenuitem) {
				if (isset($tobjmenuitem['title'])) {
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td>
					<input type="checkbox" name="cid[]" value="<?php echo $tobjmenuitem['id']; ?>" onclick="isChecked(this.checked);" />
					</td>
					<td nowrap="nowrap">
					<?php
					$linkmenuitem = $tobjmenuitem['linkmenuitem'];
					//$linkmenuitem = "index.php?module=com_menu&task=edit&id=$objmenuitem->id&menu_menuitem=$objmenuitem->menu&type=$objmenuitem->type";
					?>
					<?php echo $tobjmenuitem['prex']; ?><a href="<?php echo $linkmenuitem; ?>" ><?php echo $tobjmenuitem['title']; ?></a>
					</td>
					<td align="center">
					<input type="text" name="order[]" size="5" value="<?php echo $tobjmenuitem['order']; ?>" class="text_area" style="text-align: center" />
					<input type="hidden" name="preorder[]" value="<?php echo $tobjmenuitem['order']; ?>" >
					</td>
					<td align="center">
					<input type="text" name="id[]" size="5" value="<?php echo $tobjmenuitem['id']; ?>" readonly class="text_area" style="text-align: center;" />
					</td>
					<td>
					<?php echo $tobjmenuitem['url']; ?>
					</td>
				</tr>
				<?php
				$k = 1 - $k;
				}
			}
		}
			?>
			</table>
	
			<input name="module" type="hidden" id="module" value="<?php echo $module; ?>" />
			<input name="menu_menuitem" type="hidden" id="menu_menuitem" value="<?php echo $menutype; ?>" />
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="boxchecked" value="0" />
		</form>
		</div></div>
		<?php
}
?>