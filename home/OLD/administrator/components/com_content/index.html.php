<?php
defined("_ALLOW") or die ("Access denied");
?>
<?php
checkadmin() or die ("Access denied");
?>
<?php
$task = "";
if (isset($_REQUEST['task']))
	$task = $_REQUEST['task'];
else if (isset($_GET['task']))
	$task = $_GET['task'];

?>
<?php
include("components/com_content/toolbar.html.php");
include_once("../class/csection.php");
include_once("../class/ccategory.php");
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
		$tsid = -1;
		$tcatid = -1;
		$introtext = "";
		$introtext_en = "";
		$introtext_cn = "";
		$fulltext = "";
		$fulltext_en = "";
		$fulltext_cn = "";		
		$image = "";
		$imageposition = "Left";
		$timenow = getdate();
		$yearnow  = $timenow['year'];
		$monthnow = $timenow['mon'];
		if ($monthnow < 10) $monthnow = "0" . $monthnow;
		$daynow = $timenow['mday'];
		if ($daynow < 10) $daynow = "0" . $daynow;
		$ttime = $yearnow."-".$monthnow."-".$daynow;
		$msgtask = "New";
		$msgtitle = "";
		if ($task == "edit") {
			include_once ("../class/ccontent.php");
			$id = $_GET['id'];
			$objcontent = $objcontent->Doc($id);
			$title = $objcontent->title;
			
			$title_en = $objcontent->title_en;
			$title_cn = $objcontent->title_cn;
			$describe = $objcontent->describe;
			
			$tag = $objcontent->tag;
			
			$tsid = $objcontent->sid;
			$tcatid = $objcontent->catid;
			$introtext = $objcontent->introtext;
			$introtext_en = $objcontent->introtext_en;
			$introtext_cn = $objcontent->introtext_cn;			
			$fulltext = $objcontent->full_text;
			$fulltext_en = $objcontent->full_text_en;
			$fulltext_cn = $objcontent->full_text_cn;			
			$image = $objcontent->image;
			$imageposition = $objcontent->imageposition;
			$ttime = $objcontent->ttime;
			$msgtask = "Edit";
			$msgtitle = "[" . $title . "]";
		}
		if (isset($_REQUEST['title'])) {
			$id = $_REQUEST['id'];
			$title = $_REQUEST['title'];
			$title_en = $_REQUEST['title_en'];
			$title_cn = $_REQUEST['title_cn'];
			$describe = $_REQUEST['describe'];
			$tag = $_REQUEST['tag'];
			$tsid = $_REQUEST['sid'];
			$tcatid = $_REQUEST['catid'];
			$introtext = $_REQUEST['introtext'];
			$introtext_en = $_REQUEST['introtext_en'];
			$introtext_cn = $_REQUEST['introtext_cn'];			
			$fulltext = $_REQUEST['full_text'];
			$fulltext_en = $_REQUEST['full_text_en'];
			$fulltext_cn = $_REQUEST['full_text_cn'];			
			$image = $_REQUEST['image'];
			$imageposition = $_REQUEST['imageposition'];
			$ttime = $_REQUEST['time'];
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
	var sid = form.sid.value;
	var catid = form.catid.value;
	if (title == "") {
		alert("Content must have a title");
		return;
	}
	else if (sid==-1) {
		alert("Content must have a section");
		return;
	}
	else if (catid==-1) {
		alert("Content must have a category");
		return;
	}
	else {
		submitform(pressbutton);
	}
}
</script>
<!-- Calendar -->
<link rel="stylesheet" type="text/css" media="all" href="../calendar/js/calendar/calendar-mos.css" title="green" />
<!-- import the calendar script -->
<script language="javascript" src="../calendar/js/calendar/calendar_mini.js"></script>
<script language="javascript" src="../calendar/js/calendar/lang/calendar-en.js"></script>
<!-- Calendar -->

