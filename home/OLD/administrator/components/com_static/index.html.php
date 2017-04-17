<?php
defined("_ALLOW") or die ("Access denied");
?>
<?php
checkpermission("grantstatic",1) or die ("Access denied");
?>
<?php
$task = "";
if (isset($_REQUEST['task']))
	$task = $_REQUEST['task'];
else if (isset($_GET['task']))
	$task = $_GET['task'];

?>
<?php
include("components/com_static/toolbar.html.php");
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
		$tag = "";
		$introtext = "";
		$introtext_en = "";
		$introtext_cn = "";
		$msgtask = "New";
		$msgtitle = "";
		if ($task == "edit") {
			include_once ("../class/cstaticcontent.php");
			$id = $_GET['id'];
			$objstaticcontent = $objstaticcontent->Doc($id);
			$title = $objstaticcontent->title;
			
			$title_en = $objstaticcontent->title_en;
			$title_cn = $objstaticcontent->title_cn;
			$describe = $objstaticcontent->describe;
			
			$tag = $objstaticcontent->tag;
			
			$introtext = $objstaticcontent->introtext;
			$introtext_en = $objstaticcontent->introtext_en;
			$introtext_cn = $objstaticcontent->introtext_cn;
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
	//form.title_menuitem.value = trim(form.title_menuitem.value);
	/*if ( pressbutton == 'menulink' ) {		
		if ( form.menu_menuitem.value == "" ) {
			alert( "Please select a Menu" );
			return;
		} 
		else if ( form.title_menuitem.value == "" ) {
			alert( "Please enter a Title for this menu item" );
			return;
		}
	}*/
	var title = form.title.value;
	form.title.value = trim(title);
	title = form.title.value;
	if (title == "") {
		alert("Static must have a title");
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
			Static Content:
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
					Static Content Details
				    <input name="id" type="hidden"  id="id" value="<?php echo $id; ?>" /></th>
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
				  <td valign="top">Introtext</td>
				  <td colspan="2"><textarea name="introtext" id="introtext" style="width:100%"><?php echo $introtext; ?></textarea></td>
				  </tr>
				<tr>
				  <td valign="top">Introtext (English) </td>
				  <td colspan="2"><textarea name="introtext_en" id="introtext_en" style="width:100%"><?php echo $introtext_en; ?></textarea></td>
				  </tr>
				  <tr>
				  <td valign="top">Introtext (Chinese) </td>
				  <td colspan="2"><textarea name="introtext_cn" id="introtext_cn" style="width:100%"><?php echo $introtext_cn; ?></textarea></td>
				  </tr>
			</table>
			</td>
			
			
		  </tr>
		</table>
<?php
		include("components/com_static/toolbar.html.php");
		break;
	case "order":
	case "remove":
	case "save":
		include_once ("../class/cstaticcontent.php");
		if ($task=="remove") {
			if (isset($_REQUEST['cid'])) {
				$arrayid = $_REQUEST['cid'];
				$count = count($arrayid);
				for ($i=0; $i<$count; $i++) {
					$sid = $arrayid[$i];
					$objstaticcontent = $objstaticcontent->Doc($sid);
					$objstaticcontent->Xoa();
				}
			}
		}
		else if ($task=="save") {
			$objstaticcontent->DocForm();
			$objstaticcontent->Ghi();
			if (checksupper()) {
				if (isset($_REQUEST['menu_menuitem'])) {
					if ($_REQUEST['menu_menuitem']!="" && $_REQUEST['title_menuitem']!="") {
					include_once ("../class/cmenuitem.php");
						$objmenuitem->DocForm();
						$objmenuitem->url = "index.php?module=com_static&id=$resultid";
						$objmenuitem->Ghi();
					}
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
						$objstaticcontent = $objstaticcontent->Doc($sid);
						$objstaticcontent->ChangeOrder($arrayorder[$i]);
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
<script language="javascript">
	function GotoPage (page) {
		var form = document.adminForm;
		form.curPage.value = page;
		form.submit();
	}
</script>
<table class="adminheading">
		<tr>
			 <th class="sections">
			Static Content Manager
			</th>
		</tr>
</table>
<table class="adminlist">
	<tr>
		<th width="20" nowrap="nowrap">#</th>
		<th width="65%" nowrap="nowrap" class="title">Static Name</th>
		<th nowrap="nowrap">Static ID</th>
	</tr>
	<?php
	include_once ("../class/cstaticcontent.php");	
	$array = $objstaticcontent->Doc_danh_sach();
	$stroutpaging = "";
	if (is_array($array)) {
		$totalPages = 0;
		$curPage = 1;
		$curRow = 1;
		$totalRows = count($array);
		$maxRows = 15;
		$maxPages = 5;
		include ("common/paging.php");
		$stroutpaging = Paging_GetPaging ();
		$array = Paging_Get_List_Content ($array);
		
		$indexrow = 0;
		$count = count($array);
		for ($i=0; $i<$count; $i++) {
			$objstaticcontent = $array[$i];
			$link = "index.php?module=com_static&task=edit&id=" . $objstaticcontent->id;
	?>
	<tr class="<?php echo "row$indexrow"; ?>" >
		<td><input type="checkbox" name="cid[]" value="<?php echo $objstaticcontent->id; ?>" onclick="isChecked(this.checked);" /></td>
		<td><a href="<?php echo $link; ?>"><?php echo $objstaticcontent->title; ?> <?php if ($objstaticcontent->describe != "") echo " ($objstaticcontent->describe)"; ?></a></td>
		<td align="center"><input type="text" name="id[]" size="5" value="<?php echo $objstaticcontent->id; ?>" readonly class="text_area" style="text-align: center;" /></td>
	</tr>
	<?php
			$indexrow = 1 - $indexrow;
		}
	}
	?>
    <tr><td colspan="3" align="center"><?php echo $stroutpaging; ?></td></tr>
</table>
<?php
	break;
}
?>
  <input name="module" type="hidden" id="module" value="com_static">
  <input name="boxchecked" type="hidden" id="boxchecked" value="0" />
  <input name="task" type="hidden" id="task" value="" />
  <input name="curPage" type="hidden" id="curPage" value="1" />
</form>
</div></div>
</td></tr>
</table>