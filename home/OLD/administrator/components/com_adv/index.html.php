<?php
defined("_ALLOW") or die ("Access denied");
?>
<?php
checkpermission("grantadv",1) or die ("Access denied");
?>
<?php
$task = "";
if (isset($_REQUEST['task']))
	$task = $_REQUEST['task'];
else if (isset($_GET['task']))
	$task = $_GET['task'];

?>
<?php
include("components/com_adv/toolbar.html.php");
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
		$name = "";
		$name_en = "";
		$describe = "";
		$tag = "";
		$website = "";
		$img = "";
		$msgtask = "New";
		$msgtitle = "";
		if ($task == "edit") {
			include_once ("../class/cadv.php");
			$id = $_GET['id'];
			$objadv = $objadv->Doc($id);
			$name = $objadv->name;
			
			$name_en = $objadv->name_en;
			$describe = $objadv->describe;
			
			$tag = $objadv->tag;
			
			$website = $objadv->website;
			$img = $objadv->img;
			$msgtask = "Edit";
			$msgtitle = "[" . $name . "]";
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
		alert("Advertisement must have a title");
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
			Advertisement:
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
					Advertisement Details
				    <input name="id" type="hidden" id="id" value="<?php echo $id; ?>" /></th>
				<tr>				
				<tr>
					<td width="8%">
					Title</td>
					<td colspan="2">
					<input name="name" type="text" class="text_area" id="name" value="<?php echo $name; ?>" size="50" maxlength="255" />					</td>
				</tr>
				<tr>
					<td>
					Title (English)</td>
					<td colspan="2">
					<input name="name_en" type="text" class="text_area" id="name_en" value="<?php echo $name_en; ?>" size="50" maxlength="255" />					</td>
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
				  <td>Website</td>
				  <td colspan="2"><input name="website" type="text" id="website" value="<?php echo $website; ?>" size="50" maxlength="255" class="text_area" /></td>
				  </tr>
				<tr>
				  <td>Image</td>
				  <td colspan="2"><input name="img" type="text" class="text_area" id="img" value="<?php echo $img; ?>" size="30" maxlength="255"  />
			      <input name="button" type="button" onclick="openBox(750,500,'no','no',0,0,'../editor/tmedit/popups/insert_image_en.php?txt=img&sorturl=1', window);" value=" ... " /></td>
				  </tr>
			</table>
		  </td>
		  </tr>
		</table>
<?php
		break;
	case "order":
	case "remove":
	case "save":
		include_once ("../class/cadv.php");
		if ($task=="remove") {
			if (isset($_REQUEST['cid'])) {
				$arrayid = $_REQUEST['cid'];
				$count = count($arrayid);
				for ($i=0; $i<$count; $i++) {
					$sid = $arrayid[$i];
					$objadv = $objadv->Doc($sid);
					$objadv->Xoa();
				}
			}
		}
		else if ($task=="save") {
			$objadv->DocForm();
			$objadv->Ghi();
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
						$objadv = $objadv->Doc($sid);
						$objadv->ChangeOrder($arrayorder[$i]);
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
			Advertisement Manager
			</th>
		</tr>
</table>
<table class="adminlist">
	<tr>
		<th width="20" nowrap="nowrap">#</th>
		<th width="65%" nowrap="nowrap" class="title">Adv Name</th>
		<th width="5%" nowrap="nowrap">Order</th>
		<th nowrap="nowrap">Adv ID</th>
	</tr>
	<?php
	include_once ("../class/cadv.php");
	$array = $objadv->Doc_danh_sach();	
	if (is_array($array)) {
		$indexrow = 0;
		$count = count($array);
		for ($i=0; $i<$count; $i++) {
			$objadv = $array[$i];
			$link = "index.php?module=com_adv&task=edit&id=" . $objadv->id;
	?>
	<tr class="<?php echo "row$indexrow"; ?>">
		<td><input type="checkbox" name="cid[]" value="<?php echo $objadv->id; ?>" onclick="isChecked(this.checked);" /></td>
		<td><a href="<?php echo $link; ?>"><?php echo $objadv->name; ?> <?php if ($objadv->describe != "") echo " ($objadv->describe)"; ?></a></td>
		<td align="center">
		<input type="text" name="order[]" size="5" value="<?php echo $objadv->order; ?>" class="text_area" style="text-align: center"  onchange="return checkunsigned(this);" />
		<input type="hidden" name="preorder[]" value="<?php echo $objadv->order; ?>" />		</td>
		<td align="center"><input type="text" name="id[]" size="5" value="<?php echo $objadv->id; ?>" readonly class="text_area" style="text-align: center;" /></td>
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
  <input name="module" type="hidden" id="module" value="com_adv">
  <input name="boxchecked" type="hidden" id="boxchecked" value="0" />
  <input name="task" type="hidden" id="task" value="" />
</form>
</div></div>
</td></tr>
</table>