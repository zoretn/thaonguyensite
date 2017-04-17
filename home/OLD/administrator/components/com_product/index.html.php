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
include("components/com_product/toolbar.html.php");
include_once("../class/cproductsection.php");
include_once("../class/cproductcategory.php");
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
		$code = "";
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
		$price = 0;
		$msgtask = "New";
		$msgtitle = "";
		if ($task == "edit") {
			include_once ("../class/cproduct.php");
			$id = $_GET['id'];
			$objproduct = $objproduct->Doc($id);
			$code = $objproduct->code;
			
			$title = $objproduct->title;
			
			$title_en = $objproduct->title_en;
			$title_cn = $objproduct->title_cn;
			$describe = $objproduct->describe;
			
			$tag = $objproduct->tag;
			
			$tsid = $objproduct->sid;
			$tcatid = $objproduct->catid;
			$introtext = $objproduct->introtext;
			$introtext_en = $objproduct->introtext_en;
			$introtext_cn = $objproduct->introtext_cn;
			$fulltext = $objproduct->full_text;
			$fulltext_en = $objproduct->full_text_en;
			$fulltext_cn = $objproduct->full_text_cn;
			$image = $objproduct->image;
			$price = $objproduct->fprice;
			if ($price == 0) $price = "";
			$msgtask = "Edit";
			$msgtitle = "[" . $title . "]";
		}
		if (isset($_REQUEST['title'])) {
			$id = $_REQUEST['id'];
			$code = $_REQUEST['code'];
			$title = $_REQUEST['title'];
			$title_en = $_REQUEST['title_en'];
			$title_cn = $_REQUEST['title_cn'];
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
			$price = $_REQUEST['price'];
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
		alert("Product must have a title");
		return;
	}
	else if (sid==-1) {
		alert("Product must have a section");
		return;
	}
	else if (catid==-1) {
		alert("Product must have a category");
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
			Product:
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
					Product Details
				      <input name="id" type="hidden" id="id" value="<?php echo $id; ?>" /></th>
				<tr>				
				<tr>
				  <td>Code</td>
				  <td colspan="2"><input name="code" type="text" class="text_area" id="code" value="<?php echo $code; ?>" size="50" maxlength="50" /></td>
				  </tr>
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
				  <td>Describe</td>
				  <td colspan="2"><input name="describe" type="text" class="text_area" id="describe" value="<?php echo $describe; ?>" size="50" maxlength="255" /></td>
				  </tr>
				<tr>
				  <td>Tag</td>
				  <td colspan="2"><input name="tag" type="text" class="text_area" id="tag" value="<?php echo $tag; ?>" size="50" maxlength="255" /></td>
				  </tr>
				<tr>
				  <td>Price</td>
				  <td colspan="2"><input name="price" type="text" id="price" class="text_area" value="<?php echo $price; ?>" /></td>
				  </tr>
				<tr>
				  <td>Section</td>
				  <td colspan="2">
				  <?php
				  $arrayproductsection = $objproductsection->Doc_danh_sach();
				  ?>
				  <select name="sid" class="inputbox" size="1" onChange="document.adminForm.task.value='new'; document.adminForm.submit();" >
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
				  <td>Category</td>
				  <td colspan="2">
				  <?php
				  include_once("../class/cadmin.php");
				  $currentadminid = $_SESSION['_idadmin'];
				  $objadmin = $objadmin->Doc($currentadminid);
				  $arraygrantcat = $objadmin->Get_ArrayGrantCat("productcat");
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
				  
				  $arrayproductcategory = $objproductcategory->Fill($strwhere);
				  ?>
				  <select name="catid" class="inputbox" size="1" >
	<option value="-1" <?php if ($tcatid==-1) echo "selected='selected'"; ?> >- Select Category -</option>
	<?php
		if (is_array($arrayproductcategory)) {
			$count = count($arrayproductcategory);
			for ($i=0; $i<$count; $i++) {
	?>
		<option value="<?php echo $arrayproductcategory[$i]->id; ?>" <?php if ($tcatid==$arrayproductcategory[$i]->id) echo "selected='selected'"; ?> ><?php echo $arrayproductcategory[$i]->title; ?> <?php if ($arrayproductcategory[$i]->describe != "") echo " (" . $arrayproductcategory[$i]->describe . ")"; ?></option>
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
				  <td valign="top">Introtext (China) </td>
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
				  <td valign="top">Fulltext (China) </td>
				  <td colspan="2"><textarea name="full_text_cn" id="full_text_cn" style="width:100%"><?php echo $fulltext_cn; ?></textarea></td>
				  </tr>
				<tr>
				  <td valign="top">Image</td><td colspan="2"><input name="image" type="text" class="text_area" id="image" value="<?php echo $image; ?>" size="30" maxlength="255"  />
			      <input type="button" value=" ... " class="button"  onclick="openBox(750,500,'no','no',0,0,'../editor/tmedit/popups/insert_image_en.php?txt=image&sorturl=1', window);"/></td>
				  </tr>
			</table>
		  </td>
		  </tr>
		</table>
<?php
		include("components/com_product/toolbar.html.php");
		break;
	case "order":
	case "remove":
	case "save":
		include_once ("../class/cproduct.php");
		if ($task=="remove") {
			if (isset($_REQUEST['cid'])) {
				$arrayid = $_REQUEST['cid'];
				$count = count($arrayid);
				for ($i=0; $i<$count; $i++) {
					$sid = $arrayid[$i];
					$objproduct = $objproduct->Doc($sid);
					$objproduct->Xoa();
				}
			}
		}
		else if ($task=="save") {
			$objproduct->DocForm();
			$objproduct->Ghi();
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
						$objproduct = $objproduct->Doc($sid);
						$objproduct->ChangeOrder($arrayorder[$i]);
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
			Product Manager			</th>
			<td width="right">
<?php
$tsid = -1;
if (isset($_REQUEST['sid'])) $tsid = $_REQUEST['sid'];
$arrayproductsection = $objproductsection->Doc_danh_sach();
?>Section
<select name="sid" class="inputbox" size="1" onChange="document.adminForm.catid.value=-1; document.adminForm.submit();"  >
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
</select>		  </td>
		    <td width="right">
			<?php
$tcatid = -1;
if (isset($_REQUEST['catid'])) $tcatid = $_REQUEST['catid'];
if ($tsid==-1)
$arrayproductcategory = $objproductcategory->Doc_danh_sach();
else
$arrayproductcategory = $objproductcategory->Doc_danh_sach($tsid);
?>
			Category
			<select name="catid" class="inputbox" size="1" onChange="document.adminForm.submit();"  >
	<option value="-1" <?php if ($tcatid==-1) echo "selected='selected'"; ?> >- Select Category -</option>
	<?php
	if (is_array($arrayproductcategory)) {
		$count = count($arrayproductcategory);
		for ($i=0; $i<$count; $i++) {
	?>
		<option value="<?php echo $arrayproductcategory[$i]->id; ?>" <?php if ($tcatid==$arrayproductcategory[$i]->id) echo "selected='selected'"; ?> ><?php echo $arrayproductcategory[$i]->title; ?> <?php if ($arrayproductcategory[$i]->describe != "") echo " (" . $arrayproductcategory[$i]->describe . ")"; ?></option>
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
		<th width="40%" nowrap="nowrap" class="title">Product Name</th>
		<th width="5%" nowrap="nowrap">Order</th>
		<th width="20%" nowrap="nowrap" class="title">Section</th>
		<th width="20%" nowrap="nowrap" class="title">Category</th>
		<th nowrap="nowrap">Product ID</th>
	</tr>
	<?php
	include_once ("../class/cproduct.php");	
	$strwhere = "";
	if ($tsid != -1) $strwhere = "sid = $tsid";
	if ($tcatid != -1) $strwhere = "catid = $tcatid";
	$totalRows = $objproduct->CountFill($strwhere);
	if ($totalRows > 0) {
		$totalPages = 0;
		$curPage = 1;
		$curRow = 1;
		$maxRows = 30;
		$maxPages = 5;
		include ("common/paging.php");
		$stroutpaging = Paging_GetPaging ();
		$beginrow = ($curPage - 1) * $maxRows;
		$arrayproduct = $objproduct->Fill ($strwhere, $maxRows, $beginrow);
		$indexrow = 0;
		$count = count($arrayproduct);
		for ($i=0; $i<$count; $i++) {
			$objproduct = $arrayproduct[$i];
			$link = "index.php?module=com_product&task=edit&id=" . $objproduct->id;
	?>
	<tr class="<?php echo "row$indexrow"; ?>" >
		<td><input type="checkbox" name="cid[]" value="<?php echo $objproduct->id; ?>" onClick="isChecked(this.checked);" /></td>
		<td><a href="<?php echo $link; ?>"><?php echo $objproduct->title; ?> <?php if ($objproduct->describe != "") echo " ($objproduct->describe)"; ?></a></td>
		<td align="center">
		<input type="text" name="order[]" size="5" value="<?php echo $objproduct->order; ?>" class="text_area" style="text-align: center"  onchange="return checkunsigned(this);" />
		<input type="hidden" name="preorder[]" value="<?php echo $objproduct->order; ?>" />		</td>
		<td>
		<?php
			$sid = $objproduct->sid;
			$objproductsection = $objproductsection->Doc($sid);
			$linksection = "index.php?module=com_productsection&task=edit&id=" . $objproductsection->id;
		?>
		<a href="<?php echo $linksection; ?>"><?php echo $objproductsection->title; ?> <?php if ($objproductsection->describe != "") echo " ($objproductsection->describe)"; ?></a>		</td>
		<td>
		<?php
			$sid = $objproduct->catid;
			$objproductcategory = $objproductcategory->Doc($sid);
			$linksection = "index.php?module=com_productcategory&task=edit&id=" . $objproductcategory->id;
		?>
		<a href="<?php echo $linksection; ?>"><?php echo $objproductcategory->title; ?> <?php if ($objproductcategory->describe != "") echo " ($objproductcategory->describe)"; ?></a>
		</td>
		<td align="center"><input type="text" name="id[]" size="5" value="<?php echo $objproduct->id; ?>" readonly class="text_area" style="text-align: center;" /></td>
	</tr>
	<?php
			$indexrow = 1 - $indexrow;
		}
	}
	?>
	
	<?php
	  	$urlpaging = "index.php?module=com_product";
		//if ($inbound != -1)
//			$urlpaging .= "&inbound=" . $inbound;
		if ($tsid != -1) 
			$urlpaging .= "&sid=" . $tsid;
		if ($tcatid != -1) 
			$urlpaging .= "&catid=" . $tcatid;
      ?>
        <script language="javascript">

var url = "<?php echo $urlpaging; ?>";
function GotoPage (page) {
	var urltopage;
	urltopage =url + "&curPage=" + page;
	location.href = urltopage;
//	Ajax_Goto(url);
}
</script>
	
	<tr>
    	<td colspan="6" align="center">
        
        <?php
		echo $stroutpaging;
		?>
    </td>
    </tr>
	
	
</table>
<?php
	break;
}
?>
  <input name="module" type="hidden" id="module" value="com_product">
  <input name="boxchecked" type="hidden" id="boxchecked" value="0" />
  <input name="task" type="hidden" id="task" value="<?php echo $task; ?>" />
</form>
</div></div>
</td></tr>
</table>