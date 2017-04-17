<?php
defined("_ALLOW") or die ("Access denied");
?>
<?php
checkpermission("grantlink",1) or die ("Access denied");
?>
<?php
$task = "";
if (isset($_REQUEST['task']))
	$task = $_REQUEST['task'];
else if (isset($_GET['task']))
	$task = $_GET['task'];

?>
<?php
include("components/com_weblink/toolbar.html.php");
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
		$address = "";
		$msgtask = "New";
		$msgtitle = "";
		if ($task == "edit") {
			include_once ("../class/clink.php");
			$id = $_GET['id'];
			$objlink = $objlink->Doc($id);
			$title = $objlink->title;
			
			$title_en = $objlink->title_en;
			$title_cn = $objlink->title_cn;
			$address = $objlink->address;
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
		alert("Link must have a title");
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
			Link:
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
					Link Details
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
					Title (China)</td>
					<td colspan="2">
					<input name="title_cn" type="text" class="text_area" id="title_cn" value="<?php echo $title_cn; ?>" size="50" maxlength="255" />					</td>
				</tr>
				<tr>
				  <td>Url</td>
				  <td colspan="2"><input name="address" type="text" class="text_area" id="address" value="<?php echo $address; ?>" size="50" maxlength="255" /></td>
				  </tr>
			</table>
			</td>
		  </tr>
		</table>
<?php
		break;
	case "remove":
	case "save":
		include_once ("../class/clink.php");
		if ($task=="remove") {
			if (isset($_REQUEST['cid'])) {
				$arrayid = $_REQUEST['cid'];
				$count = count($arrayid);
				for ($i=0; $i<$count; $i++) {
					$sid = $arrayid[$i];
					$objlink = $objlink->Doc($sid);
					$objlink->Xoa();
				}
			}
		}
		else if ($task=="save") {
			$objlink->DocForm();
			$objlink->Ghi();
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
			Link Manager
			</th>
		</tr>
</table>
<table class="adminlist">
	<tr>
		<th width="20" nowrap="nowrap">#</th>
		<th width="65%" nowrap="nowrap" class="title">Link Name</th>
		<th nowrap="nowrap">Link ID</th>
	</tr>
	<?php
	include_once ("../class/clink.php");
	$array = $objlink->Doc_danh_sach();	
	if (is_array($array)) {
		$indexrow = 0;
		$count = count($array);
		for ($i=0; $i<$count; $i++) {
			$objlink = $array[$i];
			$link = "index.php?module=com_weblink&task=edit&id=" . $objlink->id;
	?>
	<tr class="<?php echo "row$indexrow"; ?>">
		<td><input type="checkbox" name="cid[]" value="<?php echo $objlink->id; ?>" onclick="isChecked(this.checked);" /></td>
		<td><a href="<?php echo $link; ?>"><?php echo $objlink->title; ?></a></td>
		<td align="center"><input type="text" name="id[]" size="5" value="<?php echo $objlink->id; ?>" readonly class="text_area" style="text-align: center;" /></td>
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
  <input name="module" type="hidden" id="module" value="com_weblink">
  <input name="boxchecked" type="hidden" id="boxchecked" value="0" />
  <input name="task" type="hidden" id="task" value="" />
</form>
</div></div>
</td></tr>
</table>