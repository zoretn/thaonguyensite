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
include("components/com_users/toolbar.html.php");
?>
<br />
<div align="center" class="centermain">
<div class="main">
<form action="index.php" method="post" name="adminForm" id="adminForm" >
<?php
switch ($task) {
	case "new":
		checksupper() or die ("Access denied");
	case "edit":
		include_once ("../class/cadmin.php");
		$id = -1;
		$username = "";
		$supper = 0;
		$fullname = "";
		$email = "";
		$ym = "";
		$supper = 0;
		$arraygrantcat = array();
		$arraygrantproductcat = array();
		$grantfaq = 0;
		$grantstatic = 0;
		$grantadv = 0;
		$grantbanner = 0;
		$grantlink = 0;
		$msgtask = "New";
		$msgtitle = "";
		if ($task == "edit") {
			$id = $_GET['id'];
			$objadmin = $objadmin->Doc($id);
			$id = $objadmin->id;
			$username = $objadmin->username;
			$fullname = $objadmin->fullname;
			$email = $objadmin->email;
			$ym = $objadmin->ym;
			$supper = $objadmin->supper;
			$arraygrantcat = $objadmin->Get_ArrayGrantCat("cat");
			$arraygrantproductcat = $objadmin->Get_ArrayGrantCat("productcat");
			$grantfaq = $objadmin->grantfaq;
			$grantstatic = $objadmin->grantstatic;
			$grantadv = $objadmin->grantadv;
			$grantbanner = $objadmin->grantbanner;
			$grantlink = $objadmin->grantlink;
			$msgtask = "Edit";
			$msgtitle = "[" . $username . "]";
		}
?>
<script language="javascript" type="text/javascript">
function submitbutton(pressbutton) {
	var form = document.adminForm;
	if (pressbutton == 'cancel') {
		submitform( pressbutton );
		return;
	}
	var username = form.username.value;
	username = trim(username);
	if (username == "") {
		alert("User must have username");
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
			User:
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
				<table width="100%" class="adminform">
				<tr>
					<th colspan="3">
					User Details
				      <input name="id" type="hidden" id="id" value="<?php echo $id; ?>" /></th>
				<tr>				
				<tr>
					<td width="8%">
					Username</td>
					<td colspan="2">
					<?php if ($task=="new") { ?> 
					<input name="username" type="text" class="text_area" id="username" value="<?php echo $username; ?>" size="50" maxlength="50" />
					<?php
						}
						else {
						echo $username;
					?>
					<input name="username" type="hidden" id="username" value="<?php echo $username; ?>"  />
					<?php } ?>					</td>
				</tr>
				<tr>
					<td>
					Password</td>
					<td colspan="2">
					<input name="password" type="password" class="text_area" id="password" size="50" maxlength="50" />					</td>
				</tr>
				<tr>
				  <td valign="top">Fullname</td>
				  <td colspan="2"><input name="fullname" type="text" class="text_area" id="fullname" value="<?php echo $fullname; ?>" size="50" maxlength="255" /></td>
				</tr>
				<tr>
				  <td valign="top">Email</td>
				  <td colspan="2"><input name="email" type="text" id="email" class="text_area" value="<?php echo $email ?>" size="50" maxlength="255" /></td>
				</tr>
				<tr>
				  <td valign="top">YM!</td>
				  <td colspan="2"><input name="ym" type="text" id="ym" class="text_area" value="<?php echo $ym ?>" size="50" maxlength="255" /></td>
				  </tr>
			</table>
		  </td>
			<?php
				$showpermission = 1;
				if (isset($_GET['showpermission']))
					$showpermission = $_GET['showpermission'];
				if (checksupper() && $showpermission==1) {
			?>
			<td valign="top" width="40%">
					<table width="100%" class="adminform">
					<tr>
						<th colspan="2">
						Grant Permission</th>
					</tr>
					<tr>
						<td colspan="2">
						This will grant permission for user
						  <input name="grantpermission" type="hidden" id="grantpermission" value="1" />
						  <br />
				      <br />						</td>
					</tr>
					<tr>
					  <td valign="top">Supper
				      <input name="chksupper" type="checkbox" id="chksupper" value="1" <?php if ($supper==1) echo "checked='checked'"; ?> /></td>
					  <td width="161">&nbsp;</td>
					  </tr>
					<tr>
					  <td valign="top" width="75">
						Select Category</td>
						<td><select name="grantcat[]" size="10" multiple="multiple" class="inputbox" id="grantcat[]" style="width:150px;" >
                          <?php
							$arraygrantcat = $objadmin->Get_ArrayGrantCat("cat");
							$strwhere = "";
							$countgrantcat = 0;
							include_once("../class/ccategory.php");
							if (is_array($arraygrantcat)) {
								foreach ($arraygrantcat as $grantcat) {
									$objcategory = $objcategory->Doc($grantcat);
									if ($objcategory != null) {
							?>
                          <option value="<?php echo $grantcat; ?>" selected="selected"><?php echo $objcategory->title; ?></option>
                          <?php
										if ($strwhere == "") {
											$strwhere = "id NOT IN (";
										}
										if ($countgrantcat > 0)
											$strwhere .= ", ";
										$countgrantcat++;
										$strwhere .= "$grantcat";
									}
								}
							}
							if ($countgrantcat > 0)
								$strwhere .= ")";
							$arraycategory = $objcategory->Fill($strwhere);
							if (is_array($arraycategory)) {
								foreach ($arraycategory as $objcategory) {
							?>
                          <option value="<?php echo $objcategory->id; ?>" ><?php echo $objcategory->title; ?></option>
                          <?php
								}
							}
						?>
                        </select></td>
					</tr>
					<tr>
					  <td valign="top" width="75">
						Select Product Category</td>
						<td>
						<select name="grantproductcat[]" size="10" multiple="multiple" class="inputbox" id="grantproductcat[]" style="width:150px;" >
						 <?php
							$arraygrantcat = $objadmin->Get_ArrayGrantCat("productcat");
							$strwhere = "";
							$countgrantcat = 0;
							include_once("../class/cproductcategory.php");
							if (is_array($arraygrantcat)) {
								foreach ($arraygrantcat as $grantcat) {
									$objproductcategory = $objproductcategory->Doc($grantcat);
									if ($objproductcategory != null) {
							?>
                          <option value="<?php echo $grantcat; ?>" selected="selected"><?php echo $objproductcategory->title; ?></option>
                          <?php
										if ($strwhere == "") {
											$strwhere = "id NOT IN (";
										}
										if ($countgrantcat > 0)
											$strwhere .= ", ";
										$countgrantcat++;
										$strwhere .= "$grantcat";
									}
								}
							}
							if ($countgrantcat > 0)
								$strwhere .= ")";
							$arrayproductcategory = $objproductcategory->Fill($strwhere);
							if (is_array($arrayproductcategory)) {
								foreach ($arrayproductcategory as $objproductcategory) {
							?>
                          <option value="<?php echo $objproductcategory->id; ?>" ><?php echo $objproductcategory->title; ?></option>
                          <?php
								}
							}
						?>
						</select>						</td>
					</tr><tr>
						<td colspan="2" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="36%">FAQ</td>
                            <td width="64%"><input name="grantfaq" type="checkbox" id="grantfaq" value="1" <?php if ($grantfaq==1) echo "checked='checked'"; ?> /></td>
                          </tr>
                          <tr>
                            <td>Static Content </td>
                            <td><input name="grantstatic" type="checkbox" id="grantstatic" value="1" <?php if ($grantstatic==1) echo "checked='checked'"; ?> /></td>
                          </tr>
                          <tr>
                            <td>Advertisement</td>
                            <td><input name="grantadv" type="checkbox" id="grantadv" value="1" <?php if ($grantadv==1) echo "checked='checked'"; ?> /></td>
                          </tr>
                          <tr>
                            <td>Banner</td>
                            <td><input name="grantbanner" type="checkbox" id="grantbanner" value="1" <?php if ($grantbanner==1) echo "checked='checked'"; ?> /></td>
                          </tr>
                          <tr>
                            <td>Links</td>
                            <td><input name="grantlink" type="checkbox" id="grantlink" value="1" <?php if ($grantlink==1) echo "checked='checked'"; ?> /></td>
                          </tr>
                        </table></td>
						</tr>
			  </table>
            </td>
			<?php } ?>
		  </tr>
		</table>
<?php
		break;
	case "remove":
	case "save":
		include_once ("../class/cadmin.php");
		if ($task=="remove") {
			checksupper() or die ("Access denied");
			if (isset($_REQUEST['cid'])) {
				$arrayid = $_REQUEST['cid'];
				$count = count($arrayid);
				for ($i=0; $i<$count; $i++) {
					$sid = $arrayid[$i];
					$objadmin = $objadmin->Doc($sid);
					$objadmin->Xoa();
				}
			}
		}
		else if ($task=="save") {
			$idcurrentuser = $_REQUEST['id'];
			(checksupper() or $_SESSION['_idadmin']==$idcurrentuser) or die ("Access denied");
			$objadmin->DocForm();
			$objadmin->Ghi();
		}
		$task = "";
?>
<?php
	default:
		if (checksupper()) {
?>
<table class="adminheading">
		<tr>
			 <th class="sections">
			User Manager
			</th>
		</tr>
</table>
<table class="adminlist">
	<tr>
		<th width="20" nowrap="nowrap">#</th>
		<th width="65%" nowrap="nowrap" class="title">Username</th>
		<th nowrap="nowrap">User Contents </th>
		<th nowrap="nowrap">Supper</th>
		<th nowrap="nowrap">Static ID</th>
	</tr>
	<?php
	include_once ("../class/cadmin.php");
	$tidadmin = $_SESSION['_idadmin'];	
	$array = $objadmin->Fill("id <> $tidadmin");
	if (is_array($array)) {
		$indexrow = 0;
		$count = count($array);
		for ($i=0; $i<$count; $i++) {
			$objadmin = $array[$i];
			$link = "index.php?module=com_users&task=edit&id=" . $objadmin->id;
			$linkusercontents = "index.php?module=com_content&useridview=" . $objadmin->id;
	?>
	<tr class="<?php echo "row$indexrow"; ?>" >
		<td><input type="checkbox" name="cid[]" value="<?php echo $objadmin->id; ?>" onclick="isChecked(this.checked);" /></td>
		<td><a href="<?php echo $link; ?>"><?php echo $objadmin->username; ?></a></td>
		<td align="center"><a href="<?php echo $linkusercontents; ?>"><img src="images/mainmenu.png" width="16" height="16" border="0" /></a></td>
		<td align="center"><?php if ($objadmin->supper==1) echo "supper"; ?></td>
		<td align="center"><input type="text" name="id[]" size="5" value="<?php echo $objadmin->id; ?>" readonly class="text_area" style="text-align: center;" /></td>
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
}
?>
  <input name="module" type="hidden" id="module" value="com_users">
  <input name="boxchecked" type="hidden" id="boxchecked" value="0" />
  <input name="task" type="hidden" id="task" value="" />
</form>
</div></div>
</td></tr>
</table>