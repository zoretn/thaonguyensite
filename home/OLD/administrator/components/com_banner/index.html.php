<?php
defined("_ALLOW") or die ("Access denied");
?>
<?php
checkpermission("grantbanner",1) or die ("Access denied");
?>
<?php
$task = "";
if (isset($_REQUEST['task']))
	$task = $_REQUEST['task'];
else if (isset($_GET['task']))
	$task = $_GET['task'];

?>
<?php
include("components/com_banner/toolbar.html.php");
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
		$describe = "";
		$tag = "";
		$active = 0;
		$image = "";
		$msgtask = "New";
		$msgtitle = "";
		if ($task == "edit") {
			include_once ("../class/cbanner.php");
			$id = $_GET['id'];
			$objbanner = $objbanner->Doc($id);
			$title = $objbanner->title;
			
			$title_en = $objbanner->title_en;
			$describe = $objbanner->describe;
			
			$tag = $objbanner->tag;
			
			$active = $objbanner->active;
			$image = $objbanner->image;
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
		alert("Banner must have a title");
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
			Banner:
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
					Banner Details
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
				  <td>Describe</td>
				  <td colspan="2"><input name="describe" type="text" class="text_area" id="describe" value="<?php echo $describe; ?>" size="50" maxlength="255" /></td>
				  </tr>
				<tr>
				  <td>Tag</td>
				  <td colspan="2"><input name="tag" type="text" class="text_area" id="tag" value="<?php echo $tag; ?>" size="50" maxlength="255" /></td>
				  </tr>
				<tr>
				  <td>Active</td>
				  <td colspan="2"><input name="active" type="checkbox" id="active" value="1" <?php if ($active==1) echo "checked='checked'"; ?> /></td>
				  </tr>
				<tr>
				  <td>Image</td>
				  <td colspan="2"><input name="image" type="text" id="image" class="text_area" value="<?php echo $image; ?>" />
			      <input name="button" type="button" id="button" onclick="openBox(750,500,'no','no',0,0,'../editor/tmedit/popups/insert_image_en.php?txt=image&sorturl=1', window);" value=" ... " /></td>
				  </tr>
			</table>
		  </td>
		  </tr>
		</table>
<?php
		break;
	case "remove":
	case "save":
		include_once ("../class/cbanner.php");
		if ($task=="remove") {
			if (isset($_REQUEST['cid'])) {
				$arrayid = $_REQUEST['cid'];
				$count = count($arrayid);
				for ($i=0; $i<$count; $i++) {
					$sid = $arrayid[$i];
					$objbanner = $objbanner->Doc($sid);
					$objbanner->Xoa();
				}
			}
		}
		else if ($task=="save") {
			$objbanner->DocForm();
			$objbanner->Ghi();
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
			Banner Manager
			</th>
		</tr>
</table>
<table class="adminlist">
	<tr>
		<th width="20" nowrap="nowrap">#</th>
		<th width="70%" nowrap="nowrap" class="title">Banner Name</th>
		<th width="5%" nowrap="nowrap">Active</th>
		<th nowrap="nowrap">Banner ID</th>
	</tr>
	<?php
	include_once ("../class/cbanner.php");
	$array = $objbanner->Doc_danh_sach();	
	if (is_array($array)) {
		$indexrow = 0;
		$count = count($array);
		for ($i=0; $i<$count; $i++) {
			$objbanner = $array[$i];
			$link = "index.php?module=com_banner&task=edit&id=" . $objbanner->id;
	?>
	<tr class="<?php echo "row$indexrow"; ?>">
		<td><input type="checkbox" name="cid[]" value="<?php echo $objbanner->id; ?>" onclick="isChecked(this.checked);" /></td>
		<td><a href="<?php echo $link; ?>"><?php echo $objbanner->title; ?> <?php if ($objbanner->describe != "") echo " ($objbanner->describe)"; ?></a></td>
		<td align="center">
		<input type="text" name="active" size="5" value="<?php echo ($objbanner->active == 1) ? "active" : "none"; ?>" class="text_area" style="text-align: center" readonly />
		</td>
		<td align="center"><input type="text" name="id[]" size="5" value="<?php echo $objbanner->id; ?>" readonly class="text_area" style="text-align: center;" /></td>
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
  <input name="module" type="hidden" id="module" value="com_banner">
  <input name="boxchecked" type="hidden" id="boxchecked" value="0" />
  <input name="task" type="hidden" id="task" value="" />
</form>
</div></div>
</td></tr>
</table>