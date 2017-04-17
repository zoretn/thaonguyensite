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
include("components/com_menumanager/toolbar.html.php");
?>
<br />
<div align="center" class="centermain">
<div class="main">
<form action="index.php" method="post" name="adminForm" id="adminForm" >
<?php
switch ($task) {
	case "new":
	case "edit":
		$id = -1;
		$title = "";
		$title_en = "";
		$title_cn = "";		
		$describe = "";
		$bulletitem = "";
		$style = 1;
		$position = "left";
		$hidetitle = 0;
		$msgtask = "New";
		$msgtitle = "";
		if ($task == "edit") {
			include_once ("../class/cmenu.php");
			$id = $_GET['id'];
			$objmenu = $objmenu->Doc($id);
			$title = $objmenu->title;
			
			$title_en = $objmenu->title_en;
			$title_cn = $objmenu->title_cn;			
			$describe = $objmenu->describe;
			
			$bulletitem = $objmenu->bulletitem;
			$style = $objmenu->style;
			$position = $objmenu->position;
			$hidetitle = $objmenu->hidetitle;
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
	var title = form.title.value;
	form.title.value = trim(title);
	title = form.title.value;
	if (title == "") {
		alert("Menu must have a title");
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
			Menu:
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
			<td valign="top" width="60%">
				<table class="adminform">
				<tr>
					<th colspan="3">
					Menu Details
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
				<tr style="visibility:hidden;">
				  <td>Bullet Item </td>
				  <td colspan="2"><input name="bulletitem" type="text" class="text_area" id="bulletitem" size="50" maxlength="255" value="<?php echo $bulletitem; ?>">
			      <input name="btnbullet" type="button" class="button" id="btnbullet" onclick="openBox(750,500,'no','no',0,0,'../editor/tmedit/popups/insert_image_en.php?txt=bulletitem&sorturl=1', window);" value="..."></td>
				  </tr>
				<tr>
				  <td>Style</td>
				  <td colspan="2"><select name="style" size="1" id="style">
				    <option value="0" <?php if ($style==0) echo "selected='selected'"; ?> >Horizonal</option>
				    <option value="1" <?php if ($style==1) echo "selected='selected'"; ?> >Vertical</option>
				    <option value="2" <?php if ($style==2) echo "selected='selected'"; ?> >Flat List</option>
				    </select>				  </td>
				  </tr>
				<tr>
				  <td>Position</td>
				  <td colspan="2"><input name="position" type="text" class="text_area" id="position" size="20" maxlength="20" value="<?php echo $position; ?>" ></td>
				  </tr>
				<tr>
				  <td>Hide Title </td>
				  <td colspan="2"><input name="hidetitle" type="checkbox" id="hidetitle" value="1" <?php if ($hidetitle==1) echo "checked='checked'"; ?> ></td>
				  </tr>
			</table>
			</td>
            <td valign="top"><table class="adminform">
              <tr>
                <th colspan="3"> Show In Menu Item</th>
              </tr>
              <tr> </tr>
              
              <tr>
                <td width="28%" valign="top">Menu Item</td>
                <td width="72%" colspan="2">
                <select name="showin[]" size="10" multiple="multiple" class="inputbox" id="showin" >
                          <option value="" selected="selected" >--All--</option>
                          <?php
						  include_once("../class/cmenuitem.php");
						  $arraymenuitem = $objmenuitem->Doc_danh_sach();
						  if (is_array($arraymenuitem)) {
						  	foreach ($arraymenuitem as $objmenuitem) {
							?>
                            <option value="<?php echo $objmenuitem->id; ?>"><?php echo $objmenuitem->title; ?><?php if ($objmenuitem->describe != "") echo " ($objmenuitem->describe)"; ?></option>
                            <?php
							}
						  }
						  ?>
                  </select>
                </td>
              </tr>
              
              
            </table></td>
		  </tr>
		</table>
<?php
		break;
	case "order":
	case "remove":
	case "save":
		include_once ("../class/cmenu.php");
		if ($task=="remove") {
			if (isset($_REQUEST['cid'])) {
				$arrayid = $_REQUEST['cid'];
				$count = count($arrayid);
				include_once ("../class/ccategory.php");
				for ($i=0; $i<$count; $i++) {
					$sid = $arrayid[$i];
					$objmenu = $objmenu->Doc($sid);
					$objmenu->Xoa();
				}
			}
		}
		else if ($task=="save") {
			$objmenu->DocForm();
			$objmenu->Ghi();
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
						$objmenu = $objmenu->Doc($sid);
						$objmenu->ChangeOrder($arrayorder[$i]);
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
			Menu Manager
			</th>
		</tr>
</table>
<table class="adminlist">
	<tr>
		<th width="20" nowrap="nowrap">#</th>
		<th width="65%" nowrap="nowrap" class="title">Menu Name</th>
		<th width="5%" nowrap="nowrap">Menu Items </th>
		<th width="5%" nowrap="nowrap">Order</th>
		<th nowrap="nowrap">Menu ID</th>
	</tr>
	<?php
	include_once ("../class/cmenu.php");
	$array = $objmenu->Doc_danh_sach();	
	if (is_array($array)) {
		$indexrow = 0;
		$count = count($array);
		for ($i=0; $i<$count; $i++) {
			$objmenu = $array[$i];
			$link = "index.php?module=com_menumanager&task=edit&id=" . $objmenu->id;
	?>
	<tr class="<?php echo "row$indexrow"; ?>">
		<td><input type="checkbox" name="cid[]" value="<?php echo $objmenu->id; ?>" onclick="isChecked(this.checked);" /></td>
		<td><a href="<?php echo $link; ?>"><?php echo $objmenu->title; ?> <?php if ($objmenu->describe != "") echo " ($objmenu->describe)"; ?></a></td>
		<td align="center"><a href="index.php?module=com_menu&menu_menuitem=<?php echo $objmenu->id; ?>"><img src="images/mainmenu.png" width="16" height="16" border="0" /></a></td>
		<td align="center">
		<input type="text" name="order[]" size="5" value="<?php echo $objmenu->order; ?>" class="text_area" style="text-align: center"  onchange="return checkunsigned(this);" />
		<input type="hidden" name="preorder[]" value="<?php echo $objmenu->order; ?>" />		</td>
		<td align="center"><input type="text" name="id[]" size="5" value="<?php echo $objmenu->id; ?>" readonly class="text_area" style="text-align: center;" /></td>
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
  <input name="module" type="hidden" id="module" value="com_menumanager">
  <input name="boxchecked" type="hidden" id="boxchecked" value="0" />
  <input name="task" type="hidden" id="task" value="" />
</form>
</div></div>
</td></tr>
</table>