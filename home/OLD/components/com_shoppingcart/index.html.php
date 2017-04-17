<?php
defined("_ALLOW") or die ("Access denied");
?>
<script language="javascript">
function SubmitCart (pressbutton) {
	form = document.formshoppingcart;
	if (pressbutton == "ordercart") {
		if (form.totalcart.value == 0)
			return;
	}
	form.task.value = pressbutton;
	form.submit();
}
</script>
<?php
$task = "";
global $lang;
if (isset($_GET['task']))
	$task = $_GET['task'];
elseif (isset($_REQUEST['task']))
	$task = $_REQUEST['task'];
	
switch ($task) {
	case "add":
		$itemnumber = $_GET['productid'];
		$itemname = $_GET['productname'];
		$itemquanlity = $_GET['productquanlity'];
		$itemprice = $_GET['productprice'];
		$itemfprice = $_GET['productfprice'];
		if (!isset($_SESSION['item'])) {
			$_SESSION['item'][] = $itemnumber;
			$_SESSION['itemname'][] = htmlspecialchars($itemname);
			$_SESSION['itemquanlity'][] = $itemquanlity;
			$_SESSION['itemprice'][] = $itemprice;
			$_SESSION['itemfprice'][] = $itemfprice;
		}
		else {
			$arrayitem = $_SESSION['item'];
			$length = count($arrayitem);
			$i=0;
			$flag = 0;
			while ($i<$length && $arrayitem[$i] != $itemnumber) {
				$i++;
			}
			if ($i<$length) {
				$_SESSION['itemquanlity'][$i] += $itemquanlity;
				$flag = 1;
				$i = 0;
			}
			if ($flag == 0) {
				while ($i<$length && $arrayitem[$i]!=-1) {
					$i++;
				}
				$_SESSION['item'][$i] = $itemnumber;
				$_SESSION['itemname'][$i] = $itemname;
				$_SESSION['itemquanlity'][$i] = $itemquanlity;
				$_SESSION['itemprice'][$i] = $itemprice;
				$_SESSION['itemfprice'][$i] = $itemfprice;
			}
		}
		break;

	case "remove":
		if (!isset($_REQUEST['chkitem'])) break;
		$arrayremove = $_REQUEST['chkitem'];
		$length = count($arrayremove);
		for ($i=0; $i<$length; $i++) {
			$itemremove = $arrayremove[$i];
			$_SESSION['item'][$itemremove] = -1;
			$_SESSION['itemquanlity'][$itemremove] = 0;
		}
		break;
	case "modify":
		if (!isset($_REQUEST['itemindex'])) break;
		$arrayindex = $_REQUEST['itemindex'];
		$arrayquanlity = $_REQUEST['itemquanlity'];
		$length = count($arrayindex);
		for ($i=0; $i<$length; $i++) {
			$itemmodify = $arrayindex[$i];
			$_SESSION['itemquanlity'][$itemmodify] = $arrayquanlity[$i];
		}
		break;
	case "ordercart":
		$sum = $_REQUEST['totalcart'];
	?>
	<body onLoad="document.formordercart.submit();">
	<form name="formordercart" action="index.php?module=com_ordercart" method="post">
	<input type="hidden" name="task" value="ordercart" />
	<input type="hidden" name="totalcart" value="<?php echo $sum; ?>" />
	</form>
	</body>
	<?php
		break;
}
?>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<form name="formshoppingcart" action="index.php?module=com_shoppingcart" method="post" onSubmit="SubmitCart('modify')" >
<tr><td class="title_category">
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
<td style="font-family:Tahoma; font-size:12px;
font-weight:bold; color:#595959; text-transform:uppercase;" ><?php if ($lang=="vn") echo "Chi tiết giỏ hàng"; else echo "Item in your cart"; ?></td>
<td align="right">
<?php if ($lang == "vn") { ?>
<input name="order" type="button" id="order" onClick="javascript:SubmitCart('ordercart');" value="Order">
  <input name="modify" type="button" id="modify" onClick="javascript:SubmitCart('modify');" value="Modify">
    <input name="remove" type="button" id="remove" onClick="javascript:SubmitCart('remove');" value="Remove">
<?php
}
else {
?>
<input name="order" type="button" id="order" onClick="javascript:SubmitCart('ordercart');" value="Gửi đơn hàng">
  <input name="modify" type="button" id="modify" onClick="javascript:SubmitCart('modify');" value="Cập nhật">
    <input name="remove" type="button" id="remove" onClick="javascript:SubmitCart('remove');" value="Xóa hàng">
<?php
}
?>
</td>
</tr>
</table>
</td></tr>

<tr>
<td id="comshoppingcart"><table width="90%" border="1" cellspacing="0" cellpadding="3" align="center" >
  <tr>
    <td width="4%">&nbsp;</td>
    <td width="11%" align="center" class="shopping_cart_titlecolumn">ID</td>
    <td width="46%" align="left" class="shopping_cart_titlecolumn">
      <?php if ($lang=="vn") echo "Tên"; else echo "Name"; ?>
    </td>
    <td width="21%" align="center" class="shopping_cart_titlecolumn">
      <?php if ($lang=="vn") echo "Số lượng"; else echo "Quantity"; ?>    </td>
    <td width="18%" align="right" class="shopping_cart_titlecolumn">
      <?php if ($lang=="vn") echo "Đơn giá"; else echo "Price"; ?>    </td>
  </tr>
  <?php
  	$sum = 0;
  	if (isset($_SESSION['item'])) {
		$count = count($_SESSION['item']);
		for ($i=0; $i<$count; $i++) {
			if ($_SESSION['item'][$i] > -1) {
  ?>
  <tr>
    <td><input type="checkbox" name="chkitem[]" value="<?php echo $i; ?>" /></td>
    <td align="center" class="shopping_cart_valuecolumn"><?php echo $_SESSION['item'][$i]; ?></td>
    <td class="shopping_cart_valuecolumn">
	<?php
    	$productname = $_SESSION['itemname'][$i];
		$productname = str_replace('\"','"',$productname);
		$productname = str_replace("\'","'",$productname);
		echo $productname;
	?>
    </td>
    <td align="center"><input name="itemquanlity[]" type="text" style="text-align:right;" value="<?php echo $_SESSION['itemquanlity'][$i]; ?>" size="5" /></td>
    <td align="right" class="shopping_cart_valuecolumn"><?php echo $_SESSION['itemfprice'][$i]; ?></td>
  </tr>
  <input type="hidden" name="itemindex[]" value="<?php echo $i; ?>" />
  <?php
  				$sum += $_SESSION['itemquanlity'][$i] * $_SESSION['itemprice'][$i];
  			}
		}
  	}
  ?>
  <?php
  	if ($sum > 0) {
  ?>
  <tr><td colspan="5" align="right" style="font-weight:bold;"><?php if ($lang=="vn") echo "Tổng: "; else echo "Total: "; ?><?php echo $sum; ?><input type="hidden" name="totalcart" id="totalcart" value="<?php echo $sum; ?>"  /></td></tr>
  <?php
  	}
	else mosRedirect("index.php");
  ?>
</table></td>
</tr>
<input type="hidden" name="task" >
</form>
</table>