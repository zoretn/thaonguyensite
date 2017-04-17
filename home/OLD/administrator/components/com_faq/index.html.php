<?php
defined("_ALLOW") or die ("Access denied");
?>
<?php
checkpermission("grantfaq",1) or die ("Access denied");
?>
<?php
$task = "";
if (isset($_REQUEST['task']))
	$task = $_REQUEST['task'];
else if (isset($_GET['task']))
	$task = $_GET['task'];

?>
<?php
include("components/com_faq/toolbar.html.php");
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
		$ask = "";
		$ask_en = "";
		$fulltext = "";
		$fulltext_en = "";
		$msgtask = "New";
		$msgtitle = "";
		if ($task == "edit") {
			include_once ("../class/cfaq.php");
			$id = $_GET['id'];
			$objfaq = $objfaq->Doc($id);
			$ask = $objfaq->ask;
			$ask_en = $objfaq->ask_en;
			$fulltext = $objfaq->full_text;
			$fulltext_en = $objfaq->full_text_en;
			$msgtask = "Edit";
			$msgtitle = "[" . $ask . "]";
		}
?>
<script language="javascript" type="text/javascript">
function submitbutton(pressbutton) {
	var form = document.adminForm;
	if (pressbutton == 'cancel') {
		submitform( pressbutton );
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
			FAQ:
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
					FAQ Details
				    <input name="id" type="hidden" id="id" value="<?php echo $id; ?>" /></th>
				<tr>				
				<tr>
					<td width="8%" valign="top">
					Ask</td>
					<td colspan="2">
					<textarea name="ask" id="ask" style="width:100%"><?php echo $ask; ?></textarea></td>
				</tr>
				<tr>
					<td valign="top">
					Ask (English)</td>
					<td colspan="2">
					<textarea name="ask_en" id="ask_en" style="width:100%"><?php echo $ask_en; ?></textarea></td>
				</tr>
				<tr>
				  <td valign="top">Answer</td>
				  <td colspan="2"><textarea name="full_text" id="full_text" style="width:100%"><?php echo $fulltext; ?></textarea></td>
				  </tr>
				<tr>
				  <td valign="top">Answer (English) </td>
				  <td colspan="2"><textarea name="full_text_en" id="full_text_en" style="width:100%"><?php echo $fulltext_en; ?></textarea></td>
				  </tr>
			</table>
			</td>
		  </tr>
		</table>
<?php
		include("components/com_faq/toolbar.html.php");
		break;
	case "order":
	case "remove":
	case "save":
		include_once ("../class/cfaq.php");
		if ($task=="remove") {
			if (isset($_REQUEST['cid'])) {
				$arrayid = $_REQUEST['cid'];
				$count = count($arrayid);
				for ($i=0; $i<$count; $i++) {
					$sid = $arrayid[$i];
					$objfaq = $objfaq->Doc($sid);
					$objfaq->Xoa();
				}
			}
		}
		else if ($task=="save") {
			$objfaq->DocForm();
			$objfaq->Ghi();
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
						$objfaq = $objfaq->Doc($sid);
						$objfaq->ChangeOrder($arrayorder[$i]);
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
			FAQ Manager
			</th>
		</tr>
</table>
<table class="adminlist">
	<tr>
		<th width="20" nowrap="nowrap">#</th>
		<th width="65%" nowrap="nowrap" class="title">FAQ</th>
		<th width="5%" nowrap="nowrap">Order</th>
		<th nowrap="nowrap">FAQ ID</th>
	</tr>
	<?php
	include_once ("../class/cfaq.php");
	$array = $objfaq->Doc_danh_sach();	
	if (is_array($array)) {
		$indexrow = 0;
		$count = count($array);
		for ($i=0; $i<$count; $i++) {
			$objfaq = $array[$i];
			$link = "index.php?module=com_faq&task=edit&id=" . $objfaq->id;
	?>
	<tr class="<?php echo "row$indexrow"; ?>">
		<td><input type="checkbox" name="cid[]" value="<?php echo $objfaq->id; ?>" onclick="isChecked(this.checked);" /></td>
		<td><a href="<?php echo $link; ?>"><?php echo $objfaq->ask; ?></a></td>
		<td align="center">
		<input type="text" name="order[]" size="5" value="<?php echo $objfaq->order; ?>" class="text_area" style="text-align: center"  onchange="return checkunsigned(this);" />
		<input type="hidden" name="preorder[]" value="<?php echo $objfaq->order; ?>" />		</td>
		<td align="center"><input type="text" name="id[]" size="5" value="<?php echo $objfaq->id; ?>" readonly class="text_area" style="text-align: center;" /></td>
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
  <input name="module" type="hidden" id="module" value="com_faq">
  <input name="boxchecked" type="hidden" id="boxchecked" value="0" />
  <input name="task" type="hidden" id="task" value="" />
</form>
</div></div>
</td></tr>
</table>