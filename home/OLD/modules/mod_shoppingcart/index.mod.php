<?php
defined("_ALLOW") or die ("Access denied");
global $lang;
?>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr><td class="titlemodule"><?php if ($lang=="vn") echo $moduletitle; else echo $moduletitle_en; ?>
</td></tr>
<tr><td>
<textarea rows="5" class="text_area" style="width:100%; border:0; padding-left:5px;" readonly="readonly">
<?php
  	if (isset($_SESSION['item'])) {
		$count = count($_SESSION['item']);
		for ($i=0; $i<$count; $i++) {
			if ($_SESSION['item'][$i] > -1) {
				$productname = $_SESSION['itemname'][$i];
				$productname = str_replace('\"','"',$productname);
				$productname = str_replace("\'","'",$productname);
				echo "$productname" . "\n";
				if ($lang=="vn") echo "Số lượng: "; else echo "Quanlity: ";
				echo $_SESSION['itemquanlity'][$i] . "\n";
				if ($lang=="vn") echo "Đơn giá: "; else echo "Price: ";
				echo $_SESSION['itemfprice'][$i] . "\n\n";
  			}
		}
  	}
?>
</textarea>
  </td></tr>
<tr><td align="center" style="padding-bottom:10px;"><a href="index.php?module=com_shoppingcart"><?php if ($lang=="vn") echo "Xem giỏ hàng"; else echo "View your cart"; ?></a></td></tr>
</table>