<table class="adminheading">
		<tr>
			<th class="sections">
			Content:
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
					Content Details
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
				  <td>Created Date </td>
				  <td colspan="2" valign="top"><input name="time" type="text" id="time" class="text_area" readonly value="<?php echo $ttime; ?>" /><input type="button" onclick="return showCalendar('time', 'yyyy-mm-dd');" value=" ... " /></td>
				  </tr>
				<tr>
				  <td>Section</td>
				  <td colspan="2">
				  <?php
				  $arraysection = $objsection->Doc_danh_sach();
				  ?>
				  <select name="sid" class="inputbox" size="1" onChange="document.adminForm.task.value='new'; document.adminForm.submit();" >
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
				  <td>Category</td>
				  <td colspan="2">
				  <?php
				  include_once("../class/cadmin.php");
				  $useridview = $_SESSION['_idadmin'];
				  $objadmin = $objadmin->Doc($useridview);
				  $arraygrantcat = $objadmin->Get_ArrayGrantCat("cat");
					$strwhere = "";
					$countgrantcat = 0;
					if (is_array($arraygrantcat)) {
						foreach ($arraygrantcat as $grantcat) {
							if ($strwhere == "") {
								$strwhere = " AND id IN (";
							}
							if ($countgrantcat > 0)
								$strwhere .= ", ";
							$countgrantcat++;
							$strwhere .= "$grantcat";
						}
					}
					if ($countgrantcat > 0)
						$strwhere .= ")";
					elseif(!checksupper())
						$strwhere = "AND id = -1";
				  $strwhere = "sid=$tsid" . $strwhere;
				  $arraycategory = $objcategory->Fill($strwhere);
				  ?>
				  <select name="catid" class="inputbox" size="1" >
	<option value="-1" <?php if ($tcatid==-1) echo "selected='selected'"; ?> >- Select Category -</option>
	<?php
		if (is_array($arraycategory)) {
			$count = count($arraycategory);
			for ($i=0; $i<$count; $i++) {
	?>
		<option value="<?php echo $arraycategory[$i]->id; ?>" <?php if ($tcatid==$arraycategory[$i]->id) echo "selected='selected'"; ?> ><?php echo $arraycategory[$i]->title; ?> <?php if ($arraycategory[$i]->describe != "") echo " (" . $arraycategory[$i]->describe . ")"; ?></option>
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
				  <td colspan="2"><textarea name="introtext_cn" id="introtext_cn" style="width:100%"><?php echo $introtext_cn; ?></textarea></td>
				  </tr>
				<tr>
				  <td valign="top">Fulltext</td>
				  <td colspan="2"><textarea name="full_text" id="full_text" style="width:100%"><?php echo $fulltext; ?></textarea></td>
				  </tr>
				<tr>
				  <td valign="top">Fulltext (English) </td>
				  <td colspan="2"><textarea name="full_text_en" id="full_text_en" style="width:100%"><?php echo $fulltext_en; ?></textarea></td>
				  </tr>
				  <tr>
				  <td valign="top">Fulltext (Chinese) </td>
				  <td colspan="2"><textarea name="full_text_cn" id="full_text_cn" style="width:100%"><?php echo $fulltext_en; ?></textarea></td>
				  </tr>
				<tr>
				  <td valign="top">Image</td>
				  <td colspan="2"><input name="image" type="text" class="text_area" id="image" value="<?php echo $image; ?>" size="30" maxlength="255"  />
			      <input name="button" type="button" onclick="openBox(750,500,'no','no',0,0,'../editor/tmedit/popups/insert_image_en.php?txt=image&sorturl=1', window);" value=" ... " /></td>
				</tr>
				<tr>
				  <td valign="top">Image Position </td>
				  <td colspan="2"><select name="imageposition" id="imageposition" class="inputbox">
				    <option value="Default" <?php if ($imageposition == "Default") echo "selected=\"selected\""; ?> >Default</option>
				    <option value="Baseline" <?php if ($imageposition == "Baseline") echo "selected=\"selected\""; ?>>Baseline</option>
				    <option value="Top" <?php if ($imageposition == "Top") echo "selected=\"selected\""; ?>>Top</option>
				    <option value="Middle" <?php if ($imageposition == "Middle") echo "selected=\"selected\""; ?>>Middle</option>
				    <option value="Bottom" <?php if ($imageposition == "Bottom") echo "selected=\"selected\""; ?>>Bottom</option>
				    <option value="TextTop" <?php if ($imageposition == "TextTop") echo "selected=\"selected\""; ?>>TextTop</option>
				    <option value="Absolute Middle" <?php if ($imageposition == "Absolute Middle") echo "selected=\"selected\""; ?>>Absolute Middle</option>
				    <option value="Absolute Bottom" <?php if ($imageposition == "Absolute Bottom") echo "selected=\"selected\""; ?>>Absolute Bottom</option>
				    <option value="Left" <?php if ($imageposition == "Left") echo "selected=\"selected\""; ?>>Left</option>
				    <option value="Right" <?php if ($imageposition == "Right") echo "selected=\"selected\""; ?>>Right</option>
				    </select></td>
				  </tr>
			</table>
			</td>
		  </tr>
		</table>
<?php
		include("components/com_content/toolbar.html.php");
		break;
	case "order":
	case "remove":
	case "save":
		include_once ("../class/ccontent.php");
		if ($task=="remove") {
			if (isset($_REQUEST['cid'])) {
				$arrayid = $_REQUEST['cid'];
				$count = count($arrayid);
				for ($i=0; $i<$count; $i++) {
					$sid = $arrayid[$i];
					$objcontent = $objcontent->Doc($sid);
					$objcontent->Xoa();
				}
			}
		}
		else if ($task=="save") {
			$objcontent->DocForm();
			$objcontent->Ghi();
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
						$objcontent = $objcontent->Doc($sid);
						$objcontent->ChangeOrder($arrayorder[$i]);
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
			Content Manager			</th>
			<td width="right">
<?php
$tsid = -1;
if (isset($_REQUEST['sid'])) $tsid = $_REQUEST['sid'];
$arraysection = $objsection->Doc_danh_sach();
?>Section
<select name="sid" class="inputbox" size="1" onChange="document.adminForm.curPage.value=1; document.adminForm.catid.value=-1; document.adminForm.submit();"  >
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
</select>		  </td>
		    <td width="right">
			<?php
$tcatid = -1;
if (isset($_REQUEST['catid'])) $tcatid = $_REQUEST['catid'];
if ($tsid==-1)
$arraycategory = $objcategory->Doc_danh_sach();
else
$arraycategory = $objcategory->Doc_danh_sach($tsid);
?>
			Category
			<select name="catid" class="inputbox" size="1" onChange="document.adminForm.curPage.value=1; document.adminForm.submit();"  >
	<option value="-1" <?php if ($tcatid==-1) echo "selected='selected'"; ?> >- Select Category -</option>
	<?php
	if (is_array($arraycategory)) {
		$count = count($arraycategory);
		for ($i=0; $i<$count; $i++) {
	?>
		<option value="<?php echo $arraycategory[$i]->id; ?>" <?php if ($tcatid==$arraycategory[$i]->id) echo "selected='selected'"; ?> ><?php echo $arraycategory[$i]->title; ?> <?php if ($arraycategory[$i]->describe != "") echo " (" . $arraycategory[$i]->describe . ")"; ?> </option>
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
		<th width="30%" nowrap="nowrap" class="title">Content Name</th>
		<th width="10%" nowrap="nowrap">Date Create </th>
		<th width="5%" nowrap="nowrap">Order</th>
		<th width="20%" nowrap="nowrap" class="title">Section</th>
		<th width="20%" nowrap="nowrap" class="title">Category</th>
		<th nowrap="nowrap">Content ID</th>
	</tr>
	<?php
	include_once ("../class/ccontent.php");	
	$strwhere = "";
	if ($tsid != -1) $strwhere = "sid = $tsid";
	if ($tcatid != -1) $strwhere = "catid = $tcatid";
	$useridview = -1;
	if (!checksupper()) {
		$useridview = $_SESSION['_idadmin'];
		if ($strwhere == "")
			$strwhere .= "createby = $useridview";
		else
			$strwhere .= " AND createby = $useridview";
	}
	else {
		if (isset($_GET['useridview'])) $useridview = $_GET['useridview'];
		if (isset($_REQUEST['useridview'])) $useridview = $_REQUEST['useridview'];
		if ($useridview > -1) {
			if ($strwhere == "")
				$strwhere .= "createby = $useridview";
			else
				$strwhere .= " AND createby = $useridview";
		}
	}
	$totalRows = $objcontent->CountFill($strwhere);
	if ($totalRows > 0) {
		$totalPages = 0;
		$curPage = 1;
		$curRow = 1;
		$maxRows = 30;
		$maxPages = 5;
		include ("common/paging.php");
		$stroutpaging = Paging_GetPaging ();
		$beginrow = ($curPage - 1) * $maxRows;
		$arraycontent = $objcontent->Fill ($strwhere, $maxRows, $beginrow);
		$indexrow = 0;
		$count = count($arraycontent);
		for ($i=0; $i<$count; $i++) {
			$objcontent = $arraycontent[$i];
			$link = "index.php?module=com_content&task=edit&id=" . $objcontent->id;
	?>
	<tr class="<?php echo "row$indexrow"; ?>" >
		<td><input type="checkbox" name="cid[]" value="<?php echo $objcontent->id; ?>" onClick="isChecked(this.checked);" /></td>
		<td><a href="<?php echo $link; ?>"><?php echo $objcontent->title; ?> <?php if ($objcontent->describe!="") echo "($objcontent->describe)"; ?></a></td>
		<td align="center"><?php echo $objcontent->fttime; ?></td>
		<td align="center">
		<input type="text" name="order[]" size="5" value="<?php echo $objcontent->order; ?>" class="text_area" style="text-align: center"  onchange="return checkunsigned(this);" />
		<input type="hidden" name="preorder[]" value="<?php echo $objcontent->order; ?>" />		</td>
		<td>
		<?php
			$sid = $objcontent->sid;
			$objsection = $objsection->Doc($sid);
			$linksection = "index.php?module=com_section&task=edit&id=" . $objsection->id;
		?>
		<a href="<?php echo $linksection; ?>"><?php echo $objsection->title; ?><?php if ($objsection->describe != "") echo " ($objsection->describe)"; ?></a>		</td>
		<td>
		<?php
			$sid = $objcontent->catid;
			$objcategory = $objcategory->Doc($sid);
			$linksection = "index.php?module=com_category&task=edit&id=" . $objcategory->id;
		?>
		<a href="<?php echo $linksection; ?>"><?php echo $objcategory->title; ?> <?php if ($objcategory->describe != "") echo " ($objcategory->describe)"; ?></a>		</td>
		<td align="center"><input type="text" name="id[]" size="5" value="<?php echo $objcontent->id; ?>" readonly class="text_area" style="text-align: center;" /></td>
	</tr>
	<?php
			$indexrow = 1 - $indexrow;
		}
	?>
	<tr><td colspan="7"><?php echo $stroutpaging; ?></td></tr>
	<?php
	}
	?>
</table>
<?php
	break;
}
?>
  <input name="module" type="hidden" id="module" value="com_content">
  <input name="boxchecked" type="hidden" id="boxchecked" value="0" />
  <input name="task" type="hidden" id="task" value="<?php echo $task; ?>" />
  <input name="curPage" type="hidden" id="curPage" value="1" />
  <input name="useridview" type="hidden" value="<?php echo $useridview; ?>" />
</form>
</div></div>
</td></tr>
</table>